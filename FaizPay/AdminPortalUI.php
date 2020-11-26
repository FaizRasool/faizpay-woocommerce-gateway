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

        <h4>Payment Notification URL</h4>
        <pre><?= home_url('/wc-api/faizpay', 'https'); ?></pre>

        <h4>Redirect URL</h4>
        <pre><?= home_url('/checkout/order-received/', 'https'); ?></pre>
        <?php
    }
}