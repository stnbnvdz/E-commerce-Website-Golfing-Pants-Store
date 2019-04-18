<?php
/**
** Register post type store
**/
function wps_store_post_type() {
	$labels = array(
		'name'                  => _x( 'Stores', 'Post Type General Name', 'wc-pickup-store' ),
		'singular_name'         => _x( 'Store', 'Post Type Singular Name', 'wc-pickup-store' ),
		'menu_name'             => __( 'Stores', 'wc-pickup-store' ),
		'name_admin_bar'        => __( 'Store', 'wc-pickup-store' ),
		'archives'              => __( 'Store Archives', 'wc-pickup-store' ),
		'attributes'            => __( 'Store Attributes', 'wc-pickup-store' ),
		'parent_item_colon'     => __( 'Parent Store:', 'wc-pickup-store' ),
		'all_items'             => __( 'All Stores', 'wc-pickup-store' ),
		'add_new_item'          => __( 'Add New Store', 'wc-pickup-store' ),
		'add_new'               => __( 'Add New Store', 'wc-pickup-store' ),
		'new_item'              => __( 'New Store', 'wc-pickup-store' ),
		'edit_item'             => __( 'Edit Store', 'wc-pickup-store' ),
		'update_item'           => __( 'Update Store', 'wc-pickup-store' ),
		'view_item'             => __( 'View Store', 'wc-pickup-store' ),
		'view_items'            => __( 'View Stores', 'wc-pickup-store' ),
		'search_items'          => __( 'Search Store', 'wc-pickup-store' ),
		'not_found'             => __( 'Not found', 'wc-pickup-store' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'wc-pickup-store' ),
		'featured_image'        => __( 'Featured Image', 'wc-pickup-store' ),
		'set_featured_image'    => __( 'Set featured image', 'wc-pickup-store' ),
		'remove_featured_image' => __( 'Remove featured image', 'wc-pickup-store' ),
		'use_featured_image'    => __( 'Use as featured image', 'wc-pickup-store' ),
		'insert_into_item'      => __( 'Insert into item', 'wc-pickup-store' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'wc-pickup-store' ),
		'items_list'            => __( 'Items list', 'wc-pickup-store' ),
		'items_list_navigation' => __( 'Items list navigation', 'wc-pickup-store' ),
		'filter_items_list'     => __( 'Filter items list', 'wc-pickup-store' ),
	);
	$args = array(
		'label'                 => __( 'Store', 'wc-pickup-store' ),
		'description'           => __( 'Stores', 'wc-pickup-store' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', ),
		'taxonomies'            => array(),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-store',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'rewrite' => array(
			'slug' => 'store',
		)
	);
	register_post_type( 'store', $args );
}
add_action('init', 'wps_store_post_type');

/**
** Show field in column
**/
function wps_store_id_columns($columns) {
	$new = array();
	unset($columns['date']);

	foreach($columns as $key => $value) {
		if($key == 'title') {
			$new['store_id'] = __('ID', 'wc-pickup-store');
		}
		$new[$key] = $value;
	}
	$new['checkout_visibility'] = __('Exclude in Checkout?', 'wc-pickup-store');

	return $new;
}
add_filter('manage_edit-store_columns', 'wps_store_id_columns');

function wps_store_id_column_content($name, $post_id) {
	$exclude_store = get_post_meta($post_id, '_exclude_store', true);
	switch ($name) {
		case 'store_id':
			echo '<a href="' . get_edit_post_link($post_id) . '">' . $post_id . '</a>';
		break;
		case 'checkout_visibility':
			echo ($exclude_store == 1) ? __('Yes', 'wc-pickup-store') : __('No', 'wc-pickup-store');
		break;
	}
}
add_filter('manage_store_posts_custom_column', 'wps_store_id_column_content', 10, 2);

/**
** Activar stores para dropdown checkout
**/
function wps_store_post_meta_box() {
	add_meta_box('checkout-visibility', __( 'Checkout Visibility', 'wc-pickup-store' ), 'wps_store_metabox_content', 'store', 'side', 'high');
	add_meta_box('store-fields', __( 'Store Fields', 'wc-pickup-store' ), 'wps_store_metabox_details_content', 'store', 'normal', 'high');
}
add_action('add_meta_boxes', 'wps_store_post_meta_box');

function wps_store_metabox_content($post) {
	// Display code/markup goes here. Don't forget to include nonces!
	$pid = $post->ID;	
	$exclude_store = get_post_meta( $pid, '_exclude_store', true );

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'wps_store_save_content', 'wps_store_metabox_nonce' );
	?>

	<div class="container_data_metabox">
		<div class="sub_data_poker">
			<p><strong><?php _e('Exclude store in checkout.', 'wc-pickup-store'); ?></strong></p>
			<input type="checkbox" name="exclude_store" class="form-control" <?php checked($exclude_store, 1) ?> />
			
			<input type="hidden" name="save_data_form_custom" value="1"/>
		</div>
	</div>

	<?php
}

