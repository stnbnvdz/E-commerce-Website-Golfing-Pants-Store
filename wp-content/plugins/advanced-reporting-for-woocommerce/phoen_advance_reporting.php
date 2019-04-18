<?php
/**
* Plugin Name: Advanced Reporting For Woocommerces
* Plugin URI: https://www.phoeniixx.com/product/advanced-reporting-for-woocommerce/
* Description: WooCommerce Advance Reporting System is a plugin which shows you a complete report of Total Summary, Recent Orders, Top Billing Country, State, Top Product Sellers, Coupons, Top Payment Gateway, Order Status, Shipping, and Tax.
* Version:2.5
* Author: phoeniixx
* Text Domain: advanced-reporting-for-woocommerce
* Author URI: http://www.phoeniixx.com/
* WC requires at least: 2.6.0
* WC tested up to: 3.5.2
*/

	add_action('admin_init', 'phoen_advance_reporting_admin_init');
	
	include(dirname(__FILE__).'/libs/execute-libs.php');

	function phoen_advance_reporting_admin_init()
	{
		
		wp_enqueue_style( 'style-advanced-reportings', plugin_dir_url(__FILE__).'assets/css/phoen-arfw-bootstrap-iso.css' );

	} 
	
	function pmsc_repoting_activate() {

			$phoen_reporting_enable_settings = get_option('phoen_reportings_enable');
			
			if($phoen_reporting_enable_settings == ''){
				
				update_option('phoen_reportings_enable',1);
				
			}
		}
		
		register_activation_hook( __FILE__, 'pmsc_repoting_activate' );
	


	add_action('admin_menu', 'phoe_advance_reporting_menu');
	
	function phoe_advance_reporting_menu() {
	   
		add_menu_page('advanced_reporting_for_woocommerce', 'Reporting' ,'manage_options','advanced_reporting_for_woocommerce',NULL, plugin_dir_url( __FILE__ ).'assets/images/aaa2.png');
		add_submenu_page( 'advanced_reporting_for_woocommerce', 'phoen_settings', 'Reports','manage_options', 'advanced_reporting_for_woocommerce', 'phoe_advance_reporting');
		add_submenu_page( 'advanced_reporting_for_woocommerce', 'phoen_settings', 'Settings','manage_options', 'phoen_report_setting', 'phoen_reportin_settings');
		
	}
		
		function phoe_advance_reporting()
		{
		
			$phoen_reporting_enable_settings = get_option('phoen_reportings_enable');
		
			if(isset($phoen_reporting_enable_settings) && $phoen_reporting_enable_settings == 1)
			{
			
			
				include_once(plugin_dir_path(__FILE__).'includes/phoe_reporting.php');
			}
			
		}
		
		
		function phoen_reportin_settings()
		{
			?>
			<h2> <?php _e('General Settings','advanced-reporting-for-woocommerce'); ?></h2>
			
			
			
			<div id="profile-page" class="wrap">
    
				<?php
					
				if(isset($_GET['tab']))
						
				{
					$tab = sanitize_text_field( $_GET['tab'] );
					
				}
				
				else
					
				{
					
					$tab="";
					
				}
				
				?>
				
				<?php $tab = (isset($_GET['tab']))?$_GET['tab']:'';?>
				
				<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">
				
					<a class="nav-tab <?php if($tab == 'phoen_report_settings' || $tab == ''){ echo esc_html( "nav-tab-active" ); } ?>" href="?page=phoen_report_setting&amp;tab=phoen_report_settings"><?php _e('Settings ','advanced-reporting-for-woocommerce'); ?></a>
					
					<a class="nav-tab <?php if($tab == 'phoen_report_report_pro'){ echo esc_html( "nav-tab-active" ); } ?>" href="?page=phoen_report_setting&amp;tab=phoen_report_report_pro"><?php _e('Premium','advanced-reporting-for-woocommerce'); ?></a>
					
				</h2>
				
			</div>
			
			<?php
			if($tab=='phoen_report_settings'|| $tab == '' )
			{
				
				include_once(plugin_dir_path(__FILE__).'includes/phoen_reporting_settings.php');
										
			}
			
			if($tab=='phoen_report_report_pro' )
			{
				
				include_once(plugin_dir_path(__FILE__).'includes/phoen_report_pro.php');
				
			}
			
			
			
		}
		
		
?>
