<?php
/**
 * WooCommerce template functions used in header
 * 
 * @since 2.0
 */

if ( ! function_exists( 'electro_header_mini_cart_icon' ) ) {
    /**
     * @since 2.0
     */
    function electro_header_mini_cart_icon() {
        if( true === electro_get_shop_catalog_mode() ) {
            return;
        }
        
        $header_cart_icon             = apply_filters( 'electro_header_cart_icon', 'ec ec-shopping-bag' );
        $disable_header_cart_dropdown = apply_filters( 'electro_header_cart_dropdown_disable', false );
        
        ?><div class="header-icon <?php if ( ! $disable_header_cart_dropdown ): ?>animate-dropdown dropdown<?php endif; ?>">
            <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" <?php if ( ! $disable_header_cart_dropdown ): ?>data-toggle="dropdown"<?php endif; ?>>
                <i class="<?php echo esc_attr( $header_cart_icon ); ?>"></i>
                <span class="cart-items-count count header-icon-counter"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                <span class="cart-items-total-price total-price"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
            </a>
            <?php if ( ! $disable_header_cart_dropdown ) : ?>
            <ul class="dropdown-menu dropdown-menu-mini-cart">
                <li>
                    <div class="widget_shopping_cart_content">
                      <?php woocommerce_mini_cart();?>
                    </div>
                </li>
            </ul>
            <?php endif; ?>
        </div><?php
    }
}

if ( ! function_exists( 'electro_header_user_account' ) ) {
    function electro_header_user_account() {

        if ( ! apply_filters( 'electro_enable_header_user_account', false ) ) {
            return;
        }

        $my_account_page_url     = get_permalink( get_option('woocommerce_myaccount_page_id') );
        $is_registration_enabled = false;
        if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) {
            $is_registration_enabled = true;
        }
        $user_account_nav_menu      = apply_filters( 'electro_user_account_nav_menu_ID', 0 );
        $user_account_nav_menu_args = apply_filters( 'electro_user_account_nav_menu_args', array( 
            'container'   => false,
            'menu'        => $user_account_nav_menu,
            'menu_class'  => 'dropdown-menu dropdown-menu-user-account',
            'depth'       => 1,
            'items_wrap'  => '%3$s'
        ) );

        $header_user_icon = apply_filters( 'electro_header_user_account_icon', 'ec ec-user' );
        $login_text       = apply_filters( 'electro_header_user_account_login_text', esc_html__( 'Returning Customer ?', 'electro' ) ) ;
        $register_text    = apply_filters( 'electro_header_user_account_register_text', esc_html__( 'Don\'t have an account ?', 'electro' ) ) ;

        ?><div class="header-icon dropdown animate-dropdown">
            <a href="<?php echo esc_url( $my_account_page_url ); ?>" data-toggle="dropdown"><i class="<?php echo esc_attr( $header_user_icon ); ?>"></i></a>
            <ul class="dropdown-menu dropdown-menu-user-account">
                <?php 
                if ( is_user_logged_in() ) :
                    if ( is_nav_menu( $user_account_nav_menu ) ) {
                        wp_nav_menu( $user_account_nav_menu_args );
                    } else {
                        electro_user_account_nav_menu_fallback();
                    }
                else: ?>
                <li>
                    <?php ob_start(); ?>
                    <div class="register-sign-in-dropdown-inner">
                        <div class="sign-in">
                            <p><?php echo esc_html( $login_text ); ?></p>
                            <div class="sign-in-action"><a href="<?php echo esc_url( $my_account_page_url ); ?>" class="sign-in-button"><?php echo esc_html__( 'Sign in', 'electro' ); ?></a></div>
                        </div>
                        <div class="register">
                            <p><?php echo esc_html( $register_text ); ?></p>
                            <div class="register-action"><a href="<?php echo esc_url( $my_account_page_url ); ?>"><?php echo esc_html__( 'Register', 'electro' ); ?></a></div>
                        </div>
                    </div>
                    <?php 
                        $header_user_account_not_logged_in_html = apply_filters( 'electro_header_user_account_not_logged_in_html', ob_get_clean() ); 
                        echo wp_kses_post( $header_user_account_not_logged_in_html ); ?>
                </li>
                <?php endif; ?>
            </ul>
        </div><?php
    }
}

if ( ! function_exists( 'electro_user_account_nav_menu_fallback' ) ) {
    function electro_user_account_nav_menu_fallback() {
        foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
            <li class="menu-item">
                <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
            </li>
        <?php endforeach;
    }
}