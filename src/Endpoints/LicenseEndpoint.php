<?php


namespace Eset\Api\Endpoints;


use Eset\Api\Resources\License;
use Eset\Api\Exceptions\ApiException;
use Eset\Api\Resources\ResourceFactory;


class LicenseEndpoint extends EndpointAbstract
{
    protected $resourcePath = "license";

    /**
     * @return License
     */
    protected function getResourceObject()
    {
        return new License($this->client);
    }


    /**
     * Retrieve a single payment from Eset.
     *
     * Will throw a ApiException if the payment id is invalid or the resource cannot be found.
     *
     * @param string $licenseId
     * @param string $licenseKey
     * @throws ApiException
     */
    public function get(string $licenseId, string $licenseKey = null)
    {
        if (empty($licenseId)) {
            throw new ApiException("Invalid license ID: '{$licenseId}'");
        }
//        if (empty($licenseKey)) {
//            throw new ApiException("Invalid license KEY: '{$licenseKey}'");
//        }

        $requestBody = [
            "LicenseId" => $licenseId,
            "LicenseKey" => $licenseKey,
        ];

        $data = parent::post(array_filter($requestBody));

        return ResourceFactory::createFromApiResult($data['License'], $this->getResourceObject());
    }
}