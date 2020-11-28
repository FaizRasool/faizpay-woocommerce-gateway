<?php


namespace FaizPay;


class CheckOutUI
{
    public static function get()
    {
        $button = plugin_dir_url(dirname(__FILE__, 1)) . 'assets/pay-button.png';
        ?>
        <img src="<?= $button; ?>"
             id="fp-image"/>
        <style>
            .payment_method_faizpay_payment {
                background: transparent !important;
                padding: 0px !important;
                width: 100% !important;
                height: 170px !important;
                max-height: 170px !important;
                display: block !important;
                min-height: 170px !important;
            }

            #fp-image {
                max-width: 250px !important;
                background: transparent !important;
                min-width: 250px !important;
                width: 250px !important;
                height: 150px !important;
                max-height: 150px !important;
                display: block !important;
                min-height: 150px !important;
                float: none !important;
            }
        </style>
        <?php
    }

}