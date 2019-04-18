<?php
wp_register_script('prefix_bootstrap', '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js');
wp_enqueue_script('prefix_bootstrap');

wp_register_style('prefix_bootstrap', '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css');
wp_enqueue_style('prefix_bootstrap');

global $wpdb;
$table = $wpdb->prefix . 'postmeta';

$data = $wpdb->get_row("SELECT * FROM  $table WHERE  meta_key = 'pargo_consent'");

if (count((array)$data->meta_key) == 0) {

} else {
    //$wpdb->update($table, array("meta_key"=> 'pargo_settings',"meta_value" => $request));
    header('Location: admin.php?page=pargo-shipping');
}


function pluginInstalled()
{

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

}

function pluginOptIn()
{

    global $wpdb;
    $table = $wpdb->prefix . 'postmeta';

    $data = $wpdb->get_row("SELECT * FROM  $table WHERE  meta_key = 'pargo_consent'");

    if (count((array)$data->meta_key) == 0) {
        $wpdb->insert($table, array("meta_key" => 'pargo_consent', "meta_value" => 'YES'));
    } else {
        //$wpdb->update($table, array("meta_key"=> 'pargo_settings',"meta_value" => $request));
        $wpdb->query($wpdb->prepare("UPDATE $table SET meta_value=%s WHERE meta_key='pargo_consent'", 'YES'));
    }

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
        'status' => 'OPT-IN',
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

function processOptIn()
{
    pluginOptIn();
    pluginInstalled();
}

function pluginOptOut()
{

    global $wpdb;
    $table = $wpdb->prefix . 'postmeta';

    $data = $wpdb->get_row("SELECT * FROM  $table WHERE  meta_key = 'pargo_consent'");

    if (count((array)$data->meta_key) == 0) {
        $wpdb->insert($table, array("meta_key" => 'pargo_consent', "meta_value" => 'NO'));
    } else {
        //$wpdb->update($table, array("meta_key"=> 'pargo_settings',"meta_value" => $request));
        $wpdb->query($wpdb->prepare("UPDATE $table SET meta_value=%s WHERE meta_key='pargo_consent'", 'NO'));
    }

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
        'status' => 'OPT-OUT',
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

if (isset($_POST['optin']) && $_POST['optin'] === 'yes') {
    processOptIn();
    header('Location: admin.php?page=pargo-shipping');
} elseif (isset($_POST['optin']) && $_POST['optin'] === 'no') {
    pluginOptOut();
    header('Location: admin.php?page=pargo-shipping');
}

?>


<div class="container-fluid">
    <div class="row">
        <div class="col-6">

            <div class="card">
                <img class="card-img-top w-25 h-25"
                     src="https://pargo.co.za/wp-content/themes/pargo/assets/img/logo.svg" alt="Card image cap">
                <div class="card-body">
                    <h4 class="pt-3">Hi <?php echo wp_get_current_user()->user_login; ?>. Thank you for installing the
                        Pargo Click and Collect plugin.</h4>
                    <h5 class="text-muted">Plugin tracking activity and usage permissions</h5>
                    <p class="lead">
                        Pargo will collect your activity and usage information to better improve the service we provide.
                        Please let us know if you would like Pargo to track your activity and usage.
                    </p>
                    <form method="post"
                          action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?page=pargo-shipping-optin'; ?>">

                        <div class="row">
                            <div class="col-4">
                                <div class="custom-control custom-radio">
                                    <input type="radio" value="yes" checked="checked" id="optin1" name="optin"
                                           class="custom-control-input">
                                    <label class="custom-control-label" for="optin1">Yes</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="custom-control custom-radio">
                                    <input type="radio" value="no" id="optin2" name="optin"
                                           class="custom-control-input">
                                    <label class="custom-control-label" for="optin2">No</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary float-right">Next</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>

        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Need some more guidance?</h5>
                    <p class="card-text">A Pargo advisers will be able to assist you with any question you. </p>
                    <a href="mailto:support@pargo.co.za" class="btn btn-primary">Send an email</a>
                    <a href="tel:+27214473636" class="btn btn-primary">Dial for support</a>

                    <div class="embed-responsive embed-responsive-4by3 mt-2">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/isrTTUVCMtI"></iframe>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

