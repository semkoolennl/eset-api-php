<?php


namespace Eset\Api\Resources;


class Price extends BaseResource
{
    /**
     * If method is empty/null, the customer can pick his/her preferred payment
     * method.
     *
     * @var float|null
     */
    public $Price;

    /**
     * If method is empty/null, the customer can pick his/her preferred payment
     * method.
     *
     * @var float|null
     */
    public $DiscountPrice;

    /**
     * If method is empty/null, the customer can pick his/her preferred payment
     * method.
     *
     * @var string
     */
    public $ProductCode;
}