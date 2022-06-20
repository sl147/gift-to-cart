<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

<?php if($stage) :?>
    <form method="post" class="form-group  sl147_gift_add_form" action="<?php admin_url('admin-post.php')?>">
        <?php wp_nonce_field( 'nonce_gift_action_orders','nonce_field_gift_orders' ); ?>
        <div class="row">
            <div class="col-lg-2 col-md-2"></div>
            <div class="col-lg-10 col-md-10">
                <label for="product_promotion" class="col-form-label"><?php _e( 'Choose a promotional product', 'sl147_gift' )?></label>

                <select name = 'product_promotion' required>
                    <?php
                    foreach ($gift_all_promotion as $value) {            
                        echo "<option value = '".$value->product_id."'>".wc_get_product( $value->product_id )->get_title()." od ".$value->date_from."  do ".$value->date_to."</option>";
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
    <h2 class="text-center" style="margin-top: 30px;"><?php _e( 'Orders with a promotional product', 'sl147_gift' )?><br><?php echo $product_promotion_name?></h2>
    <div class="row">
        <div class="col-lg-1 col-md-1"></div>
        <div class="col-lg-10 col-md-10 sl147_gift_table">
            <table class="table  table-bordered table-striped table-hover">
                <thead>
                    <th class="text-center"><?php _e( 'Order №', 'sl147_gift' )?></th>
                    <th class="text-center"><?php _e( 'User', 'sl147_gift' )?></th>
                    <th class="text-center"><?php _e( 'Date of purchase', 'sl147_gift' )?></th>
                    <th class="text-center"><?php _e( 'Order total', 'sl147_gift' )?></th>
                </thead>
                <tbody>

                    <?php foreach ( $orders_promotion as $value ) : ?>

                        <tr>
                            <td class="text-center">
                                <a href="post.php?post=<?php echo $value['id']?>&action=edit" target="_blank">
                                    <?php echo $value['id'] ?>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="post.php?post=<?php echo $value['id']?>&action=edit" target="_blank">
                                    <?php echo $value['user_name'] ?>
                                </a>
                            </td>
                            <td class="text-center"><?php echo $value['date_created'] ?></td>
                            <td class="text-center"><?php echo $value['total'] ?></td>
                          
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td class="text-center" colspan="3"><?php _e( 'Total', 'sl147_gift' )?></td>
                        <td class="text-center"><?php echo number_format($sl147_total,2)?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

<?php endif;?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>