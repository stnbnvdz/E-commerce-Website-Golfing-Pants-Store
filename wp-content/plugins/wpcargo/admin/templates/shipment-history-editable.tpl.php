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
				<th class="tbl-sh-action">&nbsp;</th>
			</tr>
		</thead>
		<tbody data-repeater-list="wpcargo_shipments_update">
		<?php
			if( !empty( $shipments ) ):
				foreach ( $shipments as $shipment ) :
					?>
					<tr data-repeater-item class="history-data">
						<td class="tbl-sh-date"><input class="date wpcargo-datepicker" type="text" name="date" value="<?php echo !empty($shipment['date']) ? date_i18n("Y-m-d", strtotime($shipment['date'])) : ''; ?>" autocomplete="off"/></td>
						<td class="tbl-sh-time"><input class="time wpcargo-timepicker" type="text" name="time" value="<?php echo $shipment['time']; ?>" autocomplete="off"/></td>
						<td class="tbl-sh-location"><input type="text" name="location" value="<?php echo $shipment['location']; ?>"/></td>
						<td class="tbl-sh-status">
							<select name="status">
								<option value="" ><?php _e('Select Option','wpcargo'); ?></option>
								<?php
									foreach ($wpcargo->status as $status) {
										?>
										<option value="<?php _e(sanitize_text_field($status), 'wpcargo'); ?>" <?php echo ( trim($status) == $shipment['status']  ) ? 'selected' : '' ; ?> ><?php echo _e(sanitize_text_field($status), 'wpcargo'); ?></option>
										<?php
									}
								?>
							</select>
						</td>
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
							<input readonly="readonly" type="text" name="updated-name" value="<?php echo $get_user_fullname; ?>">
							<input type="hidden" name="updated-by" value="<?php echo $get_user_updated_by; ?>"/>
						</td>
						<td class="tbl-sh-remarks"><textarea style="width: 100%;" name="remarks" ><?php echo $shipment['remarks']; ?></textarea></td>
						<?php do_action('wpcargo_shipment_history_data_editable', $shipment ); ?>
						<td class="tbl-sh-action">
							<input data-repeater-delete type="button" class="wpc-delete" value="<?php _e('Delete', 'wpcargo')?>"/>
						</td>
					</tr>
					<?php
				endforeach;
			else :
				?>
				<tr data-repeater-item class="history-data">
					<td class="tbl-sh-date"><input class="date wpcargo-datepicker" type="text" name="date" value="" autocomplete="off"/></td>
					<td class="tbl-sh-time"><input class="time wpcargo-timepicker" type="text" name="time" value="" autocomplete="off"/></td>
					<td class="tbl-sh-location"><input type="text" name="location" value=""/></td>
					<td class="tbl-sh-status">
						<select name="status">
							<option value="" ><?php _e('Select Option','wpcargo'); ?></option>
							<?php
								foreach ($wpcargo->status as $status) {
									?>
									<option value="<?php _e(sanitize_text_field($status), 'wpcargo'); ?>"><?php echo _e(sanitize_text_field($status), 'wpcargo'); ?></option>
									<?php
								}
							?>
						</select>
					</td>
					<td class="tbl-sh-author">
						<input readonly="readonly" type="text" name="updated-name" value="<?php echo $current_user->first_name.' '.$current_user->last_name; ?>">
						<input type="hidden" name="updated-by" value="<?php echo $current_user->ID; ?>"/>
					</td>
					<td class="tbl-sh-remarks"><textarea style="width: 100%;" name="remarks" ></textarea></td>
					<?php do_action('wpcargo_shipment_history_data_editable', $shipment = array() ); ?>
					<td class="tbl-sh-action">
						<input data-repeater-delete type="button" class="wpc-delete" value="<?php _e('Delete', 'wpcargo')?>"/>
					</td>
				</tr>
				<?php
			endif;
		?>
		</tbody>
	</table>
</div>
<script>
jQuery(document).ready(function ($) {
	'use strict';
	$('#shipment-history').repeater({
		defaultValues: {
			'date': '<?php echo $wpcargo->user_date(get_current_user_id()); ?>',
			'time': '<?php echo $wpcargo->user_time(get_current_user_id()); ?>',
			'location': '',
			'remarks': '',
			'updated-name': '<?php echo $current_user->user_firstname.' '.$current_user->user_lastname; ?>',
			'updated-by': '<?php echo $current_user->ID; ?>'
		},
		show: function () {
			$(this).slideDown();
			$(".wpcargo-datepicker").datepicker({dateFormat: "<?php echo $wpcargo->date_format; ?>"});
			$(".wpcargo-timepicker").timepicker({timeFormat: "<?php echo $wpcargo->time_format; ?>"});
		},
		hide: function (deleteElement) {
			if( confirm('<?php _e( 'Are you sure you want to delete this element?', 'wpcargo' ); ?>') ) {
				$(this).slideUp(deleteElement);
			}
		}
	});
});
</script>