<?php


namespace FenaCommerceGateway;


class CheckoutIcon
{
    public static function get($id)
    {
        $icon_html = '';
        $providers = array('bank-payment');
        foreach ($providers as $provider) {
            $url = \WC_HTTPS::force_https_url(plugin_dir_url(dirname(__FILE__, 1)) . 'assets/' . $provider . '.svg');
            $icon_html .= '<img width="26" src="' . esc_attr($url) . '" alt="' . esc_attr($provider) . '" />';
        }
        $icon_html .= '
        <style>
@media only screen and (max-width: 1000px) {
  .payment_method_faizpay_payment label img:nth-child(5){
    display: none !important;
  }
  .payment_method_faizpay_payment label img:nth-child(2){
    display: none !important;
  }
}
</style>
';
        return apply_filters('woocommerce_gateway_icon', $icon_html, $id);
    }
}
