=== Gift to cart ===
Contributors: sl147
Tags: Gift, gratis, cart
Tested Wordpress: 3.0.1
Tested Woocommerce: 6.6.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Gift to the cart

== Description ==

Adds a promotional product to the cart when certain conditions are met

== Installation ==

Upload the Gift to cart plugin to your site, Activate it.
To use the Gift to cart you should use the do_action( 'sl147_woocommerce_gift' )
after do_action( 'woocommerce_before_cart_contents' )
Place it in cart templates .

== Frequently Asked Questions ==

= 1. How do I publish the MTPL Insurance calculator in the page or post? =
Place do_action( 'sl147_woocommerce_gift' ) in cart page and done.


== Changelog ==

= 1.0 =
*  Initial version