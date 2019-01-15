<?php

function electro_ocdi_import_files() {
    return apply_filters( 'electro_ocdi_files_args', array(
        array(
            'import_file_name'             => 'Electro',
            'categories'                   => array( 'Electronics' ),
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'assets/dummy-data/dummy-data.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'assets/dummy-data/widgets.wie',
            'local_import_redux'           => array(
                array(
                    'file_path'   => trailingslashit( get_template_directory() ) . 'assets/dummy-data/redux-options.json',
                    'option_name' => 'electro_options',
                ),
            ),
            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'assets/images/electro-preview.jpg',
            'import_notice'                => esc_html__( 'Import process may take 10-15 minutes. If you facing any issues please contact our support.', 'electro' ),
            'preview_url'                  => 'https://demo2.madrasthemes.com/electro/',
        ),
    ) );
}

function electro_ocdi_after_import_setup( $selected_import ) {
    
    // Assign menus to their locations.
    $topbar_left_menu       = get_term_by( 'name', 'Top Bar Left', 'nav_menu' );
    $topbar_right_menu      = get_term_by( 'name', 'Top Bar Right', 'nav_menu' );
    $primary_menu           = get_term_by( 'name', 'Main Menu', 'nav_menu' );
    $navbar_primary_menu    = get_term_by( 'name', 'Navbar Primary', 'nav_menu' );
    $secondary_menu         = get_term_by( 'name', 'Secondary Nav', 'nav_menu' );
    $departments_menu       = get_term_by( 'name', 'Departments Menu', 'nav_menu' );
    $all_departments_menu   = get_term_by( 'name', 'All Departments Menu', 'nav_menu' );
    $blog_menu              = get_term_by( 'name', 'Blog Menu', 'nav_menu' );
    $mobile_hh_departments  = get_term_by( 'name', 'Mobile Handheld Department', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'topbar-left'                   => $topbar_left_menu->term_id,
            'topbar-right'                  => $topbar_right_menu->term_id,
            'primary-nav'                   => $primary_menu->term_id,
            'navbar-primary'                => $navbar_primary_menu->term_id,
            'secondary-nav'                 => $secondary_menu->term_id,
            'departments-menu'              => $departments_menu->term_id,
            'all-departments-menu'          => $all_departments_menu->term_id,
            'blog-menu'                     => $blog_menu->term_id,
            'hand-held-nav'                 => $all_departments_menu->term_id,
            'mobile-handheld-department'    => $mobile_hh_departments->term_id,
        )
    );

    // Assign front page and posts page (blog page) and other WooCommerce pages
    $front_page_id      = get_page_by_title( 'Home v1' );
    $blog_page_id       = get_page_by_title( 'Blog' );
    $shop_page_id       = get_page_by_title( 'Shop' );
    $cart_page_id       = get_page_by_title( 'Cart' );
    $checkout_page_id   = get_page_by_title( 'Checkout' );
    $myaccount_page_id  = get_page_by_title( 'My Account' );
    $terms_page_id      = get_page_by_title( 'Terms and Conditions' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );
    update_option( 'woocommerce_shop_page_id', $shop_page_id->ID );
    update_option( 'woocommerce_cart_page_id', $cart_page_id->ID );
    update_option( 'woocommerce_checkout_page_id', $checkout_page_id->ID );
    update_option( 'woocommerce_myaccount_page_id', $myaccount_page_id->ID );
    update_option( 'woocommerce_terms_page_id', $terms_page_id->ID );

    // Update Wishlist Position
    update_option( 'yith_wcwl_button_position', 'shortcode' );

    // Enable Registration on "My Account" page
    update_option( 'woocommerce_enable_myaccount_registration', 'yes' );

    // Set WPBPage Builder ( formerly Visual Composer ) for Static Blocks
    if ( function_exists( 'vc_set_default_editor_post_types' ) ) {
        vc_set_default_editor_post_types( array( 'page', 'static_block' ) );
    }

    if( class_exists( 'RevSlider' ) ) {
        require_once( ABSPATH . 'wp-load.php' );
        require_once( ABSPATH . 'wp-includes/functions.php' );
        require_once( ABSPATH . 'wp-admin/includes/file.php' );

        $slider_array = array(
            trailingslashit( get_template_directory() ) . 'assets/dummy-data/home-v1-slider.zip',
            trailingslashit( get_template_directory() ) . 'assets/dummy-data/home-v2-slider.zip',
            trailingslashit( get_template_directory() ) . 'assets/dummy-data/home-v3-slider.zip',
            trailingslashit( get_template_directory() ) . 'assets/dummy-data/home-v4-slider.zip',
            trailingslashit( get_template_directory() ) . 'assets/dummy-data/home-v5-slider.zip',
        );
        $slider = new RevSlider();

        foreach( $slider_array as $filepath ) {
            $slider->importSliderFromPost( true, true, $filepath );
        }
    }

    if ( function_exists( 'wc_delete_product_transients' ) ) {
        wc_delete_product_transients();
    }
    if ( function_exists( 'wc_delete_shop_order_transients' ) ) {
        wc_delete_shop_order_transients();
    }
    if ( function_exists( 'wc_delete_expired_transients' ) ) {
        wc_delete_expired_transients();
    }
}

function electro_ocdi_before_widgets_import() {

    $sidebars_widgets = get_option('sidebars_widgets');
    $all_widgets = array();

    array_walk_recursive( $sidebars_widgets, function ($item, $key) use ( &$all_widgets ) {
        if( ! isset( $all_widgets[$key] ) ) {
            $all_widgets[$key] = $item;
        } else {
            $all_widgets[] = $item;
        }
    } );

    if( isset( $all_widgets['array_version'] ) ) {
        $array_version = $all_widgets['array_version'];
        unset( $all_widgets['array_version'] );
    }

    $new_sidebars_widgets = array_fill_keys( array_keys( $sidebars_widgets ), array() );

    $new_sidebars_widgets['wp_inactive_widgets'] = $all_widgets;
    if( isset( $array_version ) ) {
        $new_sidebars_widgets['array_version'] = $array_version;
    }

    update_option( 'sidebars_widgets', $new_sidebars_widgets );
}
