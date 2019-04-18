<?php
	
if ( ! empty( $_POST ) && check_admin_referer( 'phoen_reporting_function', 'phoen_reporting_nonce_field' ) ) {
	
	if(isset($_POST['phoen_set_reporting']) && $_POST['phoen_set_reporting'] == 'Save changes')
	{
		
		if(isset($_POST['phoen_reporting_enable'])){
			
			$phoen_enable = sanitize_text_field($_POST['phoen_reporting_enable']);
			
			
		}else{
			
			$phoen_enable = '';
		}
		
		update_option('phoen_reportings_enable',$phoen_enable);	
	}
	
}
		
$phoen_reporting_enable_settings = get_option('phoen_reportings_enable');

$plugin_dir_url =  plugin_dir_url( __FILE__ );
		
?>
		
<form method="post">

	<?php wp_nonce_field( 'phoen_reporting_function', 'phoen_reporting_nonce_field' ); ?>

	 <div class="pho-upgrade-btn">
		<a href="https://www.phoeniixx.com/product/advanced-reporting-for-woocommerce/" target="_blank"><img src="<?php echo $plugin_dir_url; ?>../assets/images/premium-btn.png" /></a>
		<a target="blank" href="http://reporting.phoeniixxdemo.com/wp-login.php?redirect_to=http%3A%2F%2Freporting.phoeniixxdemo.com%2Fwp-admin%2F&reauth=1"><img src="<?php echo $plugin_dir_url; ?>../assets/images/button2.png" /></a>
     </div>
	 
	 <div class="phoe_video_main">
		<h3>How to set up plugin</h3> 
		<iframe width="800" height="360"src="https://www.youtube.com/embed/tuO262-OFoE" allowfullscreen></iframe>
	</div>
	 
	<table class="form-table">

		<tbody>
		
			<tr class="phoen-user-user-login-wrap">
			
				<th><label for="phoen_advance_reporting"><?php _e("Enable Reporting Plugin",'advanced-reporting-for-woocommerce'); ?></label></th>
			
				<td>
				
					<input type="checkbox" value="1" <?php echo(isset($phoen_reporting_enable_settings) && $phoen_reporting_enable_settings == '1')?'checked':'';?> name="phoen_reporting_enable">
					
				</td>
			
			</tr>
			
			
		</tbody>
		
	</table>
	<br />
	<input type="submit" value="Save changes" class="button-primary" name="phoen_set_reporting">
	
</form>
		
<style>

	.form-table th {
	
		width: 270px;
		
		padding: 25px;
		
	}
	
	.form-table td {
	
		padding: 20px 10px;
	}
	
	.form-table {
	
		background-color: #fff;
	}
	
	h3 {
	
		padding: 10px;
		
	}

	.pho-upgrade-btn {
		margin-top: 20px;
	}

	.pho-upgrade-btn a:focus {
		box-shadow: none;
	}

	.phoe_video_main {
		padding: 20px;
		text-align: center;
	}
	
	.phoe_video_main h3 {
		color: #02c277;
		font-size: 28px;
		font-weight: bolder;
		margin: 20px 0;
		text-transform: capitalize
		display: inline-block;
	}

</style>
	