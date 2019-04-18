<?php
if (!defined('ABSPATH')){
	exit; // Exit if accessed directly
}
class WPC_MP_Results{
	public function __construct() {
		add_action('wpcargo_after_track_details', array($this, 'wpc_mp_results_hook'));
	}
	public function wpc_mp_results_hook($shipment_detail) {
		$wpc_mp_settings = get_option('wpc_mp_settings');
		if(!empty($wpc_mp_settings['wpc_mp_enable_frontend'])) {
			require_once( WPCARGO_PLUGIN_PATH.'templates/wpc-mp-result-hook.tpl.php' );
		}
	}
}
$wpc_mp_results =  new WPC_MP_Results;
