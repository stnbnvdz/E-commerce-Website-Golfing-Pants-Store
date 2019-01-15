<?php
/**
 * Template functions hooked into the `homepage` action in the homepage template
 */

if ( ! function_exists( 'electro_revslider' ) ) {
	/**
	 *
	 */
	function electro_revslider( $slider_name = '' ) {

		if ( ! empty( $slider_name ) && function_exists( 'putRevSlider' ) ) {
			putRevSlider( $slider_name );
		}
	}
}

if ( ! function_exists( 'electro_ads_block' ) ) {
	/**
	 *
	 */
	function electro_ads_block( $args = array() ) { 
		$cols = count( $args );?>
		<div class="da-block columns-<?php echo esc_attr( $cols ); ?>">
		<?php foreach( $args as $arg ) : ?>
			<div class="da">
				<div class="da-inner">
					<a class="da-media" href="<?php echo esc_url( $arg['action_link'] ); ?>">
						<?php if ( ! empty( $arg['ad_image'] ) ) : ?>
						<div class="da-media-left"><img src="<?php echo esc_url( $arg['ad_image'] ); ?>" alt="" /></div>
						<?php endif; ?>
						<div class="da-media-body">
							<div class="da-text">
								<?php echo wp_kses_post( $arg['ad_text'] ); ?>
							</div>
							<div class="da-action">
								<?php echo wp_kses_post( $arg['action_text'] ); ?>
							</div>
						</div>
					</a>
				</div>
			</div>
		<?php endforeach; ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'electro_ads_with_banners' ) ) {
	/**
	 *
	 */
	function electro_ads_with_banners( $args = array() ) {
		$defaults = apply_filters( 'electro_ads_with_banners_args', array(
			'section_class'		=> '',
			'animation'			=> '',
			'ads_banners'		=> array(
				array(
					'title'					=> '',
					'description'			=> '',
					'price'					=> '',
					'image'					=> '',
					'banner_image'			=> '',
					'is_align_end'  		=> false,
					'action_link'   		=> '#',
					'banner_action_link'	=> '#',
				),
				array(
					'title'					=> '',
					'description'			=> '',
					'price'					=> '',
					'image'					=> '',
					'banner_image'			=> '',
					'is_align_end'  		=> true,
					'action_link'   		=> '#',
					'banner_action_link'	=> '#',
				)
			)
		) );
		$args = wp_parse_args( $args, $defaults );
		electro_get_template( 'homepage/ads-with-banners-block.php', $args );
	}
}

if ( ! function_exists( 'electro_products_carousel' ) ) {
	/**
	 * Products Carousel
	 */
	function electro_products_carousel( $section_args, $carousel_args ) {

		global $electro_version;

		$default_section_args 	= apply_filters( 'electro_products_carousel_section_args', array(
			'products_html'		=> '',
			'section_title'		=> '',
			'carousel_id'		=> 'products-carousel-' . uniqid(),
			'section_class'		=> 'section-products-carousel',
			'show_custom_nav'	=> true,
			'animation'			=> ''
		) );

		$default_carousel_args 	= apply_filters( 'electro_products_carousel_args', array(
			'items'				=> 4,
			'nav'				=> false,
			'slideSpeed'		=> 300,
			'dots'				=> true,
			'rtl'				=> is_rtl() ? true : false,
			'paginationSpeed'	=> 400,
			'navText'			=> array( '', '' ),
			'margin'			=> 0,
			'touchDrag'			=> true,
			'responsive'		=> array(
				'0'		=> array( 'items'	=> 2 ),
				'480'	=> array( 'items'	=> 2 ),
				'768'	=> array( 'items'	=> 3 ),
				'992'	=> array( 'items'	=> 3 ),
				'1200'	=> array( 'items'	=> 4 ),
			)
		) );

		$section_args 	= wp_parse_args( $section_args, $default_section_args );
		$carousel_args 	= wp_parse_args( $carousel_args, $default_carousel_args );

		extract( $section_args );

		if ( ! empty( $animation ) ) {
			$section_class .= ' animate-in-view animation';
		}

		if ( ! empty( $products_html ) ) :

			wp_enqueue_script( 'owl-carousel-js', 	get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array( 'jquery' ), $electro_version, true );
		?>
			<section class="<?php echo esc_attr( $section_class ); ?>" <?php if ( ! empty( $animation ) ) : ?>data-animation="<?php echo esc_attr( $animation ); ?>"<?php endif; ?>>

				<?php if ( ! empty( $section_title ) ) : ?>

				<header>

					<h2 class="h1"><?php echo wp_kses_post( $section_title ); ?></h2>

				<?php if ( $show_custom_nav ) : ?>
					<div class="owl-nav">
						<?php if ( is_rtl() ) : ?>
						<a href="#products-carousel-prev" data-target="#<?php echo esc_attr( $carousel_id ); ?>" class="slider-prev"><i class="fa fa-angle-right"></i></a>
						<a href="#products-carousel-next" data-target="#<?php echo esc_attr( $carousel_id ); ?>" class="slider-next"><i class="fa fa-angle-left"></i></a>
						<?php else : ?>
						<a href="#products-carousel-prev" data-target="#<?php echo esc_attr( $carousel_id ); ?>" class="slider-prev"><i class="fa fa-angle-left"></i></a>
						<a href="#products-carousel-next" data-target="#<?php echo esc_attr( $carousel_id ); ?>" class="slider-next"><i class="fa fa-angle-right"></i></a>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				</header>

				<?php endif; ?>

				<div id="<?php echo esc_attr( $carousel_id );?>" data-ride="owl-carousel" data-replace-active-class="true" data-carousel-selector=".products-carousel" data-carousel-options="<?php echo esc_attr( json_encode( $carousel_args ) ); ?>">
				<?php
					$search 		= array( '<ul', '<li', '</li>', '</ul>', 'class="products' );
					$replace 		= array( '<div', '<div', '</div>', '</div>', 'class="products owl-carousel products-carousel' );
					$products_html 	= str_replace( $search, $replace, $products_html );
					echo apply_filters( 'electro_products_carousel_html', $products_html );
				?>
				</div>
			</section>
		<?php

		endif;
	}
}

