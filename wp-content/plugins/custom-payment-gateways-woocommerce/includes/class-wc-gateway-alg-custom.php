<?php
/**
 * Custom Payment Gateways for WooCommerce - Gateways Class
 *
 * @version 1.2.0
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

add_action( 'plugins_loaded', 'init_wc_gateway_alg_custom_class' );

if ( ! function_exists( 'init_wc_gateway_alg_custom_class' ) ) {

	function init_wc_gateway_alg_custom_class() {

		if ( class_exists( 'WC_Payment_Gateway' ) ) {

			/**
			 * WC_Gateway_Alg_Custom_Template class.
			 *
			 * @version 1.2.0
			 * @since   1.0.0
			 */
			class WC_Gateway_Alg_Custom_Template extends WC_Payment_Gateway {

				/**
				 * Constructor.
				 *
				 * @version 1.1.0
				 * @since   1.0.0
				 */
				function __construct() {
					$this->is_wc_version_below_3 = version_compare( get_option( 'woocommerce_version', null ), '3.0.0', '<' );
					return true;
				}

				/**
				 * Initialise gateway settings form fields.
				 *
				 * @version 1.2.0
				 * @since   1.0.0
				 * @todo    [dev] check if we really need `is_admin()` for `$shipping_methods`
				 */
				function init_form_fields() {
					// Prepare shipping methods
					$shipping_methods = array();
					if ( is_admin() ) {
						$data_store = WC_Data_Store::load( 'shipping-zone' );
						$raw_zones  = $data_store->get_zones();
						foreach ( $raw_zones as $raw_zone ) {
							$zones[] = new WC_Shipping_Zone( $raw_zone );
						}
						$zones[] = new WC_Shipping_Zone( 0 );
						foreach ( WC()->shipping()->load_shipping_methods() as $method ) {
							$shipping_methods[ $method->get_method_title() ] = array();
							// Translators: %1$s shipping method name.
							$shipping_methods[ $method->get_method_title() ][ $method->id ] = sprintf( __( 'Any &quot;%1$s&quot; method', 'woocommerce' ),
								$method->get_method_title() );
							foreach ( $zones as $zone ) {
								$shipping_method_instances = $zone->get_shipping_methods();
								foreach ( $shipping_method_instances as $shipping_method_instance_id => $shipping_method_instance ) {
									if ( $shipping_method_instance->id !== $method->id ) {
										continue;
									}
									$option_id = $shipping_method_instance->get_rate_id();
									// Translators: %1$s shipping method title, %2$s shipping method id.
									$option_instance_title = sprintf( __( '%1$s (#%2$s)', 'woocommerce' ),
										$shipping_method_instance->get_title(), $shipping_method_instance_id );
									// Translators: %1$s zone name, %2$s shipping method instance name.
									$option_title = sprintf( __( '%1$s &ndash; %2$s', 'woocommerce' ), $zone->get_id() ? $zone->get_zone_name() :
										__( 'Other locations', 'woocommerce' ), $option_instance_title );
									$shipping_methods[ $method->get_method_title() ][ $option_id ] = $option_title;
								}
							}
						}
					}
					// Prepare icon description
					$icon_desc = ( '' !== ( $icon_url = $this->get_option( 'icon', '' ) ) ?
						'<img src="' . $icon_url . '" alt="' . $this->title . '" title="' . $this->title . '" />' : '' );
					// Form fields
					$this->form_fields = require( 'settings/class-wc-gateway-alg-custom-form-fields.php' );
				}

				/**
				 * Check if the gateway is available for use,
				 *
				 * @version 1.2.0
				 * @since   1.0.0
				 * @return  bool
				 * @todo    [dev] recheck enable_for_virtual part of the code
				 */
				function is_available() {
					$order = null;

					// Check min amount
					$min_amount = apply_filters( 'alg_wc_custom_payment_gateways', 0, 'value_min_amount', $this );
					if ( $min_amount > 0 && isset( WC()->cart->total ) && '' != WC()->cart->total && isset( WC()->cart->fee_total ) ) {
						$total_excluding_fees = WC()->cart->total - WC()->cart->fee_total;
						if ( $total_excluding_fees < $min_amount ) {
							return false;
						}
					}

					// Check if is virtual
					if ( ! $this->enable_for_virtual ) {
						if ( WC()->cart && ! WC()->cart->needs_shipping() ) {
							return false;
						}
						if ( is_page( wc_get_page_id( 'checkout' ) ) && 0 < get_query_var( 'order-pay' ) ) {
							$order_id = absint( get_query_var( 'order-pay' ) );
							$order    = wc_get_order( $order_id );
							// Test if order needs shipping.
							$needs_shipping = false;
							if ( 0 < sizeof( $order->get_items() ) ) {
								foreach ( $order->get_items() as $item ) {
									$_product = $order->get_product_from_item( $item );

									if ( $_product->needs_shipping() ) {
										$needs_shipping = true;
										break;
									}
								}
							}
							$needs_shipping = apply_filters( 'woocommerce_cart_needs_shipping', $needs_shipping );
							if ( $needs_shipping ) {
								return false;
							}
						}
					}

					// Only apply if all packages are being shipped via ...
					if ( ! empty( $this->enable_for_methods ) ) {
						$session_object = WC()->session;
						$chosen_shipping_methods_session = ( is_object( $session_object ) ) ? $session_object->get( 'chosen_shipping_methods' ) : null;
						$chosen_shipping_methods = ( isset( $chosen_shipping_methods_session ) ) ? array_unique( $chosen_shipping_methods_session ) : array();
						$check_method = false;
						if ( is_object( $order ) ) {
							$shipping_method = ( $this->is_wc_version_below_3 ? $order->shipping_method : $order->get_shipping_method() );
							if ( $shipping_method ) {
								$check_method = $shipping_method;
							}
						} elseif ( empty( $chosen_shipping_methods ) || sizeof( $chosen_shipping_methods ) > 1 ) {
							$check_method = false;
						} elseif ( sizeof( $chosen_shipping_methods ) == 1 ) {
							$check_method = $chosen_shipping_methods[0];
						}
						if ( ! $check_method ) {
							return false;
						}
						$found = false;
						foreach ( $this->enable_for_methods as $method_id ) {
							if ( strpos( $method_id, ':' ) === false ) {
								$_check_method = explode( ':', $check_method );
								$_check_method = $_check_method[0];
							} else {
								$_check_method = $check_method;
							}
							if ( $_check_method === $method_id ) {
								$found = true;
								break;
							}
						}
						if ( ! $found ) {
							return false;
						}
					}

					return parent::is_available();
				}


				/**
				 * Output for the order received page.
				 *
				 * @version 1.0.0
				 * @since   1.0.0
				 */
				function thankyou_page() {
					if ( $this->instructions ) {
						echo do_shortcode( wpautop( wptexturize( $this->instructions ) ) );
					}
				}

				/**
				 * Add content to the WC emails.
				 *
				 * @version 1.1.0
				 * @since   1.0.0
				 * @access  public
				 * @param   WC_Order $order
				 * @param   bool $sent_to_admin
				 * @param   bool $plain_text
				 */
				function email_instructions( $order, $sent_to_admin, $plain_text = false ) {
					if ( $this->instructions_in_email && ! $sent_to_admin && $this->id === ( $this->is_wc_version_below_3 ? $order->payment_method : $order->get_payment_method() ) && $this->default_order_status === ( $this->is_wc_version_below_3 ? $order->status : $order->get_status() ) ) {
						echo do_shortcode( wpautop( wptexturize( $this->instructions_in_email ) ) . PHP_EOL );
					}
				}

				/**
				 * Process the payment and return the result
				 *
				 * @version 1.1.0
				 * @since   1.0.0
				 * @param   int $order_id
				 * @return  array
				 */
				function process_payment( $order_id ) {

					$order = wc_get_order( $order_id );

					// Mark as default order status
					$statuses = alg_wc_custom_payment_gateways_get_order_statuses();
					$note = isset( $statuses[ $this->default_order_status ] ) ? $statuses[ $this->default_order_status ] : '';
					$order->update_status( $this->default_order_status, $note ); // e.g. ( 'on-hold', __( 'Awaiting payment', 'woocommerce' ) )

					// Emails
					if ( 'yes' === $this->send_email_to_admin || 'yes' === $this->send_email_to_customer ) {
						$woocommerce_mailer = WC()->mailer();
						if ( 'yes' === $this->send_email_to_admin ) {
							$woocommerce_mailer->emails['WC_Email_New_Order']->trigger( $order_id );
						}
						if ( 'yes' === $this->send_email_to_customer ) {
							$woocommerce_mailer->emails['WC_Email_Customer_Processing_Order']->trigger( $order_id );
						}
					}

					// Reduce stock levels
					$result_reduce_order_stock = ( $this->is_wc_version_below_3 ? $order->reduce_order_stock() : wc_reduce_stock_levels( $order->get_id() ) );

					// Remove cart
					WC()->cart->empty_cart();

					// Return thankyou redirect
					return array(
						'result'   => 'success',
						'redirect' => ( '' == $this->custom_return_url ) ? $this->get_return_url( $order ) : $this->custom_return_url,
					);
				}

				/**
				 * init.
				 *
				 * @version 1.2.0
				 * @since   1.0.0
				 */
				function init( $id_count ) {
					$this->id                       = 'alg_custom_gateway_' . $id_count;
					$this->has_fields               = false;
					$this->method_title             = get_option( 'alg_wc_custom_payment_gateways_admin_title_' . $id_count, __( 'Custom Gateway', 'custom-payment-gateways-for-woocommerce' ) . ' #' . $id_count );
					$this->method_description       = __( 'Custom Payment Gateway', 'custom-payment-gateways-for-woocommerce' ) . ' #' . $id_count;
					$this->id_count                 = $id_count;
					// Load the settings
					$this->init_form_fields();
					$this->init_settings();
					// Define user set variables
					$this->title                    = $this->get_option( 'title', __( 'Custom Payment Gateway', 'custom-payment-gateways-for-woocommerce' ) );
					$this->description              = $this->get_option( 'description', __( 'Custom Payment Gateway Description.', 'custom-payment-gateways-for-woocommerce' ) );
					$this->instructions             = $this->get_option( 'instructions', '' );
					$this->instructions_in_email    = $this->get_option( 'instructions_in_email', '' );
					$this->icon                     = $this->get_option( 'icon', '' );
					$this->min_amount               = $this->get_option( 'min_amount', 0 );
					$this->enable_for_methods       = $this->get_option( 'enable_for_methods', array() );
					$this->enable_for_virtual       = $this->get_option( 'enable_for_virtual', 'yes' ) === 'yes';
					$this->default_order_status     = $this->get_option( 'default_order_status', 'pending' );
					$this->send_email_to_admin      = $this->get_option( 'send_email_to_admin', 'no' );
					$this->send_email_to_customer   = $this->get_option( 'send_email_to_customer', 'no' );
					$this->custom_return_url        = $this->get_option( 'custom_return_url', '' );
					// Actions
					add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
					add_action( 'woocommerce_thankyou_' . $this->id,                        array( $this, 'thankyou_page' ) );
					add_action( 'woocommerce_email_before_order_table',                     array( $this, 'email_instructions' ), 10, 3 ); // Customer Emails
				}

			}

			/**
			 * add_wc_gateway_alg_custom_classes.
			 *
			 * @version 1.0.0
			 * @since   1.0.0
			 */
			function add_wc_gateway_alg_custom_classes( $methods ) {
				for ( $i = 1; $i <= apply_filters( 'alg_wc_custom_payment_gateways', 1, 'value_total_gateways' ); $i++ ) {
					$the_method = new WC_Gateway_Alg_Custom_Template();
					$the_method->init( $i );
					$methods[] = $the_method;
				}
				return $methods;
			}
			add_filter( 'woocommerce_payment_gateways', 'add_wc_gateway_alg_custom_classes' );
		}
	}
}
