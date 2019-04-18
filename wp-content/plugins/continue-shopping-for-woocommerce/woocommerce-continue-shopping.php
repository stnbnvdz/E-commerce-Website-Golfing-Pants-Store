<?php
/*
Plugin Name: WooCommerce Continue Shopping
Plugin URI: http://www.happykite.co.uk
Description: Provides the ability to choose where the 'Continue Shopping' button on the WooCommerce Checkout takes you.
Author: HappyKite
Author URI: http://www.happykite.co.uk/
Version: 1.3.1
WC requires at least: 2.4
WC tested up to: 3.3.3
*/

/*
 This file is part of WooCommerce Continue Shopping.
 WooCommerce Continue Shopping is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.
 WooCommerce Continue Shopping is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.
 You should have received a copy of the GNU General Public License
 along with WooCommerce Continue Shopping.  If not, see <http://www.gnu.org/licenses/>.
 */

/***************************
 * global variables
 ***************************/

//Retrieve settings from Admin Options table
$hpy_cs_options = get_option('hpy_cs_settings');


/***************************
 * includes
 ***************************/

add_action( 'plugins_loaded', 'hpy_cs_initiate_plugin' );

function hpy_cs_initiate_plugin() {
	include('classes/class-admin-options.php');
	include('classes/class-continue-shopping.php');
}

/***************************
 * Adding Plugin Settings Link
 ***************************/

function hpy_cs_settings_link($links) {
	$settings_link = '<a href="admin.php?page=wc-settings&tab=products&section=hpy_cs">Settings</a>';
	array_unshift($links, $settings_link);
	return $links;
}

$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'hpy_cs_settings_link' );