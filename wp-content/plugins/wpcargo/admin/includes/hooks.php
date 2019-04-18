<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Client Account Hooks
function wpcargo_shipper_details_table_callback( ){
    global $wpcargo, $post;
	$disabled_shipper_search  = get_option('wpc_disable_registered_shipper_search');
	if( $disabled_shipper_search ){
		return false;
	}
	$users = $wpcargo->users;
	?>
    <table class="wpcargo form-table">
    	<tbody>
        	<tr>
            	<th><?php echo apply_filters( 'wpcargo_registered_shipper_label', __('Registered Shipper', 'wpcargo' ) ); ?></th>
                <td id="reg-shipper-container" >
                    <select id="reg-shipper" name="registered_shipper" tabindex="-1">
        				<option></option>
                    	<?php
						foreach( $users as $user ){
						?><option value="<?php echo $user->ID; ?>" <?php echo ( get_post_meta( $post->ID, 'registered_shipper', TRUE ) == $user->ID ) ? 'selected' : '' ; ?> ><?php echo $wpcargo->user_fullname( $user->ID );  ?></option><?php
						}
						?>
					</select>
                    <span class="spinner"></span>
                </td>
            </tr>
        </tbody>
    </table>
    <?php
}

add_action('wpc_before_shipper_details_table', 'wpcargo_shipper_details_table_callback', 10, 1);
function wpcargo_receiver_details_table_callback(){
    global $wpcargo, $post;
	$disabled_receiver_search  = get_option('wpc_disable_registered_receiver_search');
	if( $disabled_receiver_search ){
		return false;
	}
	$users = $wpcargo->users;
	?>
    <table class="wpcargo form-table">
    	<tbody>
        	<tr>
            	<th><?php echo apply_filters( 'wpcargo_registered_receiver_label', __('Registered Receiver', 'wpcargo' ) ); ?></th>
                <td id="reg-receiver-container">
					 <select id="reg-receiver" name="registered_receiver" tabindex="-1">
        				<option></option>
                    	<?php
						foreach( $users as $user ){
						?><option value="<?php echo $user->ID; ?>" <?php echo ( get_post_meta( $post->ID, 'registered_receiver', TRUE ) == $user->ID ) ? 'selected' : '' ; ?> data-meta="<?php echo $user->ID ?> " ><?php echo $wpcargo->user_fullname( $user->ID );  ?></option><?php
						}
						?>
					</select>
                 <span class="spinner"></span>
                </td>
            </tr>
        </tbody>
    </table>
    <?php
}
add_action('wpc_before_receiver_details_table', 'wpcargo_receiver_details_table_callback', 10, 1);

function wpcargo_track_shipment_history_details( $shipment ) {
    global $wpdb, $wpcargo;
    $settings   = $wpcargo->settings;
    $date_format = $wpcargo->date_format;
    $time_format = $wpcargo->time_format;
    if( !empty( $settings ) ){
        if( !array_key_exists( 'wpcargo_invoice_display_history', $settings ) ){
            return false;
        }
    }
    require_once( WPCARGO_PLUGIN_PATH.'templates/result-shipment-history.tpl.php');
}
add_action('wpcargo_after_track_details', 'wpcargo_track_shipment_history_details', 10, 1);
/*
 * Hooks for Custom Field Add ons
 */
function wpcargo_add_display_client_accounts( $flags ){
    ?>
        <tr>
            <th><?php _e('Do you want to display it on account page?', 'wpcargo' ); ?></th>
            <td><input name="display_flags[]" value="account_page" type="checkbox"></td>
        </tr>
    <?php
}

