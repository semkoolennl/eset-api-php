<?php


namespace Eset\Api\Endpoints;


use Eset\Api\Exceptions\ApiException;
use Eset\Api\Resources\License;
use Eset\Api\Resources\Order;
use Eset\Api\Resources\ResourceFactory;

class OrderEndpoint extends EndpointAbstract
{
    protected $resourcePath = "order";

    /**
     * @return Order
     */
    protected function getResourceObject()
    {
        return new Order($this->client);
    }


    /**
     * @return License
     */
    protected function getLicenseObject()
    {
        return new License($this->client);
    }


    /**
     * Retrieve a single price information from Eset.
     *
     * Will throw a ApiException if the payment id is invalid or the resource cannot be found.
     *
     * @param array $requestArray
     * @throws ApiException
     */
    public function create(array $requestArray)
    {
        $requestBody = array_filter($requestArray);
        echo "<br/>Order request body:<br/>";
        var_dump($requestBody);
        echo "<br/>";
        return $requestBody;
//        $data = parent::post($requestBody);
        $licenses = [];
        var_dump($data['Licenses']);
        foreach ($data['Licenses'] as $license)
        {
            $licenses[] = ResourceFactory::createFromApiResult($license, $this->getLicenseObject());
        }
        $data['Licenses'] = $licenses;

        return ResourceFactory::createFromApiResult($data, $this->getResourceObject());
    }



}