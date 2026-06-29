<?php global $product;
$attributes = negarshop_option('product_vip_attrs', 'posts',get_the_id());
if(empty($attributes)){return;}
?>
<div class="product-featured-attrs">
    <h6 class="title"><?php _e("ویژگی های محصول",'negarshop'); ?></h6>
    <ul>
        <?php

        foreach ( $attributes as $attribute ) :
            ?>
            <li>
                <span class="title"><i class="<?php echo $attribute['icon'] ?? ''; ?>"></i> <?php echo $attribute['title'] ?? ''; ?>:</span>
                <?php echo $attribute['values'] ?? ''; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>