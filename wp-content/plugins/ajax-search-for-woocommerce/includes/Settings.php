<?php

namespace DgoraWcas;

use DgoraWcas\Admin\SettingsAPI;
use DgoraWcas\BackwardCompatibility;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Settings API data
 */
class Settings {
	/*
	 * @var string
	 * Unique settings slug
	 */

	private $setting_slug = DGWT_WCAS_SETTINGS_KEY;

	/*
	 * @var array
	 * All options values in one array
	 */
	public $opt;

	/*
	 * @var object
	 * Settings API object
	 */
	public $settings_api;

	public function __construct() {
		global $dgwt_wcas_settings;

		// Set global variable with settings
		$settings = get_option( $this->setting_slug );
		if ( ! isset( $settings ) || empty( $settings ) ) {
			$dgwt_wcas_settings = array();
		} else {
			$dgwt_wcas_settings = $settings;
		}

		$this->opt = $dgwt_wcas_settings;

		$this->settings_api = new SettingsAPI( $this->setting_slug );

		add_action( 'admin_init', array( $this, 'settings_init' ) );
		add_filter( 'dgwt_wcas_settings_sections', array( $this, 'hide_settings_details_tab' ) );
	}

	/*
	 * Set sections and fields
	 */

	public function settings_init() {

		//Set the settings
		$this->settings_api->set_sections( $this->settings_sections() );
		$this->settings_api->set_fields( $this->settings_fields() );

		//Initialize settings
		$this->settings_api->settings_init();
	}

	/*
	 * Set settings sections
	 * 
	 * @return array settings sections
	 */

	public function settings_sections() {

		$sections = array(
			array(
				'id'    => 'dgwt_wcas_basic',
				'title' => __( 'Basic', 'ajax-search-for-woocommerce' )
			),
			array(
				'id'    => 'dgwt_wcas_form_body',
				'title' => __( 'Form', 'ajax-search-for-woocommerce' )
			),
			array(
				'id'    => 'dgwt_wcas_colors',
				'title' => __( 'Colors', 'ajax-search-for-woocommerce' )
			),
			array(
				'id'    => 'dgwt_wcas_engine',
				'title' => __( 'Scope', 'ajax-search-for-woocommerce' )
			),
//            array(
//                'id'    => 'dgwt_wcas_engine_pro',
//                'title' => Helpers::getSettingsProLabel(
//                    __( 'Rocket Search Engine', 'ajax-search-for-woocommerce' ),
//                    'header',
//                    __( 'up to 50x faster ', 'ajax-search-for-woocommerce')
//                )
//            )
		);


		$sections = apply_filters( 'dgwt_wcas_settings_sections', $sections ); // deprecated since v1.2.0
        $sections = apply_filters( 'dgwt/wcas/settings/sections', $sections );

		return $sections;
	}

