<?php
/*
Plugin Name: Woocommerce SMS Gateway
Plugin URI: https://zazan.me
Description: Adds sms gateway on WooCommerce new Order
Version: 1.2
Author: Zazan
Author URI: https://zazan.me
License: GPL2
*/

/**
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * **********************************************************************
 */

include dirname( __FILE__ ) . '/smsGateway.php';
include dirname( __FILE__ ) . '/settings.php';

function wc_sms_gateway( $order_id ) {
	$smsGateway = new SmsGateway(get_option('wc_sms_gateway_email'), get_option('wc_sms_gateway_password'));
	$order = new WC_Order( $order_id );
	
	$id = wp_kses_post( $order->get_payment_method() );
	$methods = WC()->payment_gateways->payment_gateways();
	$norek = $methods[$id];
	
	$deviceID = get_option('wc_sms_gateway_device');
	$number = $order->get_billing_phone();
	$message = get_option('wc_sms_gateway_content');
	$message = str_replace('{order_number}', $order->get_id(), $message);
	$message = str_replace('{order_total}', number_format($order->get_total(), 0, '', '.'), $message);
	$message = str_replace('{order_billing_name}', $order->get_billing_first_name(), $message);
	$message = str_replace('{order_norek}', $norek->get_description(), $message);

	//Please note options is no required and can be left out
	$result = $smsGateway->sendMessageToNumber($number, $message, $deviceID);
}
add_action( 'woocommerce_new_order', 'wc_sms_gateway' );
