<?php

namespace DgoraWcas;


class Product
{
    private $productID = 0;
    private $wcProduct = null;
    private $variations = array();

    public function __construct($product)
    {
        if ( ! empty($product) && is_object($product) && is_a($product, 'WC_Product')) {
            $this->productID = $product->get_id();
            $this->wcProduct = $product;
        }

        if ( ! empty($product) && is_object($product) && is_a($product, 'WP_Post')) {
            $this->productID = absint($product->ID);
            $this->wcProduct = wc_get_product($product);
        }

        if (is_numeric($product) && 'product' === get_post_type($product)) {
            $this->productID = absint($product);
            $this->wcProduct = wc_get_product($product);
        }
    }

    /**
     * Get product ID (post_id)
     * @return INT
     */
    public function getID()
    {
        return $this->productID;
    }

    /**
     * Get product name
     * @return string
     */
    public function getName()
    {
        return $this->wcProduct->get_name();
    }

    /**
     * Get product short description
     * @return string
     */
    public function getDescription()
    {

        $output = '';

        $desc = $this->wcProduct->get_short_description();

        if (empty($desc)) {
            $desc = $this->wcProduct->get_description();
        }

        if ( ! empty($desc)) {
            $output = Helpers::strCut(wp_strip_all_tags($desc), 120);
            $output = html_entity_decode($output);
        }

        return $output;

    }

    /**
     * Get product permalink
     * @return string
     */
    public function getPermalink()
    {
        return $this->wcProduct->get_permalink();
    }

    /**
     * Get product thumbnail url
     * @return string
     */
    public function getThumbnailSrc()
    {
        $src = '';

        $imageID = $this->wcProduct->get_image_id();

        if ( ! empty($imageID)) {
            $imageSrc = wp_get_attachment_image_src($imageID, 'dgwt-wcas-product-suggestion');

            if ( ! empty($imageSrc[0])) {
                $src = $imageSrc[0];
            }
        }

        return $src;
    }

    /**
     * Get product thumbnail
     * @return string
     */
    public function getThumbnail()
    {
        return '<img src="' . $this->getThumbnailSrc() . '" alt="' . $this->getName() . '" />';
    }

    /**
     * Get HTML code with the product price
     * @return string
     */
    public function getPriceHTML()
    {
        return $this->wcProduct->get_price_html();
    }

    /**
     * Get SKU
     * @return string
     */
    public function getSKU()
    {
        return $this->wcProduct->get_sku();
    }

    /**
     * Get available variations
     * @return array
     */
    public function getAvailableVariations()
    {
        $childrens = $this->wcProduct->get_children();

        if (empty($this->variations) && ! empty($childrens)) {
            $this->variations = $this->wcProduct->get_available_variations();
        }

        return $this->variations;

    }

    /**
     * Get all SKUs for variations
     * @return array
     */
    public function getVariationsSKUs()
    {
        $skus = array();

        foreach ($this->variations as $variation) {

            if ( ! empty($variation->variation_has_sku)) {
                $skus[] = $variation->get_sku();
            }
        }

        return $skus;
    }


    /**
     * Check, if class is initialized correctly
     * @return bool
     */
    public function isValid()
    {
        $isValid = false;

        if (is_a($this->wcProduct, 'WC_Product')) {
            $isValid = true;
        }

        return $isValid;
    }

    /**
     * Get total reviews
     *
     * @return
     */
    public function getReviewCount()
    {
        return $this->wcProduct->get_review_count();
    }

    /**
     * WooCommerce raw product object
     *
     * @return object
     */
    public function getWooObject()
    {
        return $this->wcProduct;
    }


}