<div  class="wpc-sh-wrap">
	<table id="shipment-history" class="wpc-shipment-history" style="width:100%">
		<thead>
			<tr>
				<th class="tbl-sh-date"><?php _e('Date', 'wpcargo'); ?></th>
				<th class="tbl-sh-time"><?php _e('Time', 'wpcargo'); ?></th>
				<th class="tbl-sh-location"><?php _e('Location', 'wpcargo'); ?></th>
				<th class="tbl-sh-status"><?php _e('Status', 'wpcargo'); ?></th>
				<th class="tbl-sh-author"><?php _e('Update By', 'wpcargo'); ?></th>
				<th class="tbl-sh-remarks"><?php _e('Remarks', 'wpcargo'); ?></th>
				<?php do_action('wpcargo_shipment_history_header'); ?>
			</tr>
		</thead>
		<tbody data-repeater-list="wpcargo_shipments_update">
		<?php
			if( !empty( $shipments ) ):
				foreach ( $shipments as $shipment ) :
					?>
					<tr data-repeater-item class="history-data">
						<td class="tbl-sh-date"><?php echo !empty($shipment['date']) ? date_i18n("Y-m-d", strtotime($shipment['date'])) : ''; ?></td>
						<td class="tbl-sh-time"><?php echo $shipment['time']; ?></td>
						<td class="tbl-sh-location"><?php echo $shipment['location']; ?></td>
						<td class="tbl-sh-status"><?php echo wpcargo_html_value( $shipment['status'] ); ?></td>
						<td class="tbl-sh-author">
							<?php
								$user_info = array();
								$get_user_updated_by = '';
								$get_user_fullname = '';
								if(array_key_exists('updated-by', $shipment)) {
									$get_user_updated_by = $shipment['updated-by'];
									if(!empty($get_user_updated_by)) {
										$user_info = get_userdata($get_user_updated_by);
										if( !empty( $user_info->first_name ) || !empty( $user_info->last_name ) ){
											$get_user_fullname = $user_info->first_name.' '.$user_info->last_name;
										}else{
											$get_user_fullname = $user_info->user_login;
										}
									}
								}
							?>
							<?php echo $get_user_fullname; ?>
						</td>
						<td class="tbl-sh-remarks"><?php echo $shipment['remarks']; ?></td>
						<?php do_action('wpcargo_shipment_history_data', $shipment ); ?>
					</tr>
					<?php
				endforeach;
			else :
				?>
				<tr data-repeater-item class="history-data">
					<td colspan="6"><?php _e('No Shipment History Found.'); ?></td>
				</tr>
				<?php
			endif;
		?>
		</tbody>
	</table>
</div>