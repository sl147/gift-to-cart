<?php if(!$add_products_all) :?>
<div class="sl147_gift_wrapper">
    <div class="sl147_gift_block" style="background-color: <?php  echo $this->sl147_options['sl147_gift_background_color']?>; color: <?php echo $this->sl147_options['sl147_gift_text_color']?>; width: <?php echo $this->sl147_options['sl147_gift_width']?>%;">

        <?php _e( 'Make a purchase over', 'sl147_gift' )?>

        <?php echo SL147_PRODUCT_SUMA_MIN ?><?php echo $currency_symbol?>, 

        <?php _e( 'and you will receive', 'sl147_gift' )?><br>

        <a 
            style="color: <?php echo $this->sl147_options['sl147_gift_link_color']?>;"
            href="<?php echo get_permalink( SL147_PRODUCT_ID )?>"
            target="_blank"
            onmouseover="this.style.color='<?php echo $this->sl147_options['sl147_gift_text_color']?>'"
            onmouseout ="this.style.color='<?php echo $this->sl147_options['sl147_gift_link_color']?>'"> 

            <?php echo $sl147_product->get_title()?>
        </a>
        <?php
             echo " "._e( 'for', 'sl147_gift')." ";
             echo (SL147_PRODUCT_PRICE > 0) ? SL147_PRODUCT_PRICE . $currency_symbol : _e( 'free', 'sl147_gift' )
         ?>
    </div>    
</div>
<?php else: ?>
<div class="sl147_gift_wrapper">
    <div class="sl147_gift_block" style="background-color: <?php  echo $this->sl147_options['sl147_gift_background_color']?>; color: <?php echo $this->sl147_options['sl147_gift_text_color']?>; width: <?php echo $this->sl147_options['sl147_gift_width']?>%">
        <?php if(SL147_PRODUCT_SUMA_MIN) :?>
            <?php _e( 'Make a purchase over', 'sl147_gift' )?>
            <?php echo SL147_PRODUCT_SUMA_MIN . $currency_symbol?>
            <?php echo _e( 'including buy', 'sl147_gift' )?>
        <?php else :?>
            <?php _e( 'Buy', 'sl147_gift' )?>
        <?php endif ;?>
        <?php if(count($add_products_all) == 1) :?>
            <?php echo _e( 'necessary', 'sl147_gift' )?>
        <?php else :?>
            <?php echo _e( 'at least one of', 'sl147_gift' )?>
        <?php endif ;?>
        <ul style=" list-style-type: none;">
            <?php foreach ($add_products_all as $value) : ?>
                <li>
                    <a 
                        style="color: <?php echo $this->sl147_options['sl147_gift_link_color']?>;" 
                        href="<?php echo get_permalink( $value->id_add_product )?>"
                        target="_blank"
                        onmouseover="this.style.color='<?php echo $this->sl147_options['sl147_gift_text_color']?>'"
                        onmouseout ="this.style.color='<?php echo $this->sl147_options['sl147_gift_link_color']?>'"
                    >
                        <?echo wc_get_product( $value->id_add_product )->get_title()?>
                    </a>
                </li>
            <?php endforeach;?>
        </ul>
        <?php _e( 'and you will receive', 'sl147_gift' )?> 
        <a 
            style="color: <?php echo $this->sl147_options['sl147_gift_link_color']?>;" 
            href="<?php echo get_permalink( SL147_PRODUCT_ID )?>"
            target="_blank"
            onmouseover="this.style.color='<?php echo $this->sl147_options['sl147_gift_text_color']?>'"
            onmouseout ="this.style.color='<?php echo $this->sl147_options['sl147_gift_link_color']?>'"
            > 
            <?php echo $sl147_product->get_title()?> 
        </a>
        <?php " "._e( 'for', 'sl147_gift' )?>
        <?php if(SL147_PRODUCT_PRICE) :?>
            <?php echo SL147_PRODUCT_PRICE . $currency_symbol?>
        <?php else :?>
            <?php _e( 'free', 'sl147_gift' )?>
         <?php endif;?>
    </div>    
</div>
<?php endif;?>