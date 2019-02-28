<?php

namespace common\services;

/**
 *
 * Class PaymentService
 * @package common\services
 *
 */
class PaymentService
{
    public function receivePayment(array $data)
    {
        $paymentSystem = $this->defineSystem('');

        if ($paymentSystem) {
            return $paymentSystem->sendToUT($data);
        }

        return null;
    }

    //================================================================================================================

    protected function sendToUT(array $paymentData)
    {
        return null;
    }

    //================================================================================================================

    private function defineSystem(string $marker)
    {
        switch ($marker) {
            case '':
                return new PayMasterService();
            default:
                return null;
        }
    }
}
