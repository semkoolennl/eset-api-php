<?php


namespace Eset\Api\Endpoints;


use Eset\Api\Resources\License;

class LeakedLicensesEndpoint extends EndpointAbstract
{
    protected $resourcePath = "leakedlicenses";

    /**
     * @return License
     */
    protected function getResourceObject()
    {
        return new License($this->client);
    }

    public function list()
    {
        $data = parent::read();
        var_dump($data);
        return $data;
    }
}