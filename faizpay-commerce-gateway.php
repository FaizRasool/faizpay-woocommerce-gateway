<?php
/*
Plugin Name:       Fena Commerce
Plugin URI:        https://github.com/fena-co/faizpay-woocommerce-gateway
Description:       Enables the Fena as payment option on the woocommerce.
Version:           1.0.11
Author:            Fena
Author URI:        https://www.fena.co
Text Domain:       fena

Fena Commerce Plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
any later version.

Fena Commerce Plugin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Fena Commerce Plugin. If not, see https://www.gnu.org/licenses/gpl-3.0.html.
*/
//  auto load
if (!file_exists(plugin_dir_path(__FILE__) . 'vendor/autoload.php')) {
    die;
}
require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';


function faizpay_woocommerce_stripe_missing_wc_notice()
{
    echo '<div class="error"><p><strong>Fena requires WooCommerce to be installed and active. You can download <a href="https://woocommerce.com/" target="_blank">WooCommerce</a> from here.</strong></p></div>';
}


function woocommerce_gateway_faizpay_init()
{
    if (!class_exists('WooCommerce')) {
        add_action('admin_notices', 'faizpay_woocommerce_stripe_missing_wc_notice');
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