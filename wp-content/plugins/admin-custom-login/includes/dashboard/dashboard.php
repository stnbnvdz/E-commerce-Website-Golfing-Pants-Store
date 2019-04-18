<!-- Dashboard Settings panel content --- >
<!----------------------------------------> 
<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="row">
	<?php include(WEBLIZAR_ACL_PLUGIN_DIR_PATH_FREE."includes/banner.php"); ?>
	<div class="post-social-wrapper clearfix">
		<div class="col-md-12 post-social-item">
			<div class="panel panel-default">
				<div class="panel-heading padding-none">
					<div class="post-social post-social-xs" id="post-social-5">
						<div class="text-center padding-all text-center">
							<div class="textbox text-white   margin-bottom settings-title">
								<?php _e('Admin Custom Login Dashboard', WEBLIZAR_ACL); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	

	<div class="panel panel-primary panel-default content-panel">
		<div class="panel-body">
			<table class="form-table">
				<tr>
					<th scope="row" ><?php _e('Admin Custom Login Status', WEBLIZAR_ACL); ?></th>
					<td></td>
				</tr>
				<tr class="radio-span" style="border-bottom:none;">
					<td>
						<span>
							<input type="radio" name="dashboard_status" value="disable" id="dashboard_status1" <?php if($dashboard_status == "disable") echo "checked"; ?> />&nbsp;<?php _e('Disable', WEBLIZAR_ACL)?><br>
						</span>
						<span>
							<input type="radio" name="dashboard_status" value="enable" id="dashboard_status2" <?php if($dashboard_status == "enable") echo "checked";?> />&nbsp;<?php _e('Enable', WEBLIZAR_ACL)?><br>
						</span>
					</td>
				</tr>
			</table>
		</div>
	</div>
	
	<div class="panel panel-primary panel-default content-panel">
		<div class="panel-body">
			<table class="form-table">
				<tr>
					<th scope="row" ><?php _e('View Login Page', WEBLIZAR_ACL); ?></th>
					<td></td>
				</tr>
				<tr class="radio-span" style="border-bottom:none;">
					<td>
						<h4><?php _e('Copy below link and open in another browser where you are not logged in', WEBLIZAR_ACL)?></h4>
						<br>
						<pre><span style="color:#ef4238"><?php echo wp_login_url(); ?></span></pre>
					</td>
				</tr>
			</table>
		</div>
	</div>	

	<!--<div class="panel panel-primary panel-default content-panel">
		<div class="panel-body">
			<table class="form-table">
				<tr>
					<th scope="row" >Enjoying Using Fre Plugin, Please Donate Us</th>
					<td></td>
				</tr>
				<tr class="radio-span" style="border-bottom:none;">
					<td class="colcent">
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
							<input type="hidden" name="cmd" value="_s-xclick">
							<input type="hidden" name="hosted_button_id" value="9MXDU3NKPCR5Y">
							<input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online!">
							<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
						</form>
					</td>
				</tr>
			</table>
		</div>
	</div>-->

	<button data-dialog="somedialog" class="dialog-button" style="display:none">Open Dialog</button>
	<div id="somedialog" class="dialog" style="position: fixed; z-index: 9999;">
		<div class="dialog__overlay"></div>
		<div class="dialog__content">
			<div class="morph-shape" data-morph-open="M33,0h41c0,0,0,9.871,0,29.871C74,49.871,74,60,74,60H32.666h-0.125H6c0,0,0-10,0-30S6,0,6,0H33" data-morph-close="M33,0h41c0,0-5,9.871-5,29.871C69,49.871,74,60,74,60H32.666h-0.125H6c0,0-5-10-5-30S6,0,6,0H33">
				<svg xmlns="" width="100%" height="100%" viewBox="0 0 80 60" preserveAspectRatio="none">
					<path d="M33,0h41c0,0-5,9.871-5,29.871C69,49.871,74,60,74,60H32.666h-0.125H6c0,0-5-10-5-30S6,0,6,0H33"></path>
				</svg>
			</div>
			<div class="dialog-inner">
				<h2><strong><?php _e('Dashboard', WEBLIZAR_ACL);?></strong> <?php _e('Setting Save Successfully', WEBLIZAR_ACL);?></h2><div><button class="action dialog-button-close" data-dialog-close id="dialog-close-button" ><?php _e('Close', WEBLIZAR_ACL);?></button></div>
			</div>
		</div>
	</div>
	
	<button data-dialog7="somedialog7" class="dialog-button7" style="display:none">Open Dialog</button>
	<div id="somedialog7" class="dialog" style="position: fixed; z-index: 9999;">
		<div class="dialog__overlay"></div>
		<div class="dialog__content">
			<div class="morph-shape" data-morph-open="M33,0h41c0,0,0,9.871,0,29.871C74,49.871,74,60,74,60H32.666h-0.125H6c0,0,0-10,0-30S6,0,6,0H33" data-morph-close="M33,0h41c0,0-5,9.871-5,29.871C69,49.871,74,60,74,60H32.666h-0.125H6c0,0-5-10-5-30S6,0,6,0H33">
				<svg xmlns="" width="100%" height="100%" viewBox="0 0 80 60" preserveAspectRatio="none">
					<path d="M33,0h41c0,0-5,9.871-5,29.871C69,49.871,74,60,74,60H32.666h-0.125H6c0,0-5-10-5-30S6,0,6,0H33"></path>
				</svg>
			</div>
			<div class="dialog-inner">
				<h2><strong><?php _e('Dashboard', WEBLIZAR_ACL)?></strong> <?php _e('Setting Reset Successfully', WEBLIZAR_ACL)?></h2><div><button class="action dialog-button-close" data-dialog-close id="dialog-close-button7" ><?php _e('Close', WEBLIZAR_ACL)?></button></div>
			</div>
		</div>
	</div>
	<div class="panel panel-primary save-button-block">
		<div class="panel-body">
			<div class="pull-left">
				<button type="button" onclick="return Custom_login_dashboard('dashboardSave', '');" class="btn btn-info btn-lg"><?php _e('Save Changes', WEBLIZAR_ACL);?></button>
			</div>
			<div class="pull-right">
				<button type="button" onclick="return Custom_login_dashboard('dashboardReset', '');" class="btn btn-primary btn-lg"><?php _e('Reset Default', WEBLIZAR_ACL);?></button>
			</div>
		</div>
	</div>
