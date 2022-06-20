<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

<div id="vue_add">
	<div class="row">
		<div class="col-lg-1 col-md-1"></div>
		<button @click="show=!show" class='btn btn-info sl147_form_block'>
			<?php _e( 'Add a new product', 'sl147_gift' )?>		
		</button>
	</div>
	<form v-show="show" method="post" class="form-group  sl147_gift_form" action="<?php admin_url('admin-post.php')?>">
		<?php wp_nonce_field( 'nonce_gift_action','nonce_field_gift' ); ?>

		<div class="row">
			<div class="col-lg-3 col-md-3"></div>
			<label for="product" class="col-lg-1 col-md-1 col-form-label"><?php _e( 'Product', 'sl147_gift' )?></label>

			<select name = 'product' required>
				<?php
				foreach ($products_all as $value) {            
					echo "<option value = '".$value->ID."'>".$value->post_title."</option>";
				}
				?>
			</select>
		</div><br>

		<div class="row">
			<div class="col-lg-2 col-md-2">
				<label for="suma_min"  class="col-form-label"><?php _e( 'Minimum amount', 'sl147_gift' )?></label>			
				<input type="text" name="suma_min" class="form-control" required>
			</div>

			<div class="col-lg-1 col-md-1"></div>

			<div class="col-lg-2 col-md-2">
				<label for="price"  class="col-lg-1 col-md-1 col-form-label"><?php _e( 'Price', 'sl147_gift' )?></label>	
				<input type="text" name="price" class="form-control" required>
			</div>				
			
			<div class="col-lg-1 col-md-1"></div>

			<div class="col-lg-2 col-md-2">
				<label for="dateFrom" class="col-form-label"><?php _e( 'Date_from', 'sl147_gift' )?></label>			
				<input type="date" name="dateFrom" class="form-control" required>
			</div>

			<div class="col-lg-1 col-md-1"></div>
			
			<div class="col-lg-2 col-md-2">
				<label for="dateTo" class="col-form-label"><?php _e( 'Date_to', 'sl147_gift' )?></label>
				<input type="date" name="dateTo" class="form-control" required>
			</div>				
		</div>
		<br>
		<div class="row">
			<div class="col-lg-1 col-md-1"></div>			
			<button type="submit" class="btn btn-info sl147_btn"><?php _e( 'SAVE', 'sl147_gift' )?></button>							
		</div>
	</form>
</div>

<?php if(!empty($gift_all)) :?>

		<?php
	//var_dump($sl147_categories);
	//echo "count=".count($sl147_categories)."!<br>";
//foreach( $sl147_categories as $item_cat ) {
		  //echo $item_cat->term_id.' - '.$item_cat->name.'<br/>';
		//}
	?>

	<div class="row">
		<div class="col-lg-1 col-md-1"></div>
		<div class="col-lg-10 col-md-10 sl147_gift_table">
			<table class="table  table-bordered table-striped table-hover">
				<thead>
					<tr class='success'>
						<th class="text-center"><?php _e( 'Product', 'sl147_gift' )?></th>
						<th class="text-center"><?php _e( 'Price', 'sl147_gift' )?></th>
						<th class="text-center"><?php _e( 'Minimum amount', 'sl147_gift' )?></th>
						<th class="text-center"><?php _e( 'Date_from', 'sl147_gift' )?></th>
						<th class="text-center"><?php _e( 'Date_to', 'sl147_gift' )?></th>
						<th class="text-center"><?php _e( 'Delete', 'sl147_gift' )?></th>
					</tr>					
				</thead>
				<tbody>
					<?php foreach ($gift_all as $value) :?>
						<tr>
							<td class="text-center">
								<a href="<?php echo get_edit_post_link( $value->product_id )?>" target="_blank">
									<?=wc_get_product( $value->product_id )->get_title()?>
								</a>
							</td>
							<td class="text-center"><?=$value->price?></td>
							<td class="text-center"><?=$value->suma_min?></td>
							<td class="text-center"><?=$value->date_from?></td>
							<td class="text-center"><?=$value->date_to?></td>
							<td class="text-center sl147_btn_delete">
								<a href="admin-post.php?page=sl147_edit_gift&amp;action_gift=delete&amp;id_gift=<?php echo $value->ID?>" class='btn btn-info btn-xs' onclick="return confirm('Usunąć. Naciśnij OK, aby usunąć i Cancel aby zatrzymać.')" title="usuń">
									<i class="dashicons dashicons-trash"></i>
								</a>
							</td>
						</tr>       
					<?php endforeach; ?>
				</tbody>

			</table> 

		</div>
	</div>

</div>
<?php endif;?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>