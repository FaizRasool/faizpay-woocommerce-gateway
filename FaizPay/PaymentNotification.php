<?php


namespace FaizPay;


use Firebase\JWT\JWT;

class PaymentNotification
{

    public static function process($terminal_id, $terminal_secret)
    {
        if (!isset($_POST['token'])) {
            die();
        }

        $decodedData = JWT::decode($_POST['token'],
            $terminal_secret,
            ['HS512']
        );

        if (!$decodedData instanceof \stdClass) {
            die();
        }
        $decodedData = json_decode(json_encode($decodedData), true);

        if (
            !isset($decodedData['id']) ||
            !isset($decodedData['orderID']) ||
            !isset($decodedData['requestAmount']) ||
            !isset($decodedData['netAmount']) ||
            !isset($decodedData['terminal'])
        ) {
            die();
        }
        $order = new \WC_Order($decodedData['orderID']);

        if ($order->get_id() == '') {
            die();
        }

        // verify the terminal
        if ($decodedData['terminal'] != $terminal_id) {
            die();
        }

        if ($order->get_total() !=
            number_format($decodedData['requestAmount'], 2, '.', "")) {
            die();
        }

        $order->add_order_note("FaizPay Order ID#{$decodedData['id']}", 0);
        $order->add_order_note("FaizPay Net Amount# £{$decodedData['netAmount']}", 0);
        $order->add_order_note("FaizPay Requested Amount# £{$decodedData['requestAmount']}", 0);
        $order->payment_complete();
        exit();
    }

}