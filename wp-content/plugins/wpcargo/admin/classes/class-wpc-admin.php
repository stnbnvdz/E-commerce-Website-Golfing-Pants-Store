<?php
class WPC_Admin{
	public static function add_user_role() {
		// Add User Role
		add_role('cargo_agent', 'WPCargo Agent', array(
			'read' => true,
			'edit_posts' => true,
			'delete_posts' => false
		));
		add_role('wpcargo_client', 'WPCargo Client', array(
	        'read' => true, // True allows that capability
	    ));
     }
	public static function remove_user_role() {
		// Remove User Role
		remove_role( 'cargo_agent' );
		remove_role( 'wpcargo_client' );
     }
	public static function add_track_page() {
		if (get_page_by_title('Track') == NULL) {
			//post status and options
			$form    = array(
				'comment_status' => 'closed',
				'ping_status' => 'closed',
				'post_author' => 1,
				'post_date' => date('Y-m-d H:i:s'),
				'post_name' => 'track-form',
				'post_status' => 'publish',
				'post_title' => 'Track',
				'post_type' => 'page',
				'post_content' => '[wpcargo_trackform]'
			);
			$trackf  = wp_insert_post($form, false);
		}
	 }
	 static function wpcargo_load_textdomain() {
		 load_plugin_textdomain( 'wpcargo', false, '/wpcargo/languages' );
	 }
}