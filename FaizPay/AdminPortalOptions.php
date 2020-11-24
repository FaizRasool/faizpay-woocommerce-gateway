<?php


namespace FaizPay;


use Ramsey\Uuid\Uuid;

class AdminPortalOptions
{

    public static function get()
    {
        return array(
            'enabled' => array(
                'title' => 'Enable/Disable',
                'type' => 'checkbox',
                'label' => 'Enable FaizPay Gateway',
                'default' => 'yes'
            ),
            'terminal_id' => array(
                'title' => 'Terminal ID',
                'type' => 'text',
                'description' => 'Enter the terminal ID Here.',
                'default' => '',
                'desc_tip' => true,
            ),

            'terminal_secret' => array(
                'title' => 'Terminal Secret',
                'type' => 'text',
                'description' => 'Enter the terminal Secret Here',
                'default' => '',
                'desc_tip' => true,
            )
        );
    }

    public static function validate($terminal_secret, $terminal_id)
    {
        if (!Uuid::isValid($terminal_secret)) {
            \WC_Admin_Settings::add_error('Invalid Terminal Secret Given');
            return false;
        }


        if (!Uuid::isValid($terminal_id)) {
            \WC_Admin_Settings::add_error('Invalid Terminal ID Given');
            return false;
        }
        return true;
    }
}