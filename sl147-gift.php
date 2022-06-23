<?php

/**
 * The plugin bootstrap file
 *
 *
 * @link             https://vaolab.pl/
 * @since             1.0.0
 * @package           sl147-gift
 *
 * @wordpress-plugin
 * Plugin Name:       Gift to cart
 * Plugin URI:        https://vaolab.pl/
 * Description:       Added gift to cart
 * Version:           1.0.0
 * Author:            Yaroslaw Livchak
 * Text Domain:       sl147_gift
 * Domain Path:       /languages
 * WC tested up to:   6.6.0
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}
global $wpdb;
define( 'WPDB_PREFIX',             $wpdb->prefix);
define( 'SL147_PRODUCT_ID',        sl147_get_product_ID()->product_id);
define( 'SL147_PRODUCT_PRICE',     sl147_get_product_ID()->price);
define( 'SL147_PRODUCT_SUMA_MIN',  sl147_get_product_ID()->suma_min);
define( 'PLUGIN_DIR_PATH',         plugin_dir_path( __FILE__));
define( 'SL147_ADD_PRODUCT_ID',    sl147_get_additional_products_ID());
define( 'SL147_GIFT_VERSION',      '1.0.0');
define( 'SL147_GIFT_PLUGIN_NAME', 'sl147_gift');

function sl147_add_gift_textdomain() {
    $locale = determine_locale();
    load_plugin_textdomain( 'sl147_gift', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}

add_action('plugins_loaded', 'sl147_add_gift_textdomain');

function sl147_get_additional_products_ID(){
    require_once plugin_dir_path( __FILE__ ) . 'admin/models/sl147_gift_models.php';   
    $gift_models = new Sl147_gift_models("sl147_gift_add");
    $gift_all    = $gift_models->gift_get_results_where('id_add_product', 'id_promotion_product', SL147_PRODUCT_ID);
    $data=[];
    foreach ($gift_all as $value) {
        $data[] = $value->id_add_product;
    }
    return $data;
}

function sl147_get_product_ID() {  
    require_once plugin_dir_path( __FILE__ ) . 'admin/models/sl147_gift_models.php';   
    $gift_models = new Sl147_gift_models("sl147_gift");
    $gift_all    = $gift_models->gift_get_row_date("*");

    return ($gift_all) ? $gift_all : false;
}

function deactivate_sl147_gift() {
    require_once PLUGIN_DIR_PATH . 'includes/class-sl147_gift-deactivator.php';
    Sl147_gift_Deactivator::deactivate();
}

function activate_sl147_gift() {
    require_once PLUGIN_DIR_PATH . 'includes/class-sl147_gift-activator.php';
    Sl147_gift_Activator::activate();
}

register_activation_hook( __FILE__, 'activate_sl147_gift' );
register_deactivation_hook( __FILE__, 'deactivate_sl147_gift' );
require_once plugin_dir_path( __FILE__ ) . 'includes/class-sl147_gift_main.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-sl147_gift.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-sl147_gift_options.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-sl147_gift_orders.php';

require_once plugin_dir_path( __FILE__ ) . 'admin/models/sl147_gift_models.php';

function run_sl147_gift() {
    
    $main          = new Sl147_gift_main();
    $plugin        = new Sl147_gift();    
    $sl147_options = new Sl147_gift_options();
    $sl147_orders  = new Sl147_gift_orders();
    $plugin->run();
}

add_action('woocommerce_before_cart', 'sl147_gift_start', 1);

function sl147_gift_start() {
    do_action( 'sl147_woocommerce_gift' );
}

do_action( 'sl147_woocommerce_gift' );
run_sl147_gift();