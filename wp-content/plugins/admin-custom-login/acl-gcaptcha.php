<?php
class ACL_gcaptcha_Login_Form {

	/** @type string private key|public key */
	private $public_key, $private_key;

	/** class constructor */
	public function __construct() {
		$g_page = unserialize(get_option('Admin_custome_login_gcaptcha'));
		if(isset($g_page['site_key']) && isset($g_page['secret_key'])){
			$site_key = $g_page['site_key'];
			$secret_key = $g_page['secret_key'];
			$acl_gcaptcha_theme = $g_page['acl_gcaptcha_theme'];
		} else {
			$site_key = '';
			$secret_key = '';
			$acl_gcaptcha_theme ='yes';
		}
   
		$this->public_key  = $site_key;
		$this->private_key = $secret_key;
        $this->acl_gcaptcha_theme = $acl_gcaptcha_theme;

		// adds the captcha to the login form
		add_action( 'login_form', array( $this, 'captcha_display' ) );

		// authenticate the captcha answer
		add_action( 'wp_authenticate_user', array( $this, 'validate_captcha_field' ), 10, 2 );
	}

	/** Output the ACL_gcaptcha form field. */
	public function captcha_display() {
		if($this->acl_gcaptcha_theme=="yes"){
			$acl_gcaptcha_theme="light";
		} else {
			$acl_gcaptcha_theme="dark";
		}
		?>
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
		<div class="g-recaptcha" data-theme="<?php echo $acl_gcaptcha_theme; ?>" data-sitekey="<?php echo $this->public_key; ?>" 
			style="margin-bottom:20px;"></div>
		<noscript>
			<div>
				<div style="width: 302px; height: 422px; position: relative;">
					<div style="width: 302px; height: 422px; position: absolute;">
						<iframe src="https://www.google.com/recaptcha/api/fallback?k=<?=$this->public_key;?>" frameborder="0" scrolling="no"
						style="width: 302px; height:422px; border-style: none;">
						</iframe>
					</div>
				</div>
				<div style="width: 300px; height: 60px; border-style: none;
				bottom: 12px; left: 25px; margin: 0px; padding: 0px; right: 25px;
				background: #f9f9f9; border: 1px solid #c1c1c1; border-radius: 3px;">
				<textarea id="g-recaptcha-response" name="g-recaptcha-response"
					class="g-recaptcha-response"
					style="width: 250px; height: 40px; border: 1px solid #c1c1c1;
					margin: 10px 25px; padding: 0px; resize: none;" >
					</textarea>
				</div>
			</div>
		</noscript>
		<?php
	}

	/**
	 * Verify the captcha answer
	 *
	 * @param $user string login username
	 * @param $password string login password
	 *
	 * @return WP_Error|WP_user
	 */
	public static function validate_captcha_field( $user, $password ) {

		if ( ! isset( $_POST['g-recaptcha-response'] ) || ! self::captcha_verification() ) {
			return new WP_Error( 'empty_captcha', '<strong>ERROR</strong>: Please confirm you are not a robot' );
		}
		return $user;
	}
	
	/**
	 * Send a GET request to verify captcha challenge
	 *
	 * @return bool
	 */
	public static function captcha_verification() {

		$response = isset( $_POST['g-recaptcha-response'] ) ? esc_attr( $_POST['g-recaptcha-response'] ) : '';
		$remote_ip = $_SERVER["REMOTE_ADDR"];

		// make a GET request to the Google reCAPTCHA Server
		$g_page = unserialize(get_option('Admin_custome_login_gcaptcha'));
		if(isset($g_page['site_key']) && isset($g_page['secret_key'])){
			$site_key = $g_page['site_key'];
			$secret_key = $g_page['secret_key'];
		} else {
			$site_key = '';
			$secret_key = '';
		}
		$request = wp_remote_get (
			'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $response . '&remoteip=' . $remote_ip
		);

		// get the request response body
		$response_body = wp_remote_retrieve_body( $request );
		$result = json_decode( $response_body, true );
		return $result['success'];
	}
}
new ACL_gcaptcha_Login_Form();
?>