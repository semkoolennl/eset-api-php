<?php


namespace Eset\Api\Resources;


class OrderDetails extends BaseResource
{
    /**
     * @var int
     */
    public $OrderID;

    /**
     * @var float
     */
    public $OrderSubtotalInclTax;

    /**
     * @var float
     */
    public $OrderSubstotalExclTax;

    /**
     * @var float
     */
    public $OrderSubTotalDiscountInclTax;

    /**
     * @var float
     */
    public $OrderSubTotalDiscountExclTax;

    /**
     * @var float
     */
    public $OrderTax;

    /**
     * @var float
     */
    public $OrderTotal;

    /**
     * @var float
     */
    public $OrderDiscount;

    /**
     * @var string|null
     */
    public $PurchaseOrderNumber;

    /**
     * @var string
     */
    public $BillingFirstName;

    /**
     * @var string
     */
    public $BillingLastName;

    /**
     * @var string|null
     */
    public $BillingPhoneNumber;

    /**
     * @var string|null
     */
    public $BillingEmail;

    /**
     * @var string|null
     */
    public $BillingCompany;

    /**
     * @var string
     */
    public $BillingAddress1;

    /**
     * @var string|null
     */
    public $BillingAddress2;

    /**
     * @var string|null
     */
    public $BillingCity;

    /**
     * @var string|null
     */
    public $BillingZipPostalCode;

    /**
     * @var string
     */
    public $CreatedOn;

    /**
     * @var OrderItem[]
     */
    public $OrderItems;
}