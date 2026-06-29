<?php
$cate = get_queried_object();
$cateID = $cate->term_id;
if (empty($cateID)) {
    return;
}
$args = [
    'post_type' => 'product',
    'post_status' => 'publish',
    'meta_key' => 'product_car_vip',
    'meta_value' => 'true',
    'posts_per_page' => 5,
    'tax_query' => array(
        array(
            'taxonomy' => 'product_cat',
            'terms' => $cateID,
        ),
    ),
];

$the_query = new WP_Query($args);
if ($the_query->have_posts()) : ?>
<section class="content-widget slider product-archive mb-4">
    <?php if (!empty(negarshop_option('products_archive_slider_text'))) { ?>
        <div class="wg-title">
            <span><?php echo negarshop_option('products_archive_slider_text'); ?></span>
        </div>
    <?php } ?>
    <div id="carouselIndicators-category" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php $i = 0;
            while ($the_query->have_posts()) : $the_query->the_post();
                $i++; ?>
                <li data-target="#carouselIndicators-category" data-slide-to="0"
                    class="<?php echo $i == 1 ? 'active' : ''; ?>"></li>
            <?php endwhile; ?>
        </ol>
        <div class="carousel-inner">
            <?php $i = 0;
            while ($the_query->have_posts()) : $the_query->the_post();
                $i++;
                $product = wc_get_product(get_the_id()); ?>
                <div class="carousel-item <?php echo $i == 1 ? 'active' : ''; ?>">
                    <div class="carousel-item-inner">
                        <figure class="thumb">
                            <a href="<?php the_permalink(); ?>">
                                <img class="lazy" data-src="<?php the_post_thumbnail_url('large'); ?>" src=""
                                     alt="<?php the_title(); ?>"">
                            </a>
                        </figure>
                        <div class="slide-details">
                            <div class="slide-details-inner">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title('<h2 class="title">', '</h2>'); ?>
                                </a>
                                <ul class="feature-attr-p">
                                    <?php
                                    $attributes = negarshop_option('product_vip_attrs', 'posts', get_the_id());
                                    if (!empty($attributes)) {
                                        ?>
                                        <?php

                                        foreach ($attributes as $attribute) :
                                            ?>
                                            <li class="product-attr">
                                                <span class="product-attr-title"><?php echo $attribute['title']; ?>: </span>
                                                <span class="product-attr-text"><span><?php echo $attribute['values']; ?></span></span>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php } ?>
                                </ul>
                                <div class="prd-price"><?php echo $product->get_price_html(); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        </div>
        <a class="carousel-control-prev" href="#carouselIndicators-category" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only"><?php _e("قبلی", 'negarshop') ?></span>
        </a>
        <a class="carousel-control-next" href="#carouselIndicators-category" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only"><?php _e("بعدی", 'negarshop') ?></span>
        </a>
    </div>
</section>
<?php endif;
