<div class="wrap">
	<h1><?php echo get_admin_page_title()?></h1>
	<form method="post" action="options.php">
		<?php
			settings_errors( 'sl147_gift_settings_errors' );
			settings_fields( $this->settings['option_group']);
			do_settings_sections( $this->settings['sl147_page_slug'] );
			submit_button(); 
		?>
	</form>
</div>
