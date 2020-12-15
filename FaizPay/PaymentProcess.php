<?php


namespace FaizPay;


use FaizPay\PaymentSDK\Connection;
use FaizPay\PaymentSDK\Error;
use FaizPay\PaymentSDK\Payment;
use FaizPay\PaymentSDK\User;

class PaymentProcess
{

    public static function process($order_id, $terminal_id, $terminal_secret)
    {
        $order = new \WC_Order($order_id);

        $connection = Connection::createConnection(
            $terminal_id,
            $terminal_secret
        );

        if ($connection instanceof Error) {
            return array(
                'result'   => 'failure',
                'messages' => 'Something went wrong. Please contact support.'
            );
        }

        $payment = Payment::createPayment(
            $connection,
            $order_id,
            $order->get_total()
        );

        if ($payment instanceof Error) {
            return array(
                'result'   => 'failure',
                'messages' => 'Something went wrong. Please contact support.'
            );
        }

        $user = User::createUser($order->get_billing_email(),
            $order->get_billing_first_name(),
            $order->get_billing_last_name(),
            $order->get_billing_phone()
        );

        if ($user instanceof Error) {
            return array(
                'result'   => 'failure',
                'messages' => 'Something went wrong. Please contact support.'
            );
        }

        // payment object
        $payment->setUser($user);

        $url = $payment->process($redirectBrowser = false);

        $order->update_status('awaiting_payment', 'Awaiting payment');

        return array(
            'result' => 'success',
            'redirect' => $url
        );
    }

}