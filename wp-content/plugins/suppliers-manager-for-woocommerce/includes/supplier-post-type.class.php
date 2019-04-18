<?php

if (!class_exists('FT_SMFW_Supplier_Post_Type')) {
    class FT_SMFW_Supplier_Post_Type
    {
		// Contructor
		// ----------

		public function __construct()
		{
            $this->init_hooks(); // Init hooks in Wordpress
            $this->init_filters(); // Init filters
		}

        public function init_hooks()
        {
            add_action('init', array($this, 'register_post_type'), 5); // Register custom post type
            add_action('manage_'. FT_SMFW_POST_TYPE .'_posts_custom_column' , array($this, 'populate_columns'), 10, 2);
            add_action('wp_trash_post', array($this, 'trash_post'));
        }

    	/**
    	 * Initiate plugin filters in Wordpress
    	 */
        public function init_filters()
        {
            add_filter('manage_'. FT_SMFW_POST_TYPE .'_posts_columns', array($this, 'register_columns'));

            if (isset($_REQUEST['post_type']) && (FT_SMFW_POST_TYPE == $_REQUEST['post_type']))
                add_filter('months_dropdown_results', '__return_empty_array');
        }

        /**
         * Register the custom post type "ft_supplier" in Wordpress Core
         */
        public function register_post_type()
        {
            if (post_type_exists(FT_SMFW_POST_TYPE)) {
    			return;
    		}

            //register post type
            return register_post_type(FT_SMFW_POST_TYPE,
                array(
                    'labels' => array(
                        'name'               => __('All suppliers', FT_SMFW_TEXT_DOMAIN),
                        'singular_name'      => __('Supplier', FT_SMFW_TEXT_DOMAIN),
                        'menu_name'          => __('Suppliers', FT_SMFW_TEXT_DOMAIN),
                        'add_new'            => __('New', FT_SMFW_TEXT_DOMAIN),
                        'add_new_item'       => __('New supplier', FT_SMFW_TEXT_DOMAIN),
                        'new_item'           => __('New supplier', FT_SMFW_TEXT_DOMAIN),
                        'edit_item'          => __('Edit', FT_SMFW_TEXT_DOMAIN),
                        'view_item'          => __('Show', FT_SMFW_TEXT_DOMAIN),
                        'all_items'          => __('All suppliers', FT_SMFW_TEXT_DOMAIN),
                        'search_items'       => __('Search supplier', FT_SMFW_TEXT_DOMAIN),
                        'parent_item_colon'  => '',
                        'not_found'          => __('No supplier found…', FT_SMFW_TEXT_DOMAIN),
                        'not_found_in_trash' => __('No supplier found in trash…', FT_SMFW_TEXT_DOMAIN),
                    ),
                    'description'       => __('Description', FT_SMFW_TEXT_DOMAIN),
                    'public'            => true,
                    'publicly_queryable'=> true,
                    'show_ui'           => true,
                    'show_in_menu'      => false,
                    'query_var'         => true,
                    'hierarchical'      => false,
                    'supports'          => array('title', 'editor'),
                    'rewrite'           => array('slug' => 'supplier', 'with_front' => 'true'),
                    'capability_type'   => 'post',
                    'map_meta_cap'      => true,
                )
            );
        }

        /**
         * Create custom columns in suppliers table
         */
        public function register_columns($columns)
        {
            unset($columns['date']);
            $columns[FT_SMFW_POST_TYPE . '_nb_products'] = __('Number of products', FT_SMFW_TEXT_DOMAIN);

            return $columns;
        }

        /**
         * Custom columns in suppliers table
         */
        public function populate_columns($column, $post_id)
        {
            $supplier = new FT_SMFW_supplier($post_id);

            switch ($column) :
                case FT_SMFW_POST_TYPE . '_nb_products' :
                    _e(count($supplier->getProducts()) ? count($supplier->getProducts()) : "-");
                    break;
            endswitch;
        }

        /**
         * When we move a supplier to the trash
         */
        public function trash_post($post_id)
        {
            // Delete products link
            $supplier = new FT_SMFW_Supplier($post_id);
            $products = $supplier->getProducts();

            foreach ($products as $product) {
                delete_post_meta($product->get_id(), 'ft_smfw_supplier');
                delete_post_meta($product->get_id(), 'ft_smfw_supplier_price');
                delete_post_meta($product->get_id(), 'ft_smfw_supplier_packaging');
            }
        }
	}
}

// Launch plugin
new FT_SMFW_Supplier_Post_Type();
