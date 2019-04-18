<?php
/**
 * Plugin Name: Pargo Shipping
 * Plugin URI: https://www.pargo.co.za
 * Description: Pargo is a convenient logistics solution that lets you collect and return parcels at Pargo parcel points throughout the country when it suits you best.
 * Version: 2.0.9
 * Author: Pargo
 * Author URI: https://www.pargo.co.za
 * License: GPL-3.0+
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */
define("PARGOPLUGINVERSION", "2.0.8");

    function replaces_jquery() {
        if (!is_admin()) {
            // comment out the next two lines to load the local copy of jQuery
            wp_deregister_script('jquery');
            wp_register_script('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js', false, '1.11.3');
            wp_enqueue_script('jquery');

        }
    }

    if ( !is_admin() ) {
        add_action('init', 'replaces_jquery');
    }

  $plugin_location = plugin_dir_path(__FILE__) . 'ProcessPargoShipping.php';
    require_once ($plugin_location);

    add_action('woocommerce_thankyou', 'enroll_student', 10, 1);
function enroll_student( $order_id ) {

    if ( ! $order_id )
        return;

    else {
        unset($_SESSION['pargo_shipping_address']);
        unset($_SESSION['chosen_shipping_methods']);
        $html = "<script>
            localStorage.removeItem('pargo-shipping-settings');
</script>";
        return $html; 
    }

}

$hook_to = 'woocommerce_thankyou';
$what_to_hook = 'wl8OrderPlacedTriggerSomething';
$prioriy = 111;
$num_of_arg = 1;
add_action($hook_to, $what_to_hook, $prioriy, $num_of_arg);

function wl8OrderPlacedTriggerSomething($order_id){

    echo "<script>
            localStorage.removeItem('pargo-shipping-settings');
</script>";
            unset($_SESSION['pargo_shipping_address']);

}


    add_action( 'woocommerce_admin_order_data_after_shipping_address', 'admin_custom_row_after_order_addresses', 10, 1 );
    function admin_custom_row_after_order_addresses( $order ){
    ?>
        </div></div>
        <div class="clear"></div>
        <!-- new custom section row -->
        <div class="order_data_column_container">
            <div class="order_data_column_wide">
                <h3 style="margin-bottom: 5px"><?php _e("Pargo Shipment"); ?></h3>
                <!-- custom row paragraph -->


                <?php if ($order->has_status('completed') ) {
                    if(isset($_GET['ship-now'])){
                    $orderProcess  = new ProcessPargoShipping();
                    $orderProcess->postOrder($order);
                    }

                    ?>

<?php

if((get_option('woocommerce_wp_pargo_settings')['pargo_auth_token'] !== null || get_option('woocommerce_wp_pargo_settings')['pargo_auth_token'] !== '') && get_option('woocommerce_wp_pargo_settings')['pargo_use_api'] == 'yes' ){

if(get_post_meta( $order->id, 'pargo_waybill', true ) == '' && get_post_meta( $order->id, 'pargo_waybill', true ) == null){ ?>
              <a style="display: inline-block;
    width: auto;
    background: #006799;
    padding: 5px;
    text-align: center;
    border-radius: 5px;
    color: white;
    font-weight: bold;
    pointer-events: none;
    text-decoration: none;" href="<?php echo $_SERVER['REQUEST_URI'].'&ship-now' ?>" id="ship-now-pargo" class="btn btn-primary">Ship now</a>
              <p>Select a Warehouse</p>
              <script>
              jQuery(document).ready(function($) {
                 $("input[name='warehouse']").change(function() {
                   if (!$("input[name='warehouse']").is(':checked')) {
                                               $('#ship-now-pargo').css( 'pointer-events', 'none' );

               }
            else {
                        $('#ship-now-pargo').css( 'pointer-events', 'auto' );
                        $("#ship-now-pargo").attr("href", "<?php echo $_SERVER['REQUEST_URI'].'&ship-now' ?>&warehouseCode="+$(this).val())

            }
                 });
});
              </script>
    <?php
        $ch = curl_init ("https://api.pargo.co.za/v8/warehouses");

        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $headers = array(
            "Content-Type:application/json",
            "Authorization: ".get_option('woocommerce_wp_pargo_settings')['pargo_auth_token']
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        if($response){
            foreach (json_decode($response)->data as $warehouse) {
                echo '<input type="radio" name="warehouse" value="'.$warehouse->warehouseCode.'"> '.$warehouse->address1.', '.$warehouse->address2.' ,'.$warehouse->suburb.', '.$warehouse->postalCode.','.$warehouse->city.', '.$warehouse->province.', '.$warehouse->country.'<br>';
            }
        }
        else{
            print_r(curl_error($ch));
        }

        curl_close($ch);
     ?>
              <?php } else { ?>
              <a style="display: inline-block;
    width: auto;
    background: #006799;
    padding: 5px;
    text-align: center;
    border-radius: 5px;
    color: white;
    font-weight: bold;
    text-decoration: none;" target="_blank" href="<? echo get_post_meta( $order->id, 'pargo_waybill', true )['label']; ?>" class="btn btn-primary">Print shipping label</a>
              <a target="_blank" style="display: inline-block;
    width: auto;
    background: #006799;
    padding: 5px;
    text-align: center;
    border-radius: 5px;
    color: white;
    font-weight: bold;
    text-decoration: none;" href="https://pargo.co.za/track-trace/?code=<? echo get_post_meta( $order->id, 'pargo_waybill', true )['waybill']; ?>" class="btn btn-primary">Track and trace</a>
    <?php } }
    else {
        echo "<p>In order to ship this parcel enable the <strong>'Pargo backend service'</strong> which you can find in the admin panel of pargo plugin. </p>";
    }
    }

}


register_activation_hook(__FILE__, 'pargo_plugin_activate');
add_action('admin_init', 'pargo_plugin_redirect');
function pargo_plugin_activate()
{
    global $wpdb;

    $redirect = null;
    $table = $wpdb->prefix . 'postmeta';
    //decode data if we want the data
    $data = $wpdb->get_row("SELECT * FROM  $table WHERE  meta_key = 'pargo_settings'");

    $plugin_location = plugin_dir_path(__FILE__) . 'pargo-shipping.php';
    $plugin_current_version = get_plugin_data($plugin_location, $markup = true, $translate = true)['Version'];

    $client_id = '3';
    $client_secret = 'L8CBIeDsHNvjJO99mUa4Ooori0cQHeKXrgtu0wYr';

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://monitor.pargosandbox.co.za/oauth/token");

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($ch, CURLOPT_POSTFIELDS, array(
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'grant_type' => 'client_credentials'
    ));

    $data = curl_exec($ch);

    $accessToken = json_decode($data)->access_token;


    $data = [
        'platform' => 'WordPress',
        'plugin_version' => $plugin_current_version,
        'client' => get_option('blogname'),
        'client_domain' => get_option('siteurl'),
        'status' => 'INSTALLED',
        'plugin_date' => date("Y-m-d H:i:s")
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://monitor.pargosandbox.co.za/api/plugin/submit');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Accept: application/json",
        "Authorization: Bearer $accessToken",
        "Cache-Control: no-cache",
        "Content-Type: application/x-www-form-urlencoded",
        "content-type: multipart/form-data;"
    ));

    $result = curl_exec($ch);


    $client = [
        'client' => get_option('siteurl'),
        'status' => 'ACTIVE'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://monitor.pargosandbox.co.za/api/plugin/client');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($client));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Accept: application/json",
        "Authorization: Bearer $accessToken",
        "Cache-Control: no-cache",
        "Content-Type: application/x-www-form-urlencoded",
        "content-type: multipart/form-data;"
    ));

    $result = curl_exec($ch);

    if (count($data) == 0) {
        $redirect = 'admin.php?page=pargo-shipping-optin';
    } else {
        $redirect = 'admin.php?page=pargo-shipping';
    }
    add_option('redirect', $redirect);
}
function pargo_plugin_redirect() {

    if(get_option('redirect')){
        wp_redirect(get_option('redirect'));
    }

    delete_option('redirect');

}

