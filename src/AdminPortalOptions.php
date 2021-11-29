<?php


namespace FaizPayCommerceGateway;


class AdminPortalOptions
{

    public static function get()
    {
        return array(
            'enabled' => array(
                'title' => 'Enable/Disable',
                'type' => 'checkbox',
                'label' => 'Enable Fena Gateway',
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
            ),
            'title' => array(
                'title' => 'Title',
                'type' => 'text',
                'description' => 'This controls the title which the user sees during checkout.',
                'default' => 'Instant Bank Transfer',
                'desc_tip' => true,
            ),
            'description' => array(
                'title' => 'Description',
                'type' => 'text',
                'desc_tip' => true,
                'description' => 'This controls the description which the user sees during checkout.',
                'default' => 'Pay instantly via online bank transfer - Supports most of the U.K banks',
            ),
        );
    }

    public static function validate($terminal_secret, $terminal_id)
    {
        if (!self::validateUUID($terminal_secret)) {
            \WC_Admin_Settings::add_error('Invalid Terminal Secret Given');
            return false;
        }


        if (!self::validateUUID($terminal_id)) {
            \WC_Admin_Settings::add_error('Invalid Terminal ID Given');
            return false;
        }
        return true;
    }

    private static function validateUUID($uuid)
    {
        if (!is_string($uuid) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid) !== 1)) {
            return false;
        }
        return true;
    }
}