<?php

namespace Eset\Api\Endpoints;

use Eset\Api\Exceptions\ApiException;
use Eset\Api\EsetApiClient;
use Eset\Api\Resources\BaseResource;
use Eset\Api\Resources\ResourceFactory;

abstract class EndpointAbstract
{
    const REST_CREATE = EsetApiClient::HTTP_POST;
    const REST_UPDATE = EsetApiClient::HTTP_PATCH;
    const REST_READ = EsetApiClient::HTTP_GET;
    const REST_LIST = EsetApiClient::HTTP_GET;
    const REST_DELETE = EsetApiClient::HTTP_DELETE;

    /**
     * @var EsetApiClient
     */
    protected $client;

    /**
     * @var string
     */
    protected $resourcePath;

    /**
     * @var string|null
     */
    protected $parentId;

    /**
     * @param EsetApiClient $api
     */
    public function __construct(EsetApiClient $api)
    {
        $this->client = $api;
    }

    /**
     * @param array $filters
     * @return string
     */
    protected function buildQueryString(array $filters)
    {
        if (empty($filters)) {
            return "";
        }

        foreach ($filters as $key => $value) {
            if ($value === true) {
                $filters[$key] = "true";
            }

            if ($value === false) {
                $filters[$key] = "false";
            }
        }

        return "?" . http_build_query($filters, "", "&");
    }

    /**
     * @param array $body
     * @return array
     * @throws ApiException
     */
    protected function post(array $body)
    {
        $result = $this->client->performHttpCall(
            $this->getResourcePath(),
            $this->parseRequestBody($body)
        );
        return $result;
    }

    /**
     * @return array
     * @throws ApiException
     */
    protected function read()
    {
        return $this->client->performHttpCall(
            $this->getResourcePath()
        );
    }

    /**
     * Retrieves a single object from the REST API.
     *
     * @param string $id Id of the object to retrieve.
     * @param array $filters
     * @return BaseResource
     * @throws ApiException
     */
    protected function rest_read($id, array $filters)
    {
        if (empty($id)) {
            throw new ApiException("Invalid resource id.");
        }

        $id = urlencode($id);
        $result = $this->client->performHttpCall(
            "{$this->getResourcePath()}/{$id}" . $this->buildQueryString($filters)
        );

        return ResourceFactory::createFromApiResult($result, $this->getResourceObject());
    }

    /**
     * Sends a DELETE request to a single Molle API object.
     *
     * @param string $id
     * @param array $body
     *
     * @return BaseResource
     * @throws ApiException
     */
    protected function rest_delete($id, array $body = [])
    {
        if (empty($id)) {
            throw new ApiException("Invalid resource id.");
        }

        $id = urlencode($id);
        $result = $this->client->performHttpCall(
            "{$this->getResourcePath()}/{$id}",
            $this->parseRequestBody($body)
        );

        if ($result === null) {
            return null;
        }

        return ResourceFactory::createFromApiResult($result, $this->getResourceObject());
    }

    /**
     * Get a collection of objects from the REST API.
     *
     * @param string $from The first resource ID you want to include in your list.
     * @param int $limit
     * @param array $filters
     *
     * @return BaseCollection
     * @throws ApiException
     */
    protected function rest_list($from = null, $limit = null, array $filters = [])
    {
        $filters = array_merge(["from" => $from, "limit" => $limit], $filters);

        $apiPath = $this->getResourcePath() . $this->buildQueryString($filters);

        $result = $this->client->performHttpCall(self::REST_LIST, $apiPath);

        /** @var BaseCollection $collection */
        $collection = $this->getResourceCollectionObject($result->count, $result->_links);

        foreach ($result->_embedded->{$collection->getCollectionResourceName()} as $dataResult) {
            $collection[] = ResourceFactory::createFromApiResult($dataResult, $this->getResourceObject());
        }

        return $collection;
    }

    /**
     * Get the object that is used by this API endpoint. Every API endpoint uses one type of object.
     *
     * @return BaseResource
     */
    abstract protected function getResourceObject();


    /**
     * @param string $resourcePath
     */
    public function setResourcePath($resourcePath)
    {
        $this->resourcePath = strtolower($resourcePath);
    }

    /**
     * @return string
     * @throws ApiException
     */
    public function getResourcePath()
    {
        if (strpos($this->resourcePath, "_") !== false) {
            list($parentResource, $childResource) = explode("_", $this->resourcePath, 2);

            if (empty($this->parentId)) {
                throw new ApiException("Subresource '{$this->resourcePath}' used without parent '$parentResource' ID.");
            }

            return "$parentResource/{$this->parentId}/$childResource";
        }

        return $this->resourcePath;
    }

    /**
     * @param array $body
     * @return null|string
     */
    protected function parseRequestBody(array $body)
    {
        if (empty($body)) {
            return null;
        }

        $encoded = json_encode($body);
//        print_r($encoded);

        return $encoded;
    }
}
