<?php

/**
 * 
 */
class Sl147_gift_orders extends Sl147_gift_main{

	private $sl147_models;

	function __construct() {
		$this->sl147_models = new Sl147_gift_models("sl147_gift");
		add_action( 'admin_menu', array( $this, 'add' ), 25 );
	}

	public function add(){
		add_submenu_page(
			'sl147_gift-slug',
			__( 'Orders', 'sl147_gift'),
			__( 'Orders', 'sl147_gift'),
			'manage_options',
			'sl147_page_orders_slug',
			[ $this, 'sl147_gift_orders_display' ]
		);
	}

	private function sl147_get_strtotime($dt) {
		return date('Y-m-d',strtotime ($dt));
	}

	public function sl147_gift_orders_display() {
		
		$orders_promotion   = [];
		$stage              = true;
		$gift_all_promotion = $this->sl147_gift_get_all_promotion_products_ext();

		if( wp_verify_nonce( $_POST['nonce_field_gift_orders'], 'nonce_gift_action_orders' )){
			$product_promotion_ID = $_POST['product_promotion'];
			$product              = $this->sl147_models->gift_get_row_where("*", "product_ID", $_POST['product_promotion']);

			$dfrom  = $this->sl147_get_strtotime($product->date_from);
			$dto    = $this->sl147_get_strtotime($product->date_to);
			$stage  = false;
			$orders = wc_get_orders( array(
				'date_created' => '>=' . $product->date_from,
			) );
			foreach ( $orders as $order ) {

				$dcreated = $this->sl147_get_strtotime($order->get_date_created());

				if(($dcreated >= $dfrom) && ($dcreated <= $dto)) {
					$order_items = $order->get_items();
					foreach ($order_items as $value) {
						if ($value->get_product_id() == $product_promotion_ID) {

							$data                   = $order->get_data();
							$product_promotion_name = $value->get_name();
							$arr                    = array(
								'id'           => $order->get_id(),
								'user_name'    =>  $data['shipping']['first_name'].' '.$data['shipping']['last_name'],
								'date_created' => date("d-m-Y", strtotime($order->get_date_created())),
								'total'        => $order->get_total()
							);

							array_push( $orders_promotion, $arr);
							$sl147_total += $order->get_total();
						}
					}
				}
			}		
		}

	include PLUGIN_DIR_PATH . 'admin/partials/sl147_gift_orders.php';

	}
}