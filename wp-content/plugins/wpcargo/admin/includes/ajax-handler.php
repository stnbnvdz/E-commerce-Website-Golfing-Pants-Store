<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
function wpcargo_autofill_information(){
    global $wpdb, $wpcargo;
	$userID 			= $_POST['userID'];
	$user_details 		= array();
	$user_info 			= get_userdata( $userID );
	$user_full_name 	= $wpcargo->user_fullname( $userID );
	$user_email 		= $user_info->user_email;
	$company_name 		= get_user_meta( $userID, 'company_name', TRUE );
	$street_address 	= get_user_meta( $userID, 'street_address', TRUE );
	$city_address 		= get_user_meta( $userID, 'city_address', TRUE );
	$zip_address 		= get_user_meta( $userID, 'zip_address', TRUE );
	$country_address 	= get_user_meta( $userID, 'country_address', TRUE );
	$user_company_phone	= get_user_meta( $userID, 'company_phone', TRUE );
	if( $city_address ){
		$city_address = ', '.$city_address;
	}
	if( $zip_address ){
		$zip_address = ', '.$zip_address;
	}
	if( $country_address ){
		$country_address = ', '.$country_address;
	}
	$user_address = $street_address.$city_address.$zip_address.$country_address;
	$user_details['user_full_name'] 	= $user_full_name;
	$user_details['user_email'] 		= ( $user_email ) ? $user_email :  '' ;
	$user_details['user_company_name'] 	= ( $company_name ) ? $company_name :  '' ;
	$user_details['user_address'] 		= ( $user_address) ? $user_address :  '' ;
	$user_details['user_company_phone'] = ( $user_company_phone ) ? $user_company_phone :  '' ;
    echo json_encode($user_details);
    die();
}
add_action('wp_ajax_autofill_information', 'wpcargo_autofill_information');
function view_shipment_details_callback(){
	$shipment_id 	= $_POST['shipmentID'];
	$shipment 		= new stdClass;
	$shipment->ID 	= $shipment_id;
	$shipment->post_title = get_the_title( $shipment_id );
	ob_start();
	?>
	<div id="wpcargo-result">
		<div id="wpcargo-result-wrapper" class="wpcargo-wrap-details container">
			<?php
			do_action('wpcargo_before_track_details', $shipment );
			do_action('wpcargo_track_header_details', $shipment );
			do_action('wpcargo_track_shipper_details', $shipment );
			do_action('wpcargo_before_shipment_details', $shipment );
			do_action('wpcargo_track_shipment_details', $shipment );
			do_action('wpcargo_after_track_details', $shipment );
			?>
		</div>
	</div>
	<?php
	$output = ob_get_clean();
	echo $output;
	wp_die();
}
add_action('wp_ajax_view_shipment_details', 'view_shipment_details_callback' );
add_action('wp_ajax_nopriv_view_shipment_details', 'view_shipment_details_callback' );