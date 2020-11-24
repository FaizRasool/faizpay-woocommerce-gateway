<?php


namespace FaizPay;


use Firebase\JWT\JWT;

class PaymentProcess
{

    public static function process($order_id, $terminal_id, $terminal_secret)
    {
        global $woocommerce;

        $order = new \WC_Order($order_id);
        $nowSeconds = time();

        $payload = [
            'terminalID' => $terminal_id,
            'orderID' => $order_id,
            'amount' => $order->get_total(),
            'email' => $order->get_billing_email(),
            'firstName' => $order->get_billing_email(),
            'lastName' => $order->get_billing_last_name(),
            'contactNumber' => $order->get_billing_phone(),
            'iat' => $nowSeconds,
            'exp' => $nowSeconds + (60 * 120) // 2 hours
        ];

        $token = JWT::encode($payload, $terminal_secret, 'HS512');
        $url = 'https://faizpay-staging.netlify.app/pay?token=' . $token;

        $order->update_status('awaiting_payment', 'Awaiting payment');

        // Remove cart
        $woocommerce->cart->empty_cart();

        return array(
            'result' => 'success',
            'redirect' => $url
        );
    }

}