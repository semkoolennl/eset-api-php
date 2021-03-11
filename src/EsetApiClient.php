<?php


namespace Eset\Api;


use Composer\CaBundle\CaBundle;
use Eset\Api\Endpoints\LeakedLicensesEndpoint;
use Eset\Api\Endpoints\LicenseEndpoint;
use Eset\Api\Endpoints\LicenseStatusEndpoint;
use Eset\Api\Endpoints\OrderDetailsEndpoint;
use Eset\Api\Endpoints\OrderEndpoint;
use Eset\Api\Endpoints\PriceEndpoint;
use Eset\Api\Endpoints\RenewalsEndpoint;
use Eset\Api\Exceptions\ApiException;
use Eset\Api\Exceptions\IncompatiblePlatform;
use Eset\Api\Models\Credentials;
use Eset\Api\HttpClient;
use Eset\Api\Guzzle\RetryMiddlewareFactory;
use Eset\Api\Resources\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class EsetApiClient
{
    /**
     * Version of the client.
     */
    const CLIENT_VERSION = "0.0.1";

    /**
     * Endpoint of the remote API.
     */
//    "https://partner.eset.nl"
    const API_ENDPOINT = "https://partner.eset.nl/api";


    /**
     * HTTP Methods
     */
    const HTTP_GET = "GET";
    const HTTP_POST = "POST";
    const HTTP_DELETE = "DELETE";
    const HTTP_PATCH = "PATCH";

    /**
     * HTTP status codes
     */
    const HTTP_NO_CONTENT = 204;

    /**
     * Default response timeout (in seconds).
     */
    const TIMEOUT = 10;

    /**
     * Default connect timeout (in seconds).
     */
    const CONNECT_TIMEOUT = 2;

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $apiEndpoint = self::API_ENDPOINT;

    /**
     * @var Credentials
     */
    public $credentials;

    /**
     * RESTful License resource.
     *
     * @var LicenseEndpoint
     */
    public $license;

    /**
     * RESTful License resource.
     *
     * @var OrderEndpoint
     */
    public $order;

    /**
     * RESTful License resource.
     *
     * @var PriceEndpoint
     */
    public $price;

    /**
     * @var LicenseStatusEndpoint
     */
    public LicenseStatusEndpoint $licenseStatus;

    /**
     * @var OrderDetailsEndpoint
     */
    public OrderDetailsEndpoint $orderDetails;

    /**
     * @var array
     */
    protected $versionStrings = [];

    /**
     * @var int
     */
    protected $lastHttpResponseStatusCode;
    /**
     * @var LeakedLicensesEndpoint
     */
    public LeakedLicensesEndpoint $leakedLicenses;
    /**
     * @var RenewalsEndpoint
     */
    public RenewalsEndpoint $renewals;


    /**
     * @param HttpClient $httpClient
     */
    public function __construct()
    {
        $this->httpClient = new HttpClient();

        $compatibilityChecker = new CompatibilityChecker();
        $compatibilityChecker->checkCompatibility();

        $this->initializeEndpoints();
    }

    public function initializeEndpoints()
    {
        $this->license = new LicenseEndpoint($this);
        $this->licenseStatus = new LicenseStatusEndpoint($this);
        $this->leakedLicenses = new LeakedLicensesEndpoint($this);
        $this->price = new PriceEndpoint($this);
        $this->order = new OrderEndpoint($this);
        $this->orderDetails = new OrderDetailsEndpoint($this);
        $this->renewals = new RenewalsEndpoint($this);
    }

    /**
     * @param string $url
     *
     * @return EsetApiClient
     */
    public function setApiEndpoint($url)
    {
        $this->apiEndpoint = rtrim(trim($url), '/');

        return $this;
    }

    /**
     * @return string
     */
    public function getApiEndpoint()
    {
        return $this->apiEndpoint;
    }

    public function setCredentials($esetGuid, $esetKey)
    {
        $credentials = new Credentials($esetGuid, $esetKey);
        $this->credentials = $credentials;
    }


    /**
     * Perform an http call. This method is used by the resource specific classes. Please use the $payments property to
     * perform operations on payments.
     *
     * @param string $apiMethod
     * @param string|null|resource|StreamInterface $httpBody
     *
     * @return \stdClass
     * @throws ApiException
     *
     * @codeCoverageIgnore
     */
    public function performHttpCall($resourcePath, $httpBody = null)
    {
        $url = $this->apiEndpoint . "/" . $resourcePath;

        return $this->performHttpCallToFullUrl($url, $httpBody);
    }

    /**
     * Perform an http call to a full url. This method is used by the resource specific classes.
     *
     * @param string $url
     * @param string|null|resource|StreamInterface $httpBody
     *
     * @throws ApiException
     *
     */
    public function performHttpCallToFullUrl($url, $httpBody = null)
    {
        if (empty($this->credentials->esetGuid) || empty($this->credentials->esetKey)) {
            throw new ApiException("You have not set an API guid/key. Please use setCredentials(string guid, string key) to set the API guid and key.");
        }

        $guid = $this->credentials->esetGuid;
        $secretKey = $this->credentials->esetKey;

        if (empty($httpBody))
        {
            $httpBody = "{}";
        }

        $signature = hash('sha256', $httpBody . $guid . $secretKey);

        $headers = [
            "Content-Type : application/x-www-form-urlencoded",
            "X-ESET-Guid :  ". $guid,
            "X-ESET-Signature : ". $signature
        ];

        $response = $this->httpClient->post($url, $headers, $httpBody);

        echo "<br/>HEADERS<br/>";
        var_dump($headers);
        echo "<br/><br/>BODY<br/>";
        var_dump($httpBody);
        echo "<br/>";

        return $this->parseResponseBody($response);
    }



    /**
     * Parse the PSR-7 Response body
     *
     * @param $response
     * @return array|null
     * @throws ApiException
     */
    private function parseResponseBody($response)
    {
        $body = $response;
        if (empty($body)) {
            throw new ApiException("No response body found.");
        }

        $object = @json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ApiException("Unable to decode Eset response: '{$body}'.");
        }

        if (key_exists("Messages", $object)){
            $messages = $object['Messages'];
        } else {
            throw new ApiException("Messages not found in response body");
        }

        if (key_exists("Result", $object)) {
            $result = $object['Result'];
            if (!$result)  {
                $messageString = "";
                foreach ($messages as $message)
                {
                    $messageString .= $message."<br/>";
                }
                throw new ApiException("Eset returned a False result for the executed request, Message: {$messageString}");
            }
        } else {
            throw new ApiException("Result not found in response body");
        }

        $response = new Response($object);

        return $response->getData();
    }
}