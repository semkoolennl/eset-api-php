<?php


namespace Mollie\Api\Types;


class LicenseStatus
{
    /**
     * The payment has expired due to inaction of the customer.
     */
    const STATUS_ACTIVE = "Active";

    /**
     * The payment has expired due to inaction of the customer.
     */
    const STATUS_CANCELLED = "Cancelled";

    /**
     * The payment has expired due to inaction of the customer.
     */
    const STATUS_INACTIVE = "Inactive";

    /**
     * The payment has expired due to inaction of the customer.
     */
    const STATUS_SUSPENDED = "Suspended";
}