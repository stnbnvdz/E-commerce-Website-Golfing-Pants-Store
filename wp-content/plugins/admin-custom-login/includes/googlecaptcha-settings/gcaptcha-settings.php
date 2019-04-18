<!-- Dashboard Settings panel content --->
<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="row">
	<div class="post-social-wrapper clearfix">
		<div class="col-md-12 post-social-item">
			<div class="panel panel-default">
				<div class="panel-heading padding-none">
					<div class="post-social post-social-xs" id="post-social-5">
						<div class="text-center padding-all text-center">
							<div class="textbox text-white   margin-bottom settings-title">
								<?php _e('Google Captcha Settings',WEBLIZAR_ACL)?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<style type="text/css">
		.acl_gcaptcha_sub_label {
		    font-weight: bold;
		    background-color: #f1f1f1;
		    padding: 7px 10px;
		    margin-top: 10px;
		    font-size: 15px;
		}
		div.acl_gcaptcha_info {
		    margin-top: 7px;
		    word-break: break-all;
		}
		.acl_gcaptcha_info {
		    color: #888;
		    font-size: 13px;
		    font-style: italic;
		}
	</style>
	<div class="panel panel-primary panel-default content-panel">
		<div class="panel-body">
			<table class="form-table">
				<tr>
					<th scope="row" ><?php _e('Google Captcha Settings',WEBLIZAR_ACL)?></th>
					<td></td>
				</tr>
				<tr class="radio-span" style="border-bottom:none;">
					<td>
						Need Help?<a href="http://www.weblizar.com" target="_blank"> Visit Help Center</a>
						<div class="acl_gcaptcha_sub_label">Authentication</div>
						<div class="acl_gcaptcha_info">Register your website with Google to get required API keys and enter them below. <a target="_blank" href="https://weblizar.com/blog/how-to-generate-recaptcha-keys-for-your-domain/">Get the API Keys</a></div>
					</td>
				</tr>
				<tr>
					<th scope="row" ><?php _e('Site Key',WEBLIZAR_ACL)?></th>
					<td></td>
				</tr>
				<tr class="radio-span" style="border-bottom:none;">
					<td>
						<input type="text" class="pro_text" id="site-key" name="site-key" placeholder="<?php _e('Site Key',WEBLIZAR_ACL)?>" size="56" value="<?php echo $site_key; ?>"/>
					</td>
				</tr>
				<tr>
					<th scope="row" ><?php _e('Secret Key',WEBLIZAR_ACL)?></th>
					<td></td>
				</tr>
				<tr class="radio-span" style="border-bottom:none;">
					<td>
						<input type="text" class="pro_text" id="secret-key" name="secret-key" placeholder="<?php _e('Secret Key',WEBLIZAR_ACL)?>" size="56" value="<?php echo $secret_key; ?>"/>
					</td>
				</tr>

				<tr>
					<th scope="row" ><?php _e('Captcha Display',WEBLIZAR_ACL)?></th>
					<td></td>
				</tr>
				<tr class="radio-span" style="border-bottom:none;">
					<td>
						<span>
							<input type="radio" name="enable_gacptcha" value="yes" id="login_enable_gcaptcha1" <?php if($login_enable_gcaptcha=="yes")echo "checked"; ?> />&nbsp;<?php _e('Enable', WEBLIZAR_ACL)?><br>
						</span>
						<span>
							<input type="radio" name="enable_gacptcha" value="no" id="login_enable_gcaptcha2" <?php if($login_enable_gcaptcha=="no")echo "checked"; ?> />&nbsp;<?php _e('Disable', WEBLIZAR_ACL)?><br>
						</span>
						<div class="acl_gcaptcha_info"><strong>Note : </strong> After enable google captcha display please insert site key & secret key.</div>
					</td>
				</tr>

				<tr>
					<th scope="row" ><?php _e('Captcha Theme',WEBLIZAR_ACL)?></th>
					<td></td>
				</tr>
				<tr class="radio-span" style="border-bottom:none;">
					<td>
						<span>
							<input type="radio" name="acl_gcaptcha_theme" value="yes" id="acl_gcaptcha_theme1" <?php if($acl_gcaptcha_theme=="yes")echo "checked"; ?> />&nbsp;<?php _e('Light', WEBLIZAR_ACL)?><br>
						</span>
						<span>
							<input type="radio" name="acl_gcaptcha_theme" value="no" id="acl_gcaptcha_theme2" <?php if($acl_gcaptcha_theme=="no")echo "checked"; ?> />&nbsp;<?php _e('Dark', WEBLIZAR_ACL)?><br>
						</span>
					</td>
				</tr>
			</table>
		</div>
	</div>
	
	<button data-dialog49="somedialog49" class="dialog-button49" style="display:none">Open Dialog</button>
	<div id="somedialog49" class="dialog" style="position: fixed; z-index: 9999;">
		<div class="dialog__overlay"></div>
		<div class="dialog__content">
			<div class="morph-shape" data-morph-open="M33,0h41c0,0,0,9.871,0,29.871C74,49.871,74,60,74,60H32.666h-0.125H6c0,0,0-10,0-30S6,0,6,0H33" data-morph-close="M33,0h41c0,0-5,9.871-5,29.871C69,49.871,74,60,74,60H32.666h-0.125H6c0,0-5-10-5-30S6,0,6,0H33">
				<svg xmlns="" width="100%" height="100%" viewBox="0 0 80 60" preserveAspectRatio="none">
					<path d="M33,0h41c0,0-5,9.871-5,29.871C69,49.871,74,60,74,60H32.666h-0.125H6c0,0-5-10-5-30S6,0,6,0H33"></path>
				</svg>
			</div>
			<div class="dialog-inner">
				<h2><strong><?php _e('Google Captcha',WEBLIZAR_ACL)?></strong> <?php _e('Setting Save Successfully',WEBLIZAR_ACL)?></h2><div><button class="action dialog-button-close" data-dialog-close id="dialog-close-button49"><?php _e('Close',WEBLIZAR_ACL)?></button></div>
			</div>
		</div>
	</div>
	<button data-dialog109="somedialog109" class="dialog-button109" style="display:none">Open Dialog</button>
	<div id="somedialog109" class="dialog" style="position: fixed; z-index: 9999;">
		<div class="dialog__overlay"></div>
		<div class="dialog__content">
			<div class="morph-shape" data-morph-open="M33,0h41c0,0,0,9.871,0,29.871C74,49.871,74,60,74,60H32.666h-0.125H6c0,0,0-10,0-30S6,0,6,0H33" data-morph-close="M33,0h41c0,0-5,9.871-5,29.871C69,49.871,74,60,74,60H32.666h-0.125H6c0,0-5-10-5-30S6,0,6,0H33">
				<svg xmlns="" width="100%" height="100%" viewBox="0 0 80 60" preserveAspectRatio="none">
					<path d="M33,0h41c0,0-5,9.871-5,29.871C69,49.871,74,60,74,60H32.666h-0.125H6c0,0-5-10-5-30S6,0,6,0H33"></path>
				</svg>
			</div>
			<div class="dialog-inner">
				<h2><strong><?php _e('Google Captcha',WEBLIZAR_ACL)?></strong> <?php _e('Setting Reset Successfully',WEBLIZAR_ACL)?></h2><div><button class="action dialog-button-close" data-dialog-close id="dialog-close-button109"><?php _e('Close',WEBLIZAR_ACL)?></button></div>
			</div>
		</div>
	</div>
	<div class="panel panel-primary save-button-block">
		<div class="panel-body">
			<div class="pull-left">
				<button type="button" onclick="return Custom_gcaptcha('googleSave', '');" class="btn btn-info btn-lg"><?php _e('Save Changes',WEBLIZAR_ACL)?></button>
			</div>
			<div class="pull-right">
				<button type="button" onclick="return Custom_gcaptcha('googleReset', '');" class="btn btn-primary btn-lg"><?php _e('Reset Default',WEBLIZAR_ACL)?></button>
			</div>
		</div>
	</div>
