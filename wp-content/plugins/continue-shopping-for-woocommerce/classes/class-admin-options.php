<?php

/**
 * The admin-options of the plugin.
 *
 * @link       http://happykite.co.uk
 * @since      1.0
 *
 * @package    HPY_CS
 * @subpackage HPY_CS/classes
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    HPY_CS
 * @subpackage HPY_CS/classes
 * @author     HappyKite <mike@happykite.co.uk>
 */

class HPY_CS_Admin {

	public static function init() {
		//Add a new section to the Products settings page then add out required fields.
		add_filter( 'woocommerce_get_sections_products', __CLASS__ . '::add_settings_tab' );
		add_filter( 'woocommerce_get_settings_products', __CLASS__ . '::get_settings', 10, 2 );
	}

	/**
	 * Add a new settings tab to the WooCommerce settings tabs array.
	 *
	 * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
	 * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
	 */
	public static function add_settings_tab( $sections ) {
		$sections['hpy_cs'] = __( 'Continue Shopping', 'woocommerce-settings-hpy-cs' );
		return $sections;
	}

	/**
	 * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
	 *
	 * @return array Array of settings for @see woocommerce_admin_fields() function.
	 */
	public static function get_settings( $settings, $current_section ) {
		$redirect_to_cart = get_option( 'woocommerce_cart_redirect_after_add' );
		$continue_destination = get_option( 'hpy_cs_destination' );
		$custom_link = get_option( 'hpy_cs_custom_link' );

		//Check for the current section, if it is our newly created section add our new fields, otherwise continue with the WooCommerce settings.
		if ( $current_section == 'hpy_cs' ) {

			$settings_cs = array();

			if ( $redirect_to_cart == 'yes' ) {
				$settings_cs[] = array(
					'title' => __( 'Continue Shopping Settings', 'hpy_cs' ),
					'type'  => 'title',
					'id'    => 'hpy_cs_title'
				);
			}else {
				$settings_cs[] = array(
					'title' => __( 'Continue Shopping Settings', 'hpy_cs' ),
					'type'  => 'title',
					'desc'  => '<div class="hpy-cs-error"><p><strong>Please Note</strong>: Continue Shopping only appears when WooCommerce is set to Redirect to the cart page after successful addition. This option can be changed <a href="' . get_site_url() . '/wp-admin/admin.php?page=wc-settings&tab=products&section=display">here</a></p></div>',
					'id'    => 'hpy_cs_title'
				);
			}

			$settings_cs[] = array(
				'title'           => __( 'Continue Shopping Destination', 'hpy_cs' ),
				'id'              => 'hpy_cs_destination',
				'default'         => 'home',
				'type'            => 'radio',
				'options'         => array(
					'home'        => __( 'Back to the Home Page', 'hpy_cs' ),
					'shop'        => __( 'Back to the Shop', 'hpy_cs' ),
					'recent_prod' => __( 'Jump back to the most recently viewed Product', 'hpy_cs' ),
					'recent_cat'  => __( 'Jump back to the most recently viewed Category', 'hpy_cs' ),
					'custom'      => __( 'Choose your own link (Best used to redirect to a landing page)', 'hpy_cs' ),
				),
				'autoload'        => false,
				'desc_tip'        => true,
				'show_if_checked' => 'option',
			);

			if ( $continue_destination == 'custom' ) {
				$settings_cs[] = array(
					'title'       => __( 'Custom Link', 'hpy_cs' ),
					'id'          => 'hpy_cs_custom_link',
					'desc_tip'    => true,
					'desc'        => 'Please enter the link you want to redirect to',
					'type'        => 'text',
				);
			}

			if ( $continue_destination == 'custom' && ( empty( $custom_link ) || !isset( $custom_link ) ) ) {
				$settings_cs[] = array(
					'type'        => 'title',
					'desc'        => '<div class="error"><p>You have Custom Link chosen however you have not set a Custom Link. Please enter it below.</p></div>',
					'id'          => 'hpy_cs_empty_link'
				);
			}

			$settings_cs[] = array(
				'title'       => __( 'Display notice', 'hpy_cs' ),
				'label'		  => __( 'Always show on Empty Cart?', 'hpy_cs' ),
				'id'          => 'hpy_cs_empty_cart_notice',
				'desc_tip'    => true,
				'desc'        => 'This will display if the Cart is empty. It will prompt the user to head to the selected option above.',
				'type'        => 'checkbox',
			);

			$settings_cs[] = array(
				'title'       => __( 'Empty Cart Text', 'hpy_cs' ),
				'id'          => 'hpy_cs_empty_cart_text',
				'desc_tip'    => true,
				'desc'        => 'This will display if the Cart is empty. It will prompt the user to head to the selected option above.',
				'type'        => 'text',
			);

			$settings_cs[] = array( 'type' => 'sectionend', 'id' => 'shipping_options' );

			return $settings_cs;
		} else {
			return $settings;
		}
	}

	public static function hpy_save_recent_category( $referrer ) {
		delete_transient( 'recent_cat' );
		set_transient( 'recent_cat', $referrer, 60*60*12 );

		return;
	}

}

HPY_CS_Admin::init();