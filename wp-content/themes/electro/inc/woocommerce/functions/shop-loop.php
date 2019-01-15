<?php
/**
 * Functions used in shop loop
 */
if ( ! function_exists( 'electro_wrap_add_to_cart_link' ) ) {
	function electro_wrap_add_to_cart_link( $add_to_cart_link, $product ) {
		$tooltip = apply_filters( 'ec_add_to_cart_tooltip', $product->add_to_cart_text(), $product );
		return sprintf( '<div class="add-to-cart-wrap" data-toggle="tooltip" data-title="%s">%s</div>', 
			esc_attr( $tooltip ),
			$add_to_cart_link
		);
	}
}