add_action( 'wpc_cf_after_form_field_add', 'wpcargo_add_display_client_accounts' );
function wpcargo_edit_display_client_accounts( $flags ){
    ?>
        <tr>
            <th><?php _e('Do you want to display it on account page?', 'wpcargo' ); ?></th>
            <td><input name="display_flags[]" value="account_page" type="checkbox" <?php echo is_array($flags) && in_array( 'account_page', $flags) ? 'checked' : ''; ?> /></td>
        </tr>
    <?php
}
add_action( 'wpc_cf_after_form_field_edit', 'wpcargo_edit_display_client_accounts' );
add_action('wp_footer', function(){
    global $post;
    if ( is_a( $post, 'WP_Post' ) && ( has_shortcode( $post->post_content, 'wpcargo_account') || has_shortcode( $post->post_content, 'wpc-ca-account') ) ) {
        ?>
        <!-- The Modal -->
        <div id="view-shipment-modal" class="wpcargo-modal">
          <!-- Modal content -->
          <div class="modal-content">
            <div class="modal-header">
              <span class="close">&times;</span>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
          </div>
        </div>
        <?php
    }
});
// Plugin row Hook
add_filter( 'plugin_row_meta', 'wpcargo_plugin_row_meta', 10, 2 );
function wpcargo_plugin_row_meta( $links, $file ) {
    if ( strpos( $file, 'wpcargo.php' ) !== false ) {
        $new_links = array(
            'settings' => '<a href="'.admin_url('admin.php?page=wpcargo-settings').'">'.__('Settings', 'wpcargo').'</a>',
            );
        $links = array_merge( $links, $new_links );
    }
    return $links;
}
add_action( 'quick_edit_custom_box', 'wpcargo_bulk_update_registered_shipper_custom_box', 10, 2 );
add_action( 'bulk_edit_custom_box', 'wpcargo_bulk_update_registered_shipper_custom_box', 10, 2 );
function wpcargo_bulk_update_registered_shipper_custom_box( $column_name,  $screen_post_type ){
    global $wpcargo;
    $shmap_active   = get_option('shmap_active');
    if( $screen_post_type == 'wpcargo_shipment'  ){
        wp_nonce_field( 'reg_shipper_bulk_update_action', 'reg_shipper_bulk_update_nonce' );
        $user_args = array(
            'meta_key' => 'first_name',
            'orderby'  => 'meta_value',
         );
        $all_users = get_users( $user_args );
        if( $column_name == 'registered_shipper' ){
            ?>
            <fieldset class="inline-edit-col-right">
                <div class="inline-edit-col">
                    <div class="inline-edit-group wp-clearfix">
                        <label class="inline-edit-registered_shipper">
                            <span class="title"><?php _e( 'Registered Shipper', 'wpcargo' ); ?></span>
                            <select name="registered_shipper">
                                <option value=""><?php _e( '— No Change —', 'wpcargo' ); ?></option>
                                <?php
                                foreach($all_users as $user){
                                    $user_fullname = apply_filters( 'wpcargo_registered_shipper_option_label', $wpcargo->user_fullname( $user->ID ), $user->ID );
                                    echo '<option value="'.trim($user->ID).'" >'.$user_fullname.'</option>';
                                }
                                ?>
                            </select>
                        </label>
                    </div>
                </div>
            </fieldset>
            <?php
        }
    }
}

