<?php


namespace FaizPayCommerceGateway;


use FaizPay\PaymentSDK\Connection;
use FaizPay\PaymentSDK\DeliveryAddress;
use FaizPay\PaymentSDK\Error;
use FaizPay\PaymentSDK\Helper\NumberFormatter;
use FaizPay\PaymentSDK\Item;
use FaizPay\PaymentSDK\Payment;
use FaizPay\PaymentSDK\User;

class PaymentProcess
{

    public static function process($order_id, $terminal_id, $terminal_secret)
    {

//        ini_set('display_errors', 1);
//        ini_set('display_startup_errors', 1);
//        error_reporting(E_ALL);

        $order = new \WC_Order($order_id);
        $connection = Connection::createConnection(
            $terminal_id,
            $terminal_secret
        );

        if ($connection instanceof Error) {
            return array(
                'result' => 'failure',
                'messages' => 'Something went wrong. Please contact support.'
            );
        }

        if ($order->get_total() < 0.50) {
            return array(
                'result' => 'failure',
                'messages' => 'Total amount should be greater than 0.50.'
            );
        }

        $payment = Payment::createPayment(
            $connection,
            $order_id,
            $order->get_total()
        );

        if ($payment instanceof Error) {
            return array(
                'result' => 'failure',
                'messages' => 'Something went wrong. Please contact support.'
            );
        }

        $user = User::createUser(
            $order->get_billing_email(),
            $order->get_billing_first_name(),
            $order->get_billing_last_name(),
            $order->get_billing_phone()
        );

        if ($user instanceof Error) {
            return array(
                'result' => 'failure',
                'messages' => 'Something went wrong. Please contact support.'
            );
        }

        // payment object
        $payment->setUser($user);

        // add items in the cart
        foreach ($order->get_items() as $item) {
            $item = Item::createItem(
                $item->get_name(),
                $item->get_quantity(),
                NumberFormatter::formatNumber($item->get_total())
            );
            if ($item instanceof Item) {
                $payment->addItem($item);
            }
        }

        // add delivery address
        if ($order->get_shipping_address_1() != '') {
            $country = $order->get_billing_country();
            if ($country == 'GB') {
                $country = 'UK';
            }
            $deliveryAddress = DeliveryAddress::createDeliveryAddress(
                $order->get_shipping_address_1(),
                $order->get_shipping_address_2(),
                $order->get_shipping_postcode(),
                $order->get_shipping_city(),
                $country
            );
        } else {
            $country = $order->get_billing_country();
            if ($country == 'GB') {
                $country = 'UK';
            }
            $deliveryAddress = DeliveryAddress::createDeliveryAddress(
                $order->get_billing_address_1(),
                $order->get_billing_address_2(),
                $order->get_billing_postcode(),
                $order->get_billing_city(),
                $country
            );
        }

        if ($deliveryAddress instanceof DeliveryAddress) {
            $payment->setDeliveryAddress($deliveryAddress);
        }

        $url = $payment->process($redirectBrowser = false);

        $order->update_status('awaiting_payment', 'Awaiting payment');

        return array(
            'result' => 'success',
            'redirect' => $url
        );
    }

}