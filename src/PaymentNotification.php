<?php


namespace FaizPayCommerceGateway;


use FaizPay\PaymentSDK\Connection;
use FaizPay\PaymentSDK\Error;
use FaizPay\PaymentSDK\NotificationHandler;

class PaymentNotification
{

    public static function process($terminal_id, $terminal_secret)
    {
        if (!isset($_POST['token'])) {
            die();
        }

        $token  = sanitize_text_field($_POST['token']);

        $connection = Connection::createConnection($terminal_id, $terminal_secret);
        if ($connection instanceof Error) {
            die();
        }

        $notificationHandler = NotificationHandler::createNotificationHandler($connection, $token);
        if ($notificationHandler instanceof Error) {
            die();
        }

        $orderId = $notificationHandler->getOrderID();

        $order = new \WC_Order($orderId);

        if ($order->get_id() == '') {
            die();
        }

        if (!$notificationHandler->validateAmount($order->get_total())) {
            die();
        }

        $order->add_order_note("Fena Order ID {$notificationHandler->getId()}", 0);
        $order->add_order_note("Fena Net Amount £{$notificationHandler->getNetAmount()}", 0);
        $order->add_order_note("Fena Requested Amount £{$notificationHandler->getRequestedAmount()}", 0);
        $order->payment_complete();
        exit();
    }

}