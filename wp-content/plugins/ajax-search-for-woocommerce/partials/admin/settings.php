<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="wrap">

	<h2><?php _e( 'AJAX Search for WooCommerce Settings', 'ajax-search-for-woocommerce' ); ?></h2>

    <?php echo DGWT_WCAS()->backwardCompatibility->notice(); ?>


<?php $settings->show_navigation(); ?>
	<?php $settings->show_forms(); ?>

</div>