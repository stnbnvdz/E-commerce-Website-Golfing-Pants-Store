<?php
	$shipment_id 		= $shipment_detail->ID;
	$shipper_name		= wpcargo_get_postmeta($shipment_id, 'wpcargo_shipper_name' );
	$shipper_address	= wpcargo_get_postmeta($shipment_id, 'wpcargo_shipper_address' );
	$shipper_phone		= wpcargo_get_postmeta($shipment_id, 'wpcargo_shipper_phone' );
	$shipper_email		= wpcargo_get_postmeta($shipment_id, 'wpcargo_shipper_email' );
	$receiver_name		= wpcargo_get_postmeta($shipment_id, 'wpcargo_receiver_name' );
	$receiver_address	= wpcargo_get_postmeta($shipment_id, 'wpcargo_receiver_address' );
	$receiver_phone		= wpcargo_get_postmeta($shipment_id, 'wpcargo_receiver_phone' );
	$receiver_email		= wpcargo_get_postmeta($shipment_id, 'wpcargo_receiver_email' );
?>
<div id="print-shipper-info">
  <div class="col-6">
    <p id="print-shipper-header"><strong><?php echo apply_filters('result_shipper_address', __('Shipper Address', 'wpcargo')); ?></strong></p>
    <p class="shipper details"><?php echo $shipper_name; ?><br />
      <?php echo $shipper_address; ?><br />
      <?php echo $shipper_phone; ?><br />
      <?php echo $shipper_email; ?><br />
    </p>
  </div>
  <div class="col-6">
    <p id="print-receiver-header"><strong><?php echo apply_filters('result_receiver_address', __('Receiver Address', 'wpcargo')); ?></strong></p>
    <p class="receiver details"><?php echo $receiver_name; ?><br />
      <?php echo $receiver_address; ?><br />
      <?php echo $receiver_phone; ?><br />
      <?php echo $receiver_email; ?><br />
    </p>
  </div>
  <div class="clear-line"></div>
</div>