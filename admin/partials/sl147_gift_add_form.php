<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

<?php if($stage) :?>

	<form method="post" class="form-group  sl147_gift_add_form" action="<?php admin_url('admin-post.php')?>">
		<?php wp_nonce_field( 'nonce_gift_action_choose','nonce_field_gift_choose' ); ?>
		<div class="row">
			<div class="col-lg-2 col-md-2"></div>
			<div class="col-lg-6 col-md-6">
				<label for="product_promotion" class="col-form-label"><?php _e( 'Choose a promotional product', 'sl147_gift' )?></label>

				<select name = 'product_promotion' required>
					<?php
					foreach ($gift_all_promotion as $value) {            
						echo "<option value = '".$value->product_id."'>".wc_get_product( $value->product_id )->get_title()."</option>";
					}
					?>
				</select>

				<button type="submit" class="btn btn-info btn-sm sl147_btn">
					<?php _e( 'NEXT', 'sl147_gift' )?>
				</button>
			</div>
		</div>
	</form>
	
<?php else: ?>

	<form method="post" class="form-group sl147_gift_add_form" action="<?php admin_url('admin-post.php')?>">
		<?php wp_nonce_field( 'nonce_gift_action_add','nonce_field_gift_add' ); ?>
		<div class="row">
			<div class="col-lg-2 col-md-2"></div>
			<div class="col-lg-10 col-md-10">
				<input type="hidden" name="product_promotion_ID" value="<?php echo $product_promotion_ID?>">
				<label for="id_add_product" class="col-form-label"><?php _e( 'Choose an additional product', 'sl147_gift' )?></label>

				<select name = 'id_add_product' required>
					<?php
					foreach ($products_all as $value) {            
						echo "<option value = '".$value->ID."'>".$value->post_title."</option>";
					}
					?>
				</select>

				<button type="submit" class="btn btn-info btn-sm sl147_btn">
					<?php _e( 'ADD', 'sl147_gift' )?>
				</button>
			</div>
		</div>
	</form>

	<div class="row">
		<div class="col-lg-2 col-md-1"></div>
		<div class="col-lg-6 col-md-6 sl147_gift_table">
			<h3 class="text-center"><?php _e( 'Promotional product: ', 'sl147_gift' )?>

				<a href="<?php echo get_edit_post_link( $product_promotion_ID )?>" target="_blank">
					<?=wc_get_product( $product_promotion_ID )->get_title()?>
				</a>
			</h3>

			<table class="table  table-bordered table-striped table-hover">
				<thead>
					<tr class='success'>						
						<th class="text-center"><?php _e( 'Additional products', 'sl147_gift' )?></th>
						<th class="text-center"><?php _e( 'Delete', 'sl147_gift' )?></th>
					</tr>					
				</thead>
				<tbody>
					<?php foreach ($add_products_all as $value) :?>
						<tr>
							<td class="text-center">
								<a href="<?php echo get_edit_post_link( $value->id_add_product )?>" target="_blank">
									<?=wc_get_product( $value->id_add_product )->get_title()?>
								</a>
							</td>
							<td class="sl147_btn_delete text-center">
								<a href="admin-post.php?page=sl147_edit_gift&amp;action_gift=delete_add&amp;id_gift=<?php echo $value->ID?>" class='btn btn-info btn-sm' onclick="return confirm('Usunąć. Naciśnij OK, aby usunąć i Cancel aby zatrzymać.')" title="usuń">
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