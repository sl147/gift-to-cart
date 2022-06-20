<?php
class Sl147_gift_Deactivator {

	public static function deactivate() {
		global $wpdb;

		$sl147_options = get_option('sl147_gift_settings_bd');

		if ($sl147_options['sl147_gift_delete_check']) {

			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
			$table_gift = $wpdb->prefix . 'sl147_gift';
			$sql = "DROP TABLE IF EXISTS ". $table_gift;
			$wpdb->query( $sql );

			$table_gift = $wpdb->prefix . 'sl147_gift_add';
			$sql = "DROP TABLE IF EXISTS ". $table_gift;
			$wpdb->query( $sql );

			delete_option('sl147_gift_settings_bd');
		}
	}
}