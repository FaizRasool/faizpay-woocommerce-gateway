<?php


namespace FaizPay;


class CheckOutUI
{
    public static function get(){
        ?>
        <div id="fp-payment-div">
            <img src="https://www.faizpay.com/wp-content/uploads/2020/11/cropped-logo-dark-blue-1.png"
                 height=""/>
            <br/>
            <p>
                Pay with your bank account
            </p>
        </div>
        <style>
            #fp-payment-div {
                border: 1px solid;
                padding: 5px;
                text-align: center;
            }
        </style>
        <?php
    }

}