//On deactivation of Pargo Plugin
register_deactivation_hook( __FILE__, 'pargo_plugin_deactivation' );
function pargo_plugin_deactivation() {
    $plugin_location = plugin_dir_path(__FILE__) . 'pargo-shipping.php';
    $plugin_current_version = get_plugin_data($plugin_location, $markup = true, $translate = true)['Version'];

    $client_id = '3';
    $client_secret = 'L8CBIeDsHNvjJO99mUa4Ooori0cQHeKXrgtu0wYr';

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://monitor.pargosandbox.co.za/oauth/token");

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($ch, CURLOPT_POSTFIELDS, array(
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'grant_type' => 'client_credentials'
    ));

    $data = curl_exec($ch);



    $accessToken = json_decode($data)->access_token;


    $data = [
        'platform' => 'WordPress',
        'plugin_version' => $plugin_current_version,
        'client' => get_option('blogname'),
        'client_domain' => get_option('siteurl'),
        'status' => 'DEACTIVATED',
        'plugin_date' => date("Y-m-d H:i:s")
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://monitor.pargosandbox.co.za/api/plugin/submit');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Accept: application/json",
        "Authorization: Bearer $accessToken",
        "Cache-Control: no-cache",
        "Content-Type: application/x-www-form-urlencoded",
        "content-type: multipart/form-data;"
    ));

    $result = curl_exec($ch);

    $client = [
        'client' => get_option('siteurl'),
        'status' => 'INACTIVE'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://monitor.pargosandbox.co.za/api/plugin/client');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($client));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Accept: application/json",
        "Authorization: Bearer $accessToken",
        "Cache-Control: no-cache",
        "Content-Type: application/x-www-form-urlencoded",
        "content-type: multipart/form-data;"
    ));

    $result = curl_exec($ch);

}

//On Uninstall of Pargo Plugin
register_uninstall_hook( __FILE__, 'pargo_plugin_uninstalled' );
function pargo_plugin_uninstalled() {

    $plugin_location = plugin_dir_path(__FILE__) . 'pargo-shipping.php';
    $plugin_current_version = get_plugin_data($plugin_location, $markup = true, $translate = true)['Version'];

    $client_id = '3';
    $client_secret = 'L8CBIeDsHNvjJO99mUa4Ooori0cQHeKXrgtu0wYr';

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://monitor.pargosandbox.co.za/oauth/token");

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($ch, CURLOPT_POSTFIELDS, array(
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'grant_type' => 'client_credentials'
    ));

    $data = curl_exec($ch);

    $accessToken = json_decode($data)->access_token;


    $data = [
        'platform' => 'WordPress',
        'plugin_version' => $plugin_current_version,
        'client' => get_option('blogname'),
        'client_domain' => get_option('siteurl'),
        'status' => 'UNINSTALLED',
        'plugin_date' => date("Y-m-d H:i:s")
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://monitor.pargosandbox.co.za/api/plugin/submit');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Accept: application/json",
        "Authorization: Bearer $accessToken",
        "Cache-Control: no-cache",
        "Content-Type: application/x-www-form-urlencoded",
        "content-type: multipart/form-data;"
    ));

    $result = curl_exec($ch);

    $client = [
        'client' => get_option('siteurl'),
        'status' => 'INACTIVE'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://monitor.pargosandbox.co.za/api/plugin/client');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($client));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Accept: application/json",
        "Authorization: Bearer $accessToken",
        "Cache-Control: no-cache",
        "Content-Type: application/x-www-form-urlencoded",
        "content-type: multipart/form-data;"
    ));

    $result = curl_exec($ch);

}


add_action( 'upgrader_process_complete', 'my_upgrade_function',10, 2);
function my_upgrade_function( $upgrader_object, $options ) {
    $current_plugin_path_name = plugin_basename( __FILE__ );

    if ($options['action'] == 'update' && $options['type'] == 'plugin' ){
        if(is_array($options['plugins'])){
            foreach($options['plugins'] as $each_plugin){

                if ($each_plugin==$current_plugin_path_name){
                    // .......................... YOUR CODES .............

                }
            }
        }
        else{

            if ($options['plugin']==$current_plugin_path_name){

                $plugin_location = plugin_dir_path(__FILE__) . 'pargo-shipping.php';
                $plugin_current_version = get_plugin_data($plugin_location, $markup = true, $translate = true)['Version'];


                $client_id = '3';
                $client_secret = 'L8CBIeDsHNvjJO99mUa4Ooori0cQHeKXrgtu0wYr';

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, "https://monitor.pargosandbox.co.za/oauth/token");

                curl_setopt($ch, CURLOPT_POST, TRUE);

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                    'client_id' => $client_id,
                    'client_secret' => $client_secret,
                    'grant_type' => 'client_credentials'
                ));

                $data = curl_exec($ch);

                $accessToken = json_decode($data)->access_token;


                $data = [
                    'platform' => 'WordPress',
                    'plugin_version' => $plugin_current_version,
                    'client' => get_option('blogname'),
                    'client_domain' => get_option('siteurl'),
                    'status' => 'UPDATED',
                    'plugin_date' => date("Y-m-d H:i:s")
                ];

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://monitor.pargosandbox.co.za/api/plugin/submit');
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Accept: application/json",
                    "Authorization: Bearer $accessToken",
                    "Cache-Control: no-cache",
                    "Content-Type: application/x-www-form-urlencoded",
                    "content-type: multipart/form-data;"
                ));

                $result = curl_exec($ch);
            }
        }

    }
}

