<?php defined( 'ABSPATH' ) or die(); ?>
<div class="wrap license-container">
	<div class="panel panel-primary panel-default content-panel ">
        <div class="panel-body">
			<img src="<?php echo WEBLIZAR_NALF_PLUGIN_URL; ?>/images/aclp.jpg" class="img-responsive"> 
        </div>
    </div>
	<div class="clearfix"></div>
	<div class="column-6-right">
		<div class="Configuration_btn">	
			<a class="conf_btn" href="<?php echo get_admin_url(); ?>admin.php?page=admin_custom_login"><?php _e( "Plugin Configuration Click Here", WEBLIZAR_ACL ); ?></a>
			<a class="conf_btn" href="https://weblizar.com/plugins/admin-custom-login-pro/" target="_blank"><?php _e( "Buy Pro", WEBLIZAR_ACL ); echo "$25" ?></a>
			<a class="conf_btn" href="http://demo.weblizar.com/admin-custom-login-pro/wp-login.php" target="_blank"><?php _e( "Admin Demo", WEBLIZAR_ACL ); ?></a>
		</div>
	</div>
</div>
<style type="text/css">
	.Configuration_btn {
    margin-top: 10px;
    text-align: center;
}
</style>