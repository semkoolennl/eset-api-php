<?php


namespace Eset\Api\Endpoints;


use Eset\Api\Exceptions\ApiException;
use Eset\Api\Resources\BaseResource;
use Eset\Api\Resources\OrderDetails;
use Eset\Api\Resources\OrderItem;
use Eset\Api\Resources\ResourceFactory;

class OrderDetailsEndpoint extends EndpointAbstract
{
    protected $resourcePath = "orderdetails";

    /**
     * @return OrderDetails
     */
    protected function getResourceObject()
    {
        return new OrderDetails($this->client);
    }

    /**
     * @return OrderItem
     */
    protected function getResourceItemObject()
    {
        return new OrderItem($this->client);
    }

    /**
     * @param int $orderNumber
     * @return BaseResource
     * @throws ApiException
     */
    public function get(int $orderNumber)
    {
        if (empty($orderNumber))
        {
            throw new ApiException("OrderNumber cannot be empty.");
        }

        $requestArray = [
            "OrderNr" => $orderNumber
        ];

        $data = parent::post(array_filter($requestArray));
        $order = $data["Order"];

        $orderItems = [];
        foreach ($order['OrderItems'] as $orderItem)
        {
            echo "<br/>";
            $orderItems[] = ResourceFactory::createFromApiResult($orderItem, $this->getResourceItemObject());
            var_dump($orderItem);
            echo "<br/>";
        }
        $order['OrderItems'] = $orderItems;

        return ResourceFactory::createFromApiResult($order, $this->getResourceObject());
    }
}