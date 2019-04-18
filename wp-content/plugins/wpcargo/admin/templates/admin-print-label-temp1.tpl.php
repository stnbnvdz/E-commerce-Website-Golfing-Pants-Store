<script type="text/javascript">
	function wpcargo_print(wpcargo_class) {
		var printContents = document.getElementById(wpcargo_class).innerHTML;
		var originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;
		location.reload(true);
	}
</script>
<div id="actions" style="margin-bottom: 12px;">
	<a href="#" class="button button-secondary print" onclick="wpcargo_print('print-label')"><span class="ti-printer"></span> <?php _e('Print Label', 'wpcargo'); ?></a>
</div>
<div id="print-label">
<style type="text/css">
@media screen, print{
	table{
		width:100%;
	}
	table ul.list,
	table,
	table tbody,
	table td,
	table tr{
		padding: 0;
		margin:0;
		border:none;
	}
	table ul li {
	    text-decoration: none;
	    list-style: none;
	}
	table td,
	table th {
	    border: none;
	    border-collapse: collapse;
	    padding: 12px;
	    position: relative;
	}
	table td .label,
	table th.header{
		font-weight: bold;
		font-size: 12px;
	}
	table td,
	table th,
	#shipment-packages td,
	table td #receiver-info .data{
		font-size: 16px;
	}
	#sender-note .data,
	table td#shipment-info .data {
	    font-size: 14px;
	}
	table tr td h3 {
	    margin-top: 0;
	    margin-bottom: 6px;
	    font-size: 18px;
	}
	#shipment-person-data tr td p{
		margin:0;
	}
	table tr td#shipment-info p {
	    float: left;
	    width: 32%;
	    margin-left: 0;
	    margin-top: 0;
	    margin-right: 2% !important;
	    margin-bottom: 8px !important;
	}
	table tr td#shipment-info p:nth-child(3n) {
	    margin-right: 0 !important;
	    clear: right;
	}
	#shipment-person-data #sender-info {
	    border-right: 1px solid #000;
	}
	#shipment-person-data .sender-section {
	    float: left;
		width: 40%;
		padding: 12px;
	}
	#shipment-packages {
    	border-collapse: collapse;
	}
	#shipment-packages td {
	    border: 1px solid #000;
	    text-align: center;
	}
	#shipment-packages tbody .package-description{
		text-align: initial;
	}
	#shipment-packages .package-description{
		width: 40%;
	}
	#shipment-packages td {
	    width: 10%;
	}
	#shipment-packages thead tr td {
	    font-weight: bold;
	}
	#shipment-packages thead tr:first-child td {
	    border-top: none;
	}
	#shipment-packages td:first-child {
	    border-left: none;
	}
	#shipment-packages td:last-child {
	    border-right: none;
	}
	#shipment-packages tr:last-child td {
	    border-bottom: none;
	}
	#shipment-packages td {
	    padding: 6px;
	}
}
</style>
<?php do_action('wpc_label_before_header_information', $shipmentDetails['shipmentID'] ); ?>
<table cellpadding="0" cellspacing="0" style="border: 1px solid #000;width: 100%;margin:0;padding:0;">
	<tr style="border-right: 1px solid #000;">
		<td style="width:50%;text-align: center;border-right: 1px solid #000;border-bottom: 1px solid #000;">
			<p style="margin:0;padding:0;font-weight: bold;"><?php _e('TRACKING #', 'wpcargo'); ?></p>
			<img style="float: none !important; margin: 0 !important;" src="<?php echo $shipmentDetails['barcode']; ?>" alt="<?php echo get_the_title( $shipmentDetails['shipmentID'] ); ?>" />
			<p style="margin:0;padding:0;font-weight: bold;"><?php echo get_the_title( $shipmentDetails['shipmentID'] ); ?></p>
			<?php do_action('wpc_label_header_barcode_information', $shipmentDetails['shipmentID'] ); ?>
		</td>
		<td style="width:50%;font-size: 14px;border-bottom: 1px solid #000; text-align: center;">
			<?php echo $shipmentDetails['siteInfo']; ?>
			<?php do_action('wpc_label_header_site_information', $shipmentDetails['shipmentID'] ); ?>
		</td>
	</tr>
	<tr style="border-top: 1px solid #000;border-bottom: 1px solid #000;">
		<td id="shipment-info" style="padding: 12px;vertical-align: initial;border-right: 1px solid #000;">
			<h3><?php _e( 'Shipment Information', 'wpcargo' ); ?></h3>
			<?php do_action('wpc_label_before_shipment_information', $shipmentDetails['shipmentID'] ); ?>
			<p><span class="label"><?php _e('Type of Shipment', 'wpcargo'); ?></span>:<br/><span class="data"><?php echo wpcargo_get_postmeta( $shipmentDetails['shipmentID'], 'wpcargo_type_of_shipment' ); ?></span></p>
			<p><span class="label"><?php _e('Courier', 'wpcargo'); ?></span>:<br/><span class="data"><?php echo wpcargo_get_postmeta( $shipmentDetails['shipmentID'], 'wpcargo_courier' ); ?></span></p>
			<p><span class="label"><?php _e('Carrier Reference No.', 'wpcargo'); ?></span>:<br/><span class="data"><?php echo wpcargo_get_postmeta( $shipmentDetails['shipmentID'], 'wpcargo_carrier_ref_number' ); ?></span></p>
			<p><span class="label"><?php _e('Mode', 'wpcargo'); ?></span>:<br/><span class="data"><?php echo wpcargo_get_postmeta( $shipmentDetails['shipmentID'], 'wpcargo_mode_field' ); ?></span></p>
			<p><span class="label"><?php _e('Carrier', 'wpcargo'); ?></span>:<br/><span class="data"><?php echo wpcargo_get_postmeta( $shipmentDetails['shipmentID'], 'wpcargo_carrier_field' ); ?></span></p>
			<p><span class="label"><?php _e('Packages', 'wpcargo'); ?></span>:<br/><span class="data"><?php echo wpcargo_get_postmeta( $shipmentDetails['shipmentID'], 'wpcargo_packages' ); ?></span></p>
			<p><span class="label"><?php _e('Product', 'wpcargo'); ?></span>:<br/><span class="data"><?php echo wpcargo_get_postmeta( $shipmentDetails['shipmentID'], 'wpcargo_product' ); ?></span></p>
			<p><span class="label"><?php _e('Weight', 'wpcargo'); ?></span>:<br/><span class="data"><?php echo wpcargo_get_postmeta( $shipmentDetails['shipmentID'], 'wpcargo_weight' ); ?></span></p>
			<p><span class="label"><?php _e('Quantity', 'wpcargo'); ?></span>:<br/><span class="data"><?php echo wpcargo_get_postmeta( $shipmentDetails['shipmentID'], 'wpcargo_qty' ); ?></span></p>
			<p><span class="label"><?php _e('Total Freight', 'wpcargo'); ?></span>:<br/><span class="data"><?php echo wpcargo_get_postmeta( $shipmentDetails['shipmentID'], 'wpcargo_total_freight' ); ?></span></p>
			<p><span class="label"><?php _e('Payment Mode', 'wpcargo'); ?></span>:<br/><span class="data"><?php echo wpcargo_get_postmeta( $shipmentDetails['shipmentID'], 'payment_wpcargo_mode_field' ); ?></span></p>
			<p><span class="label"><?php _e('Origin', 'wpcargo'); ?></span>:<br/><span class="data"><?php echo wpcargo_get_postmeta( $shipmentDetails['shipmentID'], 'wpcargo_origin_field' ); ?></span></p>
			<p><span class="label"><?php _e('Pickup Date', 'wpcargo'); ?></span>:<br/><span class="data"><?php echo wpcargo_get_postmeta( $shipmentDetails['shipmentID'], 'wpcargo_pickup_date_picker', 'date' ); ?></span></p>
			<p><span class="label"><?php _e('Destination', 'wpcargo'); ?></span>:<br/><span class="data"><?php echo wpcargo_get_postmeta( $shipmentDetails['shipmentID'], 'wpcargo_destination' ); ?></span></p>
			<p><span class="label"><?php _e('Departure Time', 'wpcargo'); ?></span>:<br/><span class="data"><?php echo wpcargo_get_postmeta( $shipmentDetails['shipmentID'], 'wpcargo_departure_time_picker' ); ?></span></p>
			<p><span class="label"><?php _e('Pickup Time', 'wpcargo'); ?></span>:<br/><span class="data"><?php echo wpcargo_get_postmeta( $shipmentDetails['shipmentID'], 'wpcargo_pickup_time_picker' ); ?></span></p>
			<p><span class="label"><?php _e('Expected Delivery Date', 'wpcargo'); ?></span>:<br/><span class="data"><?php echo wpcargo_get_postmeta( $shipmentDetails['shipmentID'], 'wpcargo_expected_delivery_date_picker', 'date' ); ?></span></p>
			<?php do_action('wpc_label_after_shipment_information', $shipmentDetails['shipmentID'] ); ?>
		</td>
		<td style="vertical-align: top;padding: 0;">
			<table id="shipment-person-data" cellpadding="0" cellspacing="0" style="width: 100%;border: none;margin:0;padding:0;">
				<tbody>
					<tr style="padding: 0;border-bottom: 1px solid #000; display: block;">
						<td style="width: 50%;padding:0;">
							<div id="sender-info" class="sender-section" >
								<h3><?php _e( 'Shipper/Exporter', 'wpcargo' ); ?></h3>
								<?php do_action('wpc_label_before_shipper_information', $shipmentDetails['shipmentID'] ); ?>
								<p><span class="data"><?php echo wpcargo_get_postmeta( $shipmentDetails['shipmentID'], 'wpcargo_shipper_name' ); ?></span></p>
								<p><span class="data"><?php echo wpcargo_get_postmeta( $shipmentDetails['shipmentID'], 'wpcargo_shipper_phone' ); ?></span></p>
								<p><span class="data"><?php echo wpcargo_get_postmeta( $shipmentDetails['shipmentID'], 'wpcargo_shipper_address' ); ?></span></p>
								<p><span class="data"><?php echo wpcargo_get_postmeta( $shipmentDetails['shipmentID'], 'wpcargo_shipper_email' ); ?></span></p>
								<?php do_action('wpc_label_after_shipper_information', $shipmentDetails['shipmentID'] ); ?>
							</div>
							<div id="sender-note" class="sender-section">
								<h3><?php _e("Sender's Instruction", 'wpcargo'); ?></h3>
								<p><span class="data"><?php echo wpcargo_get_postmeta( $shipmentDetails['shipmentID'], 'wpcargo_comments' ); ?></span></p>
							</div>
						</td>
					</tr>
					<tr style="padding: 0;">
						<td id="receiver-info">
							<h3><?php _e( 'Consignee/Receiver ', 'wpcargo' ); ?></h3>
							<?php do_action('wpc_label_before_receiver_information', $shipmentDetails['shipmentID'] ); ?>
							<p><span class="data"><?php echo wpcargo_get_postmeta( $shipmentDetails['shipmentID'], 'wpcargo_receiver_name' ); ?></span></p>
							<p><span class="data"><?php echo wpcargo_get_postmeta( $shipmentDetails['shipmentID'], 'wpcargo_receiver_phone' ); ?></span></p>
							<p><span class="data"><?php echo wpcargo_get_postmeta( $shipmentDetails['shipmentID'], 'wpcargo_receiver_address' ); ?></span></p>
							<p><span class="data"><?php echo wpcargo_get_postmeta( $shipmentDetails['shipmentID'], 'wpcargo_receiver_email' ); ?></span></p>
							<?php do_action('wpc_label_after_receiver_information', $shipmentDetails['shipmentID'] ); ?>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
	</tr>
	<?php
	$mp_settings = $shipmentDetails['packageSettings'];
	if( $mp_settings ){
		//** Checked in multiple setting has value
		if( array_key_exists('wpc_mp_enable_admin', $mp_settings)){
			//** Check if the multiple package is Enable
			$packages = $shipmentDetails['packages'];
			if( !empty( $packages ) ){
				//** Check if package array is not empty
				if( count($packages) == 1 ){
					//** Check if package array has value and not empty
					$package = array_filter($packages[0]);
					if( !empty( $package ) ){
						?>
						<tr>
							<td colspan="2" style="border-top: 2px solid #000;padding: 0;">
								<table id="shipment-packages" cellpadding="0" cellspacing="0" style="width: 100%;border: none;margin:0;padding:0;">
									<thead>
										<tr>
											<td class="package-description"><?php _e('Description', 'wpcargo'); ?></td>
											<td><?php _e('Qty.', 'wpcargo'); ?></td>
											<td><?php _e('Piece Type', 'wpcargo'); ?></td>
											<?php if( array_key_exists('wpc_mp_enable_dimension_unit', $mp_settings)): ?>
												<td><?php _e('Length', 'wpcargo'); ?> (<?php echo $mp_settings['wpc_mp_dimension_unit']; ?>)</td>
												<td><?php _e('Width', 'wpcargo'); ?> (<?php echo $mp_settings['wpc_mp_dimension_unit']; ?>)</td>
												<td><?php _e('Height', 'wpcargo'); ?> (<?php echo $mp_settings['wpc_mp_dimension_unit']; ?>)</td>
											<?php endif; ?>
											<td><?php _e('Weight', 'wpcargo'); ?> (<?php echo $mp_settings['wpc_mp_weight_unit']; ?>)</td>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ( $packages as $package ) {
											?>
											<tr>
												<td class="package-description"><?php echo $package['wpc-pm-description']; ?></td>
												<td><?php echo $package['wpc-pm-qty']; ?></td>
												<td><?php echo $package['wpc-pm-piece-type']; ?></td>
												<?php if( array_key_exists('wpc_mp_enable_dimension_unit', $mp_settings)): ?>
													<td><?php echo $package['wpc-pm-length']; ?></td>
													<td><?php echo $package['wpc-pm-width']; ?></td>
													<td><?php echo $package['wpc-pm-height']; ?></td>
												<?php endif; ?>
												<td><?php echo $package['wpc-pm-weight']; ?></td>
											</tr>
											<?php
										}
										?>
									</tbody>
								</table>
							</td>
						</tr>
						<?php
					}
				}else{
					?>
					<tr>
						<td colspan="2" style="border-top: 2px solid #000;padding: 0;">
							<table id="shipment-packages" cellpadding="0" cellspacing="0" style="width: 100%;border: none;margin:0;padding:0;">
								<thead>
									<tr>
										<td class="package-description"><?php _e('Description', 'wpcargo'); ?></td>
										<td><?php _e('Qty.', 'wpcargo'); ?></td>
										<td><?php _e('Piece Type', 'wpcargo'); ?></td>
										<?php if( array_key_exists('wpc_mp_enable_dimension_unit', $mp_settings)): ?>
											<td><?php _e('Length', 'wpcargo'); ?> (<?php echo $mp_settings['wpc_mp_dimension_unit']; ?>)</td>
											<td><?php _e('Width', 'wpcargo'); ?> (<?php echo $mp_settings['wpc_mp_dimension_unit']; ?>)</td>
											<td><?php _e('Height', 'wpcargo'); ?> (<?php echo $mp_settings['wpc_mp_dimension_unit']; ?>)</td>
										<?php endif; ?>
										<td><?php _e('Weight', 'wpcargo'); ?> (<?php echo $mp_settings['wpc_mp_weight_unit']; ?>)</td>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ( $packages as $package ) {
										?>
										<tr>
											<td class="package-description"><?php echo $package['wpc-pm-description']; ?></td>
											<td><?php echo $package['wpc-pm-qty']; ?></td>
											<td><?php echo $package['wpc-pm-piece-type']; ?></td>
											<?php if( array_key_exists('wpc_mp_enable_dimension_unit', $mp_settings)): ?>
												<td><?php echo $package['wpc-pm-length']; ?></td>
												<td><?php echo $package['wpc-pm-width']; ?></td>
												<td><?php echo $package['wpc-pm-height']; ?></td>
											<?php endif; ?>
											<td><?php echo $package['wpc-pm-weight']; ?></td>
										</tr>
										<?php
									}
									?>
								</tbody>
							</table>
						</td>
					</tr>
					<?php
				}
			}
		}
	}
	?>
</table>
<?php do_action('wpc_label_footer_information', $shipmentDetails['shipmentID'] ); ?>
</div>
<div style="text-align: center; margin:12px 0;">
	<a href="#" class="button button-secondary print" onclick="wpcargo_print('print-label')"><span class="ti-printer"></span> <?php _e('Print File', 'wpcargo'); ?></a>
</div>