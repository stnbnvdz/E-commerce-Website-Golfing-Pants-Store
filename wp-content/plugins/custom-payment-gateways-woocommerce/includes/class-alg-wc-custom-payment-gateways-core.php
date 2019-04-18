<?php
/**
 * Custom Payment Gateways for WooCommerce - Core Class
 *
 * @version 1.2.0
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_Custom_Payment_Gateways_Core' ) ) :

class Alg_WC_Custom_Payment_Gateways_Core {

	/**
	 * Constructor.
	 *
	 * @version 1.2.0
	 * @since   1.0.0
	 */
	function __construct() {
		if ( 'yes' === get_option( 'alg_wc_custom_payment_gateways_enabled', 'yes' ) ) {
			// Include custom payment gateways class
			require_once( 'class-wc-gateway-alg-custom.php' );
		}
	}

}

endif;

return new Alg_WC_Custom_Payment_Gateways_Core();
