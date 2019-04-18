=== WC Pickup Store ===
Contributors: keylorcr
Donate link: https://www.paypal.me/keylorcr
Tags: ecommerce, e-commerce, store, local pickup, store pickup, woocommerce, local shipping, store post type, recoger en tienda
Requires at least: 4.7
Tested up to: 5.0.3
Stable tag: 1.1.1
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WC Pickup Store is a custom shipping method that allows you to set one or multiple stores to local pickup in checkout page in WooCommerce

== Description ==
WC Pickup Store is a shipping method able to sets up a custom post type "store" to manage stores in WooCommerce and activate them for shipping method "Local Pickup" in checkout page. It also includes several options to show content by Widget or Visual Composer element or configure this shipping costs.


### Features And Options:
* Compatible with Visual Composer with a custom element to print the stores in pages.
* Widget option.
* Dropdown of stores in Checkout page.
* Local pickup details in thankyou page, order details and emails.
* Archive template is now available.
* Shipping costs by method or per each store.
* All templates from /wc-pickup-store/templates/ can be overriden in custom themes.
* Filters and actions are available throughout the code to manage your own custom options.
* Font Awesome and Bootstrap css libraries are included into the plugin


== Installation ==

= Requires WooCommerce =

1. Upload the plugin files to the `/wp-content/plugins/wc-pickup-store` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Go to settings page from `Menu > Stores > Settings` or the shipping methods page in WC to activate `WC Pickup Store` shipping method.
4. Done.


== Frequently Asked Questions ==

= How to setup? =
Just activate the plugin, go to settings page and enable the shipping method. Customize the shipping method title, default store and checkout notification message.

= How to manage stores? =
Go to Menu > Stores > All Stores > Add New

= Can I edit the store templates? =
Yes, you can override all the templates. Just copy from /plugins/wc-pickup-store/templates/ to /theme/template-parts/. Single store and archive page might be overriden in /theme/ directory as WordPress does.

= How do I replace or remove waze icon? =
Simply use filters wps_store_get_waze_icon or wps_store_get_vc_waze_icon to manage waze icon

= Can I set a default store in checkout? =
Yes, just go to Menu > Appearance > Customize > WC Pickup Store > Default Store

= Can I set custom page without using Visual Composer? =
The shortcode functionality had been removed since previous versions but since version 1.5.13 you can use the `archive-store.php` located in the plugin templates directory

= Is there a way to add a price for the shipping method? =
Fortunately since version 1.5.13 the option to set custom costs by shipping method or per stores is available. Hope you enjoy it!


== Screenshots ==
1. WC Pickup Store shipping configurations.
2. Default Store.	
3. Checkout page.
4. Order details.
5. VC element.
6. VC element Result.
7. Widget Element.
8. Widget Element Result.
9. Published store validation.
10. WC error after store validation.
11. Email notification
12. Shipping cost by shipping method
13. Shipping cost per stores


== Changelog ==
= 1.5.14 =
* Change of wp_enqueue_style instead of using wp_register_style with bootstrap and font awesome libraries

= 1.5.13 =
* **New** shipping method custom price
* **New** adding shipping method price per store
* Fix in VC element initialization
* Fix in image custom size validation used in VC custom element
* **New** Archive Template
* New .pot file
* Font Awesome and Bootstrap css have been included

= 1.5.12 =
* Logo waze svg
* Filters wps_store_get_waze_icon and wps_store_get_vc_waze_icon to manage waze icon

= 1.5.11 =
* Single store template
* Filter wps_store_query_args for store query args
* Fix esc_html to print content in template
* VC element and widget from template

= 1.5.10 =
* Validate whether all stores are published, otherwise, shipping method is not applicable
* Fix selected store notification in emails
* Notification was added in admin panel 
* Editor field was added to stores

= 1.5.9 =
* Latest stable version


== Upgrade Notice ==
= 1.5.14 =
* Change of wp_enqueue_style instead of using wp_register_style with bootstrap and font awesome libraries

= 1.5.13 =
* Shipping costs added by shipping method or per each store
* Archive template added
* File .pot updaded
* Fixes in VC element
* Font Awesome and Bootstrap css have been included

= 1.5.12 =
* Filters wps_store_get_waze_icon and wps_store_get_vc_waze_icon to manage waze icon

= 1.5.11 =
* Fix esc_html to print content in template

= 1.5.10 =
* Fix selected store notification in emails
* Fix validation for available stores in checkout

= 1.5.9 =
* Fix: Validate shipping method before to show the store in checkout page
* Update: Change in shipping method title to remove the amount ($0.00)

= 1.5.8 =
* Update: Textdomain and function names
* Delete: provincias taxonomy
* Add: Minify VC element styles file
