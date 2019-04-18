<?php
function wpcargo_trackform_shipment_number( $shipment_number ) {
    global $wpdb;
    $shipment_number = esc_sql( $shipment_number );
    $sql = apply_filters( 'wpcargo_trackform_shipment_number_query', "SELECT `ID` FROM `{$wpdb->prefix}posts` WHERE post_title = '{$shipment_number}' AND `post_status` = 'publish' AND `post_type` = 'wpcargo_shipment' LIMIT 1", $shipment_number );
    $results = $wpdb->get_var($sql);
    return $results;
}
function wpcargo_get_postmeta( $post_id = '' , $metakey = '', $type = '' ){
    $result = '';
    if( !empty( $post_id ) && !empty( $metakey ) ){
        $result                    = maybe_unserialize( get_post_meta( $post_id, $metakey, true) );
        if( is_array( $result ) ){
            $result = array_filter( array_map( 'trim', $result ) );
            if( !empty( $result ) ){
                $result = implode(', ',$result);
            } 
            if( $type == 'url' ){
                $url_data = array_values( maybe_unserialize( get_post_meta( $post_id, $metakey, true) ) );
                $target   = count( $url_data ) > 2 ? '_blank' : '' ;
                $url      = $url_data[1] ? $url_data[1] : '#' ;
                $label    = $url_data[0];
                $result   = '<a href="'.$url.'" target="'.$target.'">'.$label.'</a>';
            }       
        }elseif( $type == 'date' ){
            if( $result ){
                $result = date_i18n( get_option( 'date_format' ), strtotime($result) );
            }   
        }
    }
    return $result;
}
function wpcargo_html_value( $string, $htmltag = 'span', $attr = 'class' ){
    $string    = trim( $string );
    $attrvalue = strtolower( str_replace(" ", '-', $string ) );
    $attrvalue = preg_replace("/[^A-Za-z0-9 -]/", '', $attrvalue);
    return '<'.$htmltag.' '.$attr.' ="'.$attrvalue.'" >'.$string.'</'.$htmltag.'>';
}
function wpcargo_user_roles_list(){
    $wpcargo_user_roles_list = apply_filters( 'wpcargo_user_roles_list', array(
        'administrator', 'wpc_shipment_manager', 'wpcargo_branch_manager', 'wpcargo_driver', 'wpcargo_client', 'cargo_agent'
    ) );
    return $wpcargo_user_roles_list;
}
function wpcargo_has_registered_shipper(){
    global $wpdb;
    $sql = "SELECT tbl2.meta_value FROM `{$wpdb->prefix}posts` AS tbl1 INNER JOIN `{$wpdb->prefix}postmeta` AS tbl2 ON tbl1.ID = tbl2.post_id WHERE tbl1.post_status LIKE 'publish' AND tbl1.post_type LIKE 'wpcargo_shipment' AND tbl2.meta_key LIKE 'registered_shipper' AND ( tbl2.meta_value IS NOT NULL AND tbl2.meta_value <> '' ) GROUP BY tbl2.meta_value";
    $result = $wpdb->get_col($sql);
    return $result;
}
function wpcargo_email_shortcodes_list(){
    $tags = array(
        '{wpcargo_tracking_number}' => __('Tracking Number','wpcargo'),
        '{wpcargo_shipper_email}'   => __('Shipper Email','wpcargo'),
        '{wpcargo_receiver_email}'  => __('Receiver Email','wpcargo'),
        '{wpcargo_shipper_phone}'   => __('Shipper Phone','wpcargo'),
        '{wpcargo_receiver_phone}'  => __('Receiver Phone','wpcargo'),
        '{admin_email}'             => __('Admin Email','wpcargo'),
        '{wpcargo_shipper_name}'    => __('Name of the Shipper','wpcargo'),
        '{wpcargo_receiver_name}'   => __('Name of the Receiver','wpcargo'),
        '{status}'                  => __('Shipment Status','wpcargo'),
        '{site_name}'               => __('Website Name','wpcargo'),
        '{site_url}'                => __('Website URL','wpcargo'),
    );

    $tags   = apply_filters( 'wpc_email_meta_tags', $tags );
    return $tags;
}
function wpcargo_defualt_status(){
    $status = array(
        __( 'Pending', 'wpcargo' ),
        __( 'Picked up', 'wpcargo' ),
        __( 'On Hold', 'wpcargo' ),
        __( 'Out for delivery', 'wpcargo' ),
        __( 'In Transit', 'wpcargo' ),
        __( 'Enroute', 'wpcargo' ),
        __( 'Cancelled', 'wpcargo' ),
        __( 'Delivered', 'wpcargo' ),
        __( 'Returned', 'wpcargo' )
    );
    return $status;
}
function wpcargo_email_replace_shortcodes_list( $post_id ){
    $delimiter = array("{", "}");
    $replace_shortcodes = array();
    if( !empty( wpcargo_email_shortcodes_list() ) ){
        foreach ( wpcargo_email_shortcodes_list() as $shortcode => $shortcode_label ) {
            $shortcode = trim( str_replace( $delimiter, '', $shortcode ) );
            if( $shortcode == 'wpcargo_tracking_number' ){
                $replace_shortcodes[] = get_the_title($post_id);
            }elseif( $shortcode == 'admin_email' ){
                $replace_shortcodes[] = apply_filters( 'wpcargo_admin_notification_email_address', get_option('admin_email') );
            }elseif( $shortcode == 'site_name' ){
                $replace_shortcodes[] = get_bloginfo('name');
            }elseif( $shortcode == 'site_url' ){
                $replace_shortcodes[] = get_bloginfo('url');
            }elseif( $shortcode == 'status' ){
                $replace_shortcodes[] = get_post_meta( $post_id, 'wpcargo_status', true );
            }else{
                $meta_value = maybe_unserialize( get_post_meta( $post_id, $shortcode, true ) );
                if( is_array( $meta_value ) ){
                    $meta_value = implode(', ',$meta_value );
                }
                $replace_shortcodes[] = $meta_value;
            }
        }
    }
    return $replace_shortcodes;
}  
function wpcargo_shipper_meta_filter(){
    return apply_filters( 'wpcargo_shipper_meta_filter', 'wpcargo_shipper_name');
} 
function wpcargo_shipper_label_filter(){
    return apply_filters( 'wpcargo_shipper_label_filter', __('Shipper Name', 'wpcargo' ) );
} 
function wpcargo_receiver_meta_filter(){
    return apply_filters( 'wpcargo_receiver_meta_filter', 'wpcargo_receiver_name' );
} 
function wpcargo_receiver_label_filter(){
    return apply_filters( 'wpcargo_receiver_label_filter', __('Receiver Name', 'wpcargo' ) );
} 
function wpcargo_default_client_email_body(){
    ob_start();
    ?>
    <p>Dear {wpcargo_shipper_name},</p>
    <p style="font-size: 1em;margin:.5em 0px;line-height: initial;">We are pleased to inform you that your shipment has now cleared customs and is now {status}.</p>
    <br />
    <h4 style="font-size: 1.2em;">Tracking Information</h4>
    <p style="font-size: 1em;margin:.5em 0px;line-height: initial;">Tracking Number - {wpcargo_tracking_number}</p>
    <p style="font-size: 1em;margin:.5em 0px;line-height: initial;">Latest International Scan: Customs status updated</p>
    <p style="font-size: 1em;margin:.5em 0px;line-height: initial;">We hope this meets with your approval. Please do not hesitate to get in touch if we can be of any further assistance.</p>
    <br />
    <p style="font-size: 1em;margin:.5em 0px;line-height: initial;">Yours sincerely</p>
    <p style="font-size: 1em;margin:.5em 0px;line-height: initial;"><a href="{site_url}">{site_name}</a></p>
    <?php
    $output = ob_get_clean();
    return $output;
}
function wpcargo_default_admin_email_body(){
    ob_start();
    ?>
    <p>Dear Admin,</p>
    <p>Shipment number {wpcargo_tracking_number} has been updated to {status}.</p>
    <br />
    <p>Yours sincerely</p>
    <p><a href="{site_url}">{site_name}</a></p>
    <?php
    $output = ob_get_clean();
    return $output;
}
function wpcargo_default_email_footer(){
    ob_start();
    ?>
    <div class="wpc-contact-info" style="margin-top: 10px;">
        <p style="font-size: 1em;margin:.5em 0px;line-height: initial;">Your Address Here...</p>
        <p style="font-size: 1em;margin:.5em 0px;line-height: initial;">Email: <a href="mailto:{admin_email}">{admin_email}</a> - Web: <a href="{site_url}">{site_name}</a></p>
        <p style="font-size: 1em;margin:.5em 0px;line-height: initial;">Phone: <a href="tel:">Your Phone Number Here</a>, <a href="tel:">Your Phone Number Here</a></p>
    </div>
    <div class="wpc-contact-bottom" style="margin-top: 2em; padding: 1em; border-top: 1px solid #000;">
        <p style="font-size: 1em;margin:.5em 0px;line-height: initial;">This message is intended solely for the use of the individual or organisation to whom it is addressed. It may contain privileged or confidential information. If you have received this message in error, please notify the originator immediately. If you are not the intended recipient, you should not use, copy, alter or disclose the contents of this message. All information or opinions expressed in this message and/or any attachments are those of the author and are not necessarily those of {site_name} or its affiliates. {site_name} accepts no responsibility for loss or damage arising from its use, including damage from virus.</p>
    </div>
    <?php
    $output = ob_get_clean();
    return $output;
}
function wpcargo_email_body_container( $email_body = '', $email_footer = '' ){
    global $wpcargo;
    $default_logo   = WPCARGO_PLUGIN_URL.'admin/assets/images/wpcargo-logo-email.png';
    $footer_image       = WPCARGO_PLUGIN_URL.'admin/assets/images/wpc-email-footer.png';
    $brand_logo         = !empty( $wpcargo->logo ) ? $wpcargo->logo : $default_logo;
    ob_start();
    ?>
    <div class="wpc-email-notification-wrap" style="width: 100%; font-family: sans-serif;">
        <div class="wpc-email-notification" style="padding: 3em; background: #efefef;">
            <div class="wpc-email-template" style="background: #fff; width: 95%; margin: 0 auto;">
                <div class="wpc-email-notification-logo" style="padding: 2em 2em 0px 2em;">
                    <table width="100%" style="max-width:210px;"><tr><td><img src="<?php echo $brand_logo; ?>" width="100%"/></td></tr></table>
                </div>
                <div class="wpc-email-notification-content" style="padding: 2em 2em 1em 2em; font-size: 18px;">
                    <?php echo $email_body; ?>
                </div>
                <div class="wpc-email-notification-footer" style="font-size: 10px; text-align: center; margin: 0 auto;">
                    <div class="wpc-footer-devider">
                    <img src="<?php echo $footer_image; ?>" style="width:100%;" />
                </div>
                    <?php echo $email_footer; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    $output = ob_get_clean();
    return $output;
}
function wpcargo_send_email_notificatio( $post_id, $status = '' ){
    wpcargo_client_mail_notification( $post_id, $status );
    wpcargo_admin_mail_notification( $post_id, $status );
}
function wpcargo_client_mail_notification( $post_id, $status = '' ){
    global $wpcargo;
    $wpcargo_mail_domain = !empty( trim( get_option('wpcargo_mail_domain') ) ) ? get_option('wpcargo_mail_domain') : get_option( 'admin_email' ) ;
    if ( $wpcargo->client_mail_active ) {
        $old_status     = get_post_meta($post_id, 'wpcargo_status', true);
        $str_find       = array_keys( wpcargo_email_shortcodes_list() );
        $str_replce     = wpcargo_email_replace_shortcodes_list( $post_id );

        $mail_content   = $wpcargo->client_mail_body;
        $mail_footer    = $wpcargo->client_mail_footer;
        $headers        = array();
        $headers[]      = 'From: ' . get_bloginfo('name') .' <'.$wpcargo_mail_domain.'>';
        if( $wpcargo->mail_cc ){
            $headers[]      = 'cc: '.str_replace($str_find, $str_replce, $wpcargo->mail_cc )."\r\n";
        }
        if( $wpcargo->mail_bcc ){
            $headers[]      = 'Bcc: '.str_replace($str_find, $str_replce, $wpcargo->mail_bcc )."\r\n";
        }
        $subject        = str_replace($str_find, $str_replce, $wpcargo->client_mail_subject );
        $send_to        = str_replace($str_find, $str_replce, $wpcargo->client_mail_to );
        $message        = str_replace($str_find, $str_replce, wpcargo_email_body_container( $mail_content, $mail_footer ) );     
        if( empty( $wpcargo->mail_status ) ){
            wp_mail( $send_to, $subject, $message, $headers );
        }elseif( !empty( $wpcargo->mail_status ) && in_array( $status, $wpcargo->mail_status) ){
            wp_mail( $send_to, $subject, $message, $headers );
        }   
    }
}
function wpcargo_admin_mail_notification( $post_id, $status = ''){
    global $wpcargo;
    $wpcargo_mail_domain = !empty( trim( get_option('wpcargo_admin_mail_domain') ) ) ? get_option('wpcargo_admin_mail_domain') : get_option( 'admin_email' ) ;
    if ( $wpcargo->admin_mail_active ) {
        $str_find       = array_keys( wpcargo_email_shortcodes_list() );
        $str_replce     = wpcargo_email_replace_shortcodes_list( $post_id );

        $mail_content   = $wpcargo->admin_mail_body;
        $mail_footer    = $wpcargo->admin_mail_footer;
        $headers        = array();
        $headers[]      = 'From: ' . get_bloginfo('name') .' <'.$wpcargo_mail_domain.'>';
        $subject        = str_replace($str_find, $str_replce, $wpcargo->admin_mail_subject );
        $send_to        = str_replace($str_find, $str_replce, $wpcargo->admin_mail_to );
        $message        = str_replace($str_find, $str_replce, wpcargo_email_body_container( $mail_content, $mail_footer ) );      
        if( empty( $wpcargo->admin_mail_status ) ){
            wp_mail( $send_to, $subject, $message, $headers );
        }elseif( !empty( $wpcargo->admin_mail_status ) && in_array( $status, $wpcargo->admin_mail_status) ){
            wp_mail( $send_to, $subject, $message, $headers );
        }   
    }
}
function wpcargo_pagination( $args = array() ) {
    
    $defaults = array(
        'range'           => 4,
        'custom_query'    => FALSE,
        'previous_string' => __( 'Previous', 'wpcargo' ),
        'next_string'     => __( 'Next', 'wpcargo' ),
        'before_output'   => '<div id="wpcargo-pagination-wrapper"><nav class="wpcargo-pagination post-nav" aria-label="'.__('Shipments', 'wpcargo').'"><ul class="wpcargo-pagination pg-blue justify-content-center">',
        'after_output'    => '</ul></nav</div>'
    );
    
    $args = wp_parse_args( 
        $args, 
        apply_filters( 'wpcargo_pagination_defaults', $defaults )
    );
    
    $args['range'] = (int) $args['range'] - 1;
    if ( !$args['custom_query'] )
        $args['custom_query'] = @$GLOBALS['wp_query'];
    $count = (int) $args['custom_query']->max_num_pages;
    $page  = intval( get_query_var( 'paged' ) );
    $ceil  = ceil( $args['range'] / 2 );
    
    if ( $count <= 1 )
        return FALSE;
    
    if ( !$page )
        $page = 1;
    
    if ( $count > $args['range'] ) {
        if ( $page <= $args['range'] ) {
            $min = 1;
            $max = $args['range'] + 1;
        } elseif ( $page >= ($count - $ceil) ) {
            $min = $count - $args['range'];
            $max = $count;
        } elseif ( $page >= $args['range'] && $page < ($count - $ceil) ) {
            $min = $page - $ceil;
            $max = $page + $ceil;
        }
    } else {
        $min = 1;
        $max = $count;
    }
    
    $echo = '';
    $previous = intval($page) - 1;
    $previous = esc_attr( get_pagenum_link($previous) );
    
    $firstpage = esc_attr( get_pagenum_link(1) );
    if ( $firstpage && (1 != $page) )
        $echo .= '<li class="previous wpcargo-page-item"><a class="wpcargo-page-link waves-effect waves-effect" href="' . $firstpage . '">' . __( 'First', 'wpcargo' ) . '</a></li>';

    if ( $previous && (1 != $page) )
        $echo .= '<li class="wpcargo-page-item" ><a class="wpcargo-page-link waves-effect waves-effect" href="' . $previous . '" title="' . __( 'previous', 'wpcargo') . '">' . $args['previous_string'] . '</a></li>';
    
    if ( !empty($min) && !empty($max) ) {
        for( $i = $min; $i <= $max; $i++ ) {
            if ($page == $i) {
                $echo .= '<li class="wpcargo-page-item active"><span class="wpcargo-page-link waves-effect waves-effect">' . str_pad( (int)$i, 2, '0', STR_PAD_LEFT ) . '</span></li>';
            } else {
                $echo .= sprintf( '<li class="wpcargo-page-item"><a class="wpcargo-page-link waves-effect waves-effect" href="%s">%002d</a></li>', esc_attr( get_pagenum_link($i) ), $i );
            }
        }
    }
    
    $next = intval($page) + 1;
    $next = esc_attr( get_pagenum_link($next) );
    if ($next && ($count != $page) )
        $echo .= '<li class="wpcargo-page-item"><a class="wpcargo-page-link waves-effect waves-effect" href="' . $next . '" title="' . __( 'next', 'wpcargo') . '">' . $args['next_string'] . '</a></li>';
    
    $lastpage = esc_attr( get_pagenum_link($count) );
    if ( $lastpage ) {
        $echo .= '<li class="next wpcargo-page-item"><a class="wpcargo-page-link waves-effect waves-effect" href="' . $lastpage . '">' . __( 'Last', 'wpcargo' ) . '</a></li>';
    }

    if ( isset($echo) ){
        echo $args['before_output'] . $echo . $args['after_output'];
    }
}
function wpcargo_brand_name(){
	return apply_filters('wpcargo_brand_name', __('WPCargo', 'wpcargo' ) );
}
function wpcargo_general_settings_label(){
	return apply_filters('wpcargo_general_settings_label', __('General Settings', 'wpcargo' ) );
}
function wpcargo_client_email_settings_label(){
	return apply_filters('wpcargo_email_settings_label', __('Client Email Settings', 'wpcargo' ) );
}
function wpcargo_admin_email_settings_label(){
    return apply_filters('wpcargo_admin_email_settings_label', __('Admin Email Settings', 'wpcargo' ) );
}
function wpcargo_client_account_settings_label(){
	return apply_filters('wpcargo_client_account_settings_label', __('Client Account Setting', 'wpcargo' ) );
}
function wpcargo_shipment_settings_label(){
	return apply_filters('wpcargo_shipment_settings_label', __('Shipment Settings', 'wpcargo' ) );
}
function wpcargo_report_settings_label(){
	return apply_filters('wpcargo_report_settings_label', __('Reports', 'wpcargo' ) );
}
function wpcargo_map_settings_label(){
	return apply_filters('wpcargo_map_settings_label', __('Map Settings', 'wpcargo' ) );
}
function wpcargo_print_layout_label(){
	return apply_filters('wpcargo_print_layout_label', __('Print Layout', 'wpcargo' ) );
}
function wpcargo_shipment_label(){
	return apply_filters('wpcargo_shipment_label', __('Shipment Label', 'wpcargo' ) );
}
function wpcargo_shipment_details_label(){
    return apply_filters('wpcargo_shipment_details_label', __('Shipment Details', 'wpcargo' ) );
}