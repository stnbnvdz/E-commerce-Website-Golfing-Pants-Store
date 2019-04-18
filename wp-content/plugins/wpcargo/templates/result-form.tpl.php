<div id="wpcargo-result-print">
  <div class="wpcargo-result wpcargo" id="wpcargo-result">
    <?php
	$shipment_id = wpcargo_trackform_shipment_number( $shipment_number );
	if ( !empty( $shipment_id) ) {
		$shipment 				= new stdClass;
		$shipment->ID 			= $shipment_id;
		$shipment->post_title 	= get_the_title( $shipment_id );
		do_action( 'wpcargo_before_search_result' );
		do_action( 'wpcargo_print_btn' ); ?>
		<div id="wpcargo-result-wrapper" class="wpcargo-wrap-details wpcargo-container">
			<?php
			do_action('wpcargo_before_track_details', $shipment );
			do_action('wpcargo_track_header_details', $shipment );
			do_action('wpcargo_track_shipper_details', $shipment );
			do_action('wpcargo_before_shipment_details', $shipment );
			do_action('wpcargo_track_shipment_details', $shipment );
			do_action('wpcargo_after_track_details', $shipment );
			?>
		</div>
		<?php
	} elseif( isset( $_REQUEST['wpcargo_tracking_number'] ) ) {

		?>
		<h3 style="color: red !important; text-align:center;margin-bottom:0;padding:12px;"><?php echo apply_filters('wpcargo_tn_no_result_text', __('No results found!','wpcargo') ); ?></h3>
		<?php
	}
	?>
  </div>
  <!-- wpcargo-result -->
</div>
