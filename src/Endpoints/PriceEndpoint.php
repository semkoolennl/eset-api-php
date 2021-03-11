<?php


namespace Eset\Api\Endpoints;


use Eset\Api\Exceptions\ApiException;
use Eset\Api\Resources\Price;
use Eset\Api\Resources\PriceRequest;
use Eset\Api\Resources\ResourceFactory;

class PriceEndpoint extends EndpointAbstract
{
    protected $resourcePath = "price";

    /**
     * @return Price
     */
    protected function getResourceObject()
    {
        return new Price($this->client);
    }

    /**
     * @return PriceRequest
     */
    protected function getRequestObject()
    {
        return new PriceRequest($this->client);
    }


    /**
     * Retrieve a single payment from Eset.
     *
     * Will throw a ApiException if the payment id is invalid or the resource cannot be found.
     *
     * @param array $requestArray
     * @return Price
     * @throws \Eset\Api\Exceptions\ApiException
     */
    public function get(array $requestArray)
    {
        echo "<br/>Price request array:<br/>";
        var_dump($requestArray);
        echo "<br/>";
        $requestBody = array_filter($requestArray);
        echo "<br/>Price request body:<br/>";
        var_dump($requestBody);
        echo "<br/>";

        $data = parent::post($requestBody);

        return ResourceFactory::createFromApiResult($data, $this->getResourceObject());
    }
}