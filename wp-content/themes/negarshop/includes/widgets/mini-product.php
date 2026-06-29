<?php
/**
 * Mini product widget hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_mini_product_item($item, $is_mini = true, $bg = 'def')
{
    if (!function_exists('WC')) {
        return;
    }
    $pf = new WC_Product_Factory();
    $prd = $pf->get_product($item['id']);
    if ($prd) {
        $bg = $bg == 'tra' ? 'transparent' : '';
        ?>
        <article class="product <?php echo $bg; ?>">
            <a href="<?php echo $item['link']; ?>">
                <figure class="thumb">
                    <img class="lazy"
                         data-src="<?php echo $is_mini ? $item['photo']['thumb']['url'] : $item['photo']['url']; ?>"
                         alt="<?php echo $item['title']; ?>">
                    <?php
                    if (!$is_mini) {
                        negarshop_print_ribbons($item['id']);
                    }
                    ?>
                </figure>
                <div class="title"><?php echo $item['title']; ?></div>
                <?php echo !$is_mini ? '<div class="rate">' . negarshop_get_rating_html($item['rate']) . '</div>' : ''; ?>
                <div class="price">
                    <?php echo negarshop_price($prd) ?>
                </div>
                <?php echo $is_mini ? '<div class="rate">' . negarshop_get_rating_html($item['rate']) . '</div>' : ''; ?>
            </a>
        </article>
        <?php
    }
}