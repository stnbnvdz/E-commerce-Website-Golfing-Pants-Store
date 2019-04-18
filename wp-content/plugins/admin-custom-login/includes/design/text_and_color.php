<!-- Dashboard Settings panel content --- >
<!---------------------------------------->
<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<Script>
//button Headline-Font-size slider
  jQuery(function() {
    jQuery( "#button-size-slider" ).slider({
		orientation: "horizontal",
		range: "min",
		max: 100,
		min:0,
		slide: function( event, ui ) {
			jQuery( "#headline-size-text-box" ).val( ui.value );
		}
	});
	jQuery( "#button-size-slider" ).slider("value",<?php if($heading_font_size != ""){echo $heading_font_size;}else{echo "30";}?> );
	jQuery( "#headline-size-text-box" ).val( jQuery( "#button-size-slider" ).slider( "value") );
  });

//button Input-Font-size slider
jQuery(function() {
	jQuery( "#button-size-slider2" ).slider({
		orientation: "horizontal",
		range: "min",
		max: 100,
		min:0,
		slide: function( event, ui ) {
		jQuery( "#input-size-text-box" ).val( ui.value );
		}
	});
	jQuery( "#button-size-slider2" ).slider("value",<?php if($input_font_size != ""){echo $input_font_size;}else{echo "30";}?> );
	jQuery( "#input-size-text-box" ).val( jQuery( "#button-size-slider2" ).slider( "value") );
});

//button Link-font-size slider
jQuery(function() {
	jQuery( "#button-size-slider3" ).slider({
		orientation: "horizontal",
		range: "min",
		max: 100,
		min:0,
		slide: function( event, ui ) {
		jQuery( "#link-size-text-box" ).val( ui.value );
		}
	});
	jQuery( "#button-size-slider3" ).slider("value",<?php if($link_size != ""){echo $link_size;}else{echo "30";}?>);
	jQuery( "#link-size-text-box" ).val( jQuery( "#button-size-slider3" ).slider( "value") );
});

//button Button-font-size slider
jQuery(function() {
	jQuery( "#button-size-slider7" ).slider({
		orientation: "horizontal",
		range: "min",
		max: 100,
		min:0,
		slide: function( event, ui ){
		jQuery( "#button-size-text-box" ).val( ui.value );
		}
	});
	jQuery( "#button-size-slider7" ).slider("value",<?php if($button_font_size != ""){echo $button_font_size;}else{echo "30";}?> );
	jQuery( "#button-size-text-box" ).val( jQuery("#button-size-slider7").slider("value"));
});

//Set Value of Drop Down
jQuery(document).ready(function(){
	//Headline Font Style
	jQuery("#headline_font_style").val('<?php if($heading_font_style != ""){echo $heading_font_style;}else {echo "";}?>');
	//Input Font Style
	jQuery("#input_font_style").val('<?php if($input_font_style != ""){echo $input_font_style;}else {echo "";}?>');
	//Link Font Style 
	jQuery("#link_font_style").val('<?php if($link_font_style != ""){echo $link_font_style;}else {echo "";}?>');
	//Button Font Style 
	jQuery("#button_font_style").val('<?php if($button_font_style != ""){echo $button_font_style;}else {echo "";}?>'); 
});
</script>

