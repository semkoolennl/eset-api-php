<?php

namespace Eset\Api\Resources;

use Eset\Api\EsetApiClient;

abstract class BaseResource
{
    /**
     * @var EsetApiClient
     */
    protected $client;

    /**
     * @param $client
     */
    public function __construct(EsetApiClient $client)
    {
        $this->client = $client;
    }
}
