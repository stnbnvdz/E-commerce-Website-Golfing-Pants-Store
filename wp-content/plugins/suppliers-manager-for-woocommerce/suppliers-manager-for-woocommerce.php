<?php
/**
 * Plugin Name: Suppliers Manager for Woocommerce
 * Plugin URI:  -
 * Description: Suppliers Manager for Woocommerce allows you to list your suppliers and associate Woocommerce products to them.
 * Version:     0.0.14
 * Author:      WP-Shopping
 * Author URI:  https://wp-shopping.com/
 * Text Domain: ft_smfw
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

defined('ABSPATH') or die('Nope, not accessing this');

// Define FT_SMFW_PLUGIN_FILE
if (!defined('FT_SMFW_PLUGIN_FILE')) {
	define('FT_SMFW_PLUGIN_FILE', __FILE__);
}

if (!class_exists('FT_SMFW_Plugin')) {
    class FT_SMFW_Plugin
    {
        // +-------------------+
		// | CLASS CONSTRUCTOR |
		// +-------------------+

		public function __construct()
		{
            if (is_admin()) {
                $this->define_constants(); // Define plugin constants
                $this->includes(); // Include plugin files
        		$this->init_hooks(); // Init hooks in Wordpress

				$smfw_notice = new FT_SMFW_Notice();
				$smfw_notice->init();
            }
		}

        // +---------------+
        // | CLASS METHODS |
        // +---------------+

    	/**
    	 * Define plugin constants
    	 */
    	private function define_constants()
        {
            $this->define('FT_SMFW_PLUGIN_NAME', 'Suppliers Manager for Woocommerce');
            $this->define('FT_SMFW_PLUGIN_VERSION', '0.0.14');

    		$this->define('FT_SMFW_ABSPATH', dirname(FT_SMFW_PLUGIN_FILE) . '/');
    		$this->define('FT_SMFW_PLUGIN_BASENAME', plugin_basename(FT_SMFW_PLUGIN_FILE));
    		$this->define('FT_SMFW_PLUGIN_URL', plugins_url() . '/suppliers-manager-for-woocommerce/');
    		$this->define('FT_SMFW_POST_TYPE', 'ft_supplier');
            $this->define('FT_SMFW_TEXT_DOMAIN', 'ft_smfw');
    	}

    	/**
    	 * Include any classes we need within admin.
    	 */
        public function includes()
        {
    		include_once(FT_SMFW_ABSPATH . 'includes/supplier-post-type.class.php');

    		include_once(FT_SMFW_ABSPATH . 'includes/admin/menu.class.php');
    		include_once(FT_SMFW_ABSPATH . 'includes/admin/editor.class.php');
    		include_once(FT_SMFW_ABSPATH . 'includes/admin/wc-products.class.php');
    		include_once(FT_SMFW_ABSPATH . 'includes/admin/wc-product.class.php');

    		include_once(FT_SMFW_ABSPATH . 'includes/classes/supplier.class.php');
    		include_once(FT_SMFW_ABSPATH . 'includes/classes/notice.class.php');
        }

    	/**
    	 * Initiate plugin hooks in Wordpress
    	 */
        public function init_hooks()
        {
            add_action('plugins_loaded', array($this, 'load_translation_files')); // Load translation files
            add_action('admin_enqueue_scripts', array($this, 'admin_style'));
        }

        /**
         * Load translation files located in the /languages folder
         */
        public function load_translation_files()
        {
            load_plugin_textdomain(
                FT_SMFW_TEXT_DOMAIN,
                false,
                basename(dirname(__FILE__)) . '/languages'
            );
        }

        public function admin_style()
        {
            // Enqueue style files
            wp_enqueue_style(FT_SMFW_POST_TYPE . '_datatables-style', "//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css");
            wp_enqueue_style(FT_SMFW_POST_TYPE . '_admin-style', plugins_url() . "/suppliers-manager-for-woocommerce/assets/css/" . FT_SMFW_POST_TYPE . "_style.css");

            // Enqueue script files
            wp_enqueue_script(FT_SMFW_POST_TYPE . '_datatables-script', "//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js", array('jquery'));
            // wp_enqueue_script(FT_SMFW_POST_TYPE . '_admin-script', plugins_url() . "/suppliers-manager-for-woocommerce/assets/js/" . FT_SMFW_POST_TYPE . "_script.js", array(FT_SMFW_POST_TYPE . '_datatables-script'));
        }

        // +--------+
        // | OTHERS |
        // +--------+

        /**
         * Show notices
         * @return string
         */
        public function show_admin_notices($message, $type = 'warning')
        {
            ?>
                <div class="notice notice-<?php _e($type); ?>">
                    <p><?php _e($message); ?></p>
                </div>
            <?php
        }

    	/**
    	 * Define constant if not already set.
    	 *
    	 * @param string      $name  Constant name.
    	 * @param string|bool $value Constant value.
    	 */
    	private function define($name, $value)
        {
    		if (!defined($name)) {
    			define($name, $value);
    		}
    	}

	}
}

// Launch plugin
new FT_SMFW_Plugin();
