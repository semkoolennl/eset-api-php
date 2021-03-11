<?php


namespace Eset\Api\Resources;


class LicenseStatus extends BaseResource
{
    /**
     * Status of the license. (Active, Inactive, Cancelled or Suspended)
     *
     * @var string
     */
    public $Status;

    /**
     * Date of the last order for the license.
     *
     * @var string
     */
    public $OrderDate;

    /**
     * Current expiration date of the license.
     *
     * @var string
     */
    public $ExpirationDate;
}