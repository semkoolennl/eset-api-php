<?php

namespace Eset\Api\Types;

class PaymentMethodStatus
{
    /**
     * The payment method is activated and ready for use.
     *
     * @link https://docs.Eset.com/reference/v2/methods-api/get-method#parameters
     */
    const ACTIVATED = "activated";

    /**
     * Eset is waiting for you to finish onboarding in the Merchant Dashboard before
     * the payment method can be activated.
     *
     * @link https://docs.Eset.com/reference/v2/methods-api/get-method#parameters
     */
    const PENDING_BOARDING = "pending-boarding";

    /**
     * Eset needs to review your request for this payment method before it can be activated.
     *
     * @link https://docs.Eset.com/reference/v2/methods-api/get-method#parameters
     */
    const PENDING_REVIEW = "pending-review";

    /**
     * Activation of this payment method relies on you taking action with an external party,
     * for example signing up with PayPal or a giftcard issuer.
     *
     * @link https://docs.Eset.com/reference/v2/methods-api/get-method#parameters
     */
    const PENDING_EXTERNAL = "pending-external";

    /**
     * Your request for this payment method was rejected.
     * Whenever Eset rejects such a request, you will always be informed via email.
     *
     * @link https://docs.Eset.com/reference/v2/methods-api/get-method#parameters
     */
    const REJECTED = "rejected";

    /**
     * This payment method was not requested.
     *
     * @link https://docs.Eset.com/reference/v2/methods-api/get-method#parameters
     */
    const NOT_REQUESTED = null;
}
