<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Register a meta box using a class.
 */
class WPCargo_Metabox {
	public $text_domain = 'wpcargo';
    public function __construct() {
		add_filter('wp_mail_content_type', array( $this, 'wpcargo_set_content_type' ));
        if ( is_admin() ) {
			add_action('wpcargo_shipper_meta_section', array( $this, 'wpc_shipper_meta_template' ), 10 );
			add_action('wpcargo_receiver_meta_section', array( $this, 'wpc_receiver_meta_template' ), 10 );
			add_action('wpcargo_shipment_meta_section', array( $this, 'wpc_shipment_meta_template' ), 10 );
			add_filter('wpcargo_after_reciever_meta_section_sep', array( $this, 'wpc_after_reciever_meta_sep' ), 10 );
			add_action( 'save_post',      array( $this, 'save_metabox' ) );
			add_action( 'add_meta_boxes', array( $this, 'add_metabox'  ) );
			add_action( 'post_submitbox_misc_actions', array( $this, 'shipment_status_display_callback' ) );
        }
		add_action('save_post_wpcargo_shipment', array( $this, 'wpcargo_shipment_history_email_template' ), 20, 10  );
    }

	/**
     * Adds the meta box.
     */
	 public function shipment_status_display_callback( $post ){
	 	global $wpcargo;
	 	$screen = get_current_screen();
		if( $screen->post_type != 'wpcargo_shipment' ){
			return false;
		}
		global $wpcargo;
		$current_status 	= get_post_meta( $post->ID, 'wpcargo_status', TRUE);
		$shipments_update 	= maybe_unserialize( get_post_meta( $post->ID, 'wpcargo_shipments_update', TRUE) );
		$location 			= '';
		if( !empty( $shipments_update ) ){
			$_history = array_pop ( $shipments_update );
			if( array_key_exists( 'location', $_history )){
				$location 	=  $_history['location'];
			}
		}

		ob_start();
		?>
		<div class="misc-pub-section wpc-status-section" style="background-color: #d4d4d4; border-top: 1px solid #757575;border-bottom: 1px solid #757575;">
			<h3 style="border-bottom: 1px solid #757575; padding-bottom: 6px;"><?php _e( 'Current Status', 'wpcargo' ); ?>: <?php echo wpcargo_html_value( $current_status ); ?></h3>
			<p><input style="width:100%;" class="date wpcargo-datepicker" type="text" name="status_date" value="<?php echo $wpcargo->user_date(get_current_user_id()); ?>" placeholder="<?php _e( 'yyyy-mm-dd', 'wpcargo' ); ?>" autocomplete="off"/></p>
			<p><input style="width:100%;" class="time wpcargo-timepicker" type="text" name="status_time" value="<?php echo $wpcargo->user_time(get_current_user_id()); ?>" autocomplete="off"/></p>
			<p><input style="width:100%;" id="wpcargo-location" class="status_location" type="text" name="status_location" value="<?php echo $location; ?>" placeholder="<?php _e( 'Current City', 'wpcargo' ); ?>" /></p>
			<?php if( !empty( $wpcargo->status ) ): ?>
		        <select style="width:100%;" class="wpcargo_status" name="wpcargo_status" >
		            <option value=""><?php _e( '--Select Status--', 'wpcargo' ) ?></option>
		            <?php
		                foreach( $wpcargo->status as $value ){
		                    ?><option value="<?php echo $value; ?>"><?php echo $value; ?></option><?php
		                }
		            ?>
		        </select>
		    <?php else: ?>
		        <p class="description"><?php _e( 'No Shipment Status Found.', 'wpcargo' ) ?> <a href="<?php echo admin_url('admin.php?page=wpcargo-settings'); ?>"><?php _e( 'Add Shipment Status', 'wpcargo' ) ?></a></p>
		    <?php endif; ?>
		    <p><textarea style="width:100%;" class="remarks" name="status_remarks" placeholder="<?php _e( 'Remarks', 'wpcargo' ); ?>" ></textarea></p>
			<?php do_action('wpcargo_shipment_misc_actions_form', $post ); ?>
		</div>
		<?php
		$output = ob_get_clean();
		echo $output;
	 }
	 public function add_metabox() {
	 	$wpc_mp_settings = get_option('wpc_mp_settings');
    	add_meta_box(
    		'wpc_add_meta_box',
    		wpcargo_shipment_details_label(),
    		array( $this, 'render_metabox' ),
    		'wpcargo_shipment'
    	);

		add_meta_box(
			'wpcargo_shipment_history',
			__( apply_filters( 'wpc_shipment_history_header', 'Shipment History' ), 'wpcargo' ),
			array( $this, 'wpc_sh_metabox_callback' ),
			'wpcargo_shipment'
		);

		if(!empty($wpc_mp_settings['wpc_mp_enable_admin'])) {

			add_meta_box( 'wpcargo-multiple-package',
				__( apply_filters( 'wpc_multiple_package_header', 'Multiple Package' ), 'wpcargo' ),
				array($this, 'wpc_mp_metabox_callback'),
				'wpcargo_shipment'
			);
		}
    }