<div class="row">
	<div class="post-social-wrapper clearfix">
		<div class="col-md-12 post-social-item">
			<div class="panel panel-default">
				<div class="panel-heading padding-none">
					<div class="post-social post-social-xs" id="post-social-5">
						<div class="text-center padding-all text-center">
							<div class="textbox text-white   margin-bottom settings-title">
								<?php _e('Text And Color Settings', WEBLIZAR_ACL)?>
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
					<th scope="row" ><?php _e('Headline Font Color', WEBLIZAR_ACL)?></th>
					<td></td>
				</tr>
				<tr  style="border-bottom:none;">
					<td id="td-headline-font-color">
						<input id="headline-font-color" name="headline-font-color" type="text" value="<?php echo $heading_font_color; ?>" class="my-color-field" data-default-color="#ffffff" />
					</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="panel panel-primary panel-default content-panel">
		<div class="panel-body">
			<table class="form-table">
				<tr>
					<th scope="row" ><?php _e('Input Font Color', WEBLIZAR_ACL)?></th>
					<td></td>
				</tr>
				<tr  style="border-bottom:none;">
					<td id="td-input-font-color">
						<input id="input-font-color" name="input-font-color" type="text" value="<?php echo $input_font_color; ?>" class="my-color-field" data-default-color="#ffffff"/>
					</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="panel panel-primary panel-default content-panel">
		<div class="panel-body">
			<table class="form-table">
				<tr>
					<th scope="row" ><?php _e('Link Color', WEBLIZAR_ACL)?></th>
					<td></td>
				</tr>
				<tr  style="border-bottom:none;">
					<td id="td-link-font-color">
						<input id="link-color" name="link-color" type="text" value="<?php echo $link_color; ?>" class="my-color-field" data-default-color="#ffffff" />
					</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="panel panel-primary panel-default content-panel">
		<div class="panel-body">
			<table class="form-table">
				<tr>
					<th scope="row" ><?php _e('Button Color', WEBLIZAR_ACL)?></th>
					<td></td>
				</tr>
				<tr  style="border-bottom:none;">
					<td id="td-button-font-color">
						<input id="button-color" name="button-color" type="text" value="<?php echo $button_color; ?>" class="my-color-field" data-default-color="#ffffff" />
					</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="panel panel-primary panel-default content-panel">
		<div class="panel-body">
			<table class="form-table">
				<tr>
					<th scope="row" ><?php _e('Headline Font size', WEBLIZAR_ACL)?></th>
					<td></td>
				</tr>
				<tr  style="border-bottom:none;">
					<td>
						<div id="button-size-slider" class="size-slider" style="width: 25%;display:inline-block"></div>
						<input type="text" class="slider-text" id="headline-size-text-box" name="headline-size-text-box"  readonly="readonly">
						<span class="slider-text-span">Px</span>
					</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="panel panel-primary panel-default content-panel">
		<div class="panel-body">
			<table class="form-table">
				<tr>
					<th scope="row" ><?php _e('Input Font Size', WEBLIZAR_ACL)?></th>
					<td></td>
				</tr>
				<tr  style="border-bottom:none;">
					<td>
						<div id="button-size-slider2" class="size-slider" style="width: 25%;display:inline-block"></div>
						<input type="text" class="slider-text" id="input-size-text-box" name="input-size-text-box"  readonly="readonly">
						<span class="slider-text-span">Px</span>
					</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="panel panel-primary panel-default content-panel">
		<div class="panel-body">
			<table class="form-table">
				<tr>
					<th scope="row" ><?php _e('Link Font Size', WEBLIZAR_ACL)?></th>
					<td></td>
				</tr>
				<tr  style="border-bottom:none;">
					<td>
						<div id="button-size-slider3" class="size-slider" style="width: 25%;display:inline-block"></div>
						<input type="text" class="slider-text" id="link-size-text-box" name="link-size-text-box"  readonly="readonly">
						<span class="slider-text-span">Px</span>
					</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="panel panel-primary panel-default content-panel">
		<div class="panel-body">
			<table class="form-table">
				<tr>
					<th scope="row" ><?php _e('Button Font Size', WEBLIZAR_ACL)?></th>
					<td></td>
				</tr>
				<tr  style="border-bottom:none;">
					<td>
						<div id="button-size-slider7" class="size-slider" style="width: 25%;display:inline-block"></div>
						<input type="text" class="slider-text" id="button-size-text-box" name="button-size-text-box"  readonly="readonly">
						<span class="slider-text-span">Px</span>
					</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="panel panel-primary panel-default content-panel">
		<div class="panel-body">
			<table class="form-table">
				<tr>
					<th scope="row" ><?php _e('Enable Link shadow?', WEBLIZAR_ACL)?></th>
					<td></td>
				</tr>
				<tr class="radio-span" style="border-bottom:none;">
					<td>
						<span>
							<input type="radio" name="enable_Link_shadow" value="yes" id="enable_Link_shadow1" <?php if($enable_link_shadow=="yes")echo "checked"; ?> />&nbsp;<?php _e('Yes', WEBLIZAR_ACL)?><br>
						</span>
						<span>
							<input type="radio" name="enable_Link_shadow" value="no" id="enable_Link_shadow2" <?php if($enable_link_shadow=="no")echo "checked"; ?> />&nbsp;<?php _e('No', WEBLIZAR_ACL)?><br>
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
					<th scope="row" ><?php _e('Link Shadow Color', WEBLIZAR_ACL)?></th>
					<td></td>
				</tr>
				<tr  style="border-bottom:none;">
					<td>
						<input id="link-shadow-color" name="link-shadow-color" type="text" value="<?php echo $link_shadow_color; ?>" class="my-color-field" data-default-color="#ffffff"/>
					</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="panel panel-primary panel-default content-panel">
		<div class="panel-body">
			<table class="form-table">
				<tr>
					<th scope="row" ><?php _e('Headline Font Style', WEBLIZAR_ACL)?></th>
					<td></td>
				</tr>
				<?php $RPP_Font_Style=""; ?>
				<tr class="" style="border-bottom:none;">
					<td>
						<select id="headline_font_style" class="standard-dropdown" name="headline_font_style">
							<optgroup label="Default Fonts">
								<option value="Arial" <?php selected($RPP_Font_Style, 'Arial' ); ?>>Arial</option>
								<option value="Arial Black" <?php selected($RPP_Font_Style, 'Arial Black' ); ?>>Arial Black</option>
								<option value="Courier New" <?php selected($RPP_Font_Style, 'Courier New' ); ?>>Courier New</option>
								<option value="Georgia" <?php selected($RPP_Font_Style, 'Georgia' ); ?>>Georgia</option>
								<option value="Grande" <?php selected($RPP_Font_Style, 'Grande' ); ?>>Grande</option>
								<option value="Helvetica Neue" <?php selected($RPP_Font_Style, 'Helvetica Neue' ); ?>>Helvetica Neue</option>
								<option value="Impact" <?php selected($RPP_Font_Style, 'Impact' ); ?>>Impact</option>
								<option value="Lucida" <?php selected($RPP_Font_Style, 'Lucida' ); ?>>Lucida</option>
								<option value="Lucida Grande" <?php selected($RPP_Font_Style, 'Lucida Grande' ); ?>>Lucida Grande</option>
								<option value="OpenSansBold" <?php selected($RPP_Font_Style, 'OpenSansBold' ); ?>>OpenSansBold</option>
								<option value="Palatino" <?php selected($RPP_Font_Style, 'Palatino' ); ?>>Palatino</option>
								<option value="Sans" <?php selected($RPP_Font_Style, 'Sans' ); ?>>Sans</option>
								<option value="Sans-Serif" <?php selected($RPP_Font_Style, 'Sans-Serif' ); ?>>Sans-Serif</option>
								<option value="Tahoma" <?php selected($RPP_Font_Style, 'Tahoma' ); ?>>Tahoma</option>
								<option value="Times New Roman"<?php selected($RPP_Font_Style, 'Times New Roman' ); ?>>Times New Roman</option>
								<option value="Trebuchet" <?php selected($RPP_Font_Style, 'Trebuchet' ); ?>>Trebuchet</option>
								<option value="Verdana" <?php selected($RPP_Font_Style, 'Verdana' ); ?>>Verdana</option>
							</optgroup>
							<optgroup label="Google Fonts">
								<?php
								    // fetch the Google font list
								    $google_api_url = 'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyDVBuDznbRvMf7ckomKRcsbgHuJ1Elf0LI';
								   $response_font_api = wp_remote_retrieve_body( wp_remote_get($google_api_url, array('sslverify' => false )));
								   if(!is_wp_error( $response_font_api ) ) {
								        $fonts_list = json_decode($response_font_api,  true);
								        // that's it
								        if(is_array($fonts_list)) {
								        	if(isset($fonts_list['items'])){
								        		$g_fonts = $fonts_list['items'];
								            	//print_r($fonts_list);
								            	foreach( $g_fonts as $g_font) { $font_name = $g_font['family']; ?>
								                	<option value="<?php echo $font_name; ?>" <?php selected($RPP_Font_Style, $font_name ); ?>><?php echo $font_name; ?></option><?php 
								            	}
								        	}
								            
								        } else {
								            echo "<option disabled>Error to fetch Google fonts.</option>";
								            echo "<option disabled>Google font will not available in offline mode.</option>";
								        }
								    } 
								?>
							</optgroup>	
						</select>
					</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="panel panel-primary panel-default content-panel">
		<div class="panel-body">
			<table class="form-table">
				<tr>
					<th scope="row" ><?php _e('Input Font Style', WEBLIZAR_ACL)?></th>
					<td></td>
				</tr>
				<?php $RPP_Font_Style=""; ?>
				<tr class="" style="border-bottom:none;">
					<td>
						<select id="input_font_style" class="standard-dropdown" name="input_font_style"  >
							<optgroup label="Default Fonts">
								<option value="Arial" <?php selected($RPP_Font_Style, 'Arial' ); ?>>Arial</option>
								<option value="Arial Black" <?php selected($RPP_Font_Style, 'Arial Black' ); ?>>Arial Black</option>
								<option value="Courier New" <?php selected($RPP_Font_Style, 'Courier New' ); ?>>Courier New</option>
								<option value="Georgia" <?php selected($RPP_Font_Style, 'Georgia' ); ?>>Georgia</option>
								<option value="Grande" <?php selected($RPP_Font_Style, 'Grande' ); ?>>Grande</option>
								<option value="Helvetica Neue" <?php selected($RPP_Font_Style, 'Helvetica Neue' ); ?>>Helvetica Neue</option>
								<option value="Impact" <?php selected($RPP_Font_Style, 'Impact' ); ?>>Impact</option>
								<option value="Lucida" <?php selected($RPP_Font_Style, 'Lucida' ); ?>>Lucida</option>
								<option value="Lucida Grande" <?php selected($RPP_Font_Style, 'Lucida Grande' ); ?>>Lucida Grande</option>
								<option value="OpenSansBold" <?php selected($RPP_Font_Style, 'OpenSansBold' ); ?>>OpenSansBold</option>
								<option value="Palatino" <?php selected($RPP_Font_Style, 'Palatino' ); ?>>Palatino</option>
								<option value="Sans" <?php selected($RPP_Font_Style, 'Sans' ); ?>>Sans</option>
								<option value="Sans-Serif" <?php selected($RPP_Font_Style, 'Sans-Serif' ); ?>>Sans-Serif</option>
								<option value="Tahoma" <?php selected($RPP_Font_Style, 'Tahoma' ); ?>>Tahoma</option>
								<option value="Times New Roman"<?php selected($RPP_Font_Style, 'Times New Roman' ); ?>>Times New Roman</option>
								<option value="Trebuchet" <?php selected($RPP_Font_Style, 'Trebuchet' ); ?>>Trebuchet</option>
								<option value="Verdana" <?php selected($RPP_Font_Style, 'Verdana' ); ?>>Verdana</option>
							</optgroup>
							<optgroup label="Google Fonts">
								<?php
		                            // fetch the Google font list
		                            $google_api_url = 'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyDVBuDznbRvMf7ckomKRcsbgHuJ1Elf0LI';
		                           $response_font_api = wp_remote_retrieve_body( wp_remote_get($google_api_url, array('sslverify' => false )));
		                           if(!is_wp_error( $response_font_api ) ) {
		                                $fonts_list = json_decode($response_font_api,  true);
		                                // that's it
		                                if(is_array($fonts_list)) {
		                                	if(isset($fonts_list['items'])){
				                                    $g_fonts = $fonts_list['items'];
				                                    foreach( $g_fonts as $g_font) { $font_name = $g_font['family']; ?>
				                                        <option value="<?php echo $font_name; ?>" <?php selected($RPP_Font_Style, $font_name ); ?>><?php echo $font_name; ?></option><?php 
				                                    }
			                                	} 
			                            	} else {
			                                    echo "<option disabled>Error to fetch Google fonts.</option>";
			                                    echo "<option disabled>Google font will not available in offline mode.</option>";
			                                }
		                            } 
		                        ?>
							</optgroup>	
						</select>
					</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="panel panel-primary panel-default content-panel">
		<div class="panel-body">
			<table class="form-table">
				<tr>
					<th scope="row" ><?php _e('Link Font Style', WEBLIZAR_ACL)?></th>
					<td></td>
				</tr>
				<?php $RPP_Font_Style=""; ?>
				<tr class="" style="border-bottom:none;">
					<td>
						<select id="link_font_style" class="standard-dropdown" name="link_font_style">	
							<optgroup label="Default Fonts">
								<option value="Arial" <?php selected($RPP_Font_Style, 'Arial' ); ?>>Arial</option>
								<option value="Arial Black" <?php selected($RPP_Font_Style, 'Arial Black' ); ?>>Arial Black</option>
								<option value="Courier New" <?php selected($RPP_Font_Style, 'Courier New' ); ?>>Courier New</option>
								<option value="Georgia" <?php selected($RPP_Font_Style, 'Georgia' ); ?>>Georgia</option>
								<option value="Grande" <?php selected($RPP_Font_Style, 'Grande' ); ?>>Grande</option>
								<option value="Helvetica Neue" <?php selected($RPP_Font_Style, 'Helvetica Neue' ); ?>>Helvetica Neue</option>
								<option value="Impact" <?php selected($RPP_Font_Style, 'Impact' ); ?>>Impact</option>
								<option value="Lucida" <?php selected($RPP_Font_Style, 'Lucida' ); ?>>Lucida</option>
								<option value="Lucida Grande" <?php selected($RPP_Font_Style, 'Lucida Grande' ); ?>>Lucida Grande</option>
								<option value="OpenSansBold" <?php selected($RPP_Font_Style, 'OpenSansBold' ); ?>>OpenSansBold</option>
								<option value="Palatino" <?php selected($RPP_Font_Style, 'Palatino' ); ?>>Palatino</option>
								<option value="Sans" <?php selected($RPP_Font_Style, 'Sans' ); ?>>Sans</option>
								<option value="Sans-Serif" <?php selected($RPP_Font_Style, 'Sans-Serif' ); ?>>Sans-Serif</option>
								<option value="Tahoma" <?php selected($RPP_Font_Style, 'Tahoma' ); ?>>Tahoma</option>
								<option value="Times New Roman"<?php selected($RPP_Font_Style, 'Times New Roman' ); ?>>Times New Roman</option>
								<option value="Trebuchet" <?php selected($RPP_Font_Style, 'Trebuchet' ); ?>>Trebuchet</option>
								<option value="Verdana" <?php selected($RPP_Font_Style, 'Verdana' ); ?>>Verdana</option>
							</optgroup>
							<optgroup label="Google Fonts">
								<?php
		                            // fetch the Google font list
		                            $google_api_url = 'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyDVBuDznbRvMf7ckomKRcsbgHuJ1Elf0LI';
		                           $response_font_api = wp_remote_retrieve_body( wp_remote_get($google_api_url, array('sslverify' => false )));
		                           if(!is_wp_error( $response_font_api ) ) {
		                                $fonts_list = json_decode($response_font_api,  true);
		                                // that's it
		                                if(is_array($fonts_list)) {
		                                	if(isset($fonts_list['items'])){
			                                    $g_fonts = $fonts_list['items'];
			                                    foreach( $g_fonts as $g_font) { $font_name = $g_font['family']; ?>
			                                        <option value="<?php echo $font_name; ?>" <?php selected($RPP_Font_Style, $font_name ); ?>><?php echo $font_name; ?></option><?php 
			                                    }
			                                } 
		                                } else {
		                                    echo "<option disabled>Error to fetch Google fonts.</option>";
		                                    echo "<option disabled>Google font will not available in offline mode.</option>";
		                                }
		                            } 
		                        ?>
							</optgroup>	
						</select>
					</td>
				</tr>
			</table>
		</div>
	</div>
	
	
	<div class="panel panel-primary panel-default content-panel">
		<div class="panel-body">
			<table class="form-table">
				<tr>
					<th scope="row" ><?php _e('Button Font Style', WEBLIZAR_ACL)?></th>
					<td></td>
				</tr>
				<?php $RPP_Font_Style=""; ?>
				<tr class="" style="border-bottom:none;">
					<td>
						<select id="button_font_style" class="standard-dropdown" name="button_font_style"  >
							<optgroup label="Default Fonts">
								<option value="Arial" <?php selected($RPP_Font_Style, 'Arial' ); ?>>Arial</option>
								<option value="Arial Black" <?php selected($RPP_Font_Style, 'Arial Black' ); ?>>Arial Black</option>
								<option value="Courier New" <?php selected($RPP_Font_Style, 'Courier New' ); ?>>Courier New</option>
								<option value="Georgia" <?php selected($RPP_Font_Style, 'Georgia' ); ?>>Georgia</option>
								<option value="Grande" <?php selected($RPP_Font_Style, 'Grande' ); ?>>Grande</option>
								<option value="Helvetica Neue" <?php selected($RPP_Font_Style, 'Helvetica Neue' ); ?>>Helvetica Neue</option>
								<option value="Impact" <?php selected($RPP_Font_Style, 'Impact' ); ?>>Impact</option>
								<option value="Lucida" <?php selected($RPP_Font_Style, 'Lucida' ); ?>>Lucida</option>
								<option value="Lucida Grande" <?php selected($RPP_Font_Style, 'Lucida Grande' ); ?>>Lucida Grande</option>
								<option value="OpenSansBold" <?php selected($RPP_Font_Style, 'OpenSansBold' ); ?>>OpenSansBold</option>
								<option value="Palatino" <?php selected($RPP_Font_Style, 'Palatino' ); ?>>Palatino</option>
								<option value="Sans" <?php selected($RPP_Font_Style, 'Sans' ); ?>>Sans</option>
								<option value="Sans-Serif" <?php selected($RPP_Font_Style, 'Sans-Serif' ); ?>>Sans-Serif</option>
								<option value="Tahoma" <?php selected($RPP_Font_Style, 'Tahoma' ); ?>>Tahoma</option>
								<option value="Times New Roman"<?php selected($RPP_Font_Style, 'Times New Roman' ); ?>>Times New Roman</option>
								<option value="Trebuchet" <?php selected($RPP_Font_Style, 'Trebuchet' ); ?>>Trebuchet</option>
								<option value="Verdana" <?php selected($RPP_Font_Style, 'Verdana' ); ?>>Verdana</option>
							</optgroup>
							<optgroup label="Google Fonts">
								<?php
		                            // fetch the Google font list
		                            $google_api_url = 'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyDVBuDznbRvMf7ckomKRcsbgHuJ1Elf0LI';
		                           $response_font_api = wp_remote_retrieve_body( wp_remote_get($google_api_url, array('sslverify' => false )));
		                           if(!is_wp_error( $response_font_api ) ) {
		                                $fonts_list = json_decode($response_font_api,  true);
		                                // that's it
		                                if(is_array($fonts_list)) {
		                                	if(isset($fonts_list['items'])){
			                                    $g_fonts = $fonts_list['items'];
			                                    foreach( $g_fonts as $g_font) { $font_name = $g_font['family']; ?>
			                                        <option value="<?php echo $font_name; ?>" <?php selected($RPP_Font_Style, $font_name ); ?>><?php echo $font_name; ?></option><?php 
			                                    }
			                                } 
		                                } else {
		                                    echo "<option disabled>Error to fetch Google fonts.</option>";
		                                    echo "<option disabled>Google font will not available in offline mode.</option>";
		                                }
		                            } 
		                        ?>
							</optgroup>	
						</select>
					</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="panel panel-primary panel-default content-panel">
		<div class="panel-body">
			<table class="form-table">
				<tr>
					<th scope="row" ><?php _e('Enable Input Box Icon?', WEBLIZAR_ACL)?></th>
					<td></td>
				</tr>
				<tr class="radio-span" style="border-bottom:none;">
					<td>
						<span>
							<input type="radio" name="enable_inputbox_icon" value="yes" id="enable_inputbox_icon1" <?php if($enable_inputbox_icon=="yes")echo "checked"; ?> />&nbsp;<?php _e('Yes', WEBLIZAR_ACL)?><br>
						</span>
						<span>	
							<input type="radio" name="enable_inputbox_icon" value="no" id="enable_inputbox_icon2" <?php if($enable_inputbox_icon=="no")echo "checked"; ?> />&nbsp;<?php _e('No', WEBLIZAR_ACL)?><br>
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
					<th scope="row" ><?php _e('Icon For user Input Box', WEBLIZAR_ACL)?></th>
					<td></td>
				</tr>
				<tr class="" style="border-bottom:none;">
					<td>
						<!-- Modal -->
						<div class="col-md-9">
						<div class="input-group">
							<input data-placement="bottomRight" class="form-control icp icp-auto" type="text" id="user-input-icon" name="user-input-icon" value="<?php echo $user_input_icon; ?>"/>
							<span class="input-group-addon"></span>
						</div>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="panel panel-primary panel-default content-panel">
		<div class="panel-body">
			<table class="form-table">
				<tr>
					<th scope="row" ><?php _e('Icon For Password Input Box', WEBLIZAR_ACL)?></th>
					<td></td>
				</tr>
				<tr class="" style="border-bottom:none;">
					<td>
						<!-- Modal -->
						<div class="col-md-9">
						<div class="input-group">
							<input data-placement="bottomRight" class="form-control icp icp-auto" type="text" id="password-input-icon" name="password-input-icon" value="<?php echo $password_input_icon; ?>"/>
							<span class="input-group-addon"></span>
						</div>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>

	<button data-dialog3="somedialog3" class="dialog-button3" style="display:none">Open Dialog</button>
	<div id="somedialog3" class="dialog" style="position: fixed; z-index: 9999;">
		<div class="dialog__overlay"></div>
		<div class="dialog__content">
			<div class="morph-shape" data-morph-open="M33,0h41c0,0,0,9.871,0,29.871C74,49.871,74,60,74,60H32.666h-0.125H6c0,0,0-10,0-30S6,0,6,0H33" data-morph-close="M33,0h41c0,0-5,9.871-5,29.871C69,49.871,74,60,74,60H32.666h-0.125H6c0,0-5-10-5-30S6,0,6,0H33">
				<svg xmlns="" width="100%" height="100%" viewBox="0 0 80 60" preserveAspectRatio="none">
					<path d="M33,0h41c0,0-5,9.871-5,29.871C69,49.871,74,60,74,60H32.666h-0.125H6c0,0-5-10-5-30S6,0,6,0H33"></path>
				</svg>
			</div>
			<div class="dialog-inner">
				<h2><strong><?php _e('Text and Color', WEBLIZAR_ACL); ?></strong> <?php _e('Setting Save Successfully', WEBLIZAR_ACL)?></h2><div><button class="action dialog-button-close" data-dialog-close id="dialog-close-button3"><?php _e('Close', WEBLIZAR_ACL)?></button></div>
			</div>
		</div>
	</div>

	<button data-dialog9="somedialog9" class="dialog-button9" style="display:none">Open Dialog</button>
	<div id="somedialog9" class="dialog" style="position: fixed; z-index: 9999;">
		<div class="dialog__overlay"></div>
		<div class="dialog__content">
			<div class="morph-shape" data-morph-open="M33,0h41c0,0,0,9.871,0,29.871C74,49.871,74,60,74,60H32.666h-0.125H6c0,0,0-10,0-30S6,0,6,0H33" data-morph-close="M33,0h41c0,0-5,9.871-5,29.871C69,49.871,74,60,74,60H32.666h-0.125H6c0,0-5-10-5-30S6,0,6,0H33">
				<svg xmlns="" width="100%" height="100%" viewBox="0 0 80 60" preserveAspectRatio="none">
					<path d="M33,0h41c0,0-5,9.871-5,29.871C69,49.871,74,60,74,60H32.666h-0.125H6c0,0-5-10-5-30S6,0,6,0H33"></path>
				</svg>
			</div>
			<div class="dialog-inner">
				<h2><strong><?php _e('Text and Color', WEBLIZAR_ACL)?></strong> <?php _e('Setting Reset Successfully', WEBLIZAR_ACL)?></h2><div><button class="action dialog-button-close" data-dialog-close id="dialog-close-button9"><?php _e('Close', WEBLIZAR_ACL)?></button></div>
			</div>
		</div>
	</div>
	
	<div class="panel panel-primary save-button-block" >
		<div class="panel-body">
			<div class="pull-left">
				<button type="button" onclick="return Custom_login_text('textandcolorSave', '');" class="btn btn-info btn-lg"><?php _e('Save Changes', WEBLIZAR_ACL)?></button>
			</div>
			<div class="pull-right">
				<button type="button" onclick="return Custom_login_text('textandcolorReset', '');" class="btn btn-primary btn-lg"><?php _e('Reset Default', WEBLIZAR_ACL)?></button>
			</div>
		</div>
	</div>
