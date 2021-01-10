<?php


namespace FaizPayCommerceGateway;


class OrderComplete
{
    public static function title($old)
    {
        global $woocommerce;

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
        $status = isset($_GET['status']) ? $_GET['status'] : "rejected";
        if ($status == 'executed') {
            return true;
        }
        return false;
    }
}