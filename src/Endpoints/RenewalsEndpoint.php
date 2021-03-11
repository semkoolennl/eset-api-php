<?php


namespace Eset\Api\Endpoints;


use Eset\Api\Resources\Renewal;
use Eset\Api\Resources\ResourceFactory;

class RenewalsEndpoint extends EndpointAbstract
{
    protected $resourcePath = "renewals";

    /**
     * @return Renewal
     */
    protected function getResourceObject()
    {
        return new Renewal($this->client);
    }


    public function getAll()
    {
        $data = parent::read();

        $renewals = [];
        foreach ($data["Renewals"] as $renewal)
        {
            $expirationDate = str_replace(["/Date(", ")/"], "", $renewal['ExpirationDate']);
            $renewal["ExpirationDate"] = date("d-m-Y", $expirationDate / 1000);
            $renewals[] = $renewal;
        }

        return $renewals;
    }

    public function getExpired()
    {
        $data = parent::read();

        $renewals = [];
        foreach ($data["Renewals"] as $renewal)
        {
            $expirationDate = str_replace(["/Date(", ")/"], "", $renewal['ExpirationDate']) / 1000;
            if ($expirationDate < microtime(true)){
                $renewal["ExpirationDate"] = date("d-m-Y", $expirationDate);
                $renewals[] = $renewal;
            }
        }

        return $renewals;
    }

    public function getExpiring()
    {
        $data = parent::read();

        $renewals = [];
        foreach ($data["Renewals"] as $renewal)
        {
            $expirationDate = str_replace(["/Date(", ")/"], "", $renewal['ExpirationDate']) / 1000;
            if ($expirationDate > microtime(true)){
                $renewal["ExpirationDate"] = date("d-m-Y", $expirationDate);
                $renewals[] = ResourceFactory::createFromApiResult($renewal, $this->getResourceObject());
            }
        }

        return $renewals;
    }

}