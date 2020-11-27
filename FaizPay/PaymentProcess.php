<?php


namespace FaizPay;


use FaizPay\PaymentSDK\Connection;
use FaizPay\PaymentSDK\Payment;
use FaizPay\PaymentSDK\User;

class PaymentProcess
{

    public static function process($order_id, $terminal_id, $terminal_secret)
    {
        global $woocommerce;

        $order = new \WC_Order($order_id);

        $connection = new Connection(
            $terminal_id,
            $terminal_secret
        );

        $payment = new Payment(
            $connection,
            $order_id,
            $order->get_total()
        );

        $user = new User();
        $user->setEmail($order->get_billing_email());
        $user->setFirstName($order->get_billing_email());
        $user->setLastName($order->get_billing_last_name());
        $user->setContactNumber($order->get_billing_phone());

        // payment object
        $payment->setUser($user);

        $url = $payment->process($redirectBrowser = false);

        $order->update_status('awaiting_payment', 'Awaiting payment');

        // Remove cart
        $woocommerce->cart->empty_cart();

        return array(
            'result' => 'success',
            'redirect' => $url
        );
    }

}