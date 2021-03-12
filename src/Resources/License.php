<?php


namespace Eset\Api\Resources;


use Eset\Api\EsetApiClient;
use Eset\Api\Exceptions\ApiException;
use Eset\Api\Types\PaymentStatus;
use Eset\Api\Types\SequenceType;
use Mollie\Api\Types\LicenseStatus;

class License extends BaseResource
{
    /**
     * Id of the license (on the Eset platform).
     *
     * @var string
     */
    public $LicenseId;

    /**
     * Ket of the license (on the Eset platform).
     *
     * @var string
     */
    public $LicenseKey;

    /**
     * Username of the license
     * method.
     *
     * @var string|null
     */
    public $Username;

    /**
     * If method is empty/null, the customer can pick his/her preferred payment
     * method.
     *
     * @var string|null
     */
    public $Password;

    /**
     * If method is empty/null, the customer can pick his/her preferred payment
     * method.
     *
     * @var string|null
     */
    public $ProductCode;

    /**
     * If method is empty/null, the customer can pick his/her preferred payment
     * method.
     *
     * @var string|null
     */
    public $ProductName;

    /**
     * If method is empty/null, the customer can pick his/her preferred payment
     * method.
     *
     * @var int|null
     */
    public $Quantity;

    /**
     * If method is empty/null, the customer can pick his/her preferred payment
     * method.
     *
     * @var string|null
     */
    public $PurchaseType;

    /**
     * Date the license was created
     *
     * @example "28-07-2015"
     * @var string|null
     */
    public $CreatedDate;

    /**
     * Date the license will expire
     *
     * @example "27-07-2017"
     * @var string|null
     */
    public $ExpirationDate;

    /**
     * If method is empty/null, the customer can pick his/her preferred payment
     * method.
     *
     * @var string|null
     */
    public $CustomerName;

    /**
     * If method is empty/null, the customer can pick his/her preferred payment
     * method.
     *
     * @var string|null
     */
    public $CustomerCompany;

    /**
     * If method is empty/null, the customer can pick his/her preferred payment
     * method.
     *
     * @var string|null
     */
    public $CustomerEmail;

    /**
     * If method is empty/null, the customer can pick his/her preferred payment
     * method.
     *
     * @var int|null
     */
    public $DiscountCode;


    /**
     * If method is empty/null, the customer can pick his/her preferred payment
     * method.
     *
     * @var string|null
     */
    public $Status;

    /**
     * If method is empty/null, the customer can pick his/her preferred payment
     * method.
     *
     * @var string|null
     */
    public $BundleProductCode;

    /**
     * If method is empty/null, the customer can pick his/her preferred payment
     * method.
     *
     * @var string|null
     */
    public $BundleProductName;

    /**
     * If method is empty/null, the customer can pick his/her preferred payment
     * method.
     *
     * @var int|null
     */
    public $BundleQuantity;

    /**
     * If method is empty/null, the customer can pick his/her preferred payment
     * method.
     *
     * @var string|null
     */
    public $ELAPassword;

    /**
     * If method is empty/null, the customer can pick his/her preferred payment
     * method.
     *
     * @var int|null
     */
    public $CountryId;

    /**
     * If method is empty/null, the customer can pick his/her preferred payment
     * method.
     *
     * @var string|null
     */
    public $RenewProductcode;


    public function getStatus()
    {
        return $this->client->licenseStatus->get($this->LicenseId, $this->LicenseKey);
    }

    public function renew(bool $test, string $orderReference = null,
                          string $licenseLetterCC = null)
    {
        return $this->client->order->create([
            "TestOrder" => $test,
            "CustomerName" => $this->CustomerName,
            "CustomerEmail" => $this->CustomerEmail,
            "CustomerCompany" => $this->CustomerCompany,
            "LicenseLetterCC" => $licenseLetterCC,
            "OrderReference" => $orderReference,
            "OrderItems" => [
                [
                    "ProductCode" => $this->RenewProductcode,
                    "Quantity" => $this->Quantity,
                    "LicenseKey" => $this->LicenseKey,
                    "LicenceId" => $this->LicenseId,
                ]
            ]
        ]);
    }

    public function getRenewPrice(int $years, float $taxRate = null)
    {
        return $this->client->price->get([
            "LicenseKey" => $this->LicenseKey,
            "LicenseId" => $this->LicenseId,
            "NewProductCode" => $this->ProductCode,
            "NewQuantity" => $this->Quantity,
            "Period" => $this->getPeriodByYears($years),
            "TaxRate" => $taxRate,
            "DicountCode" => $this->DiscountCode
        ]);
    }

    private function getPeriodByYears(int $years)
    {
        switch ($years) {
            case 1: $period = 1; break;
            case 2: $period = 2; break;
            case 3: $period = 5; break;
            default: $period = 6; break;
        }
        return $period;
    }


}