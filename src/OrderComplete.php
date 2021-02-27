<?php


namespace FaizPayCommerceGateway;


class OrderComplete
{
    public static function title($old)
    {
        global $woocommerce;

        $orderID = self::getOrderId();
        $order = wc_get_order($orderID);

        $orderData = wc_get_order($order);

        if($orderData === false){
            return $old;
        }

        $paymentMethod = $orderData->get_payment_method();
        if ($paymentMethod != 'faizpay_payment') {
            return $old;
        }

        if (self::checkOrderStatus()) {
            // Remove cart items
            $woocommerce->cart->empty_cart();
            return $old;
        }
        wc_add_notice('Your payment has been rejected', 'notice');
        $url = wc_get_checkout_url();
        if (wp_redirect($url)) {
            exit;
        }
        return "Payment Rejected";
    }

    public static function text($old)
    {
        if (self::checkOrderStatus()) {
            return $old;
        }
        return "Unfortunately your payment has been rejected.";
    }

    private static function checkOrderStatus()
    {
        $status = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : "rejected";
        if ($status == 'executed') {
            return true;
        }
        return false;
    }

    private static function getOrderId()
    {
        return isset($_GET['order']) ? sanitize_text_field($_GET['order']) : "0";
    }
}