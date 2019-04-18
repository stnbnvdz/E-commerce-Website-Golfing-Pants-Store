<?php
/**
 * Custom Payment Gateways for WooCommerce - Gateways Form Fields
 *
 * @version 1.2.0
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 * @todo    [dev] "Custom Order Status for WooCommerce plugin"
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

return array(
	'enabled' => array(
		'title'             => __( 'Enable/Disable', 'woocommerce' ),
		'type'              => 'checkbox',
		'label'             => __( 'Enable custom gateway', 'custom-payment-gateways-for-woocommerce' ),
		'default'           => 'no',
	),
	'title' => array(
		'title'             => __( 'Title', 'woocommerce' ),
		'type'              => 'text',
		'description'       => __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
		'default'           => __( 'Custom Payment Gateway', 'custom-payment-gateways-for-woocommerce' ),
		'desc_tip'          => true,
	),
	'description' => array(
		'title'             => __( 'Description', 'woocommerce' ),
		'type'              => 'textarea',
		'description'       => __( 'Payment method description that the customer will see on your checkout.', 'woocommerce' ),
		'default'           => __( 'Custom Payment Gateway Description.', 'custom-payment-gateways-for-woocommerce' ),
		'desc_tip'          => true,
	),
	'instructions' => array(
		'title'             => __( 'Instructions', 'woocommerce' ),
		'type'              => 'textarea',
		'description'       => __( 'Instructions that will be added to the thank you page.', 'custom-payment-gateways-for-woocommerce' ),
		'default'           => '',
		'desc_tip'          => true,
	),
	'instructions_in_email' => array(
		'title'             => __( 'Email instructions', 'custom-payment-gateways-for-woocommerce' ),
		'type'              => 'textarea',
		'description'       => __( 'Instructions that will be added to the emails.', 'custom-payment-gateways-for-woocommerce' ),
		'default'           => '',
		'desc_tip'          => true,
	),
	'icon' => array(
		'title'             => __( 'Icon', 'custom-payment-gateways-for-woocommerce' ),
		'type'              => 'text',
		'desc_tip'          => __( 'If you want to show an image next to the gateway\'s name on the frontend, enter a URL to an image.', 'custom-payment-gateways-for-woocommerce' ),
		'default'           => '',
		'description'       => $icon_desc,
		'css'               => 'width:100%',
	),
	'min_amount' => array(
		'title'             => __( 'Minimum order amount', 'custom-payment-gateways-for-woocommerce' ),
		'type'              => 'number',
		'desc_tip'          => __( 'If you want to set minimum order amount (excluding fees) to show this gateway on frontend, enter a number here. Set to 0 to disable.', 'custom-payment-gateways-for-woocommerce' ),
		'default'           => 0,
		'description'       => apply_filters( 'alg_wc_custom_payment_gateways', sprintf(
			'You will need <a target="_blank" href="%s">Custom Payment Gateways for WooCommerce Pro plugin</a> to use minimum order amount option.',
				'https://wpfactory.com/item/custom-payment-gateways-woocommerce/' ), 'settings' ),
		'custom_attributes' => apply_filters( 'alg_wc_custom_payment_gateways', array( 'disabled' => 'disabled' ), 'settings_array_min_amount' ),
	),
	'enable_for_methods' => array(
		'title'             => __( 'Enable for shipping methods', 'woocommerce' ),
		'type'              => 'multiselect',
		'class'             => 'chosen_select',
		'default'           => '',
		'description'       => __( 'If gateway is only available for certain shipping methods, set it up here. Leave blank to enable for all methods.', 'custom-payment-gateways-for-woocommerce' ),
		'options'           => $shipping_methods,
		'desc_tip'          => true,
		'custom_attributes' => array( 'data-placeholder' => __( 'Select shipping methods', 'woocommerce' ) ),
	),
	'enable_for_virtual' => array(
		'title'             => __( 'Accept for virtual orders', 'woocommerce' ),
		'label'             => __( 'Accept', 'custom-payment-gateways-for-woocommerce' ),
		'description'       => __( 'Accept gateway if the order is virtual.', 'custom-payment-gateways-for-woocommerce' ),
		'type'              => 'checkbox',
		'default'           => 'yes'
	),
	'default_order_status' => array(
		'title'             => __( 'Default order status', 'custom-payment-gateways-for-woocommerce' ),
		'description'       => sprintf( 'In case you need more custom order statuses - we suggest using free <a target="_blank" href="%s">Custom Order Status for WooCommerce plugin</a>.',
			'https://wordpress.org/plugins/custom-order-statuses-woocommerce/' ),
		'default'           => apply_filters( 'woocommerce_default_order_status', 'pending' ),
		'type'              => 'select',
		'options'           => alg_wc_custom_payment_gateways_get_order_statuses(),
	),
	'send_email_to_admin' => array(
		'title'             => __( 'Send additional emails', 'custom-payment-gateways-for-woocommerce' ),
		'description'       => sprintf( __( 'This may help if you are using pending or custom default order status and not receiving %s emails.', 'custom-payment-gateways-for-woocommerce' ),
			'<a target="_blank" href="' . admin_url( 'admin.php?page=wc-settings&tab=email&section=wc_email_new_order' ) . '">' .
				__( 'admin new order', 'custom-payment-gateways-for-woocommerce' ) . '</a>' ),
		'label'             => __( 'Send to admin', 'custom-payment-gateways-for-woocommerce' ),
		'default'           => 'no',
		'type'              => 'checkbox',
	),
	'send_email_to_customer' => array(
		'label'             => __( 'Send to customer', 'custom-payment-gateways-for-woocommerce' ),
		'description'       => sprintf( __( 'This may help if you are using pending or custom default order status and not receiving %s emails.', 'custom-payment-gateways-for-woocommerce' ),
			'<a target="_blank" href="' . admin_url( 'admin.php?page=wc-settings&tab=email&section=wc_email_customer_processing_order' ) . '">' .
				__( 'customer processing order', 'custom-payment-gateways-for-woocommerce' ) . '</a>' ),
		'default'           => 'no',
		'type'              => 'checkbox',
	),
	'custom_return_url' => array(
		'title'             => __( 'Custom return URL (Thank You page)', 'custom-payment-gateways-for-woocommerce' ),
		'label'             => __( 'URL', 'custom-payment-gateways-for-woocommerce' ),
		'desc_tip'          => __( 'Enter full URL with http(s).', 'custom-payment-gateways-for-woocommerce' ),
		'description'       => __( 'Optional. Leave blank to use default URL.', 'custom-payment-gateways-for-woocommerce' ),
		'default'           => '',
		'type'              => 'text',
		'css'               => 'width:100%',
	),
);
