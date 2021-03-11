<?php


namespace Eset\Api\Resources;


use DateTime;
use Eset\Api\Exceptions\ApiException;

class Renewal extends BaseResource
{
    /**
     * @var string
     */
    public $Username;

    /**
     * @var string
     */
    public $LicenseKey;

    /**
     * @var string
     */
    public $Email;

    /**
     * @var string
     */
    public $Name;

    /**
     * @var DateTime
     */
    public $ExpirationDate;

    /**
     * @var string
     */
    public $Product;

    /**
     * @var int
     */
    public $ProductCode;

    /**
     * @var int
     */
    public $Quantity;

    /**
     * @var int
     */
    public $OrderID;

    /**
     * @var string
     */
    public $PurchaseType;

    public function orderDetails()
    {
        return $this->client->orderDetails->get($this->OrderID);
    }

    public function getLicenses()
    {
        if (empty($this->OrderID)) {
            return null;
        }
        echo "<br/>Searching for order: {$this->OrderID}<br/>";
        try {
            $orderDetails = $this->client->orderDetails->get($this->OrderID);
            $licenses = [];
            foreach ($orderDetails->OrderItems as $orderItem) {
                if (!empty($orderItem->License)) {
                    $licenses[] = $this->client->license->get($orderItem->License);
                }
            }
            return $licenses;
        } catch (ApiException $exception){
            return null;
        }
    }
}