//Prevent direct access to plugin
if ( ! defined( 'WPINC' ) ) {
    die;
}

if (!session_id()) {
    session_start();
}

/*
 * Check if WooCommerce is active
 */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {


    /* Version 1.2.1 Admin Menu

    /** Step 1 (admin menu). */
    add_action( 'admin_menu', 'pargo_plugin_menu' );
    /** Step 2 */
    function pargo_plugin_menu() {
        add_menu_page(
            "Pargo Plugin Options",
            "Pargo",
            "manage_options",
            "pargo-shipping",
            "pargo_plugin_options",
            "dashicons-cart"
        );

        add_submenu_page(
            "pargo-shipping", //Required. Slug of top level menu item
            "Pargo - Getting Started", //Required. Text to be displayed in title.
            "Getting Started", //Required. Text to be displayed in menu.
            "manage_options", //Required. The required capability of users.
            "pargo-shipping", //Required. A unique identifier to the sub menu item.
            "pargo_plugin_options", //Optional. This callback outputs the content of the page associated with this menu item.
            "" //Optional. The URL of the menu item icon
        );

        add_submenu_page(
            "pargo-shipping", //Required. Slug of top level menu item
            "Pargo - Usage Tracking Opt-in Options", //Required. Text to be displayed in title.
            null, //Required. Text to be displayed in menu.
            "manage_options", //Required. The required capability of users.
            "pargo-shipping-optin", //Required. A unique identifier to the sub menu item.
            "pargo_shipping_optin_page", //Optional. This callback outputs the content of the page associated with this menu item.
            "" //Optional. The URL of the menu item icon
        );
    }
    /** Step 3. */
    function pargo_plugin_options() {
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }

        include 'pargo-admin.php';

    }// end pargo_plugin_options

//the optin page

    function pargo_shipping_optin_page() {
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }

        return include('pargo-admin-tracking-optin.php');

    } //end function pargo_shipping_optin_page()

    /** Step 3 (admin menu). */
    add_action( 'admin_menu', 'pargo_plugin_menu' );


