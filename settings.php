<?php
class WC_SMS_Tab {
    /**
     * Bootstraps the class and hooks required actions & filters.
     *
     */
    public static function init() {
        add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
        add_action( 'woocommerce_settings_tabs_sms_gateway', __CLASS__ . '::settings_tab' );
        add_action( 'woocommerce_update_options_sms_gateway', __CLASS__ . '::update_settings' );
    }
    
    
    /**
     * Add a new settings tab to the WooCommerce settings tabs array.
     *
     * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
     * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
     */
    public static function add_settings_tab( $settings_tabs ) {
        $settings_tabs['sms_gateway'] = __( 'WC SMS Gateway', 'woocommerce' );
        return $settings_tabs;
    }
    /**
     * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
     *
     * @uses woocommerce_admin_fields()
     * @uses self::get_settings()
     */
    public static function settings_tab() {
        woocommerce_admin_fields( self::get_settings() );
    }
    /**
     * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
     *
     * @uses woocommerce_update_options()
     * @uses self::get_settings()
     */
    public static function update_settings() {
        woocommerce_update_options( self::get_settings() );
    }
    /**
     * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
     *
     * @return array Array of settings for @see woocommerce_admin_fields() function.
     */
    public static function get_settings() {
        $settings = array(
            'section_title' => array(
                'name'     => __( 'Woocommerce SMS Gateway', 'woocommerce' ),
                'type'     => 'title',
                'desc'     => 'Integrasi smsgateway.me. Silahkan install Aplikasi Android nya lalu Signup.',
                'id'       => 'wc_sms_gateway_section_title'
            ),
            'email' => array(
                'name' => __( 'Email', 'woocommerce' ),
                'type' => 'text',
                'id'   => 'wc_sms_gateway_email'
            ),
            'password' => array(
                'name' => __( 'Password', 'woocommerce' ),
                'type' => 'text',
                'id'   => 'wc_sms_gateway_password'
            ),
            'device' => array(
                'name' => __( 'Device ID', 'woocommerce' ),
                'type' => 'text',
                'desc' => __( 'Device ID yang tertera di Aplikasi anda.', 'woocommerce' ),
                'id'   => 'wc_sms_gateway_device'
            ),
            'content' => array(
                'name' => __( 'Content SMS', 'woocommerce' ),
                'type' => 'textarea',
				'desc' => __( 'SMS bisa berisi template tag {order_number} {order_total} {order_billing_name} ', 'woocommerce' ),
				'css'      => 'width:50%;height:150px',
                'id'   => 'wc_sms_gateway_content'
            ),
            'section_end' => array(
                 'type' => 'sectionend',
                 'id' => 'wc_settings_tab_demo_section_end'
            )
        );
        return apply_filters( 'wc_sms_gateway_settings', $settings );
    }
}
WC_SMS_Tab::init();