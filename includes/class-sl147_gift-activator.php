<?php

class Sl147_gift_Activator {

	public static function activate() {
		global $wpdb;

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$table_gift = $wpdb->prefix . 'sl147_gift';
		$sql = "CREATE TABLE IF NOT EXISTS ". $table_gift." (
			ID BIGINT( 20 ) NOT NULL AUTO_INCREMENT,
			product_id INT( 10 ) NOT NULL,
			price DECIMAL( 10,2 ),
			suma_min DECIMAL( 10 ) NOT NULL,
			date_from DATE,
			date_to DATE,
			activate BOOLEAN NOT NULL DEFAULT FALSE,
			PRIMARY KEY  ( ID )
		) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";                
		dbDelta( $sql );

		$table_gift = $wpdb->prefix . 'sl147_gift_add';
		$sql = "CREATE TABLE IF NOT EXISTS ". $table_gift." (
			ID BIGINT( 20 ) NOT NULL AUTO_INCREMENT,
			id_promotion_product INT( 7 ) NOT NULL,
			id_add_product INT( 7 ) NOT NULL,
			PRIMARY KEY  ( ID )
		) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";                
		dbDelta( $sql );        
	}

}