	/**
     * Renders the meta box.
     */

	 public function render_metabox( $post ) {

        // Add nonce for security and authentication.
        wp_nonce_field( 'wpc_metabox_action', 'wpc_metabox_nonce' );
		$this->wpc_title_autogenerate();
		?>
		<div id="wrap">
		<?php

			do_action('wpcargo_before_metabox_section', 10);
			do_action('wpcargo_shipper_meta_section', 10);
			do_action('wpcargo_receiver_meta_section', 10);
			apply_filters('wpcargo_after_reciever_meta_section_sep', 10 );
			do_action('wpcargo_shipment_meta_section', 10);
			do_action('wpcargo_after_metabox_section', 10);

		?>
		</div>
		<script>
			jQuery(document).ready(function($) {
				$( "#wpc_add_meta_box .datepicker" ).datepicker({dateFormat: "yy-mm-dd"});
				$("#wpc_add_meta_box .time_1").timepicker({timeFormat: "<?php echo get_option( 'time_format' ); ?>"});
			});
		</script>
		<?php
    }

	public function wpc_shipper_meta_template() {
		global $post;
		require_once( WPCARGO_PLUGIN_PATH.'admin/templates/shipper-metabox.tpl.php' );
	}

	public function wpc_receiver_meta_template(){
		global $post;
		require_once( WPCARGO_PLUGIN_PATH.'admin/templates/receiver-metabox.tpl.php' );
	}

	public function wpc_shipment_meta_template(){
		global $post, $wpcargo;
		$options 			= get_option('wpcargo_option_settings');
		$wpc_date_format 	= get_option( 'date_format' );
		$wpcargo_expected_delivery_date_picker 	= get_post_meta($post->ID, 'wpcargo_expected_delivery_date_picker', true);
		$wpcargo_pickup_date_picker 			= get_post_meta($post->ID, 'wpcargo_pickup_date_picker', true);
		$shipment_status   		= $options['settings_shipment_status'];
		$shipment_status_list 	= explode(",", $shipment_status);
		$shipment_status_list 	= array_filter( $shipment_status_list );
		$shipment_status_list 	= apply_filters( 'wpcargo_status_option', $shipment_status_list  );
		$shipment_country_des 	= $options['settings_shipment_country'];
        $shipment_country_des_list 	= explode(",", $shipment_country_des);
		$shipment_country_des_list 	= array_filter( $shipment_country_des_list );
		$shipment_country_org 		= $options['settings_shipment_country'];
        $shipment_country_org_list 	= explode(",", $shipment_country_org);
		$shipment_country_org_list 	= array_filter( $shipment_country_org_list );
		$shipment_carrier 			= $options['settings_shipment_wpcargo_carrier'];
        $shipment_carrier_list 	= explode(",", $shipment_carrier);
		$shipment_carrier_list 	= array_filter( $shipment_carrier_list );
		$payment_mode 			= $options['settings_shipment_wpcargo_payment_mode'];
        $payment_mode_list 		= explode(",", $payment_mode);
		$payment_mode_list 		= array_filter( $payment_mode_list );
		$shipment_mode 		= $options['settings_shipment_wpcargo_mode'];
        $shipment_mode_list = explode(",", $shipment_mode);
		$shipment_mode_list = array_filter( $shipment_mode_list );
		$shipment_type 		= $options['settings_shipment_type'];
        $shipment_type_list = explode(",", $shipment_type);
		$shipment_type_list = array_filter( $shipment_type_list );
		$wpc_agent_args  	= array( 'role' => 'cargo_agent', 'orderby' => 'user_nicename', 'order' => 'ASC' );
        $wpc_agents 		= get_users($wpc_agent_args);
		require_once( WPCARGO_PLUGIN_PATH.'admin/templates/shipment-metabox.tpl.php' );
	}

