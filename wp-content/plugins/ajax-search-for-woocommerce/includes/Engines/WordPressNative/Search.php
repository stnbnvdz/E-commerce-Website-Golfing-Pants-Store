<?php

namespace DgoraWcas\Engines\WordPressNative;

use DgoraWcas\Product;
use DgoraWcas\Helpers;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Search {

	/**
	 * Suggestions limit
	 * int
	 */
	private $limit;

	/**
	 * Description limit
	 * int
	 */
	private $descLimit = 130;

	/**
	 * Empty slots
	 * int
	 */
	private $slots;

	public function __construct() {

		$this->limit = absint( DGWT_WCAS()->settings->get_opt( 'suggestions_limit', 10 ) );
		$this->slots = $this->limit; // Free slots for the results. Default 10

		add_filter( 'posts_search', array( $this, 'searchFilters' ), 501, 2 );
		add_filter( 'posts_where', array( $this, 'fixWooExcerptSearch' ), 100, 2 );
		add_filter('posts_distinct', array($this, 'search_distinct'), 501, 2);
		add_filter( 'posts_join', array( $this, 'searchFiltersJoin' ), 501, 2 );
		add_filter( 'pre_get_posts', array( $this, 'changeWpSearchSize' ), 500 );
		add_filter( 'pre_get_posts', array( $this, 'setSearchResultsQuery' ), 501 );
        add_filter( 'pre_get_posts', array( $this, 'forcePostType' ), 502 );

		// Search results ajax action
		if ( DGWT_WCAS_WC_AJAX_ENDPOINT ) {
			add_action( 'wc_ajax_' . DGWT_WCAS_SEARCH_ACTION, array( $this, 'getSearchResults' ) );
		} else {
			add_action( 'wp_ajax_nopriv_' . DGWT_WCAS_SEARCH_ACTION, array( $this, 'getSearchResults' ) );
			add_action( 'wp_ajax_' . DGWT_WCAS_SEARCH_ACTION, array( $this, 'getSearchResults' ) );
		}
	}

	/**
	 * Get search results via ajax
	 */

	public function getSearchResults() {
		global $woocommerce;

        $start = microtime(true);

		if ( !defined( 'DGWT_WCAS_AJAX' ) ) {
			define( 'DGWT_WCAS_AJAX', true );
		}

		$output	 = array();
		$results = array();
        $keyword = '';

		// Compatibile with v1.1.7
		if(!empty($_REQUEST[ 'dgwt_wcas_keyword' ])){
            $keyword = sanitize_text_field( $_REQUEST[ 'dgwt_wcas_keyword' ] );
        }

        if(!empty($_REQUEST[ 's' ])){
            $keyword = sanitize_text_field( $_REQUEST[ 's' ] );
        }


		/* SEARCH IN WOO CATEGORIES */
		if ( DGWT_WCAS()->settings->get_opt( 'show_matching_categories' ) === 'on' ) {

			$results = array_merge( $this->get_categories( $keyword ), $results );

			// Update slots
			$this->slots = $this->slots - count( $results );
		} /* END SEARCH IN WOO CATEGORIES */


		/* SEARCH IN WOO TAGS */
		if ( $this->slots > 0 ) {

			if ( DGWT_WCAS()->settings->get_opt( 'show_matching_tags' ) === 'on' ) {

				$results = array_merge( $this->get_tags( $keyword ), $results );

				// Update slots
				$this->slots = $this->slots - count( $results );
			}
		}/* END SEARCH IN WOO TAGS */


		// Continue searching in products if there are room in the slots
		/* SEARCH IN PRODUCTS */
		if ( $this->slots > 0 ) {
			$ordering_args = $woocommerce->query->get_catalog_ordering_args( 'title', 'asc' );

			$args = array(
				's'						 => $keyword,
				'post_type'				 => DGWT_WCAS_WOO_PRODUCT_POST_TYPE,
				'post_status'			 => 'publish',
				'ignore_sticky_posts'	 => 1,
				'orderby'				 => $ordering_args[ 'orderby' ],
				'order'					 => $ordering_args[ 'order' ],
				'suppress_filters'		 => false
			);

			// Backward compatibility WC < 3.0
			if ( Helpers::compare_wc_version( '3.0', '<' ) ) {
				$args['meta_query'] = $this->get_meta_query();
			}else{
				$args['tax_query'] = $this->get_tax_query();
			}


			$args = apply_filters('dgwt_wcas_products_args', $args); // deprecated since v1.2.0
            $args = apply_filters('dgwt/wcas/search_query/args', $args);

			$products = get_posts( $args );

			if ( !empty( $products ) ) {

			    $relevantProducts = array();

				foreach ( $products as $post ) {
					$product = new Product( $post );

					$r = array(
						'post_id'	 => $product->getID(),
						'value'		 => wp_strip_all_tags($product->getName()),
						'url'		 => $product->getPermalink(),
					);

					$r['score'] = $this->applyScore($r['value'], $keyword);

					// Get thumb HTML
					if ( DGWT_WCAS()->settings->get_opt( 'show_product_image' ) === 'on' ) {
						$r[ 'thumb_html' ] = $product->getThumbnail();
					}

					// Get price
					if ( DGWT_WCAS()->settings->get_opt( 'show_product_price' ) === 'on' ) {
						$r[ 'price' ] = $product->getPriceHTML();
					}

					// Get description
					if ( DGWT_WCAS()->settings->get_opt( 'show_product_desc' ) === 'on' ) {
						if ( DGWT_WCAS()->settings->get_opt( 'show_details_box' ) === 'on' ) {
							$this->descLimit = 60;
						}
						$r[ 'desc' ] = Helpers::get_product_desc( $product->getID(), $this->descLimit );
					}

					// Get SKU
					if ( DGWT_WCAS()->settings->get_opt( 'show_product_sku' ) === 'on' ) {
						$r[ 'sku' ] = $product->getSKU();
					}

					// Is on sale
//					if ( DGWT_WCAS()->settings->get_opt( 'show_sale_badge' ) === 'on' ) {
//						$r[ 'on_sale' ] = $product->is_on_sale();
//					}

					// Is featured
//					if ( DGWT_WCAS()->settings->get_opt( 'show_featured_badge' ) === 'on' ) {
//						$r[ 'featured' ] = $product->is_featured();
//					}

                    $relevantProducts[] = apply_filters( 'dgwt/wcas/search_results/products', $r, $product );
                    $this->slots--;

                    if($this->slots == 0){
                        break;
                    }
				}
			}
			wp_reset_postdata();
		} /* END SEARCH IN PRODUCTS */



		if ( !empty( $relevantProducts ) ) {

		    // Sort by relevance
            usort($relevantProducts, array($this, 'cmpSimilarity'));

            $results = array_merge( $results, $relevantProducts );

		}

		if(empty($results)){
            // Show nothing on empty results
            //@todo show 'No results' as option
            $results[] = array(
                'value' => __( 'No results', 'ajax-search-for-woocommerce' ),
            );
        }

        $output[ 'suggestions' ] = $results;
		$output['time'] = number_format((microtime(true) - $start), 2, '.', '') . ' sec';

		echo json_encode( apply_filters( 'dgwt/wcas/search_results/output', $output ));
		die();
	}

    /**
     *
     * Calculate score for results
     *
     * @param string $pname
     * @param string $keyword
     *
     * @return float|int
     */
	private function applyScore($pname, $keyword){

	    $pname = strtolower($pname);
        similar_text($keyword, $pname, $percent);

        $score = $percent;

        $pos = strpos($pname, $keyword);

        // Add score based on substring position
        if ($pos !== false) {
            $score += 50; // Bonus for contained substring

            // Bonus for substring position
            $posBonus = (100 - ($pos * 100) / strlen($pname)) / 2;
            $score    += $posBonus;
        }

        return $score;
    }

    /**
     * Sorting by score
     *
     * @param array $a
     * @param array $b
     *
     * @return int
     */
    public function cmpSimilarity($a, $b)
    {
        if ($a['score']== $b['score']) {
            return 0;
        }

        return ($a['score'] < $b['score']) ? 1 : -1;
    }

	/**
	 * Get meta query
	 * For WooCommerce < 3.0
	 *
	 * return array
	 */

	private function get_meta_query() {

		$meta_query = array(
			'relation' => 'AND',
			1          => array(
				'key'     => '_visibility',
				'value'   => array( 'search', 'visible' ),
				'compare' => 'IN'
			),
			2          => array(
				'relation' => 'OR',
				array(
					'key'     => '_visibility',
					'value'   => array( 'search', 'visible' ),
					'compare' => 'IN'
				)
			)
		);


		// Exclude out of stock products from suggestions
		if ( DGWT_WCAS()->settings->get_opt( 'exclude_out_of_stock' ) === 'on' ) {
			$meta_query[] = array(
				'key'     => '_stock_status',
				'value'   => 'outofstock',
				'compare' => 'NOT IN'
			);
		};

		return $meta_query;
	}

	/**
	 * Get tax query
	 * For WooCommerce >= 3.0
	 *
	 * return array
	 */

	private function get_tax_query() {

		$product_visibility_term_ids = wc_get_product_visibility_term_ids();

		$tax_query = array(
			'relation' => 'AND'
		);

		$tax_query[] = array(
			'taxonomy' => 'product_visibility',
			'field'    => 'term_taxonomy_id',
			'terms'    => $product_visibility_term_ids['exclude-from-search'],
			'operator' => 'NOT IN',
		);


		 // Exclude out of stock products from suggestions
		if ( DGWT_WCAS()->settings->get_opt( 'exclude_out_of_stock' ) === 'on' ) {
			$tax_query[] = array(
				'taxonomy' => 'product_visibility',
				'field'    => 'term_taxonomy_id',
				'terms'    => $product_visibility_term_ids['outofstock'],
				'operator' => 'NOT IN',
			);
		};

		return $tax_query;
	}

	/**
	 * Search for matching category
	 *
	 * @param string $keyword
	 *
	 * @return array
	 */

	public function get_categories( $keyword ) {

		$results = array();

		$args = array(
			'taxonomy' => DGWT_WCAS_WOO_PRODUCT_CATEGORY
		);

		$product_categories = get_terms( DGWT_WCAS_WOO_PRODUCT_CATEGORY, $args );

// Compare keyword and term name
		$i = 0;
		foreach ( $product_categories as $cat ) {

			if ( $i < $this->limit ) {

			    $cat_name = html_entity_decode($cat->name);

				$pos = strpos( strtolower( $cat_name ), strtolower( $keyword ) );

				if ( $pos !== false ) {
					$results[ $i ] = array(
						'term_id'	 => $cat->term_id,
						'taxonomy'	 => DGWT_WCAS_WOO_PRODUCT_CATEGORY,
						'value'		 => preg_replace( sprintf( "/(%s)/", $keyword ), "$1", $cat_name ),
						'url'		 => get_term_link( $cat, DGWT_WCAS_WOO_PRODUCT_CATEGORY ),
						'parents'	 => ''
					);

					// Add category parents info
					$parents = $this->get_taxonomy_parent_string( $cat->term_id, DGWT_WCAS_WOO_PRODUCT_CATEGORY, array(), array( $cat->term_id ) );

					if ( !empty( $parents ) ) {

						$results[ $i ][ 'parents' ] = sprintf( ' <em>%s <b>%s</b></em>', __( 'in', 'ajax-search-for-woocommerce' ), mb_substr( $parents, 0, -3 ) );
					}

					$i++;
				}
			}


		}

		return $results;
	}

	/**
	 * Extend research in the Woo tags
	 *
	 * @param strong $keyword
	 *
	 * @return array
	 */

	public function get_tags( $keyword ) {

		$results = array();

		$args = array(
			'taxonomy' => DGWT_WCAS_WOO_PRODUCT_TAG
		);

		$product_tags = get_terms( DGWT_WCAS_WOO_PRODUCT_TAG, $args );

// Compare keyword and term name
		$i = 0;
		foreach ( $product_tags as $tag ) {

			if ( $i < $this->limit ) {

                $tag_name = html_entity_decode($tag->name);

				$pos = strpos( strtolower( $tag_name ), strtolower( $keyword ) );

				if ( $pos !== false ) {
					$results[ $i ] = array(
						'term_id'	 => $tag->term_id,
						'taxonomy'	 => DGWT_WCAS_WOO_PRODUCT_TAG,
						'value'		 => preg_replace( sprintf( "/(%s)/", $keyword ), "$1", $tag_name ),
						'url'		 => get_term_link( $tag, DGWT_WCAS_WOO_PRODUCT_TAG ),
						'parents'	 => ''
					);

					// Add taxonomy parents info
					$parents = $this->get_taxonomy_parent_string( $tag->term_id, DGWT_WCAS_WOO_PRODUCT_TAG, array(), array( $tag->term_id ) );

					if ( !empty( $parents ) ) {

						$results[ $i ][ 'parents' ] = sprintf( ' <em>%s <b>%s</b></em>', __( 'in', 'ajax-search-for-woocommerce' ), mb_substr( $parents, 0, -3 ) );
					}

					$i++;
				}
			}
		}

		return $results;
	}

	/**
	 * Set search product limit
	 */
	public function changeWpSearchSize( $query ) {

		if ( $this->is_ajax_search() && $query->is_search ) {
               // @TODO Buffer for improve relevance.
               // Better way return all relevant posts and add link "show all results"
                $limit = $this->slots + 30;
				$query->query_vars[ 'posts_per_page' ] = $limit;
		}

		return $query;
	}

	/**
	 * Search only in products titles
	 *
	 * @param string $search SQL
	 *
	 * @return string prepared SQL
	 */

	public function searchFilters( $search, $wp_query ) {
		global $wpdb;

		if ( empty( $search ) || is_admin() ) {
			return $search; // skip processing - there is no keyword
		}

		if ( $this->is_ajax_search() || $this->is_search_page() ) {

			$q = $wp_query->query_vars;

			if ( $q[ 'post_type' ] !== DGWT_WCAS_WOO_PRODUCT_POST_TYPE ) {
				return $search; // skip processing
			}

			$n = !empty( $q[ 'exact' ] ) ? '' : '%';

			$search		 = $searchand	 = '';

			if ( !empty( $q[ 'search_terms' ] ) ) {
				foreach ( (array) $q[ 'search_terms' ] as $term ) {
					$term = esc_sql( $wpdb->esc_like( $term ) );

					$search .= "{$searchand} (";

					// Search in title
					$search .= "($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";

					// Search in content
					if ( DGWT_WCAS()->settings->get_opt( 'search_in_product_content' ) === 'on' ) {
						$search .= " OR ($wpdb->posts.post_content LIKE '{$n}{$term}{$n}')";
					}

					// Search in excerpt
					if ( DGWT_WCAS()->settings->get_opt( 'search_in_product_excerpt' ) === 'on' ) {
						$search .= " OR ($wpdb->posts.post_excerpt LIKE '{$n}{$term}{$n}')";
					}

					// Search in SKU
					if ( DGWT_WCAS()->settings->get_opt( 'search_in_product_sku' ) === 'on' ) {
						$search .= " OR (dgwt_wcasmsku.meta_key='_sku' AND dgwt_wcasmsku.meta_value LIKE '{$n}{$term}{$n}')";
					}

					$search .= ")";

					$searchand = ' AND ';
				}
			}

			if ( !empty( $search ) ) {
				$search = " AND ({$search}) ";
				if ( !is_user_logged_in() )
					$search .= " AND ($wpdb->posts.post_password = '') ";
			}
		}

		return $search;
	}

	/**
	 * @param $where
	 *
	 * @return string
	 */
	public function search_distinct($where) {
		if ( $this->is_ajax_search() || $this->is_search_page() ) {
			return 'DISTINCT';
		}

		return $where;
	}

	/**
	 * Join the postmeta column in the search posts SQL
	 */

	public function searchFiltersJoin( $join, $query ) {
		global $wpdb;

		if ( empty( $query->query_vars[ 'post_type' ] ) || $query->query_vars[ 'post_type' ] !== 'product' ) {
			return $join; // skip processing
		}

		if ( ($this->is_ajax_search() || $this->is_search_page()) && !is_admin() ) {

			if ( DGWT_WCAS()->settings->get_opt( 'search_in_product_sku' ) === 'on' ) {
				$join .= " INNER JOIN $wpdb->postmeta AS dgwt_wcasmsku ON ( $wpdb->posts.ID = dgwt_wcasmsku.post_id )";
			}
		}


		return $join;
	}

	/**
	 * Corrects the search by excerpt if necessary.
	 * WooCommerce adds search in excerpt by defaults and this should be corrected.
	 *
	 * @since 1.1.4
	 *
	 * @param string $where
	 * @return string
	 */
	public function fixWooExcerptSearch($where){
		global $wp_the_query;

		// If this is not a WC Query, do not modify the query
		if ( empty( $wp_the_query->query_vars['wc_query'] ) || empty( $wp_the_query->query_vars['s'] ) ) {
			return $where;
		}

		if ( DGWT_WCAS()->settings->get_opt( 'search_in_product_excerpt' ) !== 'on' ) {

			$where = preg_replace(
				"/OR \(post_excerpt\s+LIKE\s*(\'\%[^\%]+\%\')\)/",
				"", $where );
		}

		return $where;
	}

	/**
	 * Get taxonomy parent
	 *
	 * @param int $term_id
	 * @param string $taxonomy
	 *
	 * @return string
	 */

	private function get_taxonomy_parent_string( $term_id, $taxonomy, $visited = array(), $exclude = array() ) {

		$chain		 = '';
		$separator	 = ' > ';

		$parent = get_term( $term_id, $taxonomy );

		if ( empty( $parent ) || !isset( $parent->name ) ) {
			return '';
		}

		$name = $parent->name;

		if ( $parent->parent && ( $parent->parent != $parent->term_id ) && !in_array( $parent->parent, $visited ) ) {
			$visited[] = $parent->parent;
			$chain .= $this->get_taxonomy_parent_string( $parent->parent, $taxonomy, $visited );
		}

		if ( !in_array( $parent->term_id, $exclude ) ) {
			$chain .= $name . $separator;
		}

		return $chain;
	}

	/**
	 * Change default search query on the search results page
	 *
	 * @since 1.0.3
	 *
	 * @param object $query
	 *
	 * @return object
	 */

	public function setSearchResultsQuery( $query ) {
		global $woocommerce;

		if ( !$this->is_ajax_search() && $query->is_search ) {

			if ( $this->is_search_page() ) {

				$query->query_vars[ 'post_type' ] = DGWT_WCAS_WOO_PRODUCT_POST_TYPE;
				$query->query_vars[ 'ignore_sticky_posts' ] = 1;
				$query->query_vars[ 'suppress_filters' ] = false;

				// Backward compatibility WC < 3.0
				if ( Helpers::compare_wc_version( '3.0', '<' ) ) {
					$query->query_vars[ 'meta_query' ] = $this->get_meta_query();
				}else{
					$query->query_vars[ 'tax_query' ] = $this->get_tax_query();
				}


				$ordering_args = $woocommerce->query->get_catalog_ordering_args( 'title', 'asc' );

				$query->query_vars[ 'orderby' ] = $ordering_args[ 'orderby' ];
				$query->query_vars[ 'order' ] = $ordering_args[ 'order' ];

                $query->query_vars = apply_filters('dgwt_wcas_products_search_page_args', $query->query_vars); // deprecated since v1.2.0
				$query->query_vars = apply_filters('dgwt/wcas/search_query/search_page/args', $query->query_vars);

			}
		}

		return $query;
	}

    /**
     * Force woocommerce product post type on search
     *
     * @since 1.2.0
     *
     * @param $query
     *
     * @return object
     */
	public function forcePostType($query){

        if($this->is_search_page() || $this->is_ajax_search()){
            if($query->is_search){
                $query->query_vars[ 'post_type' ] = DGWT_WCAS_WOO_PRODUCT_POST_TYPE;
            }
        }

        return $query;
    }

	/**
	 * Check if is WooCommerce search results page
	 *
	 * @since 1.1.3
	 *
	 * @return bool
	 */
	public function is_search_page() {
		if ( ! empty( $_GET['dgwt_wcas'] ) && ! empty( $_GET['s'] ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Check if is ajax search processing
	 *
	 * @since 1.1.3
	 *
	 * @return bool
	 */
	public function is_ajax_search() {
		if ( defined( 'DGWT_WCAS_AJAX' ) && DGWT_WCAS_AJAX ) {
			return true;
		}

		return false;
	}

}

?>