</div>
<!-- /row -->
<script>
function Custom_login_text(Action, id){
	if(Action == "textandcolorSave") {
		(function() {
			var dlgtrigger = document.querySelector( '[data-dialog3]' ),
				somedialog = document.getElementById( dlgtrigger.getAttribute( 'data-dialog3' ) ),
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

		var heading_font_color = jQuery("#headline-font-color").val();
		var input_font_color = jQuery("#input-font-color").val();
		var link_color = jQuery("#link-color").val();
		var button_color = jQuery("#button-color").val();
		
		var heading_font_size = jQuery("#headline-size-text-box").val();
		var input_font_size = jQuery("#input-size-text-box").val();
		var link_size = jQuery("#link-size-text-box").val();
		var button_font_size = jQuery("#button-size-text-box").val();
		
		if (document.getElementById('enable_Link_shadow1').checked) {
			var enable_link_shadow = document.getElementById('enable_Link_shadow1').value;
		} else {
			var enable_link_shadow = document.getElementById('enable_Link_shadow2').value;
		}
		var link_shadow_color = jQuery("#link-shadow-color").val();
		
		var heading_font_style = jQuery( "#headline_font_style option:selected" ).val();
		var input_font_style = jQuery( "#input_font_style option:selected" ).val();
		var link_font_style = jQuery( "#link_font_style option:selected" ).val();
		var button_font_style = jQuery( "#button_font_style option:selected" ).val();
		
		if (document.getElementById('enable_inputbox_icon1').checked) {
			var enable_inputbox_icon = document.getElementById('enable_inputbox_icon1').value;
		} else {
			var enable_inputbox_icon = document.getElementById('enable_inputbox_icon2').value;
		}
		var user_input_icon = jQuery("#user-input-icon").val();
		var password_input_icon = jQuery("#password-input-icon").val();
		var PostData = "Action=" + Action + "&heading_font_color=" + heading_font_color + "&input_font_color=" + input_font_color + "&link_color=" + link_color + "&button_color=" + button_color  + "&heading_font_size=" + heading_font_size + "&input_font_size=" + input_font_size + "&link_size=" + link_size + "&button_font_size=" + button_font_size + "&enable_link_shadow=" + enable_link_shadow + "&link_shadow_color=" + link_shadow_color + "&heading_font_style=" + heading_font_style + "&input_font_style=" + input_font_style + "&link_font_style=" + link_font_style + "&button_font_style=" + button_font_style + "&enable_inputbox_icon=" + enable_inputbox_icon + "&user_input_icon=" + user_input_icon + "&password_input_icon=" + password_input_icon;
		jQuery.ajax({
			dataType : 'html',
			type: 'POST',
			url : location.href,
			cache: false,
			data : PostData,
			complete : function() {  },
			success: function(data) {
				// Save message box open
				jQuery(".dialog-button3").click();
				// Function to close message box
				setTimeout(function(){
					jQuery("#dialog-close-button3").click();
				}, 1000);
			}
		});
	}
	// Save Message box Close On Mouse Hover
	document.getElementById('dialog-close-button3').disabled = false;
	jQuery('#dialog-close-button3').hover(function () {
		jQuery("#dialog-close-button3").click();
		document.getElementById('dialog-close-button3').disabled = true; 
	});
	 
	// Reset Message box Close On Mouse Hover
	document.getElementById('dialog-close-button9').disabled = false;
	jQuery('#dialog-close-button9').hover(function () {
		jQuery("#dialog-close-button9").click();
		document.getElementById('dialog-close-button9').disabled = true; 
	});
	 
	if(Action == "textandcolorReset") {		
		(function() {
			var dlgtrigger = document.querySelector( '[data-dialog9]' ),
				somedialog = document.getElementById( dlgtrigger.getAttribute( 'data-dialog9' ) ),
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
				});
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
				//Headline Font Style
				jQuery("#headline_font_style").val('Arial');
				//Input Font Style
				jQuery("#input_font_style").val('Arial');
				//Link Font Style 
				jQuery("#link_font_style").val('Arial');	
				//Button Font Style 
				jQuery("#button_font_style").val('Arial');
				//	Heading Font Color
				jQuery("#td-headline-font-color a.wp-color-result").closest("a").css({"background-color": "#ffffff"});
				//	Input Font Color
				jQuery("#td-input-font-color a.wp-color-result").closest("a").css({"background-color": "#000000"});
				//Link Font Color
				jQuery("#td-link-font-color a.wp-color-result").closest("a").css({"background-color": "#ffffff"});
				//	Button Font Color
				jQuery("#td-button-font-color a.wp-color-result").closest("a").css({"background-color": "#dd3333"});

				jQuery( "#button-size-slider" ).slider("value",14 );
				jQuery( "#headline-size-text-box" ).val( jQuery( "#button-size-slider" ).slider( "value") );
				
				jQuery( "#button-size-slider2" ).slider("value",18 );
				jQuery( "#input-size-text-box" ).val( jQuery( "#button-size-slider2" ).slider( "value") );
				
				jQuery( "#button-size-slider3" ).slider("value",14 );
				jQuery( "#link-size-text-box" ).val( jQuery( "#button-size-slider3" ).slider( "value") );
				
				jQuery( "#button-size-slider7" ).slider("value",14 );
				jQuery( "#button-size-text-box" ).val( jQuery( "#button-size-slider7" ).slider( "value") );
				
				document.getElementById("user-input-icon").value ='fa-user';
				document.getElementById("password-input-icon").value ='fa-key';
				// Reset message box open
				jQuery(".dialog-button9").click();
				// Function to close message box
				setTimeout(function(){
					jQuery("#dialog-close-button9").click();
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
	if($Action == "textandcolorSave"){
		$heading_font_color = sanitize_option('heading_font_color', $_POST['heading_font_color']);
		$input_font_color = sanitize_option('input_font_color', $_POST['input_font_color']);
		$link_color = sanitize_option('link_color', $_POST['link_color']);
		$button_color = sanitize_option('button_color', $_POST['button_color']);
		$heading_font_size = sanitize_option('heading_font_size', $_POST['heading_font_size']);
		$input_font_size = sanitize_option('input_font_size', $_POST['input_font_size']);
		$link_size = sanitize_option('link_size', $_POST['link_size']);
		$button_font_size = sanitize_option('button_font_size', $_POST['button_font_size']);
		$enable_link_shadow = sanitize_option('enable_link_shadow', $_POST['enable_link_shadow']);
		$link_shadow_color = sanitize_option('link_shadow_color', $_POST['link_shadow_color']);
		$heading_font_style = sanitize_option('heading_font_style', $_POST['heading_font_style']);
		$input_font_style = sanitize_option('input_font_style', $_POST['input_font_style']);
		$link_font_style = sanitize_option('link_font_style', $_POST['link_font_style']);
		$button_font_style = sanitize_option('button_font_style', $_POST['button_font_style']);
		$enable_inputbox_icon = sanitize_option('enable_inputbox_icon', $_POST['enable_inputbox_icon']);
		$user_input_icon = sanitize_option('user_input_icon', $_POST['user_input_icon']);
		$password_input_icon = sanitize_option('password_input_icon', $_POST['password_input_icon']);

		
		// Save Values in Option Table
		$text_and_color_page= serialize(array(
			'heading_font_color'=>$heading_font_color,
			'input_font_color'=>$input_font_color,
			'link_color'=>$link_color,
			'button_color'=>$button_color,
			'heading_font_size'=>$heading_font_size,
			'input_font_size'=>$input_font_size,
			'link_size'=>$link_size,
			'button_font_size'=>$button_font_size,
			'enable_link_shadow'=>$enable_link_shadow,
			'link_shadow_color'=>$link_shadow_color,
			'heading_font_style'=>$heading_font_style,
			'input_font_style'=>$input_font_style,
			'link_font_style'=>$link_font_style,
			'button_font_style'=>$button_font_style,
			'enable_inputbox_icon'=>$enable_inputbox_icon,
			'user_input_icon'=>$user_input_icon,
			'password_input_icon'=>$password_input_icon
		));
		update_option('Admin_custome_login_text', $text_and_color_page);
	}

	if($Action == "textandcolorReset") {
		$text_and_color_page= serialize(array(
			'heading_font_color'=>'#ffffff',
			'input_font_color'=>'#000000',
			'link_color'=>'#ffffff',
			'button_color'=>'#dd3333',
			'heading_font_size'=>'14',
			'input_font_size'=>'18',
			'link_size'=>'14',
			'button_font_size'=>'14',
			'enable_link_shadow'=>'yes',
			'link_shadow_color'=>'#ffffff',
			'heading_font_style'=>'Open Sans',
			'input_font_style'=>'Open Sans',
			'link_font_style'=>'Open Sans',
			'button_font_style'=>'Open Sans',
			'enable_inputbox_icon'=>'yes',
			'user_input_icon'=>'fa-user',
			'password_input_icon'=>'fa-key'
		));
		update_option('Admin_custome_login_text', $text_and_color_page);
	}
}
?>