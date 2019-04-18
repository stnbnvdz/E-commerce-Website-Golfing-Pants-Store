<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
class WPC_Shipment_History_Map{
	function __construct(){
		add_action( 'admin_enqueue_scripts', array( $this,'admin_scripts' ) );
		add_action( 'admin_footer', array( $this, 'gmap_library') );

		//** Settings
		add_action( 'admin_menu', array($this, 'admin_menu') );
		add_action( 'admin_init', array($this, 'plugin_init') );
		add_action( 'wpc_add_settings_nav', array( $this, 'settings_navigation' ) );
	}
	function admin_menu(){
		add_submenu_page(
			'wpcargo-settings',
			wpcargo_map_settings_label(),
			wpcargo_map_settings_label(),
			'manage_options',
			'admin.php?page=wpc-shmap-settings'
		);
		add_submenu_page(
			NULL,
			wpcargo_map_settings_label(),
			wpcargo_map_settings_label(),
			'manage_options',
			'wpc-shmap-settings',
			array( $this, 'map_settings_callback' )
		);
	}
	function plugin_init(){
		register_setting( 'wpc_shmap_option_group', 'shmap_api' );
		register_setting( 'wpc_shmap_option_group', 'shmap_active' );
		register_setting( 'wpc_shmap_option_group', 'shmap_type' );
		register_setting( 'wpc_shmap_option_group', 'shmap_zoom' );
		register_setting( 'wpc_shmap_option_group', 'shmap_result' );
		register_setting( 'wpc_shmap_option_group', 'shmap_label_color' );
		register_setting( 'wpc_shmap_option_group', 'shmap_label_size' );
		register_setting( 'wpc_shmap_option_group', 'shmap_marker' );
	}
	function settings_navigation(){
		$view = $_GET['page'];
		?>
		<a class="nav-tab <?php echo ( $view == 'wpc-shmap-settings') ? 'nav-tab-active' : '' ;  ?>" href="<?php echo admin_url().'admin.php?page=wpc-shmap-settings'; ?>" ><?php echo wpcargo_map_settings_label(); ?></a>
		<?php
	}
	function map_settings_callback(){
		$shmap_api 		= get_option('shmap_api');
		$shmap_active 	= get_option('shmap_active');
		$shmap_type 	= get_option('shmap_type');
		$shmap_zoom 	= get_option('shmap_zoom');
		$shmap_result 	= get_option('shmap_result');
		$shmap_label_color 	= get_option('shmap_label_color');
		$shmap_label_size 	= get_option('shmap_label_size');
		$shmap_marker 	= get_option('shmap_marker');
		?>
		<div class="wrap">
        	<h1><?php echo wpcargo_map_settings_label(); ?></h1>
            <?php require_once( WPCARGO_PLUGIN_PATH.'admin/templates/admin-navigation.tpl.php' ); ?>
			<div class="postbox">
				<div class="inside">
					<?php require_once( WPCARGO_PLUGIN_PATH.'admin/templates/history-map-settings.tpl.php' ); ?>
				</div>
			</div>
		</div>
        <?php
	}
	function admin_scripts(){
		$screen 		= get_current_screen();
		$shmap_active 	= get_option('shmap_active');
		if( $screen->post_type == 'wpcargo_shipment' && $screen->base == 'post' && $shmap_active ){
			wp_enqueue_style( 'wpc-shmap-styles', WPCARGO_PLUGIN_URL.'admin/assets/css/shmap-style.css', array(), WPCARGO_VERSION, true );
		}
	}
	function gmap_library(){
		global $post, $wpcargo;
		$screen 		= get_current_screen();
		$shmap_api 		= get_option('shmap_api');
		$shmap_active 	= get_option('shmap_active');
		$shmap_type 	= get_option('shmap_type') ? get_option('shmap_type') : 'terrain' ;
		$shmap_zoom 	= get_option('shmap_zoom') ? get_option('shmap_zoom') : 15 ;
		$shipmentID 	= !empty( $post ) ? $post->ID : 0 ;
		$maplabels 			= apply_filters('wpcargo_map_labels', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890' );
		//if( $screen->post_type == 'wpcargo_shipment' && $screen->base == 'post' && $shmap_active ){
		if( $screen->post_type == 'wpcargo_shipment' && $shmap_active && !empty( $shmap_api ) ){
			$history 		= $wpcargo->history( $shipmentID );
			$history_location = array();
			if( !empty( $history  ) ){
				foreach ( $history as $value ) {
					if( empty( $value['location'] ) ){
						continue;
					}
					$history_location[] = $value['location'];
				}
			}
			$addressLocations 	= $history_location;
			$shipment_origin 	= array_shift( $history_location );
			$shipment_destination 	= array_pop( $history_location );
			?>
			<script>
				jQuery('.row-actions').on('click', '.editinline', function($){
					setTimeout(function(){
						getPlace_dynamic();
					}, 500);
				});
				/*
				** Google map Script Auto Complete address
				*/
				var placeSearch, autocomplete, map, geocoder;
				var componentForm = {
					street_number: 'short_name',
					route: 'long_name',
					locality: 'long_name',
					administrative_area_level_1: 'short_name',
					country: 'long_name',
					postal_code: 'short_name'
				};
				var labels = '<?php echo $maplabels; ?>';
      			var labelIndex = 0;

				function wpcSHinitMap() {

					geocoder = new google.maps.Geocoder();

					getPlace_dynamic();

					<?php if( $screen->base == 'post' ): ?>

				        var map = new google.maps.Map( document.getElementById('wpc-shmap'), {
				          zoom: <?php echo $shmap_zoom; ?>,
				          center: {lat: 41.85, lng: -87.65},
				          mapTypeId: '<?php echo $shmap_type; ?>',
				        });

				        /* 	Map script
						** 	Initialize Shipment Locations
						*/
						var shipmentAddress = <?php echo json_encode( $addressLocations ); ?>;
						var shipmentData 	= <?php echo json_encode( $history ); ?>;

						var flightPlanCoordinates = [];

						for (var i = 0; i < shipmentAddress.length; i++ ) {
							codeAddress( geocoder, map, shipmentAddress[i], flightPlanCoordinates, i, shipmentData );
						}

				        var demoformat = [
				          {lat: 10.2976348, lng: 123.89349070000003},
				          {lat: 3.139003, lng: 101.68685499999992},
				          {lat: 14.5995124, lng: 120.9842195}
				        ];

				        //console.log( flightPlanCoordinates );

				        var flightPath = new google.maps.Polyline({
				          path: flightPlanCoordinates,
				          geodesic: true,
				          strokeColor: '#FF0000',
				          strokeOpacity: 1.0,
				          strokeWeight: 2
				        });

				        flightPath.setMap(map);
				    <?php endif; ?>
				}

				function getPlace_dynamic() {
					 var defaultBounds = new google.maps.LatLngBounds(
						 new google.maps.LatLng(-33.8902, 151.1759),
						 new google.maps.LatLng(-33.8474, 151.2631)
					 );

					 var input = document.getElementsByClassName('status_location');
					 var options = {
					     bounds: defaultBounds,
					     types: ['geocode']
					 };
					 for (i = 0; i < input.length; i++) {
					     autocomplete = new google.maps.places.Autocomplete(input[i], options);
					 }
				}

				function codeAddress( geocoder, map, address, flightPlanCoordinates, index, shipmentData ) {
					var wpclabelColor 	= '<?php echo ( get_option('shmap_label_color') ) ? get_option('shmap_label_color') : '#fff' ;  ?>';
      				var wpclabelSize 	= '<?php echo ( get_option('shmap_label_size') ) ? get_option('shmap_label_size').'px' : '18px' ;  ?>';
      				var wpcMapMarker 	= '<?php echo ( get_option('shmap_marker') ) ? get_option('shmap_marker') : WPCARGO_PLUGIN_URL.'/admin/assets/images/wpcmarker.png' ;  ?>';
					geocoder.geocode({'address': address}, function(results, status) {
						if (status === 'OK') {

							var geolatlng = { lat: results[0].geometry.location.lat(),  lng: results[0].geometry.location.lng() };

							flightPlanCoordinates[index] = geolatlng;

							map.setCenter(results[0].geometry.location);
							var marker = new google.maps.Marker({
								map: map,
								label: {text: labels[index % labels.length], color: wpclabelColor, fontSize: wpclabelSize },
								position: results[0].geometry.location,
								icon: wpcMapMarker
							});

							/*
					        ** Marker Information window
					        */
							// shipmentData
							var sAddressDate = shipmentData[index].date;
							var sAddresstime = shipmentData[index].time;
							var sAddresslocation = shipmentData[index].location;
							var sAddressstatus = shipmentData[index].status;

							var shipemtnInfo = '<strong><?php _e('Date', 'wpcargo'); ?>:</strong> '+sAddressDate+' '+sAddresstime+'</br>'+
											   '<strong><?php _e('Location', 'wpcargo'); ?>:</strong> '+sAddresslocation+'</br>'+
											   '<strong><?php _e('Status', 'wpcargo'); ?>:</strong> '+sAddressstatus;

							var infowindow = new google.maps.InfoWindow({
					          content: shipemtnInfo
					        });
							marker.addListener('click', function() {
					          infowindow.open(map, marker);
					        });
						} else {
							alert('Geocode was not successful for the following reason: ' + status);
						}
					});
				}
		    </script>
			<?php
		}
		if( $screen->post_type == 'wpcargo_shipment' && $shmap_active && !empty( $shmap_api ) && !( isset( $_GET['page'] ) && $_GET['page'] == 'wpcargo-print-layout' )  ){
			?><script async defer src="https://maps.googleapis.com/maps/api/js?libraries=geometry,places&key=<?php echo $shmap_api; ?>&callback=wpcSHinitMap&libraries=places"></script><?php
		}
	}
}
new WPC_Shipment_History_Map;