if ( ! function_exists( 'electro_products_carousel_tabs' ) ) {
	/**
	 * Displays Products Carousel Tabs in home
	 *
	 * @return void
	 */
	function electro_products_carousel_tabs( $args ) {

		if ( is_woocommerce_activated() ) {

			$defaults = apply_filters( 'electro_products_carousel_tabs_args', array(
				'tabs' 			=> array(
					array(
						'id'			=> 'featured-products',
						'title'			=> esc_html__( 'Featured', 'electro' ),
						'shortcode_tag'	=> 'featured_products',
					),
					array(
						'id'			=> 'sale-products',
						'title'			=> esc_html__( 'On Sale', 'electro' ),
						'shortcode_tag'	=> 'sale_products',
					),
					array(
						'id'			=> 'top-rated-products',
						'title'			=> esc_html__( 'Top Rated', 'electro' ),
						'shortcode_tag'	=> 'top_rated_products'
					)
				),
				'limit'			=> 4,
				'columns'		=> 3,
				'carousel_args' => array(
					'items'			=> 3,
					'responsive'	=> array(
						'0'		=> array( 'items'	=> 2 ),
						'576'	=> array( 'items'	=> 3 ),
						'768'	=> array( 'items'	=> 3 ),
						'992'	=> array( 'items'	=> 3 ),
						'1200'	=> array( 'items'	=> 3 )
					)
				)
			) );

			$args = wp_parse_args( $args, $defaults );

			electro_get_template( 'homepage/products-carousel-tabs.php', $args );
		}
	}
}