	public function wpc_after_reciever_meta_sep(){
		echo '<div class="clear-line"></div>';
	}

	public function wpc_title_autogenerate(){
		global $post, $wpcargo;
		$screen = get_current_screen();
		if( $screen->action && $wpcargo->autogenerate_title ){
		?>
		<script>
			jQuery(document).ready(function($) {
				$( "#titlewrap #title" ).val('<?php echo $wpcargo->create_shipment_number(); ?>');
			});
		</script>
		<?php
		}
	}

	public function excluded_meta_keys(){
		$excluded_meta_keys = array(
			'wpc_metabox_nonce',
			'save',
			'_wpnonce',
			'_wp_http_referer',
			'user_ID',
			'action',
			'originalaction',
			'post_author',
			'post_type',
			'original_post_status',
			'referredby',
			'_wp_original_http_referer',
			'post_ID',
			'meta-box-order-nonce',
			'closedpostboxesnonce',
			'post_title',
			'hidden_post_status',
			'post_status',
			'hidden_post_password',
			'hidden_post_visibility',
			'visibility',
			'post_password',
			'original_publish',
			'original_publish',
			'status_date',
			'status_time',
			'status_location',
			'status_remarks',
			'wpcargo_status',
			'wpcargo_shipments_update'

		);
		return $excluded_meta_keys;
	}

	/**
     * Handles saving the meta box.
     * @param int     $post_id Post ID.
     * @param WP_Post $post    Post object.
     * @return null
	 */

	 public function save_metabox( $post_id ) {

		// Add nonce for security and authentication.
        $nonce_name   = isset( $_POST['wpc_metabox_nonce'] ) ? $_POST['wpc_metabox_nonce'] : '';
        $nonce_action = 'wpc_metabox_action';
        // Check if nonce is set.
        if ( ! isset( $nonce_name ) ) {
            return;
        }
        // Check if nonce is valid.
        if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
            return;
        }
        // Check if user has permissions to save data.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
        // Check if not an autosave.
        if ( wp_is_post_autosave( $post_id ) ) {
            return;
        }

		//save the last status
		$get_last_status 		= get_post_meta($post_id, 'wpcargo_status', true);

		// Get all ecluded meta keys in saving post meta
		$excluded_meta_keys = $this->excluded_meta_keys();

		foreach( $_POST as $key => $value ) {

			if( in_array( $key, $excluded_meta_keys ) ) {
				continue;
			}

			if( is_array( $value ) ) {
				$meta_value  = maybe_serialize( $value );
			} else {
				$meta_value  = sanitize_text_field( $value );
			}
			update_post_meta($post_id, $key, $meta_value);

		}


		$wpcargo_shipments_update = maybe_unserialize( get_post_meta( $post_id, 'wpcargo_shipments_update', true ) );

		$current_user 		= wp_get_current_user();
		$status_date 		= sanitize_text_field( $_POST['status_date'] );
		$status_time 		= sanitize_text_field( $_POST['status_time'] );
		$status_location 	= sanitize_text_field( $_POST['status_location'] );
		$status_remarks 	= sanitize_text_field( $_POST['status_remarks'] );
		$wpcargo_status 	= sanitize_text_field( $_POST['wpcargo_status'] );

		// Make sure that it is set.
		$new_history = apply_filters( 'wpcargo_shipment_history_before_save', array(
			'date' => $status_date,
			'time' => $status_time,
			'location' => $status_location,
			'updated-name' => $current_user->display_name,
			'updated-by' => $current_user->ID,
			'remarks'	=> $status_remarks,
			'status'    => $wpcargo_status
			), $_POST
		);

