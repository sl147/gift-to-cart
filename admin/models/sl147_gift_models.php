<?php

/**
 * 
 */
class Sl147_gift_models {
	
	function __construct($table) {
		$this->table = WPDB_PREFIX . $table;
	}

	public function gift_get_results ($what) {
		global $wpdb;
		return $wpdb->get_results("SELECT " . $what . " FROM " . $this->table);
	}

	public function gift_get_results_where($what, $where_name, $where_value) {
		global $wpdb;
		return $wpdb->get_results("SELECT " . $what . " FROM " . $this->table . " WHERE ".$where_name."=".$where_value);
	}

	public function gift_get_row_where($what, $where_name, $where_value) {
		global $wpdb;
		return $wpdb->get_row("SELECT " . $what . " FROM " . $this->table . " WHERE ".$where_name."=".$where_value);
	}

	public function gift_get_row_date($what) {
		global $wpdb;
		return $wpdb->get_row("SELECT " . $what . " FROM " . $this->table . " WHERE CURDATE() BETWEEN DATE(date_from) AND DATE(date_to)");
	}

	public function gift_delete($where, $where_format) {
		global $wpdb;
		return $wpdb->delete($this->table, $where, $where_format);
	}

	public function gift_insert($data, $format){
		global $wpdb;
		return $wpdb->insert($this->table, $data, $format);
	}

	public function gift_update ($data, $where, $format, $where_format) {
		global $wpdb;
		return $wpdb->update($this->table, $data, $where, $format, $where_format);
	}
}