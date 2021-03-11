<?php

namespace Eset\Api\Endpoints;

use Eset\Api\Resources\BaseCollection;

abstract class ResponseEndpointAbstract extends EndpointAbstract
{
    /**
     * Get the collection object that is used by this API endpoint. Every API endpoint uses one type of collection object.
     *
     * @param bool $result
     * @param array $messages
     *
     * @return BaseCollection
     */
    abstract protected function getResponseObject($this->client);
}
