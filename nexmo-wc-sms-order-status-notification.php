<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://kendyson.com
 * @since             1.0.0
 * @package           Nexmo_Wc_Sms_Order_Status_Notification
 *
 * @wordpress-plugin
 * Plugin Name:       Nexmo Woo SMS order status notification
 * Plugin URI:        https://github.com/Kendysond/nexmo-wc-sms-order-status-notification
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Douglas Kendyson
 * Author URI:        http://kendyson.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nexmo-wc-sms-order-status-notification
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'NEXMO_WC_SMS_ORDER_STATUS_NOTIFICATION_VERSION', '1.0.0' );
require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';
define( 'WC_SMS_ORDER_NEXMO_KEY', '');
define( 'WC_SMS_ORDER_NEXMO_SECRET', '');
define( 'WC_SMS_ORDER_NEXMO_SENDER_NAME', 'Nexmo123');



/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-nexmo-wc-sms-order-status-notification-activator.php
 */
function activate_nexmo_wc_sms_order_status_notification() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nexmo-wc-sms-order-status-notification-activator.php';
	Nexmo_Wc_Sms_Order_Status_Notification_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-nexmo-wc-sms-order-status-notification-deactivator.php
 */
function deactivate_nexmo_wc_sms_order_status_notification() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nexmo-wc-sms-order-status-notification-deactivator.php';
	Nexmo_Wc_Sms_Order_Status_Notification_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_nexmo_wc_sms_order_status_notification' );
register_deactivation_hook( __FILE__, 'deactivate_nexmo_wc_sms_order_status_notification' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-nexmo-wc-sms-order-status-notification.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_nexmo_wc_sms_order_status_notification() {

	$plugin = new Nexmo_Wc_Sms_Order_Status_Notification();
	$plugin->run();

}
run_nexmo_wc_sms_order_status_notification();
