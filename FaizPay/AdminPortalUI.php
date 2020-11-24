<?php


namespace FaizPay;


class AdminPortalUI
{
    public static function get($settings)
    {
        ?>
        <h2>FaizPay Payment Gateway</h2>
        <table class="form-table">
            <?= $settings; ?>
        </table>
        <h4>Payment Notification Url: <?= home_url('/wc-api/faizpay'); ?></h4>
        <h4>Redirect Url: <?= home_url('/checkout/order-received/'); ?></h4>
        <?php
    }
}