	/**
	 * Create settings fields
	 *
	 * @return array settings fields
	 */
	function settings_fields() {
		$settings_fields = array(
			'dgwt_wcas_basic'     => apply_filters( 'dgwt/wcas/settings/section=basic', array(
				array(
					'name'  => 'how_to_use',
					'label' => __( 'How to use?', 'ajax-search-for-woocommerce' ),
					'type'  => 'desc',
					'desc'  => Helpers::how_to_use_html(),
				),
				array(
					'name'    => 'suggestions_limit',
					'label'   => __( 'Suggestions limit', 'ajax-search-for-woocommerce' ),
					'type'    => 'number',
					'size'    => 'small',
					'desc'    => __( 'Maximum number of suggestions rows.', 'ajax-search-for-woocommerce' ),
					'default' => 10,
				),
				array(
					'name'    => 'min_chars',
					'label'   => __( 'Minimum characters', 'ajax-search-for-woocommerce' ),
					'type'    => 'number',
					'size'    => 'small',
					'desc'    => __( 'Minimum number of characters required to trigger autosuggest.', 'ajax-search-for-woocommerce' ),
					'default' => 3,
				),
                array(
                    'name'    => 'max_form_width',
                    'label'   => __( 'Max form width', 'ajax-search-for-woocommerce' ),
                    'type'    => 'number',
                    'size'    => 'small',
                    'desc'    => ' px. ' . __( 'To set 100% width leave blank', 'ajax-search-for-woocommerce' ),
                    'default' => 600,
                ),
				array(
					'name'    => 'show_submit_button',
					'label'   => __( 'Show submit button', 'ajax-search-for-woocommerce' ),
					'type'    => 'checkbox',
					'size'    => 'small',
					'default' => 'off',
				),
				array(
					'name'    => 'search_submit_text',
					'label'   => __( 'Search submit button text', 'ajax-search-for-woocommerce' ),
					'type'    => 'text',
					'desc'    => __( 'To display a magnifier icon leave this field empty.', 'ajax-search-for-woocommerce' ),
					'default' => __( 'Search', 'ajax-search-for-woocommerce' ),
				),
				array(
					'name'    => 'search_placeholder',
					'label'   => __( 'Search input placeholder', 'ajax-search-for-woocommerce' ),
					'type'    => 'text',
					'default' => __( 'Search for products...', 'ajax-search-for-woocommerce' ),
				)
			) ),
			'dgwt_wcas_form_body' => apply_filters( 'dgwt/wcas/settings/section=form', array(
				array(
					'name'  => 'product_suggestion_head',
					'label' => __( 'Suggestions output', 'ajax-search-for-woocommerce' ),
					'type'  => 'head',
					'class' => 'dgwt-wcas-sgs-header'
				),
				array(
					'name'    => 'show_product_image',
					'label'   => __( 'Show product image', 'ajax-search-for-woocommerce' ),
					'type'    => 'checkbox',
					'default' => 'off',
				),
				array(
					'name'    => 'show_product_price',
					'label'   => __( 'Show price', 'ajax-search-for-woocommerce' ),
					'type'    => 'checkbox',
					'default' => 'off',
				),
				array(
					'name'    => 'show_product_desc',
					'label'   => __( 'Show product description', 'ajax-search-for-woocommerce' ),
					'type'    => 'checkbox',
					'default' => 'off',
				),
				array(
					'name'    => 'show_product_sku',
					'label'   => __( 'Show SKU', 'ajax-search-for-woocommerce' ),
					'type'    => 'checkbox',
					'default' => 'off',
				),
				array(
					'name'    => 'show_matching_categories',
					'label'   => __( 'Also show matching categories', 'ajax-search-for-woocommerce' ),
					'type'    => 'checkbox',
					'default' => 'on',
				),
				array(
					'name'    => 'show_matching_tags',
					'label'   => __( 'Also show matching tags', 'ajax-search-for-woocommerce' ),
					'type'    => 'checkbox',
					'default' => 'off',
				),
//				array(
//					'name'		 => 'show_sale_badge',
//					'label'		 => __( 'Show sale badge', 'ajax-search-for-woocommerce' ),
//					'type'		 => 'checkbox',
//					'default'	 => 'off',
//				),
//				array(
//					'name'		 => 'show_featured_badge',
//					'label'		 => __( 'Show featured badge', 'ajax-search-for-woocommerce' ),
//					'type'		 => 'checkbox',
//					'default'	 => 'off',
//				),
				array(
					'name'  => 'preloader',
					'label' => __( 'Preloader', 'ajax-search-for-woocommerce' ),
					'type'  => 'head',
					'class' => 'dgwt-wcas-sgs-header'
				),
				array(
					'name'    => 'show_preloader',
					'label'   => __( 'Show preloader', 'ajax-search-for-woocommerce' ),
					'type'    => 'checkbox',
					'default' => 'on',
				),
				array(
					'name'    => 'preloader_url',
					'label'   => __( 'Upload preloader image', 'ajax-search-for-woocommerce' ),
					'type'    => 'file',
					'default' => '',
				),
				array(
					'name'  => 'details_box_head',
					'label' => __( 'Details box', 'ajax-search-for-woocommerce' ),
					'type'  => 'head',
					'class' => 'dgwt-wcas-sgs-header'
				),
				array(
					'name'    => 'show_details_box',
					'label'   => __( 'Show details box', 'ajax-search-for-woocommerce' ),
					'type'    => 'checkbox',
					'size'    => 'small',
					'class'   => 'dgwt-wcas-options-cb-toggle',
					'desc'    => sprintf( __( 'The Details box is an additional container for extended information. The details are changed dynamically when you hover the mouse over one of the suggestions. <a href="%s" target="_blank">See where the details box will appear.</a>', 'ajax-search-for-woocommerce' ), DGWT_WCAS_URL . 'assets/img/details-box.png' ),
					'default' => 'off',
				),
				array(
					'name'    => 'show_for_tax',
					'label'   => __( 'Products list', 'ajax-search-for-woocommerce' ),
					'type'    => 'select',
					'desc'    => __( 'Applies only to category or tags suggestions type', 'ajax-search-for-woocommerce' ),
					'options' => array(
						'all'      => __( 'All Product', 'ajax-search-for-woocommerce' ),
						'featured' => __( 'Featured Products', 'ajax-search-for-woocommerce' ),
						'onsale'   => __( 'On-sale Products', 'ajax-search-for-woocommerce' ),
					),
					'class'   => 'wcas-opt-show-details-box',
					'default' => 'on',
				),
				array(
					'name'    => 'orderby_for_tax',
					'label'   => __( 'Order by', 'ajax-search-for-woocommerce' ),
					'type'    => 'select',
					'class'   => 'wcas-opt-show-details-box',
					'desc'    => __( 'Applies only to category or tags suggestions type', 'ajax-search-for-woocommerce' ),
					'options' => array(
						'date'  => __( 'Date', 'ajax-search-for-woocommerce' ),
						'price' => __( 'Price', 'ajax-search-for-woocommerce' ),
						'rand'  => __( 'Random', 'ajax-search-for-woocommerce' ),
						'sales' => __( 'Sales', 'ajax-search-for-woocommerce' ),
					),
					'default' => 'on',
				),
				array(
					'name'    => 'order_for_tax',
					'label'   => __( 'Order', 'ajax-search-for-woocommerce' ),
					'type'    => 'select',
					'class'   => 'wcas-opt-show-details-box',
					'desc'    => __( 'Applies only to category or tags suggestions type', 'ajax-search-for-woocommerce' ),
					'options' => array(
						'desc' => __( 'DESC', 'ajax-search-for-woocommerce' ),
						'asc'  => __( 'ASC', 'ajax-search-for-woocommerce' ),
					),
					'default' => 'desc',
				)
			) ),
			'dgwt_wcas_colors'    => apply_filters( 'dgwt/wcas/settings/section=colors', array(
				array(
					'name'  => 'search_form',
					'label' => __( 'Search form', 'ajax-search-for-woocommerce' ),
					'type'  => 'head',
					'class' => 'dgwt-wcas-sgs-header'
				),
				array(
					'name'    => 'bg_input_color',
					'label'   => __( 'Search input background', 'ajax-search-for-woocommerce' ),
					'type'    => 'color',
					'default' => '',
				),
				array(
					'name'    => 'text_input_color',
					'label'   => __( 'Search input text', 'ajax-search-for-woocommerce' ),
					'type'    => 'color',
					'default' => '',
				),
				array(
					'name'    => 'border_input_color',
					'label'   => __( 'Search input border', 'ajax-search-for-woocommerce' ),
					'type'    => 'color',
					'default' => '',
				),
				array(
					'name'    => 'bg_submit_color',
					'label'   => __( 'Search submit background', 'ajax-search-for-woocommerce' ),
					'type'    => 'color',
					'default' => '',
				),
				array(
					'name'    => 'text_submit_color',
					'label'   => __( 'Search submit text', 'ajax-search-for-woocommerce' ),
					'type'    => 'color',
					'default' => '',
				),
				array(
					'name'  => 'syggestions_style_head',
					'label' => __( 'Suggestions', 'ajax-search-for-woocommerce' ),
					'type'  => 'head',
					'class' => 'dgwt-wcas-sgs-header'
				),
				array(
					'name'    => 'sug_bg_color',
					'label'   => __( 'Suggestion background', 'ajax-search-for-woocommerce' ),
					'type'    => 'color',
					'default' => '',
				),
				array(
					'name'    => 'sug_hover_color',
					'label'   => __( 'Suggestion selected', 'ajax-search-for-woocommerce' ),
					'type'    => 'color',
					'default' => '',
				),
				array(
					'name'    => 'sug_text_color',
					'label'   => __( 'Text color', 'ajax-search-for-woocommerce' ),
					'type'    => 'color',
					'default' => '',
				),
				array(
					'name'    => 'sug_highlight_color',
					'label'   => __( 'Highlight color', 'ajax-search-for-woocommerce' ),
					'type'    => 'color',
					'default' => '',
				),
				array(
					'name'    => 'sug_border_color',
					'label'   => __( 'Border color', 'ajax-search-for-woocommerce' ),
					'type'    => 'color',
					'default' => '',
				)
			) ),
			'dgwt_wcas_engine'    => apply_filters( 'dgwt/wcas/settings/section=engine', array(
				array(
					'name'  => 'search_engine_nw_head',
					'label' => __( 'Search scope', 'ajax-search-for-woocommerce' ),
					'type'  => 'head',
					'class' => 'wcas-opt-native dgwt-wcas-sgs-header'
				),
				array(
					'name'    => 'search_in_product_content',
					'label'   => __( 'Search in products content', 'ajax-search-for-woocommerce' ),
					'type'    => 'checkbox',
					'default' => 'off',
				),
				array(
					'name'    => 'search_in_product_excerpt',
					'label'   => __( 'Search in products excerpt', 'ajax-search-for-woocommerce' ),
					'type'    => 'checkbox',
					'default' => 'off',
				),
				array(
					'name'    => 'search_in_product_sku',
					'label'   => __( 'Search in products SKU', 'ajax-search-for-woocommerce' ),
					'type'    => 'checkbox',
					'default' => 'off',
				),
				array(
					'name'    => 'exclude_out_of_stock',
					'label'   => __( "Exclude 'out of stock' products", 'ajax-search-for-woocommerce' ),
					'type'    => 'checkbox',
					'default' => 'off',
				)
			) ),
            'dgwt_wcas_engine_pro'    => apply_filters( 'dgwt/wcas/settings/section=rocket_engine', array(
                array(
                    'name'  => 'search_engine_head',
                    'label' => __( 'Rocket Search Engine', 'ajax-search-for-woocommerce' ),
                    'type'  => 'head',
                    'class' => 'dgwt-wcas-sgs-header'
                ),
                array(
                    'name'    => 'search_engine',
                    'label'   => __( 'Choose the engine', 'ajax-search-for-woocommerce' ),
                    'type'    => 'radio',
                    'options' => array(
                        'native'    => __( 'Native WordPress', 'ajax-search-for-woocommerce' ),
                        'tntsearch' => __( 'TNT Search (experimental)', 'ajax-search-for-woocommerce' ) . ' <small> - [' . __( 'up to <b>50x faster</b> than native WordPress.', 'ajax-search-for-woocommerce' ) . ']</small>',
                    ),
                    'default' => 'native',
                ),
            ) )
		);


		if(DGWT_WCAS()->engine === 'tntsearch'){
            $settings_fields['dgwt_wcas_engine_pro'][] = array(
                'name'  => 'search_engine_build_btn',
                'label' => __( 'Build index', 'ajax-search-for-woocommerce' ),
                'type'  => 'desc',
                'desc'  => '<a class="button js-ajax-build-index" href="#">Build index</a>',
                'class' => 'wcas-opt-tntsearch'
            );
        }

		return $settings_fields;
	}

