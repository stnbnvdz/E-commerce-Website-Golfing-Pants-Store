<?php
/**
** Add shipping method to WC
**/
function wps_store_shipping_method( $methods ) {
	$methods['wc_pickup_store'] = 'WC_PICKUP_STORE';

	return $methods;
}
add_filter('woocommerce_shipping_methods', 'wps_store_shipping_method');

/**
** Declare Shipping Method
**/
function wps_store_shipping_method_init() {
	class WC_PICKUP_STORE extends WC_Shipping_Method {
		/**
		 * Constructor for your shipping class
		 *
		 * @access public
		 * @return void
		 */
		public function __construct() {
			$this->id = 'wc_pickup_store';
			$this->method_title = __('WC Pickup Store');
			$this->method_description = __('Lets users to choose a store to pick up their products', 'wc-pickup-store');

			$this->init();
			// $this->includes();
		}

		// public function includes() {}

		/**
		 * Init your settings
		 *
		 * @access public
		 * @return void
		 */
		function init() {
			// Load the settings API
			$this->init_form_fields(); // This is part of the settings API. Override the method to add your own settings
			$this->init_settings(); // This is part of the settings API. Loads settings you previously init.

			// Turn these settings into variables we can use
			foreach ( $this->settings as $setting_key => $value ) {
				$this->$setting_key = $value;
			}

			// Save settings in admin if you have any defined
			add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
			add_filter('woocommerce_get_order_item_totals', array($this, 'wc_reordering_order_item_totals'), 10, 3);
		}

		public function init_form_fields() {
			$this->form_fields = array(
				'enabled' => array(
					'title' => __( 'Enable/Disable', 'woocommerce' ),
					'type' => 'checkbox',
					'label' => __( 'Enable', 'woocommerce' ),
					'default'  => 'yes',
					'description' => __( 'Enable/Disable shipping method', 'wc-pickup-store' ),
					'desc_tip'    => true
				),
				'enable_store_select' => array(
					'title' => __( 'Enable stores in checkout', 'wc-pickup-store' ),
					'type' => 'checkbox',
					'label' => __( 'Enable', 'woocommerce' ),
					'default'  => 'no',
					'description' => __( 'Shows select field to pick a store in checkout', 'wc-pickup-store' ),
					'desc_tip'    => true
				),
				'title' => array(
					'title' => __( 'Shipping Method Title', 'wc-pickup-store' ),
					'type' => 'text',
					'description' => __( 'Label that appears in checkout options', 'wc-pickup-store' ),
					'default' => __( 'Pickup Store', 'wc-pickup-store' ),
					'desc_tip'    => true
				),
				'costs' => array(
					'title' => __( 'Shipping Costs', 'wc-pickup-store' ),
					'type' => 'text',
					'description' => __( 'Adds shipping cost to store pickup', 'wc-pickup-store' ),
					'default' => 0,
					'placeholder' => '0',					
					'desc_tip'    => true
				),
				'costs_per_store' => array(
					'title' => __( 'Enable costs per store', 'wc-pickup-store' ),
					'type' => 'checkbox',
					'label' => __( 'Enable', 'woocommerce' ),
					'default'  => 'no',
					'description' => __( 'Allows to add shipping costs by store. Checking this will disable main shipping price.', 'wc-pickup-store' ),
					'desc_tip'    => true
				),
				'store_default' => array(
					'type' => 'store_default',
					'description' => __( 'Choose a default store to checkout', 'wc-pickup-store' ),
					'desc_tip'    => true
				),
				'checkout_notification' => array(
					'title' => __( 'Checkout notification', 'wc-pickup-store' ),
					'type' => 'textarea',
					'description' => __( 'Message that appears next to shipping options in Checkout page', 'wc-pickup-store' ),
					'default' => __( '', 'wc-pickup-store' ),
					'desc_tip'    => true
				),
				'plugin_version' => array(
					'type' => 'plugin_version',
				),
			);
		}

		public function is_available( $package ) {
			$is_available = ($this->enabled == 'yes') ? true : false;

			return apply_filters( 'woocommerce_shipping_' . $this->id . '_is_available', $is_available, $package, $this );
		}

		/**
		 * calculate_shipping function.
		 *
		 * @access public
		 * @param mixed $package
		 * @return void
		 */
		public function calculate_shipping( $package = array() ) {
			$rate = array(
				'id' => $this->id,
				'label' => $this->title,
				'cost' => (!empty($this->costs) && $this->costs_per_store != 'yes') ? apply_filters('wps_shipping_costs', $this->costs) : 0,
				'package' => $package,
				'calc_tax' => 'per_order' // 'per_item'
			);

			// Register the rate
			$this->add_rate( $rate );
		}

		public function generate_store_default_html() {
			ob_start();
			?>
			<tr valign="top">
				<th scope="row" class="titledesc"><?php _e('Default store', 'wc-pickup-store'); ?>:</th>
				<td class="forminp">
					<p><?php
						echo sprintf(__('Find this option in <a href="%s" target="_blank">the Customizer</a>', 'wc-pickup-store'), admin_url('/customize.php?autofocus[section]=wps_store_customize_section'));
					?></p>
				</td>
			</tr>
			<?php
			return ob_get_clean();
		}

		public function generate_plugin_version_html() {
			ob_start();
			?>
			<tr valign="top">
				<td colspan="2" align="right">
					<p><em><?php echo sprintf(__('Version %s', $this->id), get_plugin_data(__FILE__)['Version']); ?></em></p>
				</td>
			</tr>
			<?php
			return ob_get_clean();
		}

		public function wc_reordering_order_item_totals($total_rows, $order, $tax_display) {
			/* Update 1.5.9 */
			$order_id = $order->get_id();
			$store = get_post_meta($order_id, '_shipping_pickup_stores', true);
			$formatted_title = (!empty($this->costs) && $this->costs_per_store != 'yes') ? $this->title . ': ' . wc_price($this->costs) : $this->title;

			if($order->has_shipping_method($this->id) && !empty($store)) {
				foreach ($total_rows as $key => $row) {
					$new_rows[$key] = $row;
					if($key == 'shipping') {
						$new_rows['shipping']['value'] = $formatted_title;
						$new_rows[$this->id] = array(
							'label' => __('Pickup Store', 'wc-pickup-store') . '<span class="colon">: </span><span>' . $this->checkout_notification . '</span>',
							'value' => $store
						);
					}
				}
				$total_rows = $new_rows;
			}

			return $total_rows;
		}
	}
	new WC_PICKUP_STORE();
}
add_action('init', 'wps_store_shipping_method_init');