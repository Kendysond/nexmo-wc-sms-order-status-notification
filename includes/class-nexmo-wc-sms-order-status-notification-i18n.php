<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://kendyson.com
 * @since      1.0.0
 *
 * @package    Nexmo_Wc_Sms_Order_Status_Notification
 * @subpackage Nexmo_Wc_Sms_Order_Status_Notification/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Nexmo_Wc_Sms_Order_Status_Notification
 * @subpackage Nexmo_Wc_Sms_Order_Status_Notification/includes
 * @author     Douglas Kendyson <kendyson@kendyson.com>
 */
class Nexmo_Wc_Sms_Order_Status_Notification_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'nexmo-wc-sms-order-status-notification',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
