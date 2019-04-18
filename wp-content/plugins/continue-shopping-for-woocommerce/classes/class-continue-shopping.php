<?php
add_filter( 'woocommerce_continue_shopping_redirect', 'wc_custom_redirect_continue_shopping' );

function wc_custom_redirect_continue_shopping() {
	$cat_referer = get_transient( 'recent_cat' );
	$continue_destination = get_option( 'hpy_cs_destination' );
	$custom_link = get_option( 'hpy_cs_custom_link' );
	$siteurl = get_site_url();

	//Begin the switch to check which option has been selected in the admin area.
	switch( $continue_destination ) {

		case "home" :
			$returnlink = $siteurl;
			break;

		case "shop" :
			$shop_id = get_option( 'woocommerce_shop_page_id' );
			$returnlink = get_permalink( $shop_id );
			break;

		case "recent_prod" :

			if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
				if( strpos( $_SERVER['HTTP_REFERER'], '/cart/' ) == 0 ) {
					$referer = $_SERVER['HTTP_REFERER'];
				}
			}

			if ( isset( $referer ) ) {
				$returnlink = $referer;
			} else {
				$shop_id = get_option( 'woocommerce_shop_page_id' );
				$returnlink = get_permalink( $shop_id );
			}
			break;

		case "recent_cat" :
			//Start a session and update a session variable on each Category load (This will only be used if the back to recent category option is selected.
			if ( isset( $_SERVER["HTTP_REFERER"] ) ) {
				$referringURL = $_SERVER[ "HTTP_REFERER" ];
			} else {
				$referringURL = '';
			}

			if ( strpos( $referringURL, 'basket' ) == false && strpos( $referringURL, '/product/' ) == false ) {
				$returnlink = $referringURL;
			} else if ( !empty( $cat_referer ) ) {
				$returnlink = $cat_referer;
			} else {
				$shop_id = get_option( 'woocommerce_shop_page_id' );
				$returnlink = get_permalink( $shop_id );
			}
			break;

		case "custom" :
			if ( isset( $custom_link ) ) {
				$returnlink = $custom_link;
			} else {
				$shop_id = get_option( 'woocommerce_shop_page_id' );
				$returnlink = get_permalink( $shop_id );
			}
			break;

		default :
			$returnlink = $siteurl;
			break;
	}

	//return the link we grabbed above.
	return $returnlink;
}

add_action( 'woocommerce_before_single_product', 'hpy_cs_single_prod_load' );
function hpy_cs_single_prod_load() {

	//Start a session and update a session variable on each Category load (This will only be used if the back to recent category option is selected.
	if ( isset( $_SERVER["HTTP_REFERER"] ) ) {
		$referringURL = $_SERVER[ "HTTP_REFERER" ];
	} else {
		$referringURL = '';
	}

	if ( strpos( $referringURL, 'basket' ) == false && strpos( $referringURL, '/product/' ) == false ) {
		HPY_CS_Admin::hpy_save_recent_category( $referringURL );
	} else {
		return;
	}

}

add_action( 'woocommerce_cart_is_empty', 'hpy_cs_output_notice', 1 );
function hpy_cs_output_notice() {

	$display_empty = get_option( 'hpy_cs_empty_cart_notice' );

	if ( $display_empty == 'yes' ) {
		$link = wc_custom_redirect_continue_shopping();

		$message = sprintf('<a href="%s" class="button wc-forward">%s</a> %s', esc_url($link), esc_html__('Continue shopping', 'woocommerce'), esc_html(get_option('hpy_cs_empty_cart_text', __('Your cart is empty.', '	$message = sprintf( \'<a href="%s" class="button wc-forward">%s</a> %s\', esc_url( $link ), esc_html__( \'Continue shopping\', \'woocommerce\' ), esc_html( get_option( \'hpy_cs_empty_cart_text\', __( \'Your cart is empty.\', \'hpy_cshpy_cshpy_cs\' ) ) ) );
'))));

		wc_print_notice($message);
	}

}

//Function used to check for/add a trailing slash. Used mainly for getting the permalink.
function fixpath($p) {
	$p=str_replace('\\','/',trim($p));
	return (substr($p,-1)!='/') ? $p.='/' : $p;
}