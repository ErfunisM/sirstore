<?php
$args = [
    'taxonomy' => 'product_cat',
];

if (is_product_category()) {
    $queried_object = get_queried_object_id();
    $args['parent'] = $queried_object;
} else {
    $args['parent'] = 0;
}

$categories = get_categories($args);

if (empty($categories) || is_wp_error($categories)) {
    return;
}
if (count($categories) > 8) {
    $categories = array_slice($categories, 0, 8);
}

$picker = negarshop_option('products_archive_categories-picker');
$widget_classes = [
    'archive-product-categories--' . $picker['true']['style']
];
?>
<section
        class="archive-product-categories mb-5 <?php echo esc_attr(implode(' ', array_filter($widget_classes, 'sanitize_html_class'))); ?>">
    <div class="owl-carousel products-carousel" data-ride="carousel">
        <?php foreach ($categories as $item):
            ?>
            <div class="item">
                <?php
                wc_get_template(
                    'content-product_cat.php',
                    array(
                        'category' => $item,
                        'style' =>  $picker['true']['style']
                    )
                );
                ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>
