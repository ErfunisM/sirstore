<?php
/**
 * Description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     2.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $post;
?>

<div class="product-description-inner">
    <?php the_content(); ?>
</div>

<div id="postDescAccordion">
    <?php
    $i_int = 0;
    $cat_description = negarshop_option('product_acc_desc', 'posts', get_the_id());
    $visibility = negarshop_option('product_acc_desc');
    foreach ($cat_description as $item): $i_int++; ?>

        <div class="card">
            <div class="card-header" id="heading<?php echo $i_int; ?>">
                <h2 class="mb-0">
                    <button class="btn btn-link <?= $visibility === 'hide' ? 'collapsed' : '' ?>"
                            data-toggle="collapse" data-target="#collapse<?php echo $i_int; ?>"
                            aria-expanded="false">
                        <i class="<?php echo $item['icon'] ?? ''; ?>"></i>
                        <?php echo $item['title'] ?? ''; ?>
                    </button>
                </h2>
            </div>

            <div id="collapse<?php echo $i_int; ?>" class="collapse <?= $visibility === 'show' ? 'show' : '' ?>"
                 aria-labelledby="heading<?php echo $i_int; ?>" data-parent="#postDescAccordion">
                <div class="card-body">
                    <?php echo do_shortcode($item['values'] ?? ''); ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php
$plus_items = negarshop_option('product_reviews_p', 'posts', get_the_id());
$nega_items = negarshop_option('product_reviews_m', 'posts', get_the_id());
$rate_items = negarshop_option('product_reviews_rate', 'posts', get_the_id());
if (!empty($rate_items) || !empty($plus_items) || !empty($nega_items)):
    ?>
    <div class="postDescReviews">
        <div class="row">
            <div class="col-md">
                <?php
                if (!empty($plus_items)) {
                    ?>
                    <h3 class="plus"><?php _e('نقاط قوت', 'negarshop') ?></h3>
                    <ul class="items plus">
                        <?php foreach ($plus_items as $item): ?>
                            <li><i class="fas fa-plus-circle"></i> <?php echo $item; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php } ?>
            </div>
            <div class="col-md">
                <?php
                if (!empty($nega_items)) {
                    ?>
                    <h3 class="negative"><?php _e('نقاط ضعف', 'negarshop') ?></h3>
                    <ul class="items negative">
                        <?php foreach ($nega_items as $item): ?>
                            <li><i class="fas fa-minus-circle"></i> <?php echo $item; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php } ?>
            </div>
            <div class="col-lg">
                <?php
                if (!empty($rate_items)) {
                    ?>
                    <div class="product_feature">
                        <?php foreach ($rate_items as $item): ?>
                            <span class="title"><?php echo $item['title']; ?></span>
                            <span class="value"><?php echo negarshop_percent_to_text($item['value']); ?></span>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar"
                                     style="width: <?php echo $item['value']; ?>%"
                                     aria-valuenow="<?php echo $item['value']; ?>" aria-valuemin="0"
                                     aria-valuemax="100"></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
<?php endif; ?>

<?php
if (wp_is_mobile() || (negarshop_option('product_single_type') === 'type-3' && negarshop_option('product_tags_tools') === 'true')) {
    global $product;
    echo wc_get_product_tag_list($product->get_id(), ', ', '<div class="tagged_as"><i class="far fa-tags"></i>' . _n('برچسب:', 'برچسب:', count($product->get_tag_ids()), 'woocommerce') . ' ', '</div>');
}
?>