		if( !empty( $wpcargo_shipments_update ) ){
			if( array_key_exists( 'wpcargo_shipments_update', $_POST ) ){
				$wpcargo_shipments_update = $_POST['wpcargo_shipments_update'];
				if( $wpcargo_status ){
					array_push($wpcargo_shipments_update, $new_history);
				}
			}else{
				if( $wpcargo_status ){
					array_push($wpcargo_shipments_update, $new_history);
				}
			}
			update_post_meta($post_id, 'wpcargo_shipments_update', maybe_serialize( $wpcargo_shipments_update ) );
		}else{
			if( !wp_is_post_revision( $post_id ) ){
				if( $wpcargo_status ){
					update_post_meta($post_id, 'wpcargo_shipments_update', maybe_serialize( array( $new_history ) ) );
				}
			}
		}

    }
	public function wpc_mp_metabox_callback($post) {
		$current_user 					= wp_get_current_user();
		$options 						= get_option( 'wpc_mp_settings' );
		$wpc_mp_dimension_unit 			= !empty($options['wpc_mp_dimension_unit']) ? $options['wpc_mp_dimension_unit'] : '';
		$wpc_mp_peice_type 				= !empty($options['wpc_mp_piece_type']) ? $options['wpc_mp_piece_type'] : '';
		$wpc_mp_weight_unit 			= !empty($options['wpc_mp_weight_unit']) ? $options['wpc_mp_weight_unit'] : '';
		$wpc_mp_enable_dimension_unit 	= !empty($options['wpc_mp_enable_dimension_unit']) ? $options['wpc_mp_enable_dimension_unit'] : '';
		$wpc_multiple_package 			= maybe_unserialize( get_post_meta( $post->ID, 'wpc-multiple-package', true ) );
        wp_nonce_field( 'wpc_mp_inner_custom_box', 'wpc_mp_inner_custom_box_nonce' );
		require_once( WPCARGO_PLUGIN_PATH.'admin/templates/multiple-package-metabox.tpl.php' );
	}
	public function wpc_sh_metabox_callback($post){

		global $wpdb, $wpcargo;
		$current_user 			= wp_get_current_user();
		$shipments 				= maybe_unserialize( get_post_meta( $post->ID, 'wpcargo_shipments_update', true ) );
		$gen_settings 			= $wpcargo->settings;
		$edit_history_role 		= ( array_key_exists( 'wpcargo_edit_history_role', $gen_settings ) ) ? $gen_settings['wpcargo_edit_history_role'] : array();
		$role_intersected 		= array_intersect( $current_user->roles, $edit_history_role );

		$shmap_active 	= get_option('shmap_active');
		if( $shmap_active ){
			?>
			<div id="shmap-wrapper" style="margin: 12px 0;">
				<div id="wpc-shmap" style="height: 320px;"></div>
			</div>
			<?php
		}

		if( !empty( $role_intersected ) ){
			require_once( WPCARGO_PLUGIN_PATH.'admin/templates/shipment-history-editable.tpl.php' );
		}else{
			require_once( WPCARGO_PLUGIN_PATH.'admin/templates/shipment-history.tpl.php' );
		}
	}

	public function wpcargo_shipment_history_email_template($post_id){
		global $wpcargo;
		if( isset( $_POST['wpcargo_status'] )  && !empty( trim( $_POST['wpcargo_status'] ) ) ){
			do_action( 'wpc_add_sms_shipment_history', $post_id );
	        $new_status 	= sanitize_text_field( $_POST['wpcargo_status'] );
	        $old_status     = get_post_meta($post_id, 'wpcargo_status', true);
	        update_post_meta( $post_id, 'wpcargo_status', $new_status );

	        if( $new_status != $old_status ){	
	        	wpcargo_send_email_notificatio( $post_id, $new_status );
	        }
		}
        
	}

	public function wpcargo_set_content_type( $content_type ) {
		return 'text/html';
	}
}
$wpcargo_metabox = new WPCargo_Metabox();
