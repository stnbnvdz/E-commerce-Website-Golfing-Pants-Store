<?php
/**
 * Custom Payment Gateways for WooCommerce - General Section Settings
 *
 * @version 1.2.0
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_Custom_Payment_Gateways_Settings_General' ) ) :

class Alg_WC_Custom_Payment_Gateways_Settings_General extends Alg_WC_Custom_Payment_Gateways_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function __construct() {
		$this->id   = '';
		$this->desc = __( 'General', 'custom-payment-gateways-for-woocommerce' );
		parent::__construct();
	}

	/**
	 * get_settings.
	 *
	 * @version 1.2.0
	 * @since   1.0.0
	 */
	function get_settings() {
		$settings = array(
			array(
				'title'    => __( 'Custom Payment Gateways Options', 'custom-payment-gateways-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_custom_payment_gateways_options',
				'desc'     => __( 'Here you can set number of custom payment gateways to add.', 'custom-payment-gateways-for-woocommerce' )
					. ' ' . sprintf( __( 'After setting the number, visit %s to set each gateway\'s options.', 'custom-payment-gateways-for-woocommerce' ),
						'<a href="' . admin_url( 'admin.php?page=wc-settings&tab=checkout' ) . '">' .
							__( 'WooCommerce > Settings > Payments', 'custom-payment-gateways-for-woocommerce' ) . '</a>' ),
			),
			array(
				'title'    => __( 'Custom Payment Gateways', 'custom-payment-gateways-for-woocommerce' ),
				'desc'     => '<strong>' . __( 'Enable plugin', 'custom-payment-gateways-for-woocommerce' ) . '</strong>',
				'desc_tip' => __( 'WooCommerce Custom Payment Gateways.', 'custom-payment-gateways-for-woocommerce' ),
				'id'       => 'alg_wc_custom_payment_gateways_enabled',
				'default'  => 'yes',
				'type'     => 'checkbox',
			),
			array(
				'title'    => __( 'Number of gateways', 'custom-payment-gateways-for-woocommerce' ),
				'desc'     => apply_filters( 'alg_wc_custom_payment_gateways',
					sprintf( '<br>' . 'You will need <a target="_blank" href="%s">Custom Payment Gateways for WooCommerce Pro plugin</a> to add more than one custom payment gateway.',
						'https://wpfactory.com/item/custom-payment-gateways-woocommerce/' ), 'settings_total_gateways' ),
				'desc_tip' => __( 'Number of custom payments gateways to be added.', 'custom-payment-gateways-for-woocommerce' ) . ' ' .
					__( 'Press Save changes after changing this number.', 'custom-payment-gateways-for-woocommerce' ),
				'id'       => 'alg_wc_custom_payment_gateways_number',
				'default'  => 1,
				'type'     => 'number',
				'custom_attributes' => apply_filters( 'alg_wc_custom_payment_gateways', array( 'readonly' => 'readonly' ), 'settings_array' ),
			),
		);
		for ( $i = 1; $i <= apply_filters( 'alg_wc_custom_payment_gateways', 1, 'value_total_gateways' ); $i++ ) {
			$settings[] = array(
				'title'    => __( 'Admin title for Custom Gateway', 'custom-payment-gateways-for-woocommerce' ) . ' #' . $i,
				'id'       => 'alg_wc_custom_payment_gateways_admin_title_' . $i,
				'default'  => __( 'Custom Gateway', 'custom-payment-gateways-for-woocommerce' ) . ' #' . $i,
				'type'     => 'text',
				'desc'     => '<a class="button" href="' . admin_url( 'admin.php?page=wc-settings&tab=checkout&section=alg_custom_gateway_' . $i ) . '" target="_blank">' .
					__( 'Settings', 'woocommerce' ) . '</a>',
			);
		}
		$settings = array_merge( $settings, array(
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_custom_payment_gateways_options',
			),
		) );
		return $settings;
	}

}

endif;

return new Alg_WC_Custom_Payment_Gateways_Settings_General();
