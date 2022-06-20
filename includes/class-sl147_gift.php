<?php

/**
 * 
 */
class Sl147_gift extends Sl147_gift_main {

	function __construct() {
		$this->sl147_version     = (defined('SL147_GIFT_VERSION')) ? SL147_GIFT_VERSION : '1.0.0';   
		$this->sl147_plugin_name = 'sl147_gift';
		$this->sl147_models      = new Sl147_gift_models("sl147_gift");
		$this->sl147_add_models  = new Sl147_gift_models("sl147_gift_add");
		$this->sl147_options     = get_option('sl147_gift_settings_bd');
	}

	private function sl147_cart_calculate_totals() {
		foreach ( WC()->cart->get_cart() as $cart_id => $cart_item ) {
			if( $cart_item['product_id'] == SL147_PRODUCT_ID ) {       
				$cart_item['data']->set_price( SL147_PRODUCT_PRICE );
				WC()->cart->calculate_totals();
			}
		}
	}

	private function sl147_delete_item_from_cart() {
		foreach ( WC()->cart->get_cart() as $cart_id => $cart_item ) {
			if( $cart_item['product_id'] == SL147_PRODUCT_ID ) {
				WC()->cart->remove_cart_item( $cart_id ); 
				WC()->cart->calculate_totals(); 
			}
		}    
	}

	private function sl147_is_additional_products_in_cart(){
		foreach ( WC()->cart->get_cart() as $cart_id => $cart_item ) {
			if (in_array($cart_item['product_id'], SL147_ADD_PRODUCT_ID)) return true;
		}
		return false;  
	}
	
	private function sl147_is_additional_product($product_promotion_ID) {
		return ($this->sl147_gift_get_all_promotion_products_ext($product_promotion_ID)) ? true : false;
	}

	private function sl147_total_suma() {
		return WC()->cart->get_totals()['subtotal'] + WC()->cart->get_totals()['subtotal_tax'];
	}

	public function sl147_add_gift(  ) {

		if (!SL147_PRODUCT_ID) return;

		$sl147_is_add_product = ($this->sl147_get_add_products_by_promotion_ID(SL147_PRODUCT_ID)) ? true : false;

		if(($sl147_is_add_product &&  $this->sl147_is_additional_products_in_cart()) ||
		  (!$sl147_is_add_product && ($this->sl147_total_suma() > SL147_PRODUCT_SUMA_MIN))) {  
			if( !WC()->cart->find_product_in_cart( WC()->cart->generate_cart_id( SL147_PRODUCT_ID ) ) ) {
				$lan = WC()->cart->add_to_cart( SL147_PRODUCT_ID, $quantity = 1, $variation_id = 0, $variation = array(), $cart_item_data = array() );
				$this->sl147_cart_calculate_totals();
			}
		}else{
			$sl147_product    = wc_get_product( SL147_PRODUCT_ID );
			$add_products_all = $this->sl147_get_add_products_by_promotion_ID(SL147_PRODUCT_ID);
			if ($this->sl147_options['sl147_gift_popup_display_check']) {
				$currency_symbol =  get_woocommerce_currency_symbol();
				include_once PLUGIN_DIR_PATH . 'public/partials/sl147_gift_popup.php';
			}
			$this->sl147_delete_item_from_cart();
		}
	}

	private function sl147_gift_get_args() {
		return [
			'post_type'   => 'product',
			'nopaging'    =>  true,
			'orderby'     => 'name',
			'order'       => 'ASC'
		];
	}

	private function sl147_gift_get_all_products() {
		return get_posts($this->sl147_gift_get_args());
	}

	private function sl147_gift_get_products() {
	    $args = $this->sl147_gift_get_args();
	    foreach (get_categories( ['taxonomy' => 'product_cat'] ) as $value) {
	    	if (get_option('sl147_gift_settings_bd')['sl147_gift_category_promotional'] == $value->term_id) {
		    	$category = $value->slug ;
		    	break;
	    	}
		}

	    $args['product_cat'] = $category;

	    return get_posts($args);
	}

	private function sl147_get_add_products_by_promotion_ID($product_promotion_ID) {
		$result = $this->sl147_add_models->gift_get_results_where("*", 'id_promotion_product', $product_promotion_ID);

		return (empty($result)) ? [] : $result;
	}

	private function sl147_is_add_product($product_promotion_ID, $id_add_product) {

		$add_products_all = $this->sl147_get_add_products_by_promotion_ID($product_promotion_ID);

		foreach ($add_products_all as $value) {
			if ($value->id_add_product == $id_add_product) return true;
		}
		return false;
	}

