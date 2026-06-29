<?php
$pta = negarshop_option('product_tools_picker');
$pta = $pta['true'];
$actionsClasses = '';

if (negarshop_option('product_single_type') === 'type-3') {
    $actionsClasses .= 'mini-product-single-actions ';
}
if (negarshop_option('product_responsive_add_to_cart') === 'false') {
    $actionsClasses .= ' inline-mode ';
}
if (negarshop_option('product_single_type') === 'type-1') {
    $type_picker = negarshop_option('product_single_type-picker');
    $type_picker = $type_picker['type-1'];
    $actionsClasses .= 'product-single-actions--' . $type_picker['actions_style'];
}
?>
<ul class="product-single-actions <?php echo esc_attr($actionsClasses); ?>">
    <?php if ($pta['product_tools_like']) {
        negarshop_fav_btn(get_the_id(), true);
    } ?>
    <?php if ($pta['product_tools_share']) {
        negarshop_print_share_btn();
    } ?>
    <?php if ($pta['product_tools_wait']) {
        negarshop_print_waiting_btn();
    } ?>
    <?php if ($pta['product_tools_compare']) {
        echo '<li>';
        negarshop_print_compare_btn(get_the_ID(), __('مقایسه', 'negarshop'));
        echo '</li>';
    } ?>
    <?php if ($pta['product_tools_changes']) {
        negarshop_print_chart_btn(get_the_id(), true);
    } ?>
    <?php if ($pta['product_tools_3dview']) {
        negarshop_print_threeview_btn(get_the_id());
    } ?>
    <?php if (isset($pta['product_tools_video']) && $pta['product_tools_video']) {
        negarshop_print_product_video_btn(get_the_id());
    } ?>
</ul>
<div class="ns-mobile-dimmer"></div>