//call function on form submit

    /** Int Code **/


    //Save Tracking data


    /*
        public function savePargoOptinData($data){
            global $wpdb;
            $request  = json_encode($data);
            $table = $wpdb->prefix.'postmeta';
            $wpdb->insert($table, array("meta_value" => $request));
        }

    */


    /** end Int code **/




    /**custom optin page js css **/

    add_action('admin_enqueue_scripts', 'pargo_optin_reg_css_and_js');

    function pargo_optin_reg_css_and_js($hook)
    {

        $current_screen = get_current_screen();

        if ( strpos($current_screen->base, 'pargo-shipping-optin') === false) {
            return;
        } else {

            wp_enqueue_style('pargo_tracking_optin_css', plugins_url('inc/pargo-tracking-optin.css',__FILE__ ));
            wp_enqueue_script('pargo_tracking_optin_js', plugins_url('inc/pargo-tracking-optin.js',__FILE__ ));

        }
    }

    /**end custom optin page css **/

    /**Add CSS and Javascript **/

    add_action( 'wp_enqueue_scripts', 'pargo_enqueued_assets' );

    function pargo_enqueued_assets(){
        wp_enqueue_script( 'jquery' );
        //wp_enqueue_script( 'jquery', array(), '2.0', true );
        wp_enqueue_script( 'pargo_main_script', plugins_url( 'js/main.js?v='.time(), __FILE__ ));
        wp_enqueue_style( 'pargo-main-style', plugins_url( 'css/main.css', __FILE__ ));
        wp_localize_script( 'pargo_main_script', 'ajax_object', array( 'ajaxurl' => plugins_url( 'ajax-pick-up-point.php', __FILE__ )) ) ;
    }
    add_filter( 'woocommerce_checkout_get_value', 'set_shipping_zip', 10, 2 );

    function set_shipping_zip() {
        global $woocommerce;
        $state = null;
        if (isset($_SESSION['pargo_shipping_address']['province'] )) {
            switch ($_SESSION['pargo_shipping_address']['province']) {
                case 'Western Provice':
                    $state = 'WP';
                    break;
                case 'Northern Cape':
                    $state = 'NC';
                    break;
                case 'Eastern Cape':
                    $state = 'EC';
                    break;
                case 'Gauteng':
                    $state = 'GP';
                    break;
                case 'North West':
                    $state = 'NW';
                    break;
                case 'Mpumalanga':
                    $state = 'MP';
                    break;
                case 'Free State':
                    $state = 'FS';
                    break;
                case 'Limpopo':
                    $state = 'LP';
                    break;
                case 'KwaZulu-Natal':
                    $state = 'KZN';
                    break;

                default:
                    $state = null;
                    break;
            }
        }



        //set it
        if(isset($_SESSION['pargo_shipping_address']['address1'])){
            $woocommerce->customer->set_shipping_address( $_SESSION['pargo_shipping_address']['address1'] );
        }
        if(isset($_SESSION['pargo_shipping_address']['address2'])){
            $woocommerce->customer->set_shipping_address_2( $_SESSION['pargo_shipping_address']['address2'] );
        }
        if(isset($_SESSION['pargo_shipping_address']['city'])){
            $woocommerce->customer->set_shipping_city( $_SESSION['pargo_shipping_address']['city'] );
        }
        if(isset($_SESSION['pargo_shipping_address']['province'])){
            $woocommerce->customer->set_shipping_state( $_SESSION['pargo_shipping_address']['province'] );
        }
        if(!is_null($state)){
            $woocommerce->customer->set_shipping_state( $state );
        }

        if(isset($_SESSION['pargo_shipping_address']['storeName'])){
            $woocommerce->customer->set_shipping_company( $_SESSION['pargo_shipping_address']['storeName'] .' ('.$_SESSION['pargo_shipping_address']['pargoPointCode'].')' );
        }
        if(isset($_SESSION['pargo_shipping_address']['postalcode'])){
            $woocommerce->customer->set_shipping_postcode( $_SESSION['pargo_shipping_address']['postalcode'] );
        }
        //if(isset($_SESSION['shipping_address']['province'])){
        //$_SESSION['pargoPointCode']
        //}

    }

    add_action( 'woocommerce_before_checkout_form', 'set_shipping_zip'  );

    function overrideShippingLogic( $fields ) {
        $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );

        $chosen_shipping = $chosen_methods[0];

        if($chosen_shipping == 'wp_pargo'){
            $fields['shipping_state']['required'] = false;
            $fields['shipping_first_name']['required'] = false;
            $fields['shipping_last_name']['required'] = false;
            $fields['shipping_country']['required'] = false;
            $fields['shipping_company']['required'] = false;
            $fields['shipping_city']['required'] = false;
            $fields['shipping_address_1']['required'] = false;
            $fields['shipping_address_2']['required'] = false;
            $fields['shipping_postcode']['required'] = false;

        }

        return $fields;
    }
    add_filter( 'woocommerce_shipping_fields', 'overrideShippingLogic' );

    /**End Add CSS and Javascript **/

    function pargo_shipping_method() {

        if ( ! class_exists( 'Pargo_Shipping_Method' ) ) {

            add_action( 'woocommerce_after_checkout_form', 'bbloomer_disable_shipping_local_pickup' );

            function bbloomer_disable_shipping_local_pickup( $available_gateways ) {
                global $woocommerce;

// Part 1: Hide shipping based on the static choice @ Cart
// Note: "#customer_details .col-2" strictly depends on your theme

                $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
                $chosen_shipping_no_ajax = $chosen_methods[0];
                if ( 0 === strpos( $chosen_shipping_no_ajax, 'wp_pargo' ) ) {

                    ?>
                    <script type="text/javascript">

                        jQuery('#customer_details .col-2').fadeOut();

                    </script>
                    <?php

                }

// Part 2: Hide shipping based on the dynamic choice @ Checkout
// Note: "#customer_details .col-2" strictly depends on your theme

                ?>
                <script type="text/javascript">
                    jQuery('form.checkout').on('change','input[name^="shipping_method"]',function() {
                        var val = jQuery( this ).val();
                        if (val.match("^wp_pargo")) {
                            jQuery('#customer_details .col-2').fadeOut();
                        } else {
                            jQuery('#customer_details .col-2').fadeIn();
                        }
                    });

                </script>
                <?php

            }

            class Pargo_Shipping_Method extends WC_Shipping_Method {
                /**
                 * Constructor for your shipping class
                 *
                 * @access public
                 * @return void
                 */
                public function __construct($instance_id = 0){
                    //$this->instance_id = 0;
                    $this->id                 = 'wp_pargo';
                    $this->method_title       = __( 'Pargo', 'woocommerce' );
                    $this->method_description = __( 'Shipping Method for Pargo', 'woocommerce' );
                    // Availability & Countries
                    $this->availability = 'including';
                    $this->countries = array(
                        'ZA', //South Africa
                    );
                    //Woocommerce 3 support
                    $this->instance_id = absint( $instance_id );
                    $this->enabled = isset( $this->settings['enabled'] ) ? $this->settings['enabled'] : 'yes';
                    $this->title = isset( $this->settings['title'] ) ? $this->settings['title'] : __( 'Pargo', 'woocommerce' );

                    $this->supports  = array(
                        'shipping-zones',
                        'instance-settings',
                        'instance-settings-modal',
                        'settings'
                    );

                    $this->init_instance_settings();
                    $this->init();

                }

                /**
                 * Init your settings
                 *
                 * @access public
                 * @return void
                 */
                public function init() {
                    // Load the settings API
                    $this->init_form_fields();
                    $this->init_settings();

                    // Save settings in admin if you have any defined
                    add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
                }

                /**
                 * Define settings field for Pargo shipping
                 * @return void
                 */
                public function init_form_fields(){

                    $this->form_fields = array(
                        'pargo_enabled' => array(
                            'title'       => __( 'Enable/Disable', 'woocommerce' ),
                            'type'            => 'checkbox',
                            'label'       => __( 'Enable Pargo', 'woocommerce' ),
                            'default'         => 'yes'
                        ),
                        'pargo_description' => array(
                            'title'       => __( 'Method Description', 'woocommerce' ),
                            'type'            => 'text',
                            'description'     => __( 'This controls the description next to the Pargo delivery method.', 'woocommerce' ),
                            'default'     => __( 'Never miss a delivery again! Choose your most convenient Pargo pickup point', 'woocommerce' ),
                        ),
                         'pargo_use_api' => array(
                            'title'      => __( 'Use backend shipment', 'woocommerce' ),
                            'type'          => 'checkbox',
                        ),
                        'pargo_auth_token' => array(
                            'title'       => __( 'Pargo Auth Token', 'woocommerce' ),
                            'type'            => 'text',
                            'description'     => __( 'This is you unique auth token from Pargo.', 'woocommerce' ),
                            'default'     => __( 'abcdefghijklmnopqrstuvwxyz', 'woocommerce' ),
                        ),
                        'pargo_map_token' => array(
                            'title'       => __( 'Pargo Map Token', 'woocommerce' ),
                            'type'            => 'text',
                            'description'     => __( 'This is you unique map token from Pargo.', 'woocommerce' ),
                            'default'     => __( 'abcdefghijklmnopqrstuvwxyz', 'woocommerce' ),
                        ),
                        'pargo_buttoncaption' => array(
                            'title'       => __( 'Pickup Button Caption Before Pickup Point Selection', 'woocommerce' ),
                            'type'            => 'text',
                            'description'     => __( 'Sets the caption of the button that allows users to choose a Pargo pickup point.', 'woocommerce' ),
                            'default'     => __( 'Select a pick up point', 'woocommerce' ),
                        ),
                        'pargo_buttoncaption_after' => array(
                            'title'       => __( 'Pickup Button Caption After Pickup Point Selection', 'woocommerce' ),
                            'type'            => 'text',
                            'description'     => __( 'Sets the caption of the button after a user has selected a Pargo pickup point.', 'woocommerce' ),
                            'default'     => __( 'Re-select a pick up point', 'woocommerce' ),
                        ),
                        'pargo_style_button' => array(
                            'title'       => __( 'Pickup Button Style', 'woocommerce' ),
                            'type'          => 'textarea',
                            'description'       => __( 'Sets the style of the button pressed to select a pickup point.', 'woocommerce' ),
                            'default'         => ''
                        ),
                        'enable_free_shipping' => array(
                            'title'      => __( 'Enable free shipping', 'woocommerce' ),
                            'type'          => 'checkbox',
                        ),
                        'free_shipping_amount' => array(
                            'title'       => __( 'Set the minimum amount for free shipping', 'woocommerce' ),
                            'type'          => 'number',
                        ),
                        'pargo_style_title' => array(
                            'title'       => __( 'Pargo Point Title Style', 'woocommerce' ),
                            'type'          => 'textarea',
                            'description'       => __( 'Set the style of the selected Pargo Point title.', 'woocommerce' ),
                            'default'         => 'font-size: 16px;font-weight:bold;margin-bottom:0px;margin-top:0px;max-width:250px;'
                        ),
                        'pargo_style_desc' => array(
                            'title'       => __( 'Pargo Point Description Style', 'woocommerce' ),
                            'type'          => 'textarea',
                            'description'       => __( 'Set the style of the selected Pargo Point line items.', 'woocommerce' ),
                            'default'         => 'font-size:12px;margin-bottom:0px;margin-top:0px;max-width:250px;'
                        ),
                        'pargo_style_image' => array(
                            'title'       => __( 'Pargo Point Image Style', 'woocommerce' ),
                            'type'          => 'textarea',
                            'description'       => __( 'Set the style of the selected Pargo Point image', 'woocommerce' ),
                            'default'         => 'max-width:250px;border:1px solid #EBEBEB;border-radius:2px;'
                        ),
                        'weight' => array(
                            'title' => __( 'Weight (kg)', 'woocommerce' ),
                            'type' => 'number',
                            'description' => __( 'Maximum allowed weight per item to use for Pargo delivery', 'woocommerce' ),
                            'id' => 'weight',
                            'default' => 15
                        ),
                        'pargo_cost_5' => array(
                            'title'       => __( '5kg Shipping Cost', 'woocommerce' ),
                            'type'            => 'number',
                            'description'     => __( 'This controls the cost of Pargo delivery for 0-5kg items.', 'woocommerce' ),
                            'default'     => __( '75', 'woocommerce' )
                        ),
                        'pargo_cost_10' => array(
                            'title'       => __( '10kg Shipping Cost', 'woocommerce' ),
                            'type'            => 'number',
                            'description'     => __( 'This controls the cost of Pargo delivery for 5-10kg items.', 'woocommerce' ),
                            'default'     => __( '', 'woocommerce' )
                        ),
                        'pargo_cost_15' => array(
                            'title'       => __( '15kg Shipping Cost', 'woocommerce' ),
                            'type'            => 'number',
                            'description'     => __( 'This controls the cost of Pargo delivery for 10-15kg items.', 'woocommerce' ),
                            'default'     => __( '', 'woocommerce' )
                        ),
                        'pargo_cost' => array(
                            'title'       => __( 'No weight Shipping Cost', 'woocommerce' ),
                            'type'            => 'number',
                            'description'     => __( 'This controls the cost of Pargo delivery without product weight settings.', 'woocommerce' ),
                            'default'     => __( '', 'woocommerce' )
                        ),
                            'pargo_map_display' => array(
                            'title'       => __( 'Pargo map display as static widget', 'woocommerce' ),
                            'type'            => 'checkbox',
                            'description'     => __( 'Display map as a modal or static widget', 'woocommerce' ),
                            'default'     => __( 'yes', 'woocommerce' )
                        )

                    );
                }



                /**
                 * calculate_shipping function.
                 * WC_Shipping_Method::get_option('pargo_cost_10');
                 * @access public
                 * @param mixed $package
                 * @return void
                 */

                public function getPargoSettings(){
                    $pargosetting['pargo_description'] = WC_Shipping_Method::get_option('pargo_description');
                    $pargosetting['pargo_map_token'] = WC_Shipping_Method::get_option('pargo_map_token');
                    $pargosetting['pargo_buttoncaption'] = WC_Shipping_Method::get_option('pargo_buttoncaption');
                    $pargosetting['pargo_buttoncaption_after'] = WC_Shipping_Method::get_option('pargo_buttoncaption_after');
                    $pargosetting['pargo_style_button'] = WC_Shipping_Method::get_option('pargo_style_button');

                    $pargosetting['pargo_style_title'] = WC_Shipping_Method::get_option('pargo_style_title');
                    $pargosetting['pargo_style_desc'] = WC_Shipping_Method::get_option('pargo_style_desc');
                    $pargosetting['pargo_style_image'] = WC_Shipping_Method::get_option('pargo_style_image');

                    return $pargosetting;
                }

                public function calculate_shipping( $package = array() ) {

                    $weight = 0;
                    $cost = 0;
                    $country = $package["destination"]["country"];

                    foreach ( $package['contents'] as $item_id => $values )
                    {
                        $_product = $values['data'];
                        if ($_product->get_weight() == '' || $_product->get_weight() == null ) {
                            $weight = 0;
                        }else{
                            $weight = $weight + $_product->get_weight() * $values['quantity'];
                        }
                    }

                    $weight = wc_get_weight( $weight, 'kg' );


                    if ($weight <= 0) {
                        $cost = WC_Shipping_Method::get_option('pargo_cost');
                    }
                    //change of logic from $weight <=1
                    elseif(  ($weight > 0) && ($weight <= 5)  ) {

                        $cost = WC_Shipping_Method::get_option('pargo_cost_5');

                    } elseif( $weight > 5 && $weight <= 10 ) {

                        $cost = WC_Shipping_Method::get_option('pargo_cost_10');

                    } elseif( $weight >10 && $weight <= 15 ) {

                        $cost = WC_Shipping_Method::get_option('pargo_cost_15');

                    }

                    elseif( $weight > 15) {

                        //$cost=($this->pargocost15*$weight)/15;

                        if( WC()->cart->get_cart_contents_count() > 0){
                            $numitems=WC()->cart->get_cart_contents_count();
                        }

                        $costfor5=WC_Shipping_Method::get_option('pargo_cost_5');
                        $costfor10=WC_Shipping_Method::get_option('pargo_cost_10');
                        $costfor15=WC_Shipping_Method::get_option('pargo_cost_15');

                        //the calculus
                        //global $pargopackages;

                        $firstadd=0;
                        $secondadd=0;
                        //$pargopackages=0;

                        $a = (int) ($weight / 5);
                        $b = (int) ($weight / 10);
                        $c = (int) ($weight / 15);

                        //$pargopackages= min($a, $b ,$c);

                        //$a is the smallest - 5
                        if (($a<=$b) && ($a<=$c)){
                            $firstadd = $a * $costfor5;
                            $d = $weight % 5;
                        }

                        //$b is the smallest - 10
                        if (($b<=$a) && ($b<=$c)){
                            $firstadd = $b * $costfor10;
                            $d = $weight % 10;
                        }

                        //$c is the smallest - 15
                        if (($c<=$a) && ($c<=$b)){
                            $firstadd = $c * $costfor15;
                            $d = $weight % 15;
                        }

                        //second

                        if (($d <= 5) && ($d > 0)){
                            $secondadd=$costfor5;
                            //$pargopackages=$pargopackages+1;
                        }

                        if (($d > 5) && ($d <= 10) && ($d > 0)){
                            $secondadd=$costfor10;
                            //$pargopackages=$pargopackages+1;
                        }

                        if (($d >10) && ($d <= 15) && ($d >0)){
                            $secondadd=$costfor15;
                            //$pargopackages=$pargopackages+1;
                        }

                        $cost=$firstadd+$secondadd;

                        //end calculus
                        //return $pargopackages;

                    }

                    $rate = array(
                        'id' => $this->id,
                        //'label' => '<img src="' . plugin_dir_url( __FILE__ ) . 'images/pargo.png" class="pargo-logo">' . $this->title,

                        'label' => $this->title . ': ' . WC_Shipping_Method::get_option('pargo_description'),
                        'cost' => $cost,
                        'calc_tax' => 'per_item'
                    );

                    if(WC_Shipping_Method::get_option('enable_free_shipping') == 'yes') {
                        global $woocommerce;
                        $total_cart_amount = (int) WC()->cart->cart_contents_total;

                        if ($total_cart_amount >= WC_Shipping_Method::get_option('free_shipping_amount')) {
                            $rate['cost'] = 0;
                            //$rate['description'] = 'Free';
                            $rate['label'] = $this->title . ': Free';
                        }

                    }

                    // Register the rate
                    $this->add_rate( $rate );
                    //return (int) $pargopackages;
                } //end cal shiping

                //end calculate shipping function

            }
        }
    }

    add_action( 'woocommerce_shipping_init', 'pargo_shipping_method' );

    function add_pargo_shipping_method( $methods ) {
        $methods['wp_pargo'] = 'Pargo_Shipping_Method';
        return $methods;
    }

    add_filter( 'woocommerce_shipping_methods', 'add_pargo_shipping_method' );

    /**Yellow Button and Display**/

    add_filter( 'woocommerce_cart_shipping_method_full_label', 'wc_pargo_label_change', 10, 2 );

    function wc_pargo_label_change( $label, $method ) {

        $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
        $chosen_shipping = $chosen_methods[0];

        if ( $chosen_shipping != 'wp_pargo') {
            // if ( $method->method_id != 'pargo') {
            $label = $label;

            unset($_SESSION['pargo_shipping_address']);
        }

        else if ( $method->method_id == 'wp_pargo') {

            //unset($_SESSION['shipping_address']);

            //get the backend settings
            $readyPargoSettings = new Pargo_Shipping_Method();

            $pargoSettings = $readyPargoSettings->getPargoSettings();
            $pargoMerchantUserToken = $pargoSettings['pargo_map_token'];
            $pargoButtonCaptionAfter = $pargoSettings['pargo_buttoncaption_after'];
            $pargo_style_button = $pargoSettings['pargo_style_button'];
            $pargo_style_title = $pargoSettings['pargo_style_title'];
            $pargo_style_desc = $pargoSettings['pargo_style_desc'];
            $pargo_style_image= $pargoSettings['pargo_style_image'];

            //$image = plugins_url( 'images/transparent.png', __FILE__ );
            $image = null;

            $storeName = null;
            $storeAddress = null;
            $businessHours = null;

            if(isset($_SESSION['pargo_shipping_address']['photo'] )){
                $image = $_SESSION['pargo_shipping_address']['photo'];
            }

            if(isset($_SESSION['pargo_shipping_address']['storeName'] )){
                $storeName = $_SESSION['pargo_shipping_address']['storeName'];
            }

            if(isset($_SESSION['pargo_shipping_address']['address1'] )){
                $storeAddress = $_SESSION['pargo_shipping_address']['address1'];
            }
            if(isset($_SESSION['pargo_shipping_address']['businessHours'] )){
                $businessHours = $_SESSION['pargo_shipping_address']['businessHours'];
            }
            /** Area 51 **/
            $pargo_total_cart_amount = (int) WC()->cart->cart_contents_total;
            /** End Area 51 **/

            //button
			$label .= '<label class="pargo-small" for="modal-trigger-center" > [ what is Pargo? ]</label>';					
            $label .= '<div class="pargo-cart"></div>';
            if(get_option('woocommerce_wp_pargo_settings')['pargo_map_display'] === 'no'){
            $label .= '<div id ="pargo_selected_pickup_location">';
            $label .= '<img id="pick-up-point-img" src="'. $image .'" style="' . $pargo_style_image . '"></img>';
            $label .= '<p id="pargoStoreName" style="' . $pargo_style_title . '">'. $storeName .'</p>';
            $label .= '<p id="pargoStoreAddress" style="' . $pargo_style_desc . '">'. $storeAddress .'</p>';
            $label .= '<p id="pargoBusinessHours" style="' . $pargo_style_desc . '">'. $businessHours .'</p>';

            $label .= '<button type="button" id="select_pargo_location_button" class="pargo-button" style="' . $pargo_style_button . '">';

            $label .= $pargoSettings['pargo_buttoncaption'];
            $label .= '</button>';
            }
            $label .= '</div>';
			$label .= '<div class="pargo-modal"><input id="modal-trigger-center" class="checkbox" type="checkbox"><div class="modal-overlay">';
			$label .= '<label for="modal-trigger-center" class="o-close"></label><div class="modal-wrap what-is-this a-center">';
			$label .= '<label for="modal-trigger-center" class="pargo-point-modal-close">X</label>';
			$label .= '<h1>Never miss a delivery again with Pargo!</h1><div class="pargo-row"><div class="pargo-l"><table class="pargo-intro">';
			$label .= '<tr><td>Convenient </td><td>Buy online and collect your parcel from a convenient Pargo Pickup Point instead of waiting for your home delivery.</td></tr>';
			$label .= '<tr><td>Fast</td><td>Delivery within 2-3 days from the moment Pargo receives the parcel (allow an extra 2 days for regional areas).</td></tr>';
			$label .= '<tr><td>Flexible</td><td>Enjoy the flexibility of collecting parcels whenever it suits you, including on weekends and after work at thousands of popular stores nationwide.</td></tr>';
			$label .= '<tr><td>Transparent</td><td>Receive continuous updates on the status of your delivery or track online.</td></tr>';
			$label .= '<tr><td>Secure</td><td>Parcels are tracked at all times and stored in a safe and secure area.</td></tr>';
			$label .= '</table></div><div class="pargo-r"><img src="https://pargo.co.za/external_img/pargo-masc.gif" /></div></div>';
			$label .= '<p class="pargo-t-blue">Join thousands of happy Pargo customers and never miss a delivery again!</p>';
			$label .= '<ul id="pargo-steps"><li><div class="step-inner">';
			$label .= '<img src="https://pargo.co.za/external_img/mag_step1.png" /><p><strong>1. CHOOSE</strong>';
			$label .= 'Choose from a huge network of<br />Pargo Points.</p></div></li><li>';
			$label .= '<div class="step-inner"><img src="https://pargo.co.za/external_img/mag_step2.png" />';
			$label .= '<p><strong>2. NOTIFY</strong>Receive SMS & email notifications<br />when your parcel arrives.</p>';
			$label .= '</div></li><li><div class="step-inner"><img src="https://pargo.co.za/external_img/mag_step3.png" />';	
			$label .= '<p><strong>3. COLLECT</strong>Collect your parcel when it<br />suits you best.</p>';
			$label .= '</div></li></ul></div></div></div>';	
			$label .= '<div class="pargo-modal pargo-modal-insurance"><input id="modal-trigger-insurance" class="checkbox" type="checkbox">';
			$label .= '<div class="modal-overlay"><label for="modal-trigger-insurance" class="o-close"></label>';
			$label .= '<div class="modal-wrap what-is-this a-center"><label for="modal-trigger-insurance" class="pargo-point-modal-close">X</label>';
			$label .= '<h1>Insurance with Pargo deliveries</h1><div class="pargo-row"><div class="pargo-l"><img src="https://pargo.co.za/external_img/claims.gif">';
			$label .= '<p class="pargo-btn-y"><a href="https://pargo.co.za/insurance-policy/" target="_blank">View insurance policy here</a></p></div><div class="pargo-ir">';
			$label .= '<a href="https://pargo.co.za/insurance-policy/" target="_blank"><img src="https://pargo.co.za/external_img/insur-items.png"></a></div></div></div></div></div>';
         
            /** HIDDEN FIELDS **/

            $label .= '<input type="hidden" id="pargomerchantusermaptoken" value="' . $pargoMerchantUserToken . '"/>';
            $label .= '<input type="hidden" id="pargobuttoncaptionafter" value="' . $pargoButtonCaptionAfter . '"/>';

        }

        return $label;


    }

    /** End --- Yellow Button and Display**/

    add_action('woocommerce_after_checkout_validation', 'pargo_after_checkout_validation');

    function pargo_after_checkout_validation( $posted ) {

        if (isset($_SESSION['pargo_shipping_address'])) {
            //unset($_SESSION['shipping_address']);

            add_action('woocommerce_checkout_update_order_meta',function( $order_id, $posted ) {
                $post = $_SESSION['pargo_shipping_address']['pargoPointCode'];
                $pargo_del_add= "" . $_SESSION['pargo_shipping_address']['storeName'] . ", " . $_SESSION['pargo_shipping_address']['storeName'] . ", " . $_SESSION['pargo_shipping_address']['address1'] . ", " . $_SESSION['pargo_shipping_address']['address2'] . ", " . $_SESSION['pargo_shipping_address']['city'] . ", " . $_SESSION['pargo_shipping_address']['province'] . ", " . $_SESSION['pargo_shipping_address']['postalcode'] . "";
                $order = wc_get_order( $order_id );
                $order->update_meta_data( 'pargo_pc', $post  );
                $order->update_meta_data( 'pargo_delivery_add', $pargo_del_add  );
                $order->save();
            } , 10, 2);

        }

    }



    /** End Save Pargo Custom Field **/

    /**
     * Display field value on the order edit page
     */
    add_action( 'woocommerce_admin_order_data_after_billing_address', 'pargo_checkout_field_display_admin_order_meta', 10, 1 );

    function pargo_checkout_field_display_admin_order_meta($order){
        global $woocommerce;
        echo '<p><b>'.__('Pargo Pick Up Address').':</b> ' . get_post_meta( $order->id, 'pargo_delivery_add', true ) . '</p>';
        echo '<p><b>'.__('Pargo Pick Up Point Code').':</b> ' . get_post_meta( $order->id, 'pargo_pc', true ) . '</p>';
    }

    /**End Display custom field value on the order edit page


    /** Pargo Modals **/

    add_action( 'wp_footer', 'pargo_modals' );

    function pargo_modals(){

        echo '<div id="pargo-not-selected" role="dialog" aria-labelledby="mySmallModalLabel">' .
            '<div id="pargo_center">' .
            '<div id="pargo_inner">' .
            '<div class="pargo_blk_title"><center><img src="' . plugin_dir_url( __FILE__ ) . 'images/alert.png" /></center></div>' .
            '<div class="pargo_close">x</div>' .
            '<div class="pargo_content">' .
            '<p>You forgot to select your pick up point!<br />'.
            'Remember, we have pick up locations throughout the country, just pick one!' .
            '</p><img src="' . plugin_dir_url( __FILE__ ) . 'images/click_point.png" />' .
            '</div>' .
            '</div>' .
            '</div>';
        echo '</div>';

    }


    /** End Pargo Modals **/


    //Pargo Weight warning

    function pargo_validate_order( $posted )   {

        $packages = WC()->shipping->get_packages();
        $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
        if( is_array( $chosen_methods ) && in_array( 'wp_pargo', $chosen_methods ) ) {
            foreach ( $packages as $i => $package ) {

                if ( $chosen_methods[ $i ] != "wp_pargo" ) {
                    continue;
                }

                $Pargo_Shipping_Method = new Pargo_Shipping_Method();
                $weightLimit = (int) $Pargo_Shipping_Method->settings['weight'];
                $weight = 0;

                foreach ( $package['contents'] as $item_id => $values )
                {
                    $_product = $values['data'];
                    $weight = $_product->get_weight();
                }

                $weight = wc_get_weight( $weight, 'kg' );

                if( $weight > $weightLimit ) {

                    $message = sprintf( __( 'Sorry, something in your cart of %d kg exceeds the maximum weight of %d kg allowed for %s', 'woocommerce' ), $weight, $weightLimit, $Pargo_Shipping_Method->title );

                    $messageType = "error";

                    if( ! wc_has_notice( $message, $messageType ) ) {
                        wc_add_notice( $message, $messageType );
                    }
                }
            }
        }
    }//end function Pargo weight warning

    add_action( 'woocommerce_review_order_before_cart_contents', 'pargo_validate_order' , 10 );

    add_action( 'woocommerce_after_checkout_validation', 'pargo_validate_order' , 10 );



    //get customer default shipping address

    add_action( 'woocommerce_review_order_after_submit', 'pargo_get_customer_default_shipping_details',  10  );
    function pargo_get_customer_default_shipping_details($order_id){
        //global $woocommerce;

    }

    //end get customer default shipping address
    //Clear session Data when order button is pressed or replace shipping address with defualt address

    add_action('woocommerce_thankyou', 'pargo_clear_shipping_address_session');

    function pargo_clear_shipping_address_session( $order_id ) {
        //unset($_SESSION['pargo_shipping_address']);
        //re-add.shipping adress here.
        //pargo_validate_order
        //$array = WC_API_Customers::get_customer_billing_address();
    }

    add_action( 'woocommerce_order_details_after_order_table', 'pargo_custom_field_display_cust_order_meta', 10, 1 );

    function pargo_custom_field_display_cust_order_meta($order){

        if(isset($_SESSION['pargo_shipping_address']['storeName'] )){
            $storeName = $_SESSION['pargo_shipping_address']['storeName'];
        }
        if(isset($_SESSION['pargo_shipping_address']['address1'] )){
            $storeAddress = $_SESSION['pargo_shipping_address']['address1'];
        }
        if(isset($_SESSION['pargo_shipping_address']['address1'] )){
            echo '<p><strong>'.__('Pargo Pickup Address').':</strong> ' . $storeName . '. ' . $storeAddress . '</p>';
            //echo '<p><strong>'.__('Pargo Pickup PUP Number').':</strong> ' . get_post_meta( $order->id, 'pargo_pc', true ). '</p>';
            //echo '<p><strong>'.__('Pickup Date').':</strong> ' . get_post_meta( $order->id, 'Pickup Date', true ). '</p>';
        }

        if(isset($_SESSION['pargo_shipping_address'] )){
            unset($_SESSION['pargo_shipping_address']);
        }

    }
    add_filter( 'style_loader_src',  'sdt_remove_ver_css_js', 9999, 2 );
