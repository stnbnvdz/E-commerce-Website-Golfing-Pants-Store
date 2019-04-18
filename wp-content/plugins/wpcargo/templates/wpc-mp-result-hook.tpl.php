<?php
if (!defined('ABSPATH')){
	exit; // Exit if accessed directly
}
$shipment_id 				= $shipment_detail->ID;
$get_multiple_package_data 	= get_post_meta($shipment_id, 'wpc-multiple-package', true);
$unserialized_mp_data		= unserialize($get_multiple_package_data);
$options 					= get_option( 'wpc_mp_settings' );
$wpc_mp_dimension_unit 		= !empty($options['wpc_mp_dimension_unit']) ? $options['wpc_mp_dimension_unit'] : 'cm';
$wpc_mp_weight_unit 		= !empty($options['wpc_mp_weight_unit']) ? $options['wpc_mp_weight_unit'] : 'lbs';
$wpc_mp_enable_dimension_unit 	= !empty($options['wpc_mp_enable_dimension_unit']) ? $options['wpc_mp_enable_dimension_unit'] : '';
?>
<!--[if !IE]><!-->
	<style>

	/*
	Max width before this PARTICULAR table gets nasty
	This query will take effect for any screen smaller than 760px
	and also iPads specifically.
	*/
	@media
	only screen and (max-width: 760px),
	(min-device-width: 768px) and (max-device-width: 1024px)  {

		/* Force table to not be like tables anymore */
		table#list-container.wpc-mp-table,
		table#list-container.wpc-mp-table thead,
		table#list-container.wpc-mp-table tbody,
		table#list-container.wpc-mp-table th,
		table#list-container.wpc-mp-table td,
		table#list-container.wpc-mp-table tr {
			display: block;
		}

		/* Hide table headers (but not display: none;, for accessibility) */
		table#list-container.wpc-mp-table thead tr {
			position: absolute;
			top: -9999px;
			left: -9999px;
		}

		table#list-container.wpc-mp-table tr {
			border: 1px solid #ccc;
			text-align: initial !important;

		}

		table#list-container.wpc-mp-table td {
			/* Behave  like a "row" */
			border: none;
			border-bottom: 1px solid #cccccc;
			position: relative;
			padding:6px;
			padding-left: 50% !important;
		}

		table#list-container.wpc-mp-table td:before {
			/* Now like a table header */
			position: absolute;
			/* Top/left values mimic padding */
			top: 6px;
			left: 6px;
			width: 45%;
			padding-right: 10px;
			white-space: nowrap;
		}
		#wpcargo-result-print .wpc-multiple-package .wpc-mp-table tbody tr {
		    background-color: #d6d6d6;
		        width: 100%;
		}
		#wpcargo-result-print .wpc-multiple-package .wpc-mp-table tbody tr:nth-child(odd) {
		    background-color: #f1f1f1;
		}

		/*
		Label the data
		*/
		table#list-container.wpc-mp-table td:nth-of-type(1):before { content: "<?php _e('Qty.', 'wpcargo'); ?>"; }
		table#list-container.wpc-mp-table td:nth-of-type(2):before { content: "<?php _e('Piece Type', 'wpcargo'); ?>"; }
		table#list-container.wpc-mp-table td:nth-of-type(3):before { content: "<?php _e('Length ('.$wpc_mp_dimension_unit.')', 'wpcargo'); ?>"; }
		table#list-container.wpc-mp-table td:nth-of-type(4):before { content: "<?php _e('Width ('.$wpc_mp_dimension_unit.')', 'wpcargo'); ?>"; }
		table#list-container.wpc-mp-table td:nth-of-type(5):before { content: "<?php _e('Height ('.$wpc_mp_dimension_unit.')', 'wpcargo'); ?>"; }
		table#list-container.wpc-mp-table td:nth-of-type(6):before { content: "<?php _e('Weight ('.$wpc_mp_weight_unit.')', 'wpcargo'); ?>"; }
		table#list-container.wpc-mp-table td:nth-of-type(7):before { content: "<?php _e('Description', 'wpcargo'); ?>"; }
	}

</style>
<!--<![endif]-->
<div class="wpc-multiple-package">
	<p class="header-title"><strong><?php _e( apply_filters( 'wpc_multiple_package_header', 'Packages' ), 'wpcargo-multiple-package'); ?></strong></p>
	<table class="table wpcargo-table" id="list-container" style="width:100%">
	<?php
		echo '<thead>';
			echo '<tr>';
				echo '<th >'.__('Qty.', 'wpcargo').'</th>';
				echo '<th >'.__('Piece Type', 'wpcargo').'</th>';
				if(!empty($wpc_mp_enable_dimension_unit) && $wpc_mp_enable_dimension_unit == 1) {
					echo '<th >'.__('Length ('.$wpc_mp_dimension_unit.')', 'wpcargo').'</th>';
					echo '<th >'.__('Width ('.$wpc_mp_dimension_unit.')', 'wpcargo').'</th>';
					echo '<th >'.__('Height ('.$wpc_mp_dimension_unit.')', 'wpcargo').'</th>';
				}
				echo '<th >'.__('Weight ('.$wpc_mp_weight_unit.')', 'wpcargo').'</th>';
				echo '<th >'.__('Description', 'wpcargo').'</th>';
				do_action('wpc_mp_header_results');
			echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
		$sum_pm_price = array();
		if(!empty($unserialized_mp_data)) {
			foreach($unserialized_mp_data as $val){

				$get_qty 			= $val['wpc-pm-qty'];
				$get_piece_type 	= $val['wpc-pm-piece-type'];
				$get_pm_length 		= $val['wpc-pm-length'];
				$get_pm_width 		= $val['wpc-pm-width'];
				$get_pm_height		= $val['wpc-pm-height'];
				$get_pm_weight		= $val['wpc-pm-weight'];
				$get_pm_desc 		= $val['wpc-pm-description'];

				echo '<tr>';
					echo '<td >'.$get_qty.'</td>';
					echo '<td >'.$get_piece_type.'</td>';
					if(!empty($wpc_mp_enable_dimension_unit) && $wpc_mp_enable_dimension_unit == 1) {
						echo '<td >'.$get_pm_length.'</td>';
						echo '<td >'.$get_pm_width.'</td>';
						echo '<td >'.$get_pm_height.'</td>';
					}
					echo '<td >'.$get_pm_weight.'</td>';
					echo '<td >'.$get_pm_desc.'</td>';
					do_action('wpc_mp_field_results', $val);
				echo '</tr>';

			}
		}
		echo '</tbody>';
		do_action('wpc_mp_after_results', $shipment_id);
	?>

	</table>
</div>