	public function sl147_gift() {
		if( wp_verify_nonce( $_POST['nonce_field_gift'], 'nonce_gift_action' )) {
			$data = [
				"product_id" => $_POST['product'],
				"price"      => $_POST['price'],
				"suma_min"   => $_POST['suma_min'],
				"date_from"  => $_POST['dateFrom'],
				"date_to"    => $_POST['dateTo'],
			];
			$format   = ["%d", "%s", "%d", "%s", "%s"];   
			$dat      = $this->sl147_models->gift_insert ($data, $format); 
		}
		$products_all = $this->sl147_gift_get_products();
		$gift_all     = $this->sl147_models->gift_get_results("*");
		include PLUGIN_DIR_PATH . 'admin/partials/sl147_gift_form.php';
	}

	public function sl147_additional() {
		$stage = true;
		if( wp_verify_nonce( $_POST['nonce_field_gift_choose'], 'nonce_gift_action_choose' )){
			$product_promotion_ID = $_POST['product_promotion'];
			$products_all = $this->sl147_gift_get_all_products();
			$stage        = false;
		}
		if( wp_verify_nonce( $_POST['nonce_field_gift_add'], 'nonce_gift_action_add' )) {
			$product_promotion_ID = $_POST['product_promotion_ID'];
			if (!$this->sl147_is_add_product($_POST['product_promotion_ID'], $_POST['id_add_product'])){
				$data = [
					"id_promotion_product" => $_POST['product_promotion_ID'],
					"id_add_product"       => $_POST['id_add_product'],
				];
				$format   = ["%d", "%d" ];   
				$dat      = $this->sl147_add_models->gift_insert ($data, $format); 
			}
			$products_all = $this->sl147_gift_get_all_products();
			$stage        = false;
		}
		$gift_all_promotion = $this->sl147_gift_get_all_promotion_products_ext();
		$add_products_all   = ($stage) ? [] : $this->sl147_get_add_products_by_promotion_ID($product_promotion_ID);
		include_once PLUGIN_DIR_PATH . 'admin/partials/sl147_gift_add_form.php';
	}

	public function sl147_edit_gift() {
		if(!empty($_REQUEST['action_gift']) and $_REQUEST['action_gift'] == 'delete') {
			$del = $this->sl147_models->gift_delete([ 'ID' => $_GET['id_gift']], "%d");
			header( 'Location: admin.php?page=sl147_gift-slug' );
		}
		if(!empty($_REQUEST['action_gift']) and $_REQUEST['action_gift'] == 'delete_add') {
			$del = $this->sl147_add_models->gift_delete([ 'ID' => $_GET['id_gift']], "%d");
			header( 'Location: admin.php?page=sl147_add_product-slug' );
		}     
	}

	public function sl147_register_menu(){
		add_menu_page('sl147_gift', __( 'Promotional products', 'sl147_gift' ), 1, 'sl147_gift-slug',array($this,'sl147_gift') ,"dashicons-clipboard",5);
		add_submenu_page( 'sl147_gift-slug', __( 'Additional products', 'sl147_gift' ), __( 'Additional products', 'sl147_gift' ), 'manage_options', 'sl147_add_product-slug', array($this,'sl147_additional'));
	}

	public function sl147_gift_enqueue_js_and_css(){
		wp_enqueue_script( $this->sl147_plugin_name.'_js', plugins_url('admin/js/sl147_gift.js',dirname(__FILE__)), array( 'jquery' ), $this->sl147_version, true );
		wp_enqueue_style($this->sl147_plugin_name.'_css', plugins_url('admin/css/sl147_gift.css',dirname(__FILE__)), array(), $this->sl147_version, 'all' );
	}

	public function sl147_add_custom_price( $cart ) {
		if ( is_admin() && ! defined( 'DOING_AJAX' ) )	return;
		if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 ) return;
		if (SL147_PRODUCT_ID) $this->sl147_cart_calculate_totals();
		return;
	}

	public function run(){
		add_action( 'init', array($this,'sl147_gift_enqueue_js_and_css' ));

		add_action( 'admin_menu', array($this,'sl147_register_menu') ); 
		add_action( 'init', array($this,'sl147_edit_gift') );

		add_action( 'sl147_woocommerce_gift', array($this, 'sl147_add_gift'), 10, 1 ); 
		add_action( 'woocommerce_before_calculate_totals', array($this, 'sl147_add_custom_price'), 1000, 1);
	}
}