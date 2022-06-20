<?php

/**
 * 
 */
class Sl147_gift_main {
	
	//public $sl147_models_ext;

	function __construct() {
		//$this->sl147_models_ext = new Sl147_gift_models("sl147_gift");
	}

	public function sl147_gift_get_all_promotion_products_ext() {
		//echo "string";
		$sl147_models_ext = new Sl147_gift_models("sl147_gift");
		return $sl147_models_ext->gift_get_results("*");
	}
}