function wpcargo_shipment_registered_shipper_custom_box_bulk_save( $post_id ) {
    global $wpcargo;
    if ( !current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    if( !isset( $_REQUEST["reg_shipper_bulk_update_nonce"] ) ){
        return;
    }
    if ( !wp_verify_nonce( $_REQUEST["reg_shipper_bulk_update_nonce"], 'reg_shipper_bulk_update_action' ) ){
        return;
    }
    $current_user = wp_get_current_user();

    if ( isset( $_REQUEST['registered_shipper'] ) && $_REQUEST['registered_shipper'] != '' ) {
        update_post_meta( $post_id, 'registered_shipper', abs($_REQUEST['registered_shipper']) );
    }
}
add_action( 'save_post', 'wpcargo_shipment_registered_shipper_custom_box_bulk_save' );
// Run this hook when plugin is deactivated
function wpcargo_detect_plugin_deactivation(  $plugin, $network_activation ) {
    if( 'wpcargo-client-accounts-addons/wpcargo-client-accounts.php' == $plugin  ){
        add_role('wpcargo_client', 'WPCargo Client', array(
            'read' => true, // True allows that capability
        ));
    }
}
add_action( 'deactivated_plugin', 'wpcargo_detect_plugin_deactivation', 10, 2 );

// Shipment History Map
function wpcargo_shipment_history_map_callback( $shipment_id ){
	$shmap_active 	= get_option('shmap_active');
	if( $shmap_active ){
		?>
		<div id="shmap-wrapper" style="margin: 12px 0;">
			<div id="wpcargo-shmap" style="height: 320px;"></div>
		</div>
		<?php
		wpcargo_gmap_library( $shipment_id );
	}
}
add_action('before_wpcargo_shipment_history', 'wpcargo_shipment_history_map_callback', 10, 1 );

function wpcargo_gmap_library( $shipment_id ){
	global $post, $wpcargo;
	$shmap_api 		= get_option('shmap_api');
	$shmap_active 	= get_option('shmap_active');
	$shmap_type 	= get_option('shmap_type') ? get_option('shmap_type') : 'terrain' ;
	$shmap_zoom 	= get_option('shmap_zoom') ? get_option('shmap_zoom') : 15 ;
	$shmap_result 	= get_option('shmap_result');
	$maplabels 		= apply_filters('wpcargo_map_labels', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890' );
	//if( $screen->post_type == 'wpcargo_shipment' && $screen->base == 'post' && $shmap_active ){
	if( $shmap_active && $shmap_result && !empty( $shmap_api ) ){
		$history 		= $wpcargo->history( $shipment_id );
		$history_location = array();
		if( !empty( $history  ) ){
			foreach ( $history as $value ) {
				if( empty( $value['location'] ) ){
					continue;
				}
				$history_location[] = $value['location'];
			}
		}
		$addressLocations 	= $history_location;
		$shipment_origin 	= array_shift( $history_location );
		$shipment_destination 	= array_pop( $history_location );
		?>
		<script>
			/*
			** Google map Script Auto Complete address
			*/
			var placeSearch, autocomplete, map, geocoder;
			var componentForm = {
				street_number: 'short_name',
				route: 'long_name',
				locality: 'long_name',
				administrative_area_level_1: 'short_name',
				country: 'long_name',
				postal_code: 'short_name'
			};
			var labels = '<?php echo $maplabels; ?>';
  			var labelIndex = 0;

			function wpcSHinitMapResult() {

				geocoder = new google.maps.Geocoder();

			        var map = new google.maps.Map( document.getElementById('wpcargo-shmap'), {
			          zoom: <?php echo $shmap_zoom; ?>,
			          center: {lat: 41.85, lng: -87.65},
			          mapTypeId: '<?php echo $shmap_type; ?>',
			        });

			        /* 	Map script
					** 	Initialize Shipment Locations
					*/
					var shipmentAddress = <?php echo json_encode( $addressLocations ); ?>;
					var shipmentData 	= <?php echo json_encode( $history ); ?>;

					var flightPlanCoordinates = [];

					for (var i = 0; i < shipmentAddress.length; i++ ) {
						codeAddressResult( geocoder, map, shipmentAddress[i], flightPlanCoordinates, i, shipmentData );
					}

			        var demoformat = [
			          {lat: 10.2976348, lng: 123.89349070000003},
			          {lat: 3.139003, lng: 101.68685499999992},
			          {lat: 14.5995124, lng: 120.9842195}
			        ];

			        //console.log( flightPlanCoordinates );

			        var flightPath = new google.maps.Polyline({
			          path: flightPlanCoordinates,
			          geodesic: true,
			          strokeColor: '#FF0000',
			          strokeOpacity: 1.0,
			          strokeWeight: 2
			        });

			        flightPath.setMap(map);
			}


			function codeAddressResult( geocoder, map, address, flightPlanCoordinates, index, shipmentData ) {
				var wpclabelColor 	= '<?php echo ( get_option('shmap_label_color') ) ? get_option('shmap_label_color') : '#fff' ;  ?>';
  				var wpclabelSize 	= '<?php echo ( get_option('shmap_label_size') ) ? get_option('shmap_label_size').'px' : '18px' ;  ?>';
  				var wpcMapMarker 	= '<?php echo ( get_option('shmap_marker') ) ? get_option('shmap_marker') : WPCARGO_PLUGIN_URL.'/admin/assets/images/wpcmarker.png' ;  ?>';
				geocoder.geocode({'address': address}, function(results, status) {
					if (status === 'OK') {

						var geolatlng = { lat: results[0].geometry.location.lat(),  lng: results[0].geometry.location.lng() };

						flightPlanCoordinates[index] = geolatlng;

						map.setCenter(results[0].geometry.location);
						var marker = new google.maps.Marker({
							map: map,
							label: {text: labels[index % labels.length], color: wpclabelColor, fontSize: wpclabelSize },
							position: results[0].geometry.location,
							icon: wpcMapMarker
						});

						/*
				        ** Marker Information window
				        */
						// shipmentData
						var sAddressDate = shipmentData[index].date;
						var sAddresstime = shipmentData[index].time;
						var sAddresslocation = shipmentData[index].location;
						var sAddressstatus = shipmentData[index].status;

						var shipemtnInfo = '<strong><?php _e('Date', 'wpcargo'); ?>:</strong> '+sAddressDate+' '+sAddresstime+'</br>'+
										   '<strong><?php _e('Location', 'wpcargo'); ?>:</strong> '+sAddresslocation+'</br>'+
										   '<strong><?php _e('Status', 'wpcargo'); ?>:</strong> '+sAddressstatus;

						var infowindow = new google.maps.InfoWindow({
				          content: shipemtnInfo
				        });
						marker.addListener('click', function() {
				          infowindow.open(map, marker);
				        });
					} else {
						alert('Geocode was not successful for the following reason: ' + status);
					}
				});
			}
	    </script>
	    <script async defer src="https://maps.googleapis.com/maps/api/js?libraries=geometry,places,visualization&key=<?php echo $shmap_api; ?>&callback=wpcSHinitMapResult"></script>
		<?php
	}
}