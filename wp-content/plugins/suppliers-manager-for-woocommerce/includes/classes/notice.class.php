<?php

if (!class_exists('FT_SMFW_Notice')) {

    class FT_SMFW_Notice
    {
        public function init()
        {
            if ((!class_exists('FT_SMFW_Pro_Plugin')) && get_option(FT_SMFW_POST_TYPE . 'show_go_pro_notice')) {
                add_action('admin_notices', array($this, 'admin_go_pro_notice'));
                add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
                add_action('wp_ajax_ft_supplier_dismiss_admin_notice', array($this, 'dismiss_admin_notice'));
            }

            if (!class_exists('FT_SMFW_Pro_Plugin')) {
                add_action('upgrader_process_complete', array($this, 'plugin_upgrade'), 10, 2);
                register_activation_hook(FT_SMFW_ABSPATH . 'suppliers-manager-for-woocommerce.php', array($this, 'reset_admin_notice'));
            }
        }

        public function admin_go_pro_notice()
        {
            $screen = get_current_screen();

            if ('fournisseurs_page_ft_supplier_go_pro' != $screen->id) {
                $current_user = wp_get_current_user();
                ?>
                <div id="smfw_an1" class="notice notice-warning is-dismissible">
                    <h3><?php _e("Suppliers Manager for Woocommerce. Go Pro!", FT_SMFW_TEXT_DOMAIN); ?></h3>
                    <p>
                        <?php _e("Hi", FT_SMFW_TEXT_DOMAIN); ?><b><?php _e($current_user->display_name); ?></b>!
                        <?php _e("To improve your business with premium features like sending emails to your suppliers ou receive \"almost out-of-stock\" alerts, visit our", FT_SMFW_TEXT_DOMAIN); ?>
                        <a href="<?php _e(admin_url("admin.php?page=" . FT_SMFW_POST_TYPE . '_go_pro')); ?>"><?php _e("Go Pro page", FT_SMFW_TEXT_DOMAIN); ?></a>.</p>
                </div>
                <?php
            }
        }

        public function enqueue_scripts($hook)
        {
            wp_enqueue_script(
                FT_SMFW_POST_TYPE . '-admin-notice-js',
                FT_SMFW_PLUGIN_URL . 'assets/scripts/admin-notices.js'
            );
        }

        public function plugin_upgrade($upgrader_object, $options)
        {
            if ($options['action'] == 'update' && $options['type'] == 'plugin') {
                foreach($options['plugins'] as $each_plugin) {
                    if ($each_plugin == FT_SMFW_PLUGIN_BASENAME) {
                        $this->reset_admin_notice();
                    }
                }
            }
        }

        public function reset_admin_notice()
        {
            update_option(FT_SMFW_POST_TYPE . 'show_go_pro_notice', true);
        }

        public function dismiss_admin_notice()
        {
            update_option(FT_SMFW_POST_TYPE . 'show_go_pro_notice', false);
            wp_die();
        }
    }
}
