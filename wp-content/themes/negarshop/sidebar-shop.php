<?php

if ( ! is_active_sidebar( 'sidebar-shop' ) ) {
    return;
}
?>
<aside id="secondary" class="sidebar shop-archive-sidebar<?php echo negarshop_option('products_archive_sidebar_acc') == "true"?' acc-widgets':''; ?>">
    <div class="panel-mobile-title">
        <span class="panel-close section-close">
            <i class="far fa-angle-right"></i>
        </span>
        <span class="panel-title">
            <?= __('فیلتر نتایج', 'negarshop') ?>
        </span>
    </div>
    <?php dynamic_sidebar( 'sidebar-shop' ); ?>
</aside><!-- #secondary -->
<button class="btn shop-filters-show" type="button" title="<?php _e('فیلتر ها','negarshop'); ?>"><i class="far fa-filter"></i></button>
