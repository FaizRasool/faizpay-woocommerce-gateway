<?php
/* @wordpress-plugin
 * Plugin Name:       WooCommerce FaizPay Plugin
 * Plugin URI:        https://www.faizpay.com
 * Description:       Enables the FaizPay as payment option on the woocommerce.
 * Version:           1.0.4
 * WC requires at least: 3.0
 * WC tested up to: 3.8
 * Author:            FaizPay
 * Author URI:        https://www.faizpay.com
 * Text Domain:       woocommerce-gateway-faizpay
 */

//  auto load
if (!file_exists(plugin_dir_path(__FILE__) . 'vendor/autoload.php')) {
    die;
}
require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';


function woocommerce_stripe_missing_wc_notice()
{
    echo '<div class="error"><p><strong>FaizPay requires WooCommerce to be installed and active. You can download <a href="https://woocommerce.com/" target="_blank">WooCommerce</a> from here.</strong></p></div>';
}


function woocommerce_gateway_faizpay_init()
{
    if (!class_exists('WooCommerce')) {
        add_action('admin_notices', 'woocommerce_stripe_missing_wc_notice');
        return;
    }

    add_filter('woocommerce_payment_gateways', 'addFaizPayPaymentGateway');
    function addFaizPayPaymentGateway($gateways)
    {
        $gateways[] = 'FaizPay\\FaizPayPaymentGateway';
        return $gateways;
    }


    require plugin_dir_path(__FILE__) . "FaizPay/FaizPayPaymentGateway.php";
}


add_action('plugins_loaded', 'woocommerce_gateway_faizpay_init');