</div>
<!-- /row -->
<script>
function Custom_gcaptcha(Action, id){
	if(Action == "googleSave") {
		(function(){
			var dlgtrigger = document.querySelector( '[data-dialog49]' ),
				somedialog = document.getElementById( dlgtrigger.getAttribute( 'data-dialog49' ) ),
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

		var site_key = jQuery("#site-key").val();
		var secret_key = jQuery("#secret-key").val();
		if (document.getElementById('login_enable_gcaptcha1').checked) {
			var login_enable_gcaptcha = document.getElementById('login_enable_gcaptcha1').value;
		} else {
			var login_enable_gcaptcha = document.getElementById('login_enable_gcaptcha2').value;
		}

		if (document.getElementById('acl_gcaptcha_theme1').checked) {
			var acl_gcaptcha_theme = document.getElementById('acl_gcaptcha_theme1').value;
		} else {
			var acl_gcaptcha_theme = document.getElementById('acl_gcaptcha_theme2').value;
		}
		
		var PostData = "Action=" + Action + "&site_key=" + site_key + "&secret_key=" + secret_key + "&login_enable_gcaptcha=" + login_enable_gcaptcha + "&acl_gcaptcha_theme=" + acl_gcaptcha_theme;
		jQuery.ajax({
			dataType : 'html',
			type: 'POST',
			url : location.href,
			cache: false,
			data : PostData,
			complete : function() {  },
			success: function(data) {
				// Save message box open
				jQuery(".dialog-button49").click();
				// Function to close message box
				setTimeout(function(){
					jQuery("#dialog-close-button49").click();
				}, 1000);
			}
		});
	}
	
	// Save Message box Close On Mouse Hover
	document.getElementById('dialog-close-button49').disabled = false;
	jQuery('#dialog-close-button49').hover(function () {
		jQuery("#dialog-close-button49").click();
		document.getElementById('dialog-close-button49').disabled = true; 
	});
	 
	// Reset Message box Close On Mouse Hover
	document.getElementById('dialog-close-button109').disabled = false;
	jQuery('#dialog-close-button109').hover(function () {
	   jQuery("#dialog-close-button109").click();
	   document.getElementById('dialog-close-button109').disabled = true; 
	});
	
	if(Action == "googleReset") {		
		(function(){
			var dlgtrigger = document.querySelector( '[data-dialog109]' ),
				somedialog = document.getElementById( dlgtrigger.getAttribute( 'data-dialog109' ) ),
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
				
				document.getElementById("site-key").value ="";
				document.getElementById("secret-key").value ="";
				jQuery(document).ready( function() {
					jQuery('input[name=enable_gcaptcha]').val(['yes']);
				});
				jQuery(document).ready( function() {
					jQuery('input[name=acl_gcaptcha_theme]').val(['yes']);
				});

				// Reset message box open
				jQuery(".dialog-button109").click();
				// Function to close message box
				setTimeout(function(){
					jQuery("#dialog-close-button109").click();
				}, 1000);
			}
		});
	}
}
</script>
<?php
if(isset($_POST['Action'])) {
	$Action = $_POST['Action'];	
	//Save Page Values
	if($Action == "googleSave") {
		$site_key = sanitize_text_field($_POST['site_key']);
		$secret_key = sanitize_text_field( $_POST['secret_key']);
		$login_enable_gcaptcha = sanitize_text_field( $_POST['login_enable_gcaptcha']);
		$acl_gcaptcha_theme = sanitize_text_field( $_POST['acl_gcaptcha_theme']);

	
		// save values in option table
		$g_page= serialize(array(
			'site_key' => $site_key,
			'secret_key'=> $secret_key,
			'login_enable_gcaptcha'=> $login_enable_gcaptcha,
			'acl_gcaptcha_theme'=>$acl_gcaptcha_theme,
			
		));
		update_option('Admin_custome_login_gcaptcha', $g_page);
	}

	//Reset Page Settings
	if($Action == "googleReset") {
		$g_page= serialize(array(
			
			'site_key'=>'',
			'secret_key'=>'',
			'login_enable_gcaptcha'=>'no',
			'acl_gcaptcha_theme'=>'yes',
			
		));
		update_option('Admin_custome_login_gcaptcha', $g_page);
	}
}
?>