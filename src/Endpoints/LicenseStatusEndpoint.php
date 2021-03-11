<?php


namespace Eset\Api\Endpoints;


use Eset\Api\Exceptions\ApiException;
use Eset\Api\Resources\BaseResource;
use Eset\Api\Resources\LicenseStatus;
use Eset\Api\Resources\ResourceFactory;

class LicenseStatusEndpoint extends EndpointAbstract
{
    protected $resourcePath = "getlicensestatus";

    /**
     * @return LicenseStatus
     */
    protected function getResourceObject()
    {
        return new LicenseStatus($this->client);
    }

    /**
     * @param string|null $licenseId
     * @param string|null $licenseKey
     * @return BaseResource
     * @throws ApiException
     */
    public function get(string|null $licenseId, string|null $licenseKey)
    {
        if (empty($licenseId) && empty($licenseKey))
        {
            throw new ApiException("LicenseId and LicenseKey cannot both be empty");
        }

        $requestArray = [
            "LicenseId" => $licenseId,
            "LicenseKey" => $licenseKey,
        ];

        $data = parent::post(array_filter($requestArray));

        return ResourceFactory::createFromApiResult($data, $this->getResourceObject());
    }
}