function wps_store_metabox_details_content($post) {
	// Display code/markup goes here. Don't forget to include nonces!
	$pid = $post->ID;	
	$city = get_post_meta( $pid, 'city', true );
	$phone = get_post_meta( $pid, 'phone', true );
	$map = get_post_meta( $pid, 'map', true );
	$waze = get_post_meta( $pid, 'waze', true );
	$description = get_post_meta( $pid, 'description', true );
	$address = get_post_meta( $pid, 'address', true );
	$store_shipping_cost = get_post_meta( $pid, 'store_shipping_cost', true );
	$wc_pickup_store_method = new WC_PICKUP_STORE();

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'wps_store_save_content', 'wps_store_metabox_nonce' );
	?>
	<table class="form-table">
		<?php if($wc_pickup_store_method->costs_per_store == 'yes') : ?>
			<tr>
				<th><?php _e('Store shipping cost', 'wc-pickup-store') ?></th>
				<td>
					<input type="text" name="store_shipping_cost" class="regular-text" value="<?= $store_shipping_cost ?>">
			</tr>
		<?php endif; ?>
	
		<tr>
			<th><?php _e('City', 'wc-pickup-store') ?></th>
			<td>
				<input type="text" name="city" class="regular-text" value="<?= $city ?>">
			</td>
		</tr>
		<tr>
			<th><?php _e('Phone', 'wc-pickup-store') ?></th>
			<td>
				<input type="text" name="phone" class="regular-text" value="<?= $phone ?>">
			</td>
		</tr>
		<tr>
			<th><?php _e('Waze', 'wc-pickup-store') ?></th>
			<td>
				<textarea name="waze" class="large-text" rows="3"><?= $waze ?></textarea>
				<p class="description"><?= __('Link de waze', 'wc-pickup-store') ?></p>
			</td>
		</tr>
		<tr>
			<th><?php _e('Map', 'wc-pickup-store') ?></th>
			<td>
				<textarea name="map" class="large-text" rows="5"><?= $map ?></textarea>
			</td>
		</tr>
		<tr>
			<th><?php _e('Short description', 'wc-pickup-store') ?></th>
			<td>
				<?php
					$settings = array('textarea_name' => 'description', 'editor_height' => 75);
					wp_editor($description, 'description', $settings );
				?>
			</td>
		</tr>
		<tr>
			<th><?php _e('Address', 'wc-pickup-store') ?></th>
			<td>
				<?php
					$settings = array('textarea_name' => 'address', 'editor_height' => 75);
					wp_editor($address, 'address', $settings );
				?>
			</td>
		</tr>
	</table>

	<?php
}

function wps_store_save_content($post_id) {
	// Check if our nonce is set.
	if ( ! isset( $_POST['wps_store_metabox_nonce'] ) ) { return; }

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['wps_store_metabox_nonce'], 'wps_store_save_content' ) ) { return; }

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }

	// Make sure that it is set.
	// if ( ! isset( $_POST['exclude_store'] ) ) { return; }

	$checked = isset( $_POST['exclude_store'] ) ? 1 : 0;
	update_post_meta( $post_id, '_exclude_store', $checked );
	update_post_meta( $post_id, 'city', sanitize_text_field($_POST['city']) );
	update_post_meta( $post_id, 'phone', sanitize_text_field($_POST['phone']) );
	update_post_meta( $post_id, 'waze', esc_url($_POST['waze']) );
	update_post_meta( $post_id, 'map', sanitize_textarea_field($_POST['map']) );
	update_post_meta( $post_id, 'description', wp_kses_data($_POST['description']));
	update_post_meta( $post_id, 'address', wp_kses_data($_POST['address']));

	if(isset($_POST['store_shipping_cost'])) {
		update_post_meta( $post_id, 'store_shipping_cost', sanitize_text_field($_POST['store_shipping_cost']));
	}
}
add_action('save_post', 'wps_store_save_content');

/**
** Single store template
**/
function wps_single_store_template($template) {
	if (is_singular('store') && $template !== locate_template(array("single-store.php"))) {
		$template = plugin_dir_path(__DIR__) . 'templates/single-store.php';
	}

	return $template;
}
add_filter('single_template', 'wps_single_store_template');

/**
** Archive Template
**/
function wps_store_archive_template($archive_template) {
	if (is_post_type_archive('store') && $archive_template !== locate_template(array("archive-store.php"))) {
		$archive_template = plugin_dir_path(__DIR__) . 'templates/archive-store.php';
	}

	return $archive_template;
}
add_filter('archive_template', 'wps_store_archive_template');