	/*
	 * Option value
	 * 
	 * @param string $option_key
	 * @param string $default default value if option not exist
	 * 
	 * @return string
	 */

	public function get_opt( $option_key, $default = '' ) {

		$value = '';

		if ( is_string( $option_key ) && ! empty( $option_key ) ) {

			$settings = get_option( $this->setting_slug );

			if ( is_array( $settings ) && array_key_exists( $option_key, $settings ) ) {
				$value = $settings[ $option_key ];
			} else {

				// Catch default
				foreach ( $this->settings_fields() as $section ) {
					foreach ( $section as $field ) {
						if ( $field['name'] === $option_key && isset( $field['default'] ) ) {
							$value = $field['default'];
						}
					}
				}
			}
		}

		if ( empty( $value ) && ! empty( $default ) ) {
			$value = $default;
		}

		$value = apply_filters( 'dgwt/wcas/settings/load_value', $value, $option_key );
        $value = apply_filters( 'dgwt/wcas/settings/load_value/key=' . $option_key, $value );

		return $value;
	}

    /*
     * Update option
     *
     * @param string $option_key
     * @param string $value
     *
     * @return bool
     */

    public function updateOpt( $optionKey, $value = '' ) {

        $updated = false;

        if ( is_string( $optionKey ) && ! empty( $optionKey ) ) {

            $settings = get_option( $this->setting_slug );

            $value = apply_filters( 'dgwt/wcas/settings/update_value', $value, $optionKey );
            $value = apply_filters( 'dgwt/wcas/settings/update_value/key=' . $optionKey, $value );

            $canUpdate = false;
                foreach ( $this->settings_fields() as $section ) {
                    foreach ( $section as $field ) {
                        if ( $field['name'] === $optionKey ) {
                            $settings[$optionKey] = $value;
                            $canUpdate = true;
                            break;
                        }
                    }
                }


            if($canUpdate){
                $updated = update_option($this->setting_slug, $settings);
            }
        }

        return $updated;
    }

	/**
	 * Handles output of the settings
	 */
	public static function output() {

		$settings = DGWT_WCAS()->settings->settings_api;

		include_once DGWT_WCAS_DIR . 'partials/admin/settings.php';
	}

	/**
	 * Disable details box setting tab if the option id rutns off
	 */


	public function hide_settings_details_tab( $sections ) {

		if ( DGWT_WCAS()->settings->get_opt( 'show_details_box' ) !== 'on' && is_array( $sections ) ) {

			$i = 0;
			foreach ( $sections as $section ) {

				if ( isset( $section['id'] ) && $section['id'] === 'dgwt_wcas_details_box' ) {
					unset( $sections[ $i ] );
				}

				$i ++;
			}
		}

		return $sections;
	}

}