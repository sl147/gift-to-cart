<?php

/**
 * 
 */
class Sl147_gift_options {

	public $settings;

	function __construct() {

		$this->settings = [
			'option_group'         => 'sl147_gift_option_group',
			'sl147_page_slug'      => 'sl147_gift_page',
			'sl147_settings_bd'    => 'sl147_gift_settings_bd',
			'sl147_section_id'     => 'sl147_gift_section_id',
			'function'             => 'sl147_gift_display_options',
			'background_color'     => 'sl147_gift_background_color',
			'text_color'           => 'sl147_gift_text_color',
			'link_color'           => 'sl147_gift_link_color',
			'popup_display_check'  => 'sl147_gift_popup_display_check',
			'width'                => 'sl147_gift_width',
			'delete_check'         => 'sl147_gift_delete_check',
			'category'             => 'sl147_gift_category_promotional',
		];

		add_action( 'admin_menu', array( $this, 'add' ), 25 );
		add_action( 'admin_init', array( $this, 'settings' ) );
		add_action( 'admin_notices', array( $this, 'notice' ) );
	}

	private function sl147_add_error($name_field, $message){
		add_settings_error(
			'sl147_gift_settings_errors',
			$name_field,
			$message,
			'error' // may be success, warning, info
		);
		return get_option( $this->settings['sl147_settings_bd'] )[$name_field];
	}

	public function sl147_gift_validate( $input ) {

		foreach( $input as $name => & $val ){

			if ($name == $this->settings['background_color']) {
				if (empty($val)) {
					$input[$this->settings['background_color']] = $this->sl147_add_error($this->settings['background_color'],__('background color').' '.__('must be not empty','sl147_gift'));		
				}				
			}

			if ($name == $this->settings['text_color']) {
				if (empty($val)) {
					$input[$this->settings['text_color']] = $this->sl147_add_error($this->settings['text_color'],$name.__('text color').' '.__('must be not empty'.$err,'sl147_gift').$val);
				}				
			}

			if ($name == $this->settings['link_color']) {
				if (empty($val)) {
					$input[$this->settings['link_color']] = $this->sl147_add_error($this->settings['link_color'],__('link color').' '.__('must be not empty','sl147_gift'));	
				}				
			}
		}
		return $input;
	}

	public function add(){
		add_submenu_page(
			'sl147_gift-slug',
			__( 'Settings', 'sl147_gift'),
			__( 'Settings', 'sl147_gift'),
			'manage_options',
			$this->settings['sl147_page_slug'],
			[ $this, 'sl147_gift_display' ]
		);
	}

	public function sl147_gift_get_categories(){
		return get_categories( [
			'taxonomy' => 'product_cat',
			'orderby'  => 'name'
		]);
	}

	public function sl147_gift_display() {

		include PLUGIN_DIR_PATH . 'admin/partials/sl147_gift_settings.php';
	}

	public function sl147_gift_section() {
		//echo "<div style='font-size:24px;'>".$this->settings['text_color']." Sekcja kolorów callback</div>";
	}

	public function settings(){

		register_setting(
			$this->settings['option_group'],
			$this->settings['sl147_settings_bd'],
			array($this,'sl147_gift_validate')
		 );

		add_settings_section( $this->settings['sl147_section_id'], '', array($this,'sl147_gift_section'), $this->settings['sl147_page_slug'] );

		$this->sl147_add_field($this->settings['background_color'],    __( 'background color', 'sl147_gift' ), 'text');
		$this->sl147_add_field($this->settings['text_color'],          __( 'text color', 'sl147_gift' ), 'text');
		$this->sl147_add_field($this->settings['link_color'],          __( 'link color', 'sl147_gift' ), 'text');
		$this->sl147_add_field($this->settings['category'],            __( 'category promotional', 'sl147_gift' ), 'select', $this->sl147_gift_get_categories());
		$this->sl147_add_field($this->settings['popup_display_check'], __( 'popup display check', 'sl147_gift' ), 'checkbox');
		$this->sl147_add_field($this->settings['width'],               __( 'width popup block %%', 'sl147_gift' ), 'number'); 
		$this->sl147_add_field($this->settings['delete_check'],        __( 'remove data from database when plugin is removed', 'sl147_gift' ), 'checkbox');
	}

	private function sl147_add_field($name_field, $label, $type, $vals = ""){
		add_settings_field(
			$name_field,
			__($label,'sl147_gift'),
			array($this, $this->settings['function']),
			$this->settings['sl147_page_slug'],
			$this->settings['sl147_section_id'],
			array( 
				'label_for' => $name_field,
				'class'     => 'sl147_gift-class',
				'name'      => $name_field,
				'type'      => $type,
				'vals'      => $vals
			)
		);
	}

	private function sl147_gift_checkbox($val, $index){

		echo "<input type='checkbox' id='$index' name='" . $this->settings['sl147_settings_bd'] . "[$index]' value='1' ".checked( 1, $val[$index], false )." />";  
	}

	private function sl147_gift_text($val, $index){

		echo "<input type='text' id='$index' name='" . $this->settings['sl147_settings_bd'] . "[$index]' value='$val[$index]' />";  
	}

	private function sl147_gift_number($val, $index){

		echo "<input type='number' id='$index' name='" . $this->settings['sl147_settings_bd'] . "[$index]' min='40' max='100' step='1' value='$val[$index]' />";  
	}

	private function sl147_gift_select($val, $index, $vals){

		echo "<select id='$index' name='" . $this->settings['sl147_settings_bd'] . "[$index]'>";
		foreach ($vals as $value) {
			$selected = ($val[$index] == $value->term_id) ? "selected='selected'" : '';        
			echo "<option value = '".$value->term_id."' $selected>".$value->name ."</option>";
		}
		echo "</select>";
	}

	public function sl147_gift_display_options($args){
		$val = get_option($this->settings['sl147_settings_bd']);
		switch ( $args['type'] ){
			case 'text':
				$this->sl147_gift_text($val, $args['name']);
			break;

			case 'number':
				$this->sl147_gift_number($val, $args['name']);
			break;

			case 'checkbox':
				$this->sl147_gift_checkbox($val, $args['name']);
			break;

			case 'select':
				$this->sl147_gift_select($val, $args['name'], $args['vals']);
			break;
		}
		
	}

	public function notice() {
		if(
			isset( $_GET[ 'page' ] )
			&& $this->settings['sl147_page_slug'] == $_GET[ 'page' ]
			&& isset( $_GET[ 'settings-updated' ] )
			&& true == $_GET[ 'settings-updated' ]

		) include PLUGIN_DIR_PATH . 'admin/partials/sl147_gift_form_update.php';
	}
}