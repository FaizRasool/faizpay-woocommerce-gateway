<?php
/*
Plugin Name:       FaizPay Commerce Plugin
Plugin URI:        https://github.com/FaizRasool/faizpay-woocommerce-gateway
Description:       Enables the FaizPay as payment option on the woocommerce.
Version:           1.0.5
WC requires at least: 3.0
WC tested up to: 3.8
Author:            FaizPay
Author URI:        https://www.faizpay.com
Text Domain:       faizpay

WC requires at least: 3.0.9
WC tested up to: 3.6.3

FaizPay Commerce Plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
any later version.

FaizPay Commerce Plugin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with FaizPay Commerce Plugin. If not, see https://www.gnu.org/licenses/gpl-3.0.html.
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
        $gateways[] = 'FaizPayCommerceGateway\\FaizPayPaymentGateway';
        return $gateways;
    }


    require plugin_dir_path(__FILE__) . "src/FaizPayPaymentGateway.php";
}


add_action('plugins_loaded', 'woocommerce_gateway_faizpay_init');