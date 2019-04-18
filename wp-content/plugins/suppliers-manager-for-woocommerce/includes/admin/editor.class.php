<?php

if (!class_exists('FT_SMFW_editor')) {
    class FT_SMFW_editor
    {
        // +-------------------+
		// | CLASS CONSTRUCTOR |
		// +-------------------+

		public function __construct()
		{
            $this->init_hooks(); // Init hooks in Wordpress
            $this->init_filters(); // Init filters in Wordpress
		}

        // +---------------+
        // | CLASS METHODS |
        // +---------------+

    	/**
    	 * Initiate plugin hooks in Wordpress
    	 */
        public function init_hooks()
        {
            add_action('admin_init', array($this, 'admin_init'));
            add_action('save_post_' . FT_SMFW_POST_TYPE, array($this, 'save_post'), 10, 3);
            // add remove_post action => remove supplier for products linked
        }

    	/**
    	 * Initiate plugin filters in Wordpress
    	 */
        public function init_filters()
        {
            add_filter('enter_title_here', array($this, 'change_enter_title_here'));
            add_filter('gettext', array($this, 'change_publish_button'), 10, 2);
        }

        /**
         * Function used when the admin is initiated
         */
        function admin_init()
        {
            // Supplier informations
            add_meta_box('ft_smfw_post_informations',  __('Supplier informations', FT_SMFW_TEXT_DOMAIN), array($this, 'post_informations_metabox'), FT_SMFW_POST_TYPE, 'normal', 'low');

            // Supplier linked products
            add_meta_box('ft_smfw_wc_products_linked', __('Supplier products', FT_SMFW_TEXT_DOMAIN), array($this, 'products_linked_metabox'), FT_SMFW_POST_TYPE, 'normal', 'low');
        }

        /**
         * Change title field placeholder in editor
         */
        function change_enter_title_here($title)
        {
            $screen = get_current_screen();

            if (FT_SMFW_POST_TYPE == $screen->post_type) {
                $title = __('Supplier name', FT_SMFW_TEXT_DOMAIN);
            }

            return $title;
        }

        /**
         * Change title field placeholder in editor
         */
        function change_publish_button($translation, $text)
        {
            if ('Publish' == $text) return __('Save', FT_SMFW_TEXT_DOMAIN);
            return $translation;
        }

        /**
         * Show informations metabox in the editor
         */
        function post_informations_metabox($post)
        {
            $supplier = new FT_SMFW_Supplier($post->ID);

            ?>
            <div class="informations-form-fields">
                <div class="form-field">
                    <label for="ft_smfw_business_name_field"><?php _e('Business name', FT_SMFW_TEXT_DOMAIN); ?></label>
                    <input
                        type="text"
                        id="ft_smfw_business_name_field"
                        name="ft_smfw_business_name"
                        value="<?php _e($supplier->getBusinessName()); ?>"
                        placeholder="<?php _e('Business name', FT_SMFW_TEXT_DOMAIN); ?>"
                        />
                </div>
                <div class="form-field">
                    <label for="ft_smfw_website_field"><?php _e('Website', FT_SMFW_TEXT_DOMAIN); ?></label>
                    <input
                    type="text"
                    id="ft_smfw_website_field"
                    name="ft_smfw_website"
                    value="<?php _e($supplier->getWebsite()); ?>"
                    placeholder="<?php _e('Website', FT_SMFW_TEXT_DOMAIN); ?>"
                    />
                </div>
                <div class="form-field">
                    <label for="ft_smfw_email_field"><?php _e('Email', FT_SMFW_TEXT_DOMAIN); ?></label>
                    <input
                    type="text"
                    id="ft_smfw_email_field"
                    name="ft_smfw_email"
                    value="<?php _e($supplier->getEmail()); ?>"
                    placeholder="<?php _e('Email', FT_SMFW_TEXT_DOMAIN); ?>"
                    />
                </div>
                <div class="form-field">
                    <label for="ft_smfw_phone_field"><?php _e('Phone', FT_SMFW_TEXT_DOMAIN); ?></label>
                    <input
                    type="text"
                    id="ft_smfw_phone_field"
                    name="ft_smfw_phone"
                    value="<?php _e($supplier->getPhone()); ?>"
                    placeholder="<?php _e('Phone', FT_SMFW_TEXT_DOMAIN); ?>"
                    />
                </div>

                <div class="form-title">
                    <h4><?php _e('Direct contact', FT_SMFW_TEXT_DOMAIN); ?></h4>
                </div>
                <div class="form-field">
                    <label for="ft_smfw_direct_name_field"><?php _e('Contact name', FT_SMFW_TEXT_DOMAIN); ?></label>
                    <input
                        type="text"
                        id="ft_smfw_direct_name_field"
                        name="ft_smfw_direct_name"
                        value="<?php _e($supplier->getDirectName()); ?>"
                        placeholder="<?php _e('Contact name', FT_SMFW_TEXT_DOMAIN); ?>"
                        />
                </div>
                <div class="form-field">
                    <label for="ft_smfw_direct_email_field"><?php _e('Email', FT_SMFW_TEXT_DOMAIN); ?></label>
                    <input
                    type="text"
                    id="ft_smfw_direct_email_field"
                    name="ft_smfw_direct_email"
                    value="<?php _e($supplier->getDirectEmail()); ?>"
                    placeholder="<?php _e('Email', FT_SMFW_TEXT_DOMAIN); ?>"
                    />
                </div>
                <div class="form-field">
                    <label for="ft_smfw_direct_phone_field"><?php _e('Phone', FT_SMFW_TEXT_DOMAIN); ?></label>
                    <input
                    type="text"
                    id="ft_smfw_direct_phone_field"
                    name="ft_smfw_direct_phone"
                    value="<?php _e($supplier->getDirectPhone()); ?>"
                    placeholder="<?php _e('Phone', FT_SMFW_TEXT_DOMAIN); ?>"
                    />
                </div>

                <div class="form-title">
                    <h4><?php _e('Address', FT_SMFW_TEXT_DOMAIN); ?></h4>
                </div>
                <div class="form-field">
                    <label for="ft_smfw_street_field"><?php _e('Street', FT_SMFW_TEXT_DOMAIN); ?></label>
                    <input
                        type="text"
                        id="ft_smfw_street_field"
                        name="ft_smfw_street"
                        value="<?php _e($supplier->getStreet()); ?>"
                        placeholder="<?php _e('Street', FT_SMFW_TEXT_DOMAIN); ?>"
                        />
                </div>
                <div class="form-field">
                    <label for="ft_smfw_zipcode_field"><?php _e('Zipcode', FT_SMFW_TEXT_DOMAIN); ?></label>
                    <input
                        type="text"
                        id="ft_smfw_zipcode_field"
                        name="ft_smfw_zipcode"
                        value="<?php _e($supplier->getZipcode()); ?>"
                        placeholder="<?php _e('Zipcode', FT_SMFW_TEXT_DOMAIN); ?>"
                        />
                </div>
                <div class="form-field">
                    <label for="ft_smfw_city_field"><?php _e('City', FT_SMFW_TEXT_DOMAIN); ?></label>
                    <input
                        type="text"
                        id="ft_smfw_city_field"
                        name="ft_smfw_city"
                        value="<?php _e($supplier->getCity()); ?>"
                        placeholder="<?php _e('City', FT_SMFW_TEXT_DOMAIN); ?>"
                        />
                </div>
                <div class="form-field">
                    <label for="ft_smfw_state_field"><?php _e('State', FT_SMFW_TEXT_DOMAIN); ?></label>
                    <input
                        type="text"
                        id="ft_smfw_state_field"
                        name="ft_smfw_state"
                        value="<?php _e($supplier->getState()); ?>"
                        placeholder="<?php _e('State', FT_SMFW_TEXT_DOMAIN); ?>"
                        />
                </div>
                <div class="form-field">
                    <label for="ft_smfw_country_field"><?php _e('Country', FT_SMFW_TEXT_DOMAIN); ?></label>
                    <input
                        type="text"
                        id="ft_smfw_country_field"
                        name="ft_smfw_country"
                        value="<?php _e($supplier->getCountry()); ?>"
                        placeholder="<?php _e('Country', FT_SMFW_TEXT_DOMAIN); ?>"
                        />
                </div>

                <div class="form-title">
                    <h4><?php _e('More', FT_SMFW_TEXT_DOMAIN); ?></h4>
                </div>
                <div class="form-field">
                    <label for="ft_smfw_delivery_time_field"><?php _e('Delivery time', FT_SMFW_TEXT_DOMAIN); ?></label>
                    <input
                        type="text"
                        id="ft_smfw_delivery_time_field"
                        name="ft_smfw_delivery_time"
                        value="<?php _e($supplier->getDeliveryTime()); ?>"
                        placeholder="<?php _e('Delivery time', FT_SMFW_TEXT_DOMAIN); ?>"
                        />
                </div>
                <div class="form-field">
                    <label for="ft_smfw_free_delivery_field"><?php _e('Free delivery', FT_SMFW_TEXT_DOMAIN); ?></label>
                    <input
                        type="text"
                        id="ft_smfw_free_delivery_field"
                        name="ft_smfw_free_delivery"
                        value="<?php _e($supplier->getFreeDelivery()); ?>"
                        placeholder="<?php _e('Free delivery', FT_SMFW_TEXT_DOMAIN); ?>"
                        />
                </div>
                <div class="form-field">
                    <label for="ft_smfw_comment_field"><?php _e('Comment', FT_SMFW_TEXT_DOMAIN); ?></label>
                    <textarea
                        id="ft_smfw_comment_field"
                        name="ft_smfw_comment"
                        placeholder="<?php _e('Comment', FT_SMFW_TEXT_DOMAIN); ?>"><?php _e($supplier->getComment()); ?></textarea>
                </div>
            </div>
            <?php
        }

        /**
         * Hook called when a post is saved
         */
        function save_post($post_id)
        {
        	// If this is just a revision, don't continue
        	if (wp_is_post_revision($post_id)) return;

            // Update datas
            $supplier = new FT_SMFW_Supplier($post_id);

            if (isset($_POST['ft_smfw_business_name'])) {
                $supplier->setBusinessName(sanitize_text_field($_POST['ft_smfw_business_name']));
            }
            if (isset($_POST['ft_smfw_website'])) {
                $supplier->setWebsite(sanitize_text_field($_POST['ft_smfw_website']));
            }
            if (isset($_POST['ft_smfw_email'])) {
                $supplier->setEmail(sanitize_text_field($_POST['ft_smfw_email']));
            }
            if (isset($_POST['ft_smfw_phone'])) {
                $supplier->setPhone(sanitize_text_field($_POST['ft_smfw_phone']));
            }
            if (isset($_POST['ft_smfw_direct_name'])) {
                $supplier->setDirectName(sanitize_text_field($_POST['ft_smfw_direct_name']));
            }
            if (isset($_POST['ft_smfw_direct_email'])) {
                $supplier->setDirectEmail(sanitize_text_field($_POST['ft_smfw_direct_email']));
            }
            if (isset($_POST['ft_smfw_direct_phone'])) {
                $supplier->setDirectPhone(sanitize_text_field($_POST['ft_smfw_direct_phone']));
            }
            if (isset($_POST['ft_smfw_street'])) {
                $supplier->setStreet(sanitize_text_field($_POST['ft_smfw_street']));
            }
            if (isset($_POST['ft_smfw_zipcode'])) {
                $supplier->setZipcode(sanitize_text_field($_POST['ft_smfw_zipcode']));
            }
            if (isset($_POST['ft_smfw_city'])) {
                $supplier->setCity(sanitize_text_field($_POST['ft_smfw_city']));
            }
            if (isset($_POST['ft_smfw_state'])) {
                $supplier->setState(sanitize_text_field($_POST['ft_smfw_state']));
            }
            if (isset($_POST['ft_smfw_country'])) {
                $supplier->setCountry(sanitize_text_field($_POST['ft_smfw_country']));
            }
            if (isset($_POST['ft_smfw_delivery_time'])) {
                $supplier->setDeliveryTime(sanitize_text_field($_POST['ft_smfw_delivery_time']));
            }
            if (isset($_POST['ft_smfw_free_delivery'])) {
                $supplier->setFreeDelivery(sanitize_text_field($_POST['ft_smfw_free_delivery']));
            }
            if (isset($_POST['ft_smfw_comment'])) {
                $supplier->setComment(sanitize_text_field($_POST['ft_smfw_comment']));
            }

            $supplier->save();
	    }

        /**
         * Show informations metabox in the editor
         */
        function products_linked_metabox($post)
        {
            $supplier = new FT_SMFW_Supplier($post->ID);
            $products = $supplier->getProducts();

            $alert_stock_min = get_option('ft_smfw_alert_stock_min');

            if (count($products)) :
                ?>
                <table id="ft_smfw_supplier_products_table">
                    <thead>
                        <tr>
                            <th class=""><?php _e('SKU', FT_SMFW_TEXT_DOMAIN); ?></th>
                            <th class="product-column"><?php _e('Product', FT_SMFW_TEXT_DOMAIN); ?></th>
                            <th class="stock-column"><?php _e('Stock', FT_SMFW_TEXT_DOMAIN); ?></th>
                            <th class="price-column"><?php _e('Supplier price', FT_SMFW_TEXT_DOMAIN); ?></th>
                            <th class="price-column"><?php _e('Sale price', FT_SMFW_TEXT_DOMAIN); ?></th>
                            <th class="packaging-column"><?php _e('Packaging', FT_SMFW_TEXT_DOMAIN); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product) : ?>
                            <tr>
                                <td><?php _e($product->get_sku()); ?></td>
                                <td>
                                    <a href="<?php _e(get_edit_post_link($product->is_type('simple') ? $product->get_id() : $product->get_parent_id())); ?>" target="_blank">
                                        <?php _e($product->get_name()); ?>
                                    </a>
                                </td>
                                <td class="cell-text-right">
                                    <?php
                                    if ($product->managing_stock()) {
                                        if ($alert_stock_min >= $product->get_stock_quantity()) { _e('<i class="dashicons dashicons-warning"></i>'); }
                                        _e($product->get_stock_quantity());
                                    } else {
                                        _e('-', FT_SMFW_TEXT_DOMAIN);
                                    }
                                    ?>
                                </td>
                                <td class="cell-text-right">
                                    <?php
                                    $product_supplier_price = get_post_meta($product->get_id(), 'ft_smfw_supplier_price', true);
                                    _e($product_supplier_price ? $product_supplier_price . get_woocommerce_currency_symbol() : __('-', FT_SMFW_TEXT_DOMAIN));
                                    ?>
                                </td>
                                <td class="cell-text-right">
                                    <?php
                                    $product_price = $product->get_price();
                                    _e($product_price ? $product_price . get_woocommerce_currency_symbol() : __('-', FT_SMFW_TEXT_DOMAIN));
                                    ?>
                                </td>
                                <td class="cell-text-right">
                                    <?php
                                    $product_supplier_packaging = get_post_meta($product->get_id(), 'ft_smfw_supplier_packaging', true);
                                    _e($product_supplier_packaging ? $product_supplier_packaging : __('-', FT_SMFW_TEXT_DOMAIN));
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <?php
            else:
                ?>
                <p>
                    <?php _e('No product linked to this supplier…', FT_SMFW_TEXT_DOMAIN); ?>
                    <a href="<?php _e(admin_url('edit.php?post_type=product')); ?>"><?php _e('Browse products', FT_SMFW_TEXT_DOMAIN); ?></a>
                </p>
                <?php
            endif;
        }
	}
}

// Launch plugin
new FT_SMFW_editor();