</div>
<!-- /row -->
<script>
function Custom_login_dashboard(Action, id) {
	if(Action == "dashboardSave") {
		(function() {
			var dlgtrigger = document.querySelector( '[data-dialog]' ),
				somedialog = document.getElementById( dlgtrigger.getAttribute( 'data-dialog' ) ),
				// svg..
				morphEl = somedialog.querySelector( '.morph-shape' ),
				s = Snap( morphEl.querySelector( 'svg' ) ),
				path = s.select( 'path' ),
				steps = { 
					open : morphEl.getAttribute( 'data-morph-open' ),
					close : morphEl.getAttribute( 'data-morph-close' )
				},
				dlg = new DialogFx( somedialog, {
					onOpenDialog : function( instance ) {
						// animate path
						setTimeout(function() {
							path.stop().animate( { 'path' : steps.open }, 1500, mina.elastic );
						}, 250 );
					},
					onCloseDialog : function( instance ) {
						// animate path
						path.stop().animate( { 'path' : steps.close }, 250, mina.easeout );
					}
				} );
			dlgtrigger.addEventListener( 'click', dlg.toggle.bind(dlg) );
		})();
		
		if (document.getElementById('dashboard_status1').checked) {
			var dashboard_status = document.getElementById('dashboard_status1').value;
		}
		else{
			var dashboard_status = document.getElementById('dashboard_status2').value;
		}
		var PostData = "Action=" + Action + "&dashboard_status=" + dashboard_status ;
		jQuery.ajax({
			dataType : 'html',
			type: 'POST',
			url : location.href,
			cache: false,
			data : PostData,
			complete : function() {  },
			success: function(data) {
				// Save message box open
				jQuery(".dialog-button").click();
				// Function to close message box
				
				setTimeout(function(){
					jQuery("#dialog-close-button").click();
				}, 1000);
			}
		});
	}
	
	// Save Message box Close On Mouse Hover
	document.getElementById('dialog-close-button').disabled = false;
		jQuery('#dialog-close-button').hover(function () {
			jQuery("#dialog-close-button").click();
			document.getElementById('dialog-close-button').disabled = true; 
		}
	 );
	 
	// Reset Message box Close On Mouse Hover
   document.getElementById('dialog-close-button7').disabled = false;
		jQuery('#dialog-close-button7').hover(function () {
			jQuery("#dialog-close-button7").click();
			document.getElementById('dialog-close-button7').disabled = true; 
		}
	);

	if(Action == "dashboardReset") {
		(function() {
			var dlgtrigger = document.querySelector( '[data-dialog7]' ),
				somedialog = document.getElementById( dlgtrigger.getAttribute( 'data-dialog7' ) ),
				// svg..
				morphEl = somedialog.querySelector( '.morph-shape' ),
				s = Snap( morphEl.querySelector( 'svg' ) ),
				path = s.select( 'path' ),
				steps = { 
					open : morphEl.getAttribute( 'data-morph-open' ),
					close : morphEl.getAttribute( 'data-morph-close' )
				},
				dlg = new DialogFx( somedialog, {
					onOpenDialog : function( instance ) {
						// animate path
						setTimeout(function() {
							path.stop().animate( { 'path' : steps.open }, 1500, mina.elastic );
						}, 250 );
					},
					onCloseDialog : function( instance ) {
						// animate path
						path.stop().animate( { 'path' : steps.close }, 250, mina.easeout );
					}
				} );
			dlgtrigger.addEventListener( 'click', dlg.toggle.bind(dlg) );
		})();
		
		var PostData = "Action=" + Action ;
		jQuery.ajax({
			dataType : 'html',
			type: 'POST',
			url : location.href,
			cache: false,
			data : PostData,
			complete : function() {  },
			success: function(data) {
			jQuery(document).ready( function() {
					jQuery('input[name=dashboard_status]').val(['disable']);
				});
				// Reset message box open
				jQuery(".dialog-button7").click();
				// Function to close message box
				setTimeout(function(){
					jQuery("#dialog-close-button7").click();
				}, 1000);
			}
		});
	}
}	
</script>
<?php
if(isset($_POST['Action'])) {
	$Action = $_POST['Action'];

	//Save
	if($Action == "dashboardSave") {
		$dashboard_status = sanitize_option('dashboard_status', $_POST['dashboard_status']);
	
	// save values in option table
		$dashboard_page= serialize(array(
			'dashboard_status' => $dashboard_status
		));
		update_option('Admin_custome_login_dashboard', $dashboard_page);
	}
	if($Action == "dashboardReset") {
		$dashboard_page= serialize(array(
			'dashboard_status' => 'disable'
		));
		update_option('Admin_custome_login_dashboard', $dashboard_page);
	}
}
?>
<style type="text/css">
	.colcent{
		width:100% !important;
		text-align: center !important;
	}
	.img_banner{
		width:100%;
	}
	@font-face {
font-family: 'Montserrat Alternates', sans-serif;
font-family: 'Nunito Sans', sans-serif;
font-family: 'Abel', sans-serif;
font-family: 'Nanum Gothic', sans-serif;
font-family: 'Lora', serif;
    src: url(https://fonts.googleapis.com/css?family=Abel|Lora|Montserrat+Alternates|Nanum+Gothic|Nunito+Sans);
}

body{
font-family: 'Nanum Gothic', sans-serif;
	
}
/*--close-media-responsive csss--*/
</style>