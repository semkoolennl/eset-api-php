<?php

namespace Eset\Api\Resources;

use Eset\Api\EsetApiClient;

class ResourceFactory
{
    /**
     * Create resource object from Api result
     *
     * @param array $apiResult
     * @param BaseResource $resource
     *
     * @return BaseResource
     */
    public static function createFromApiResult($apiResult, BaseResource $resource)
    {
        foreach ($apiResult as $property => $value) {
            $resource->{$property} = $value;
        }
        return $resource;
    }

    /**
     * Create resource object from Api result
     *
     * @param array $apiResult
     * @param object $resource
     *
     * @return array
     */
    public static function createArrayFromObject(object $resource)
    {
        $objectParser = new ObjectParser();
        return $objectParser->createArrayFromObject($resource);
    }



}
