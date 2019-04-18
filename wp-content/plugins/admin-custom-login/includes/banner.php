<?php

if ( ! defined( 'ABSPATH' ) ) exit;
$acl_imgpath = WEBLIZAR_NALF_PLUGIN_URL."images/aclp.png";
$acl_bg_imgpath =  WEBLIZAR_NALF_PLUGIN_URL."images/bg.jpg";
?>
<div class="wb_plugin_feature notice  is-dismissible">
	<div class="wb_plugin_feature_banner default_pattern pattern_ ">
	<div class="wb-col-md-6 wb-col-sm-12 wb-text-center institute_banner_img">
	<h2>  Admin Custom Login Pro </h2>
		<img class="wp-img-responsive" src="<?php echo $acl_imgpath; ?>" alt="img">
	</div>
		<div class="wb-col-md-6 wb-col-sm-12 wb_banner_featurs-list"><?php _e('', WEBLIZAR_ACL)?>
			<span><h2>Admin Custom Login Pro Features</h2></span>
			<ul>
				<li> <?php _e('Max Login Retry', WEBLIZAR_ACL)?></li>
				<li> <?php _e('Login With Access Token', WEBLIZAR_ACL)?></li>
				<li> <?php _e('Freeze Login Form On Brute Force Attack', WEBLIZAR_ACL)?></li>
				<li> <?php _e('Unfreeze Login Form By Admin', WEBLIZAR_ACL)?></li>
				<li> <?php _e('Social Media Login', WEBLIZAR_ACL)?></li>
				<li> <?php _e('Login Restriction By User Roles', WEBLIZAR_ACL)?></li>					
				<li> <?php _e('Ban User', WEBLIZAR_ACL)?>(s) <?php _e('Login Access', WEBLIZAR_ACL)?></li>
				<li> <?php _e('Max User Access Management', WEBLIZAR_ACL)?></li>
				<li> <?php _e('Restrict Unauthorized IP', WEBLIZAR_ACL)?></li>
				<li> <?php _e('Import Export Settings', WEBLIZAR_ACL)?></li>
				<li> <?php _e('Login Form Logo', WEBLIZAR_ACL)?></li>
				<li> <?php _e('Redirect Users After Login', WEBLIZAR_ACL)?></li>
				<li> <?php _e('Google reCpatcha', WEBLIZAR_ACL)?></li>
				
			</ul>
		<div class="wp_btn-grup">
			<a class="wb_button-primary"  href="http://demo.weblizar.com/admin-custom-login-pro/wp-login.php" target="_blank">View Demo</a>
			<a class="wb_button-primary" href="https://weblizar.com/plugins/admin-custom-login-pro/" target="_blank">Buy Now $25</a>
		</div>
		<div class="plugin_vrsion"> <span> <b> 5.7 </b> Version  </span> </div>
		</div>
</div>
</div>
<style type="text/css">
	.wb-col-md-12{
	width:100%;
}
.wb_plugin_feature{
	color:#fff;
}
.wb-text-center{
	text-align:center;
}

.wp-img-responsive{
	max-width:100%;
}

.wb_plugin_feature_banner.default_pattern {
   box-shadow: 0px 2px 20px #818181;
    margin: 40px 0px;
    background: linear-gradient(-67deg, #e53637 57%, rgba(4, 4, 4, 0.65) 39%), url(<?php echo $acl_bg_imgpath; ?>);
    float: left;
    display: block;
    clear: right;
    width: 98%;
    position: relative;
}
.wb_banner_featurs-list ul {
    list-style: decimal;
	color:#fff;
    display: inline-block;
}

.wb_button-primary {
    padding: 15px 20px;
    color: #fff;
    text-decoration: none;
    margin: 5px;
    border-radius: 4px;
    box-shadow: 2px 2px 5px #1111113d;
    background-color: #3d9b3d;
}
.wp_btn-grup .wb_button-primary {
    width: 100%;
}
.plugin_vrsion {
    position: absolute;
    background: #55505a;
    border-radius: 0px 0px 0px 52px;
    padding: 15px 30px;
    right: 0px;
    /* border: 1px solid; */
    font-size: 18px;
    top: 0;
    box-shadow: -6px 5px 7px hsla(187, 1%, 15%, 0.3);
}
.wb_banner_featurs-list ul li {
    margin: 7px 20px;
    font-size: 14px;

}
.wb_banner_featurs-list h2 {
    border-bottom:2px solid #fff;
}
.wp_btn-grup {
    display: flex;
	text-align:center;
}
/*--media-responsive csss--*/
@media (min-width: 901px){
.wb_banner_featurs-list ul li {
    float: left;
    width: 42%
}

.wb-col-md-6{
	float:left;
	width:50%;
}
.wp_btn-grup {
    margin: 0 auto;
    width: 60%;
}
}

@media (max-width: 900px){
.wb-col-sm-12{
	width:100%;
}
.wb_plugin_feature_banner.default_pattern {
    background: linear-gradient(0deg, #e53637 57%, rgba(4, 4, 4, 0.74) 39%), url(./img/bg.jpg);
}
.wb_plugin_feature_banner{
	float:none;
}
.wb-col-sm-6{
	float:left;
	width:50%;
}
}

.wb_plugin_feature_banner.pattern_2 {
    background: linear-gradient(17deg, #663399 -16%, #ee3e3f 70%, #440e0e 93%), url(./img/bg.jpg);
}

.wb_plugin_feature_banner.pattern_3 {
    background: linear-gradient(17deg, #6f3f9e -16%, #d63131de 93%), url(./img/bg-3.jpg);
    background-repeat: repeat-x;
}
a.wb_button-primary:hover,
	a.wb_button-primary:focus {
    color: #f1f1f1;
    text-decoration: none;
}
</style>
