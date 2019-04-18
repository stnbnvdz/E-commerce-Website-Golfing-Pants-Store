<?php
/**
Plugin Name: WC Pickup Store
Description: Sets up a custom post type for stores available to use it as shipping method Local pickup in WooCommerce. It allows you to choose an store in Checkout page and it adds the details in order details and email.
Version: 1.5.14
Requires at least: 4.7
Tested up to: 5.0.3
WC requires at least: 3.0
WC tested up to: 3.5.3
Author: Keylor Mendoza A.
Author URI: https://www.keylormendoza.com
License: GPLv2
Text Domain: wc-pickup-store
*/

if (!defined('ABSPATH')) { exit; }

if (!defined('WPS_PLUGIN_FILE')) {
	define('WPS_PLUGIN_FILE', plugin_basename(__FILE__));
}

/**
** Check if WooCommerce is active
**/
if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
	add_action('admin_notices', 'wps_store_inactive_notice');
	return;
}

function wps_store_inactive_notice() {
	if ( current_user_can( 'activate_plugins' ) ) :
		if ( !class_exists( 'WooCommerce' ) ) :
			?>
			<div id="message" class="error">
				<p>
					<?php
					printf(
						__('%s requires %sWooCommerce%s to be active.', 'wc-pickup-store'),
						'<strong>WC Pickup Store</strong>',
						'<a href="http://wordpress.org/plugins/woocommerce/" target="_blank" >',
						'</a>'
					);
					?>
				</p>
			</div>		
			<?php
		endif;
	endif;
}

include plugin_dir_path(__FILE__) . '/includes/wps-init.php';
include plugin_dir_path(__FILE__) . '/includes/wps-admin.php';
include plugin_dir_path(__FILE__) . '/includes/wps-functions.php';
include plugin_dir_path(__FILE__) . '/includes/widget-stores.php';
include plugin_dir_path(__FILE__) . '/includes/post_type-store.php';
include plugin_dir_path(__FILE__) . '/includes/vc_stores.php';

