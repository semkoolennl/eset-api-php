<?php


namespace Eset\Api\Resources;


class Order extends BaseResource
{
    /**
     * If method is empty/null, the customer can pick his/her preferred payment
     * method.
     *
     * @var int|null
     */
    public $Ordernumber;


    /**
     * @var License[]
     */
    public $Licenses;
}