<?php


namespace Eset\Api\Resources;


class OrderItem extends BaseResource
{
    public $Name;
    public $UnitPriceInclTax;
    public $UnitPriceExclTax;
    public $PriceInclTax;
    public $PriceExclTax;
    public $License;
    public $Quantity;
    public $DiscountAmountInclTax;
    public $DiscountAmountExclTax;
    public $SKU;
    public $AttributeDescription;
}