add_filter( 'script_loader_src', 'sdt_remove_ver_css_js', 9999, 2 );

function sdt_remove_ver_css_js( $src, $handle )
{
    $handles_with_version = [ 'style' ]; // <-- Adjust to your needs!

    if ( strpos( $src, 'ver=' ) && ! in_array( $handle, $handles_with_version, true ) )
        $src = remove_query_arg( 'ver', $src );

    return $src;
}


add_action( 'woocommerce_review_order_before_payment', 'add_box_option_to_checkout' );
function add_box_option_to_checkout( $method ) {

    echo
    woocommerce_form_field( 'parcel_test', array(
        'type'          => 'checkbox',
        'class'         => array('add_gift_box form-row-wide'),
        'label'         => __('Insure your parcel?'),
        'placeholder'   => __(''),
        ), WC_Checkout::get_value( 'parcel_test' ));

}

add_action( 'wp_footer', 'woocommerce_add_gift_box' );
function woocommerce_add_gift_box() {
    if (is_checkout()) {
    ?>
    <script type="text/javascript">
    jQuery( document ).ready(function( $ ) {
        $('#parcel_test').click(function(){
            jQuery('body').trigger('update_checkout');
        });
    });

    </script>
    <?php
    }
}


add_action( 'woocommerce_cart_calculate_fees', 'woo_add_cart_fee' );
function woo_add_cart_fee( $cart ){
        if ( ! $_POST || ( is_admin() && ! is_ajax() ) ) {
        return;
    }

    if ( isset( $_POST['post_data'] ) ) {
        parse_str( $_POST['post_data'], $post_data );
    } else {
        $post_data = $_POST; // fallback for final checkout (non-ajax)
    }

    if (isset($post_data['parcel_test'])) {
        if( WC()->cart->cart_contents_total  <= 2000) {
            $insurance_fee = 20;
        }
        else{
            $insurance_fee =  WC()->cart->cart_contents_total - (WC()->cart->cart_contents_total * (99/100));
        }
        WC()->cart->add_fee( 'Shipping insurance:',         $insurance_fee);
    }

}


            if(get_option('woocommerce_wp_pargo_settings')['pargo_map_display'] === 'yes'){

   add_action( 'woocommerce_review_order_before_payment', function() {
        echo '<div style="display: none" class="pargo-info-box"><p>Selected pick-up point:</p>';
        echo '<img id="pargo-store-img" width="35" height="25" style="float: left;margin-right: 10px;" src=""> <p id="pargo-store-name" style="margin-bottom: 2px"></p>';
        echo '<p id="pargo-store-address" style="margin-bottom: 2px"></p>';
        echo '<p class="opening-hours-pargo-btn" style="margin-left: 45px;margin-bottom:2px;cursor: pointer;text-decoration: underline;color: blue">Opening hours and details</p>';
        echo '<div><p class="open-hours-pargo-info" style="margin-left: 45px;display: none" id="pargo-store-hours"></p></div>';
        echo '<button type="button" class="pargo-toggle-map" style="margin-bottom: 20px">Choose a different pick-up point</button></div>';
        echo '<a id="pargo-block" href="#pargo-block-map"></a><iframe style="border: none;display: none" name="iframe" id="pargo_map_block" height="400px" width="100%" src="https://map.pargo.co.za/?token=YQw7kd9fQAdkxKefS3GW8PNCRXBuqg"></iframe>';
    });
   }

}

