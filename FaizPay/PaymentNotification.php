<?php


namespace FaizPay;


use FaizPay\PaymentSDK\Connection;
use FaizPay\PaymentSDK\NotificationHandler;

class PaymentNotification
{

    public static function process($terminal_id, $terminal_secret)
    {
        if (!isset($_POST['token'])) {
            die();
        }

        $connection = new Connection($terminal_id, $terminal_secret);
        $notificationHandler = new NotificationHandler($connection, $_POST['token']);

        // validate the given token
        if (!$notificationHandler->isValidToken()) {
            die();
        }

        $orderId = $notificationHandler->getOrderID();

        $order = new \WC_Order($orderId);

        if ($order->get_id() == '') {
            die();
        }

        if (!$notificationHandler->validatePayment($order->get_total())) {
            die();
        }

        $order->add_order_note("FaizPay Order ID {$notificationHandler->getId()}", 0);
        $order->add_order_note("FaizPay Net Amount £{$notificationHandler->getNetAmount()}", 0);
        $order->add_order_note("FaizPay Requested Amount £{$notificationHandler->getRequestedAmount()}", 0);
        $order->payment_complete();
        exit();
    }

}