if ( ! function_exists( 'electro_deal_and_tabs_block' ) ) {
	/**
	 * Displays a deal and product tabs
	 *
	 * @return void
	 */
	function electro_deal_and_tabs_block( $args ) {

		if ( is_woocommerce_activated() ) {

			$defaults = array(
				'section_args' 			=> array( 'section_class' => '' ),
				'deal_products_args' 	=> '',
				'product_tabs_args'		=> '',
			);

			$args = wp_parse_args( $args, $defaults );

			extract( $args );

			$section_class 	= empty ( $section_args['section_class'] ) ? 'deals-and-tabs' : $section_args['section_class'] . ' deals-and-tabs';
			$animation 		= isset( $args['section_args']['animation'] ) ? $args['section_args']['animation'] : '';

			if ( !empty( $animation ) ) {
				$section_class .= ' animate-in-view';
			}

			$deals_is_enabled		= isset ( $deal_products_args['is_enabled'] ) ? $deal_products_args['is_enabled'] : 'no';
			$deals_section_class 	= $deals_is_enabled !== 'yes' ? 'deals-block' : 'deals-block';
			$tabs_section_class 	= $deals_is_enabled !== 'yes' ? 'tabs-block tabs-block-stretch' : 'tabs-block';

			?>
			<div class="<?php echo esc_attr( $section_class ); ?>" <?php if ( ! empty( $animation ) ) : ?>data-animation="<?php echo esc_attr( $animation );?>"<?php endif; ?>>
				<?php if( $deals_is_enabled === 'yes' ) : ?>
				<div class="<?php echo esc_attr( $deals_section_class ); ?>">
					<?php electro_onsale_product( $deal_products_args ); ?>
				</div>
				<?php endif; ?>
				<div class="<?php echo esc_attr( $tabs_section_class ); ?>">
					<?php electro_products_tabs( $product_tabs_args ); ?>
				</div>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'electro_onsale_product' ) ) {
	/**
	 * Displays an onsale product in home
	 *
	 * @return void
	 */
	function electro_onsale_product( $args = array() ) {

		if ( is_woocommerce_activated() ) {

			$defaults 	= array(
				'section_title'	=> wp_kses_post( __( '<span class="highlight">Special</span> Offer', 'electro' ) ),
				'section_class'	=> '',
				'show_savings'	=> true,
				'savings_in'	=> 'amount',
				'savings_text'	=> esc_html__( 'Save', 'electro' ),
			);

			if ( isset( $args['product_choice'] ) ) {
				switch( $args['product_choice'] ) {
					case 'random':
						$args['orderby'] = 'rand';
					break;
					case 'recent':
						$args['orderby'] 	= 'date';
						$args['order'] 		= 'DESC';
					break;
					case 'specific':
						$args['orderby'] 	= 'post__in';
						$args['ids'] 		= $args['product_id'];
						$args['post__in'] 	= array_map( 'trim', explode( ',', $args['product_id'] ) );
					break;
				}
			}

			$args 		= wp_parse_args( array( 'per_page'	=> 1 ), $args );
			$args 		= wp_parse_args( $args, $defaults );
			$products 	= Electro_Products::sale_products( $args );

			extract( $args );

			if ( $products->have_posts() ) {

				while ( $products->have_posts() ) : $products->the_post();
			?>
			<section class="section-onsale-product <?php echo esc_attr( $section_class ); ?>">

				<?php if ( ! empty ( $section_title ) || $show_savings ) : ?>

				<header>

					<?php if ( ! empty ( $section_title ) ) : ?>

					<h2 class="h1"><?php echo wp_kses_post( $section_title ); ?></h2>

					<?php endif ; ?>

					<?php if ( $show_savings ) : ?>

					<div class="savings">
						<span class="savings-text">
						<?php
							global $product;
							echo sprintf( '%s %s', $savings_text, Electro_WC_Helper::get_savings_on_sale( $product, $savings_in ) );
						?>
						</span>
					</div>

					<?php endif; ?>

				</header>

				<?php endif; ?>
				<div class="onsale-products">
					<?php wc_get_template_part( 'templates/contents/content', 'onsale-product' ); ?>
				</div>

			</section>

			<?php

				endwhile;

				woocommerce_reset_loop();
				wp_reset_postdata();
			}
		}
	}
}

if ( ! function_exists( 'electro_onsale_product_v2' ) ) {
	/**
	 * Displays an onsale product in slider
	 *
	 * @return void
	 */
	function electro_onsale_product_v2( $args = array() ) {

		if ( is_woocommerce_activated() ) {

			$defaults 	= array(
				'section_class'	=> '',
				'product_id'	=> ''
			);

			$args = wp_parse_args( $args, $defaults );

			extract( $args );
			
			if( ! empty( $product_id ) ) {
				$shortcode_atts = array(
					'orderby'	=> 'post__in',
					'ids'		=> $product_id,
					'post__in'	=> array_map( 'trim', explode( ',', $product_id ) ),
				);
			} else {
				$shortcode_atts = array(
					'orderby'	=> 'rand'
				);
			}

			$shortcode_atts 	= wp_parse_args( array( 'per_page'	=> 1 ), $shortcode_atts );
			$products			= Electro_Products::sale_products( $shortcode_atts );

			if ( $products->have_posts() ) {

				while ( $products->have_posts() ) : $products->the_post();
					?>
					<section class="section-onsale-product-v2 <?php echo esc_attr( $section_class ); ?>">
						<div class="onsale-product">
							<?php wc_get_template_part( 'templates/contents/content', 'onsale-product-carousel-v2' ); ?>
						</div>
					</section>
					<?php
				endwhile;

				woocommerce_reset_loop();
				wp_reset_postdata();
			}
		}
	}
}

if ( ! function_exists( 'electro_onsale_product_carousel' ) ) {
	/**
	 * Displays an onsale products carousel in home
	 *
	 * @return void
	 */
	function electro_onsale_product_carousel( $section_args = array(), $carousel_args = array() ) {

		if ( is_woocommerce_activated() ) {

			$default_section_args 	= array(
				'section_title'		=> esc_html__( 'Deals of the week', 'electro' ),
				'section_class'		=> '',
				'show_savings'		=> true,
				'savings_in'		=> 'amount',
				'savings_text'		=> esc_html__( 'Save', 'electro' ),
				'limit'				=> 4,
				'show_custom_nav'	=> true,
				'product_ids'		=> '',
				'animation'			=> '',
				'show_progress'		=> true,
				'show_timer'		=> true,
				'show_cart_btn'		=> false
			);

			$default_carousel_args 	= array(
				'items'				=> 1,
				'nav'				=> false,
				'slideSpeed'		=> 300,
				'dots'				=> true,
				'rtl'				=> is_rtl() ? true : false,
				'paginationSpeed'	=> 400,
				'navText'			=> array( '', '' ),
				'margin'			=> 0,
				'touchDrag'			=> true
			);

			$section_args 		= wp_parse_args( $section_args, $default_section_args );
			$carousel_args 		= wp_parse_args( $carousel_args, $default_carousel_args );

			$args = array( 'per_page' => $section_args['limit'] );

			if ( isset( $section_args['product_choice'] ) ) {
				switch( $section_args['product_choice'] ) {
					case 'random':
						$args['orderby'] 	= 'rand';
					break;
					case 'recent':
						$args['orderby'] 	= 'date';
						$args['order'] 		= 'DESC';
					break;
					case 'specific':
						$args['orderby'] 	= 'post__in';
						$args['ids'] 		= $section_args['product_ids'];
						$args['post__in'] 	= array_map( 'trim', explode( ',', $section_args['product_ids'] ) );
					break;
				}
			}

			$products 	= Electro_Products::sale_products( $args );

			extract( $section_args );

			$section_class .= ' section-onsale-product-carousel';

			if ( ! empty ( $animation ) ) {
				$section_class .= ' animate-in-view';
			}

			if( ! $show_progress ) {
				$section_class .= ' hide-progress';
			}

			if( ! $show_timer ) {
				$section_class .= ' hide-timer';
			}

			if( ! $show_cart_btn ) {
				$section_class .= ' hide-cart-button';
			}

			$show_custom_nav = isset( $products->post_count ) && ( $products->post_count <= 1 ) ? false : $show_custom_nav;

			if ( $products->have_posts() ) {
				global $electro_version;
				$carousel_id = 'onsale-products-carousel-' . uniqid();
				wp_enqueue_script( 'owl-carousel-js', 	get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array( 'jquery' ), $electro_version, true );

				?>
				<section class="<?php echo esc_attr( $section_class ); ?>" <?php if ( ! empty( $animation ) ) : ?>data-animation="<?php echo esc_attr( $animation );?>"<?php endif; ?>>

					<?php if ( ! empty ( $section_title ) ) : ?>
						<header>
							<h2 class="h1"><?php echo wp_kses_post( $section_title ); ?></h2>
						</header>
					<?php endif ; ?>
					<?php if ( $show_custom_nav ) : ?>
						<div class="owl-nav">
							<?php if ( is_rtl() ) : ?>
							<a href="#onsale-products-carousel-prev" data-target="#<?php echo esc_attr( $carousel_id ); ?>" class="slider-prev"><i class="fa fa-angle-right"></i><?php echo esc_html( $carousel_args['navText'][0] ); ?></a>
							<a href="#onsale-products-carousel-next" data-target="#<?php echo esc_attr( $carousel_id ); ?>" class="slider-next"><?php echo esc_html( $carousel_args['navText'][1] ); ?><i class="fa fa-angle-left"></i></a>
							<?php else : ?>
							<a href="#onsale-products-carousel-prev" data-target="#<?php echo esc_attr( $carousel_id ); ?>" class="slider-prev"><i class="fa fa-angle-left"></i><?php echo esc_html( $carousel_args['navText'][0] ); ?></a>
							<a href="#onsale-products-carousel-next" data-target="#<?php echo esc_attr( $carousel_id ); ?>" class="slider-next"><?php echo esc_html( $carousel_args['navText'][1] ); ?><i class="fa fa-angle-right"></i></a>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<div id="<?php echo esc_attr( $carousel_id ); ?>">
					<div class="onsale-product-carousel owl-carousel">
					<?php while ( $products->have_posts() ) : $products->the_post(); ?>
						<?php global $product; ?>
						<div class="onsale-product">
							<div class="onsale-product-thumbnails">

								<?php if ( $show_savings ) : ?>

								<div class="savings">
									<span class="savings-text">
									<?php echo sprintf( '%s %s', $savings_text, Electro_WC_Helper::get_savings_on_sale( $product, $savings_in ) ); ?>
									</span>
								</div>

								<?php endif; ?>

								<?php electro_show_wc_product_images(); ?>

							</div>
							<?php wc_get_template_part( 'templates/contents/content', 'onsale-product-carousel' ); ?>
						</div>
					<?php endwhile; ?>
					</div>
					</div>
					<script type="text/javascript">
						jQuery(document).ready( function($){
							$( '#<?php echo esc_attr( $carousel_id ); ?> .owl-carousel').owlCarousel( <?php echo json_encode( $carousel_args );?> );
						} );
					</script>
				</section>
				<?php
			}

			woocommerce_reset_loop();
			wp_reset_postdata();
		}
	}
}

if ( ! function_exists( 'electro_onsale_product_carousel_v5' ) ) {
	/**
	 * Displays an onsale products carousel in home v5
	 *
	 * @return void
	 */
	function electro_onsale_product_carousel_v5( $section_args = array(), $carousel_args = array() ) {

		if ( is_woocommerce_activated() ) {

			$default_section_args 	= array(
				'section_title'		=> esc_html__( 'Deals of the week', 'electro' ),
				'section_class'		=> '',
				'limit'				=> 4,
				'show_custom_nav'	=> true,
				'product_ids'		=> '',
				'animation'			=> '',
				'show_progress'		=> true,
				'show_timer'		=> true,
				'show_cart_btn'		=> false
			);

			$default_carousel_args 	= array(
				'items'				=> 1,
				'nav'				=> false,
				'slideSpeed'		=> 300,
				'dots'				=> true,
				'rtl'				=> is_rtl() ? true : false,
				'paginationSpeed'	=> 400,
				'navText'			=> array( '', '' ),
				'margin'			=> 0,
				'touchDrag'			=> true
			);

			$style_attr = '';
			if ( ! empty( $bg_image[0] ) ) {
				$style_attr = 'background-image: url( ' . esc_url( $bg_image[0] ) . ' ); height: ' . esc_attr( $bg_image[2] ) . 'px;';
			}

			$section_args 		= wp_parse_args( $section_args, $default_section_args );
			$carousel_args 		= wp_parse_args( $carousel_args, $default_carousel_args );

			$args = array( 'per_page' => $section_args['limit'] );

			if ( isset( $section_args['product_choice'] ) ) {
				switch( $section_args['product_choice'] ) {
					case 'random':
						$args['orderby'] 	= 'rand';
					break;
					case 'recent':
						$args['orderby'] 	= 'date';
						$args['order'] 		= 'DESC';
					break;
					case 'specific':
						$args['orderby'] 	= 'post__in';
						$args['ids'] 		= $section_args['product_ids'];
						$args['post__in'] 	= array_map( 'trim', explode( ',', $section_args['product_ids'] ) );
					break;
				}
			}

			$products 	= Electro_Products::sale_products( $args );

			extract( $section_args );

			$section_class .= ' section-onsale-product-carousel-v5';

			if ( ! empty ( $animation ) ) {
				$section_class .= ' animate-in-view';
			}

			if( ! $show_progress ) {
				$section_class .= ' hide-progress';
			}

			if( ! $show_timer ) {
				$section_class .= ' hide-timer';
			}

			if( ! $show_cart_btn ) {
				$section_class .= ' hide-cart-button';
			}


			if ( $products->have_posts() ) {
				global $electro_version;
				$carousel_id = 'onsale-products-carousel-' . uniqid();
				wp_enqueue_script( 'owl-carousel-js', 	get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array( 'jquery' ), $electro_version, true );

				?>
				<section class="<?php echo esc_attr( $section_class ); ?>" <?php if ( ! empty( $animation ) ) : ?>data-animation="<?php echo esc_attr( $animation );?>"<?php endif; ?>>

					<div id="<?php echo esc_attr( $carousel_id ); ?>">
						<div class="onsale-product-carousel owl-carousel">
							<?php while ( $products->have_posts() ) : $products->the_post(); ?>
							<div class="deals-carousel-inner-block"<?php if ( !empty( $style_attr ) ) : ?>style="<?php echo esc_attr( $style_attr );?>"<?php endif; ?>>
								<header>
									<?php if ( ! empty ( $section_title ) ) : ?>
										<h2 class="section-title"><?php echo wp_kses_post( $section_title ); ?></h2>
									<?php endif ; ?>

									<?php if ( ! empty ( $sub_title ) ) : ?>
										<h3 class="sub-title"><?php echo wp_kses_post( $sub_title ); ?></h3>
									<?php endif ; ?>
								</header>

								<?php wc_get_template_part( 'templates/contents/content', 'onsale-product-carousel-v2' ); ?>
							</div>
							<?php endwhile; ?>
						</div>
					</div>
					<script type="text/javascript">
						jQuery(document).ready( function($){
							$( '#<?php echo esc_attr( $carousel_id ); ?> .owl-carousel').owlCarousel( <?php echo json_encode( $carousel_args );?> );
						} );
					</script>
				</section>
				<?php
			}

			woocommerce_reset_loop();
			wp_reset_postdata();
		}
	}
}

if ( ! function_exists( 'electro_deal_products_with_featured' ) ) {
	/**
	 *
	 */
	function electro_deal_products_with_featured( $args ) {

		if ( is_woocommerce_activated() ) {
			$defaults = array(
				'section_title' 		=> '',
				'section_class'			=> '',
				'shortcode_tag'			=> '',
				'shortcode_atts'		=> array(),
				'timer_title'			=> '',
				'header_timer'			=> true,
				'timer_value'			=> '',
				'animation'				=> ''
			);

			$args 	= wp_parse_args( $args, $defaults );

			electro_get_template( 'homepage/deal-products-with-featured.php', $args );
		}
	}
}

if ( ! function_exists( 'electro_products_2_1_2_block' ) ) {
	/**
	 *
	 */
	function electro_products_2_1_2_block( $args ) {

		if ( is_woocommerce_activated() ) {
			$default_cat_count = apply_filters( 'electro_apply_v1', false ) ? 7 : 9;

			$defaults = array(
				'section_title' 	=> '',
				'categories_count'	=> $default_cat_count,
				'categories_slugs'	=> '',
				'category_args'		=> '',
				'products'			=> '',
				'animation'			=> '',
			);

			$args 	= wp_parse_args( $args, $defaults );

			if ( empty( $args['products'] ) ) {
				return;
			}

			$default_product_cat = get_option( 'default_product_cat' );
			$cat_args            = array( 'number' => $args['categories_count'], 'hide_empty' => false, 'exclude' => $default_product_cat );

			if ( !empty( $args['categories_slugs'] ) ) {
				$slugs 					= explode( ',', $args['categories_slugs'] );
				$cat_args['slug'] 		= $slugs;
				$cat_args['hide_empty'] = false;

				$include = array();

				foreach ( $slugs as $slug ) {
					$include[] = "'" . $slug ."'";
				}

				if ( ! empty($include ) ) {
					$cat_args['include'] 	= $include;
					$cat_args['orderby']	= 'include';
				}
			}

			if ( ! empty( $args['category_args'] ) ) {
				$cat_args = wp_parse_args( $args['category_args'], $cat_args );
			}

			$cat_args   = apply_filters( 'electro_products_2_1_2_block_cat_args', $cat_args );
			$categories = get_terms( 'product_cat',  $cat_args );
			electro_get_template( 'homepage/products-2-1-2-block.php', array( 'categories' => $categories, 'products' => $args['products'], 'section_title' => $args['section_title'], 'animation' => $args['animation'] ) );
		}
	}
}

if ( ! function_exists( 'electro_products_6_1_block' ) ) {
	/**
	 *
	 */
	function electro_products_6_1_block( $args ) {

		if ( is_woocommerce_activated() ) {
			$defaults = array(
				'section_title' 	=> '',
				'section_class'		=> '',
				'categories_count'	=> 7,
				'categories_slugs'	=> '',
				'category_args'		=> '',
				'products'			=> '',
				'animation'			=> '',
			);

			$args 	= wp_parse_args( $args, $defaults );

			if ( empty( $args['products'] ) ) {
				return;
			}

			$cat_args  	= array( 'number' => $args['categories_count'], 'hide_empty' => false );

			if ( !empty( $args['categories_slugs'] ) ) {
				$slugs 					= explode( ',', $args['categories_slugs'] );
				$cat_args['slug'] 		= $slugs;
				$cat_args['hide_empty'] = false;

				$include = array();

				foreach ( $slugs as $slug ) {
					$include[] = "'" . $slug ."'";
				}

				if ( ! empty($include ) ) {
					$cat_args['include'] 	= $include;
					$cat_args['orderby']	= 'include';
				}
			}

			if ( ! empty( $args['category_args'] ) ) {
				$cat_args = wp_parse_args( $args['category_args'], $cat_args );
			}

			$categories = get_terms( 'product_cat',  $cat_args );
			electro_get_template( 'homepage/products-6-1-block.php', array( 'categories' => $categories, 'products' => $args['products'], 'section_title' => $args['section_title'], 'section_class' => $args['section_class'], 'animation' => $args['animation'] ) );
		}
	}
}

if ( ! function_exists( 'electro_fullbanner_ad' ) ) {
	function electro_fullbanner_ad( $args ) {

			$defaults = array(
				'img_src'	=> 'http://placehold.it/1170x170',
				'el_class'	=> '',
				'link'		=> '#'
			);

			$args = wp_parse_args( $args, $defaults );

			extract( $args );

			$el_class = empty ( $el_class ) ? 'fullbanner-ad' : $el_class . ' fullbanner-ad';
		?>
		<div class="<?php echo esc_attr( $el_class ); ?>" style="margin-bottom: 39px;">
			<a href="<?php echo esc_url( $link ); ?>" style="display: block;">
				<img src="<?php echo esc_url( $img_src ); ?>" class="img-fluid" alt="">
			</a>
		</div>
		<?php
	}
}

if ( ! function_exists( 'electro_features_list' ) ) {
	/**
	 *
	 */
	function electro_features_list( $features = array(), $columns = 0 ) {

		foreach( $features as $key => $feature ) {
			if ( empty( $feature['text'] ) && empty( $feature['icon'] ) ) {
				unset( $features[ $key ] );
			}
		}

		if ( 0 === $columns ) {
			$columns = count( $features );
		}

		if( ! empty( $features ) ) {
			?>
			<div class="features-list columns-<?php echo esc_attr( $columns ) ; ?>">
				<?php foreach( $features as $feature ) : ?>
				<div class="feature">
					<div class="media">
						<div class="media-left media-middle feature-icon">
							<i class="<?php echo esc_attr( $feature['icon'] ); ?>"></i>
						</div>
						<div class="media-body media-middle feature-text">
							<?php echo wp_kses_post( $feature['text'] ); ?>
						</div>
					</div>
				</div>
				<?php endforeach ; ?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'electro_products_tabs' ) ) {
	/**
	 * Displays Products Tabs in home
	 *
	 * @return void
	 */
	function electro_products_tabs( $args = array() ) {

		if ( is_woocommerce_activated() ) {

			$defaults =  array(
				'tabs' 		=> array(
					array(
						'id'			=> 'featured-products',
						'title'			=> esc_html__( 'Featured', 'electro' ),
						'shortcode_tag'	=> 'featured_products',
					),
					array(
						'id'			=> 'sale-products',
						'title'			=> esc_html__( 'On Sale', 'electro' ),
						'shortcode_tag'	=> 'sale_products',
					),
					array(
						'id'			=> 'top-rated-products',
						'title'			=> esc_html__( 'Top Rated', 'electro' ),
						'shortcode_tag'	=> 'top_rated_products'
					)
				),
				'limit'		=> 6,
				'columns'	=> 3,
				'animation'	=> '',
			);

			$args = apply_filters( 'electro_products_tabs_args', wp_parse_args( $args, $defaults ) );
			electro_get_template( 'homepage/products-tabs.php', $args );
		}
	}
}

if ( ! function_exists( 'electro_product_cards_carousel' ) ) {
	/**
	 * Displays Product cards as carousel
	 */
	function electro_product_cards_carousel( $section_args, $carousel_args ) {

		global $electro_version;

		$default_section_args 	= array(
			'section_title'		=> '',
			'section_class'		=> '',
			'show_nav'			=> true,
			'show_top_text'		=> true,
			'show_categories'	=> true,
			'show_carousel_nav'	=> false,
			'products'			=> '',
			'columns'			=> '',
			'rows'				=> '',
			'total'				=> '',
			'cat_limit'			=> 5,
			'cat_slugs'			=> '',
			'animation'			=> '',
		);

		$default_carousel_args 	= array(
			'items'				=> 1,
			'nav'				=> false,
			'slideSpeed'		=> 300,
			'dots'				=> true,
			'rtl'				=> is_rtl() ? true : false,
			'paginationSpeed'	=> 400,
			'navText'			=> array( '', '' ),
			'margin'			=> 0,
			'touchDrag'			=> true
		);

		$section_args 		= wp_parse_args( $section_args, $default_section_args );
		$carousel_args 		= wp_parse_args( $carousel_args, $default_carousel_args );

		extract( $section_args );

		$columns 			= intval( $columns );
		$rows 				= intval( $rows );

		$cat_args  			= array( 'number' => $cat_limit, 'hide_empty' => false );

		if ( !empty( $cat_slugs ) ) {
			$slugs 				= explode( ',', $cat_slugs );
			$cat_args['slug'] 	= $slugs;

			$include = array();

			foreach ( $slugs as $slug ) {
				$include[] = "'" . $slug ."'";
			}

			if ( ! empty($include ) ) {
				$cat_args['include'] 	= $include;
				$cat_args['orderby']	= 'include';
			}
		}

		if ( ! empty( $section_args['categories_args'] ) ) {
			$cat_args = wp_parse_args( $section_args['categories_args'], $cat_args );
		}

		$categories 		= get_terms( 'product_cat',  $cat_args );
		$products_card_html = '';
		$carousel_id 		= uniqid();

		if ( $products instanceof WP_Query ) {
			$products_card_html = Electro_WC_Helper::product_card_loop( $products, $columns, $rows );
		}

		$section_class = empty( $section_class ) ? 'section-product-cards-carousel' : 'section-product-cards-carousel ' . $section_class;

		if ( ! empty( $animation ) ) {
			$section_class .= ' animate-in-view';
		}

		if ( ! empty( $products_card_html ) ) {

			wp_enqueue_script( 'owl-carousel-js', 	get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array( 'jquery' ), $electro_version, true ); ?>

			<section class="<?php echo esc_attr( $section_class ); ?>" <?php if ( ! empty( $animation ) ) : ?>data-animation="<?php echo esc_attr( $animation ); ?>"<?php endif; ?>>

				<?php if ( ! empty( $section_title ) ) : ?>

				<header <?php if ( $show_nav ) : ?>class="show-nav"<?php endif; ?>>

					<h2 class="h1"><?php echo esc_html( $section_title ); ?></h2>

					<?php if ( $show_nav ) : ?>
					<ul class="nav nav-inline">

						<?php if ( $show_top_text ) : ?>
						<li class="nav-item active">
							<span class="nav-link"><?php echo sprintf( esc_html__( 'Top %s', 'electro' ), $products->post_count ); ?></span>
						</li>
						<?php endif; ?>

						<?php if ( $show_categories && ! empty ( $categories ) && ! is_wp_error( $categories ) ) : ?>
							<?php foreach( $categories as $category ) : ?>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo esc_url( get_term_link( $category ) ); ?>"><?php echo esc_html( $category->name ); ?></a>
							</li>
							<?php endforeach; ?>
						<?php endif; ?>
					</ul>
					<?php elseif ( $show_carousel_nav ) : ?>
					<div class="owl-nav">
						<?php if ( is_rtl() ) : ?>
						<a href="#products-cards-carousel-prev" data-target="#<?php echo esc_attr( $carousel_id ); ?>" class="slider-prev"><i class="fa fa-angle-right"></i></a>
						<a href="#products-cards-carousel-next" data-target="#<?php echo esc_attr( $carousel_id ); ?>" class="slider-next"><i class="fa fa-angle-left"></i></a>
						<?php else : ?>
						<a href="#products-cards-carousel-prev" data-target="#<?php echo esc_attr( $carousel_id ); ?>" class="slider-prev"><i class="fa fa-angle-left"></i></a>
						<a href="#products-cards-carousel-next" data-target="#<?php echo esc_attr( $carousel_id ); ?>" class="slider-next"><i class="fa fa-angle-right"></i></a>
						<?php endif; ?>
					</div>
					<?php endif; ?>
				</header>

				<?php endif; ?>

				<div id="<?php echo esc_attr( $carousel_id );?>" data-ride="owl-carousel" data-carousel-selector=".product-cards-carousel" data-carousel-options="<?php echo esc_attr( json_encode( $carousel_args ) );?>">
					<?php echo $products_card_html; ?>
				</div>

			</section><?php
		}
	}
}

if ( ! function_exists( 'electro_home_list_categories' ) ) {
	/**
	 *
	 */
	function electro_home_list_categories( $args = array() ) {

		$default_args = apply_filters( 'electro_home_list_categories_args', array(
			'section_title'			=> '',
			'section_class'			=> '',
			'category_args'			=> array(
				'orderby'				=> 'name',
				'order'					=> 'ASC',
				'hide_empty'			=> true,
				'number'				=> 6,
				'hierarchical'			=> false,
				'slug'					=> '',
			),
			'child_category_args'	=> array(
				'echo' 					=> false,
				'title_li' 				=> '',
				'show_option_none' 		=> '',
				'number' 				=> 6,
				'depth'					=> 1,
				'hide_empty'			=> false
			)
		) );

		$args = wp_parse_args( $args, $default_args );

		if ( is_woocommerce_activated() ) {
			electro_get_template( 'homepage/home-list-categories.php', $args );
		}
	}
}

if ( ! function_exists( 'electro_product_categories_list' ) ) {
	/**
	 *
	 */
	function electro_product_categories_list( $args = array() ) {

		if ( is_woocommerce_activated() ) {

			$default_args = apply_filters( 'electro_product_categories_list_default_args', array(
				'section_class'			=> '',
				'columns'				=> 4,
				'category_args'			=> array(
					'orderby'				=> 'name',
					'order'					=> 'ASC',
					'hide_empty'			=> true,
					'number'				=> 8,
					'hierarchical'			=> false,
					'slug'					=> '',
				)
			) );

			$args = wp_parse_args( $args, $default_args );

			electro_get_template( 'homepage/product-categories-list.php', $args );
		}
	}
}

if ( ! function_exists( 'electro_product_categories_menu_list' ) ) {
	/**
	 *
	 */
	function electro_product_categories_menu_list( $args = array() ) {

		if ( is_woocommerce_activated() ) {

			$default_args = apply_filters( 'electro_product_categories_menu_list_default_args', array(
				'section_title'	=> '',
				'category_list'	=> array(
					array(
						'title'	=>	'',
						'category_args'	=> array(
							'number'		=> 5,
							'orderby'		=> 'name',
							'order'			=> 'ASC',
							'hide_empty'	=> true
						)
					),
					array(
						'title'	=>	'',
						'category_args'	=> array(
							'number'		=> 5,
							'orderby'		=> 'name',
							'order'			=> 'ASC',
							'hide_empty'	=> true
						)
					),
				),
				'action_text'           => '',
                'action_link'           => '#',
			) );

			$args = wp_parse_args( $args, $default_args );

			electro_get_template( 'homepage/product-categories-menu-list.php', $args );
		}
	}
}

if ( ! function_exists( 'electro_product_categories_list_with_header' ) ) {
	/**
	 *
	 */
	function electro_product_categories_list_with_header( $args = array() ) {

		if ( is_woocommerce_activated() ) {
			
			$default_args = apply_filters( 'electro_product_categories_list_with_header_default_args', array(
				'section_class'			=> '',
				'section_title'			=> '',
				'sub_title'				=> '',
				'bg_image'				=> '',
				'enable_header'			=> false,
				'columns'				=> 4,
				'category_args'			=> array(
					'orderby'				=> 'name',
					'order'					=> 'ASC',
					'hide_empty'			=> true,
					'number'				=> 8,
					'hierarchical'			=> false,
					'slug'					=> '',
				),
				'type'					=> ''
			) );

			$args = wp_parse_args( $args, $default_args );

			electro_get_template( 'homepage/product-categories-list-with-header.php', $args );
		}
	}
}

if ( ! function_exists( 'electro_home_categories_block' ) ) {
	/**
	 *
	 */
	function electro_home_categories_block( $args = array() ) {

		$default_args = apply_filters( 'electro_home_categories_block_args', array(
			'section_title'			=> '',
			'columns'				=> 4,
			'section_class'			=> '',
			'enable_full_width'		=> true,
			'category_args'			=> array(
				'orderby'				=> 'name',
				'order'					=> 'ASC',
				'hide_empty'			=> true,
				'number'				=> 8,
				'hierarchical'			=> false,
				'slug'					=> '',
			)
		) );

		$args = wp_parse_args( $args, $default_args );

		if ( is_woocommerce_activated() ) {
			electro_get_template( 'homepage/home-categories-block.php', $args );
		}
	}
}

if ( ! function_exists( 'electro_get_atts_for_shortcode' ) ) {
	function electro_get_atts_for_shortcode( $args ) {
		$atts = array();

        if ( isset( $args['shortcode'] ) ) {

            if ( 'product_attribute' == $args['shortcode'] && ! empty( $args['attribute'] ) && ! empty( $args['terms'] ) ) {

                $atts['attribute']      = $args['attribute'];
                $atts['terms']          = $args['terms'];
                $atts['terms_operator'] = ! empty( $args['terms_operator'] ) ? $args['terms_operator'] : 'IN';

            } elseif ( 'product_category' == $args['shortcode'] && ! empty( $args['product_category_slug'] ) ) {

                $atts['category']       = $args['product_category_slug'];
                $atts['cat_operator']   = ! empty( $args['cat_operator'] ) ? $args['cat_operator'] : 'IN';

            } elseif ( 'products' == $args['shortcode'] && ! empty( $args['products_ids_skus'] ) ) {

                $ids_or_skus            = ! empty( $args['products_choice'] ) ? $args['products_choice'] : 'ids';
                $atts[$ids_or_skus]     = $args['products_ids_skus'];
                $atts['orderby']        = 'post__in';

            } elseif ( $args['shortcode'] == 'sale_products'  ) {

                $atts['on_sale']        = true;

            } elseif ($args['shortcode'] == 'best_selling_products'  ) {

                $atts['best_selling']   = true;

            } elseif ( $args['shortcode'] == 'featured_products'  ) {

                $atts['visibility']     = 'featured';

            } elseif ( $args['shortcode'] == 'top_rated_products' ) {

                $atts['top_rated']      = true;

            } elseif ( $args['shortcode'] == 'recent_products' ) {

                $atts['visibility']     = 'visible';

            }
        }

        if( isset( $args['shortcode_atts'] ) ) {
            $atts = wp_parse_args( $atts, $args['shortcode_atts'] );
        }

        return $atts;
    }
}

if ( ! function_exists( 'electro_products_carousel_tabs_v5' ) ) {
	/**
	 * Displays Products Carousel Tabs in home
	 *
	 * @return void
	 */
	function electro_products_carousel_tabs_v5( $args ) {

		if ( is_woocommerce_activated() ) {

			$defaults = apply_filters( 'electro_products_carousel_tabs_v5_args', array(
				'section_title'		=> esc_html__( 'Popular Products', 'electro' ),
				'tabs' 			=> array(
					array(
						'id'			=> 'featured-products',
						'title'			=> esc_html__( 'Featured', 'electro' ),
						'shortcode_tag'	=> 'featured_products',
					),
					array(
						'id'			=> 'sale-products',
						'title'			=> esc_html__( 'On Sale', 'electro' ),
						'shortcode_tag'	=> 'sale_products',
					),
					array(
						'id'			=> 'top-rated-products',
						'title'			=> esc_html__( 'Top Rated', 'electro' ),
						'shortcode_tag'	=> 'top_rated_products'
					)
				),
				'limit'			=> 4,
				'columns'		=> 3,
				'carousel_args' => array(
					'items'			=> 3,
					'nav'			=> true,
					'autoplay'		=> false,
					'nav'			=> true,
					'navText'		=> is_rtl() ? array( '<i class="fa fa-angle-right"></i>', '<i class="fa fa-angle-left"></i>' ) : array( '<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>' ),
					'dots'			=> true,
					'responsive'	=> array(
						'0'		=> array( 'items'	=> 2 ),
						'480'	=> array( 'items'	=> 2 ),
						'768'	=> array( 'items'	=> 2 ),
						'992'	=> array( 'items'	=> 3 ),
						'1200'	=> array( 'items'	=> 3 )
					)
				)
			) );

			$args = wp_parse_args( $args, $defaults );

			electro_get_template( 'homepage/products-carousel-tabs-v2.php', $args );
		}
	}
}

if ( ! function_exists( 'electro_products_carousel_v5' ) ) {
	/**
	 * Products Carousel
	 */
	function electro_products_carousel_v5( $section_args, $carousel_args ) {

		global $electro_version;

		$default_section_args 	= apply_filters( 'electro_products_carousel_v5_section_args', array(
			'products_html'		=> '',
			'section_title'		=> '',
			'carousel_id'		=> 'products-carousel-' . uniqid(),
			'section_class'		=> 'section-products-carousel',
			'el_class'			=> '',
			'show_custom_nav'	=> true,
			'animation'			=> ''
		) );

		$default_carousel_args 	= apply_filters( 'electro_products_carousel_v5_args', array(
			'items'				=> 4,
			'nav'				=> true,
			'slideSpeed'		=> 300,
			'dots'				=> true,
			'rtl'				=> is_rtl() ? true : false,
			'paginationSpeed'	=> 400,
			'navText'			=> is_rtl() ? array( '<i class="fa fa-angle-right"></i>', '<i class="fa fa-angle-left"></i>' ) : array( '<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>' ),
			'margin'			=> 0,
			'touchDrag'			=> true,
			'responsive'		=> array(
				'0'		=> array( 'items'	=> 2 ),
				'480'	=> array( 'items'	=> 2 ),
				'768'	=> array( 'items'	=> 2 ),
				'992'	=> array( 'items'	=> 3 ),
				'1200'	=> array( 'items'	=> 4 ),
			)
		) );

		$section_args 	= wp_parse_args( $section_args, $default_section_args );
		$carousel_args 	= wp_parse_args( $carousel_args, $default_carousel_args );

		extract( $section_args );

		if ( ! empty( $animation ) ) {
			$section_class .= ' animate-in-view animation';
		}

		if ( ! empty( $el_class ) ) {
			$section_class .= ' '. $el_class .' ';
		}

		if ( ! empty( $products_html ) ) :

			wp_enqueue_script( 'owl-carousel-js', 	get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array( 'jquery' ), $electro_version, true );
		?>
			<section class="<?php echo esc_attr( $section_class ); ?>" <?php if ( ! empty( $animation ) ) : ?>data-animation="<?php echo esc_attr( $animation ); ?>"<?php endif; ?>>

				<?php if ( ! empty( $section_title ) ) : ?>

				<header>

					<h2 class="h1"><?php echo wp_kses_post( $section_title ); ?></h2>
					
					<?php if ( ! empty( $button_text ) ) : ?>
			            <a class="action-text" href="<?php echo esc_attr( $button_link ); ?>"><?php echo wp_kses_post( $button_text ); ?></a>
			        <?php endif; ?>
					
				</header>

				<?php endif; ?>

				<div id="<?php echo esc_attr( $carousel_id );?>" data-ride="owl-carousel" data-replace-active-class="true" data-carousel-selector=".products-carousel" data-carousel-options="<?php echo esc_attr( json_encode( $carousel_args ) ); ?>">
				<?php
					$search 		= array( '<ul', '<li', '</li>', '</ul>', 'class="products' );
					$replace 		= array( '<div', '<div', '</div>', '</div>', 'class="products owl-carousel products-carousel' );
					$products_html 	= str_replace( $search, $replace, $products_html );
					echo apply_filters( 'electro_products_carousel_html', $products_html );
				?>
				</div>
			</section>
		<?php

		endif;
	}
}

if ( ! function_exists( 'electro_get_atts_for_taxonomy_slugs' ) ) {
	function electro_get_atts_for_taxonomy_slugs( $args ) {
		if ( ! empty( $args['slugs'] ) ) {
			$cat_slugs = is_array( $args['slugs'] ) ? $args['slugs'] : explode( ',', $args['slugs'] );
			$cat_slugs = array_map( 'trim', $cat_slugs );
			$args['slug'] 	= $cat_slugs;

			$include = array();

			foreach ( $cat_slugs as $slug ) {
				$include[] = "'" . $slug ."'";
			}

			if ( ! empty($include ) ) {
				$args['include'] 	= $include;
				$args['orderby']	= 'include';
			}
		}

		return $args;
	}
}

if ( ! function_exists( 'electro_home_v5_product_carousel' ) ) {
	/**
	 * Displays Products Carousel Tabs in home
	 *
	 * @return void
	 */
	function electro_home_v5_product_carousel( $args ) {

		if ( is_woocommerce_activated() ) {

			$defaults = apply_filters( 'electro_home_v5_product_carousel_args', array(
				'section_title'		=> esc_html__( 'Popular Products', 'electro' ),
				'enable_categories'	=> true,
				'categories_title'	=> '',
				'shortcode_tag'		=> '',
				'shortcode_atts'	=> array(),
				'show_custom_nav'	=> true,
				'category_args'		=> array(),
				'carousel_args'		=> array(
					'items'			=> '7',
					'nav'			=> true,
					'autoplay'		=> false,
					'nav'			=> true,
					'navText'		=> is_rtl() ? array( '<i class="fa fa-angle-right"></i>', '<i class="fa fa-angle-left"></i>' ) : array( '<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>' ),
					'dots'			=> true,
					'responsive'	=> array(
						'0'			=> array( 'items' => 2 ),
						'480'		=> array( 'items' => 2 ),
						'768'		=> array( 'items' => 2 ),
						'992'		=> array( 'items' => 3 ),
						'1200'		=> array( 'items' => 6 ),
						'1430'      => array( 'items' => 7 ),
					)
				)
			) );

			$args = wp_parse_args( $args, $defaults );

			if( $args['enable_categories'] ) {
				$cat_args = electro_get_atts_for_taxonomy_slugs( $args['category_args'] );
				$categories = get_terms( 'product_cat',  $cat_args );
				$args['categories'] = $categories;
			}

			electro_get_template( 'templates/homepage/products-carousel.php', $args );
		}
	}
}

if ( ! function_exists( 'electro_products_carousel_with_deal' ) ) {
	/**
	 * Displays Products Carousel Tabs in home
	 *
	 * @return void
	 */
	function electro_products_carousel_with_deal( $args ) {

		if ( is_woocommerce_activated() ) {

			$defaults = apply_filters( 'electro_products_carousel_with_deal_args', array(
				'section_title'		=> esc_html__( 'Week Deals limited, Just now', 'electro' ),
				'timer_title'		=> esc_html__( 'Hurry up! Offer ends in:', 'electro' ),
				'header_timer'		=> true,
				'timer_value'		=> '',
				'deal_percentage'	=> '%',
				'product_limit'		=> 12,
				'product_columns'	=> 4,
				'shortcode_tag'		=> '',
				'shortcode_atts'	=> array(),
				'section_args'		=> '',
				'carousel_args'		=> array(
					'autoplay'			=> 'no',
					'margin'			=> '5',
					'nav'				=> true,
					'navText'			=> is_rtl() ? array( '<i class="fa fa-angle-right"></i>', '<i class="fa fa-angle-left"></i>' ) : array( '<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>' ),
					'dots'				=> true,
					'responsive'		=> array(
						'0'					=> array( 'items' => 2 ),
						'480'				=> array( 'items' => 2 ),
						'768'				=> array( 'items' => 2 ),
						'992'				=> array( 'items' => 3 ),
						'1024'				=> array( 'items' => 3 ),
						'1200'				=> array( 'items' => 4 ),
					)
				)
			) );

			$args = wp_parse_args( $args, $defaults );

			electro_get_template( 'templates/homepage/products-deal-carousel.php', $args );
		}
	}
}

if ( ! function_exists( 'electro_recent_viewed_products' ) ) {
	/**
	* Display Recently Viewed Products
	*/
	function electro_recent_viewed_products( $args = array() ) {

		if( is_woocommerce_activated() ) {

			$viewed_products = electro_get_viewed_products();

			if ( empty( $viewed_products ) ) {
				return;
			}

			$defaults = apply_filters( 'electro_recent_viewed_products_default_args', array(
				'section_title'     => esc_html__( 'Recently Viewed', 'electro' ),
				'shortcode_atts'    => array( 'columns' => '5','per_page' => 10 )
			) );

			$args = wp_parse_args( $args, $defaults );

			$shortcode_atts = wp_parse_args( array( 'ids' => implode(',', $viewed_products ) ), $args['shortcode_atts'] );

			$section_class = empty( $section_class ) ? 'footer-recently-viewed' : 'footer-recently-viewed ' . $section_class;

			if ( ! empty( $animation ) ) {
			    $section_class .= ' animate-in-view';
			}

			?>
			<section class="<?php echo esc_attr( $section_class ); ?>" <?php if ( ! empty( $animation ) ) : ?>data-animation="<?php echo esc_attr( $animation ); ?>"<?php endif; ?>>
				<header>
					<h2 class="h1"><?php echo wp_kses_post( $args['section_title'] ); ?></h2>
				</header>
				<div class="products-block">
					<?php echo electro_do_shortcode( 'products',  $shortcode_atts ); ?>
				</div>
			</section>
			<?php
		}
	}
}