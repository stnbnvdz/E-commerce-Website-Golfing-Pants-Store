<div class="wpc-mp-wrap">
	<table class="wpc-multiple-package wpc-repeater">
		<!--
			The value given to the data-repeater-list attribute will be used as the
			base of rewritten name attributes.  In this example, the first
			data-repeater-item's name attribute would become group-a[0][text-input],
			and the second data-repeater-item would become group-a[1][text-input]
		-->
		<thead>
			<tr>
				<th><?php _e('Qty.','wpcargo'); ?></th>
				<th><?php _e('Piece Type','wpcargo'); ?></th>
				<?php
					if(!empty($wpc_mp_enable_dimension_unit) && $wpc_mp_enable_dimension_unit == 1) {
						?>
							<th><?php _e('Length','wpcargo'); ?> (<?php echo !empty($wpc_mp_dimension_unit) ? $wpc_mp_dimension_unit : 'cm'; ?>)</th>
							<th><?php _e('Width','wpcargo'); ?> (<?php echo !empty($wpc_mp_dimension_unit) ? $wpc_mp_dimension_unit : 'cm'; ?>)</th>
							<th><?php _e('Height','wpcargo'); ?> (<?php echo !empty($wpc_mp_dimension_unit) ? $wpc_mp_dimension_unit : 'cm'; ?>)</th>
						<?php
					}
				?>
				<th><?php _e('Weight','wpcargo'); ?> (<?php echo !empty($wpc_mp_weight_unit) ? $wpc_mp_weight_unit : 'lbs'; ?>)</th>
				<th><?php _e('Description','wpcargo'); ?></th>
				<th>&nbsp;</th>
				<?php
					do_action('wpc_mp_add_head_title');
				?>
			</tr>
		</thead>
		<tbody data-repeater-list="wpc-multiple-package">
		<?php

		if(!empty($wpc_multiple_package) && is_array($wpc_multiple_package)) {
			foreach($wpc_multiple_package as $mp) {
			?>
				<tr data-repeater-item class="wpc-mp-tr">
				<td><input class="number" type="text" name="wpc-pm-qty" value="<?php echo $mp['wpc-pm-qty']; ?>"/></td>
				<td><select name="wpc-pm-piece-type">
				<option value=""><?php _e('-- Select Type --','wpcargo'); ?></option>
					<?php
						$explode_peice_type	= explode(",", $wpc_mp_peice_type);
						foreach($explode_peice_type as $val){
							$piece_type = $mp['wpc-pm-piece-type'];
							if(trim($val) == $piece_type){
								$selected = 'selected';
							}else{
								$selected = '';
							}
							echo '<option value="'.trim($val).'" '.$selected.'>'.trim($val).'</option>';
						}
					?>
				</select></td>
				<?php
					if(!empty($wpc_mp_enable_dimension_unit) && $wpc_mp_enable_dimension_unit == 1) {
						?>
							<td><input class="number" type="text" name="wpc-pm-length" value="<?php echo $mp['wpc-pm-length']; ?>"/></td>
							<td><input class="number" type="text" name="wpc-pm-width" value="<?php echo $mp['wpc-pm-width']; ?>"/></td>
							<td><input class="number" type="text" name="wpc-pm-height" value="<?php echo $mp['wpc-pm-height']; ?>"/></td>
						<?php
					}
				?>
				<td><input class="number" type="text" name="wpc-pm-weight" value="<?php echo $mp['wpc-pm-weight']; ?>"/></td>
				<td><textarea style="width:100%" class="textarea" type="text" name="wpc-pm-description"><?php echo $mp['wpc-pm-description']; ?></textarea></td>
				<?php
					do_action( 'wpc_mp_add_field_data', $mp );
				?>
				<td><input data-repeater-delete type="button" class="wpc-delete" value="Delete"/></td>
				</tr>
			<?php
			}
		}else{
			?>
				<tr data-repeater-item class="wpc-mp-tr">
					<td><input class="number" type="text" name="wpc-pm-qty" value=""/></td>
					<td><select name="wpc-pm-piece-type">
					<option value=""><?php _e('-- Select Type --','wpcargo'); ?></option>
						<?php
							$explode_peice_type	= explode(",", $wpc_mp_peice_type);
							foreach($explode_peice_type as $val){
								echo '<option value="'.trim($val).'">'.trim($val).'</option>';
							}
						?>
					</select></td>
					<?php
					if(!empty($wpc_mp_enable_dimension_unit) && $wpc_mp_enable_dimension_unit == 1) {
						?>
						<td><input class="number" type="text" name="wpc-pm-length" value=""/></td>
						<td><input class="number" type="text" name="wpc-pm-width" value=""/></td>
						<td><input class="number" type="text" name="wpc-pm-height" value=""/></td>
						<?php
						}
					?>
					<td><input class="number" type="text" name="wpc-pm-weight" value=""/></td>
					<td><textarea style="width:100%" class="textarea" type="text" name="wpc-pm-description"></textarea></td>
					<?php
						do_action( 'wpc_mp_add_field' );
					?>
					<td><input data-repeater-delete type="button" class="wpc-delete" value="Delete"/></td>
				</tr>
			<?php
		}
		?>
		</tbody>
		<tfoot>
		<?php
			do_action('wpc_mp_after_add_field_data', $post->ID);
		?>
		<tr class="wpc-computation">
			<td colspan="6"><input data-repeater-create type="button" class="wpc-add" value="<?php _e('Add Package','wpcargo'); ?>"/></td>
		</tr>
		</tfoot>
	</table>
</div>
