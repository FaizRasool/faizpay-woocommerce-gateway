<?php


namespace FaizPay;


class CheckOutUI
{
    public static function get()
    {
        $button = plugin_dir_url(dirname(__FILE__, 1)) . '/assets/pay-button.png';
        ?>
            <img src="<?= $button; ?>"
                 id="fp-image"/>
        <style>
            .payment_method_faizpay_payment {
                background: transparent !important;
                padding: 0px !important;
            }

            #fp-image {
                max-width: 250px;
                background: transparent;
                min-width: 250px;
                width: 250px;
            }
        </style>
        <?php
    }

}