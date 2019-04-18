<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class WPCargo_Post_Types{
	public static function init(){
		add_action('init', array( __CLASS__, 'wpcargo_post_type' ), 9 );
	}
	public static function wpcargo_post_type(){
		$labels_menu = array(
			'name'					=> _x('Shipment', 'Shipment', 'wpcargo'),
			'singular_name'			=> _x('Shipment', 'Shipment', 'wpcargo'),
			'menu_name' 			=> __('Shipment', 'wpcargo'),
			'all_items' 			=> __('All Shipment', 'wpcargo'),
			'view_item' 			=> __('View Shipment', 'wpcargo'),
			'add_new_item' 			=> __('Add New Shipment', 'wpcargo'),
			'add_new' 				=> __('Add Shipment', 'wpcargo'),
			'edit_item' 			=> __('Edit Shipment', 'wpcargo'),
			'update_item' 			=> __('Update Shipment', 'wpcargo'),
			'search_items' 			=> __('Search Shipment', 'wpcargo'),
			'not_found' 			=> __('Shipment Not found', 'wpcargo'),
			'not_found_in_trash' 	=> __('Shipment Not found in Trash', 'wpcargo')
		);
		$wpcargo_supports 			= array( 'title', 'author', 'thumbnail', 'revisions' );
		$args_tag         			= array(
			'label' 				=> __('Shipment', 'wpcargo'),
			'description' 			=> __('Shipment', 'wpcargo'),
			'labels' 				=> $labels_menu,
			'supports' 				=> $wpcargo_supports,
			'taxonomies' 			=> array( 'wpcargo_shipment', 'post_tag' ),
			'menu_icon' 			=> 'dashicons-location-alt',
			'hierarchical' 			=> true,
			'public' 				=> false,
			'show_ui' 				=> true,
			'show_in_menu' 			=> true,
			'show_in_nav_menus' 	=> true,
			'show_in_admin_bar' 	=> true,
			'menu_position' 		=> 5,
			'can_export' 			=> true,
			'has_archive' 			=> false,
			'exclude_from_search' 	=> true,
			'publicly_queryable' 	=> false,
			'capability_type' 		=> 'post'
		);
		register_post_type('wpcargo_shipment', $args_tag);
		$labels_cat = array(
			'name' 				=> _x('Category', 'wpcargo'),
			'singular_name' 	=> _x('Category', 'wpcargo'),
			'search_items' 		=> __('Search Category', 'wpcargo'),
			'all_items' 		=> __('All Category', 'wpcargo'),
			'parent_item' 		=> __('Parent Category', 'wpcargo'),
			'parent_item_colon' => __('Parent Category:', 'wpcargo'),
			'edit_item' 		=> __('Edit Category', 'wpcargo'),
			'update_item' 		=> __('Update Category', 'wpcargo'),
			'add_new_item' 		=> __('Add New Category', 'wpcargo'),
			'new_item_name' 	=> __('New Category Name', 'wpcargo'),
			'menu_name' 		=> __('Category', 'wpcargo')
		);
		$args_cat   = array(
			'hierarchical' 		=> true,
			'labels' 			=> $labels_cat,
			'show_ui' 			=> true,
			'show_admin_column' => true,
			'query_var' 		=> true
		);
		register_taxonomy('wpcargo_shipment_cat', array( 'wpcargo_shipment'	), $args_cat, 20);
	}
}
WPCargo_Post_Types::init();
