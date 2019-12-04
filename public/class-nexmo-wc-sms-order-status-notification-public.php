<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://kendyson.com
 * @since      1.0.0
 *
 * @package    Nexmo_Wc_Sms_Order_Status_Notification
 * @subpackage Nexmo_Wc_Sms_Order_Status_Notification/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Nexmo_Wc_Sms_Order_Status_Notification
 * @subpackage Nexmo_Wc_Sms_Order_Status_Notification/public
 * @author     Douglas Kendyson <kendyson@kendyson.com>
 */
class Nexmo_Wc_Sms_Order_Status_Notification_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;
	protected $nexmo_client;
	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_action( 'woocommerce_order_status_pending', 'send_customer_sms_notification', 10, 1);
		add_action( 'woocommerce_order_status_failed', 'send_customer_sms_notification', 10, 1);
		add_action( 'woocommerce_order_status_on-hold', 'send_customer_sms_notification', 10, 1);
		add_action( 'woocommerce_order_status_processing', 'send_customer_sms_notification', 10, 1);
		add_action( 'woocommerce_order_status_completed', 'send_customer_sms_notification', 10, 1);
		add_action( 'woocommerce_order_status_refunded', 'send_customer_sms_notification', 10, 1);
		add_action( 'woocommerce_order_status_cancelled', 'send_customer_sms_notification', 10, 1);

		foreach ( array( 'pending', 'failed', 'on-hold', 'processing', 'completed', 'refunded', 'cancelled' ) as $status ) {
			add_action( 'woocommerce_order_status_' . $status, array( $this, 'send_customer_sms_notification' ) );
		}
		$this->nexmo_client = new Nexmo\Client(new Nexmo\Client\Credentials\Basic(WC_SMS_ORDER_NEXMO_KEY, WC_SMS_ORDER_NEXMO_SECRET));
		
	}

	public function send_customer_sms_notification( $order_id ) {
		$order = wc_get_order( $order_id );
		$new_order_status = $order->get_status();
		$phone_number   = method_exists( $order, 'get_billing_phone' ) ? $order->get_billing_phone() : $order->billing_phone;
		$message =  "Your order #".$order_id." status has been updated to ".$new_order_status;
		
		try {
			$message = $this->nexmo_client->message()->send([
				'to' => $phone_number,
				'from' => WC_SMS_ORDER_NEXMO_SENDER_NAME,
				'text' => $message
			]);
			$response = $message->getResponseData();
		
			if($response['messages'][0]['status'] == 0) {
				$order_note = "Customer notified on order status change to ".$new_order_status." via SMS (".$phone_number.")";
			} else {
				$order_note = "Unable to notify customer on order status change via SMS. Error:". $response['messages'][0]['status'];
			}
		} catch (Exception $e) {
			$order_note = "Unable to notify customer on order status change via SMS. Error:". $e->getMessage();
		}
		$order->add_order_note( $order_note );
	}
	

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Nexmo_Wc_Sms_Order_Status_Notification_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Nexmo_Wc_Sms_Order_Status_Notification_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/nexmo-wc-sms-order-status-notification-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Nexmo_Wc_Sms_Order_Status_Notification_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Nexmo_Wc_Sms_Order_Status_Notification_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/nexmo-wc-sms-order-status-notification-public.js', array( 'jquery' ), $this->version, false );

	}

}
