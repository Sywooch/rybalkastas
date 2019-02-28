<?php

namespace common\services;

/**
 *
 * Class PayMasterService
 * @package common\services
 *
 */
class PayMasterService extends PaymentService
{
    public function sendToUT(array $paymentData)
    {
        $formattedPaymentData = $this->formatPaymentData($paymentData);

        return parent::sendToUT($formattedPaymentData);
    }

    //================================================================================================================

    private function formatPaymentData(array $paymentData)
    {
        $formattedPaymentData = [];

        return  $formattedPaymentData;
    }
}
