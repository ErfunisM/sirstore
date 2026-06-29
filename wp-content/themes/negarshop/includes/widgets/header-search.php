<?php
/**
 * Header search widget hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_header_search($opts = array())
{
    $postType = (isset($opts['search_post_type'])) ? $opts['search_post_type'] : "post";
    $searchMode = (isset($opts['search_mode'])) ? $opts['search_mode'] : "";
    $searchType = $opts['search_type'] ?? 'normal';
    $opts_ajax = isset($opts['search_ajax']) && $opts['search_ajax'] != 'false';
    $opts_filter = isset($opts['search_filters']) && $opts['search_filters'] != 'false';
    $optsText = $opts['search_placeholder'] ?? 'جستجو در سایت ...';
    $btnLabel = $opts['search_button_title'] ?? '';
    $btnIcon = $opts['search_button_icon'] ?? [];
    $showOverlay = $opts['search_overlay'] ?? false;

    $current_cat = $_GET['pcat'] ?? "";
    $current_stock = $_GET['stock'] ?? "";


    $widgetClasses = 'search-type-' . $searchType;
    if ($opts_ajax) {
        $widgetClasses .= ' ajax-form';
    }
    if ($current_cat != "" or $current_stock != "") {
        $widgetClasses .= ' show-filters';
    }
    ?>
<div class="header-search <?php echo negarshop_is_checked($showOverlay) ? 'show-overlay' : ''; ?>">
    <?php
    if ($searchType !== 'popup' && negarshop_is_checked($showOverlay)) {
        echo '<div class="search-overlay"></div>';
    }
    ?>

    <?php if ($searchType === 'popup'): ?>
    <button aria-label="<?php echo esc_attr(negarshop_fontawesome_425($opts['search_icon']['value'])); ?>"
            class="ns-popup-btn header-search-pup"
            type="button" data-toggle=".header-search-modal">
        <i class="<?php echo esc_attr(negarshop_fontawesome_425($opts['search_icon']['value'])); ?>"></i>
        <?php
        if ($opts['show_search_title'] === 'yes') {
            echo esc_html($opts['search_title']);
        }
        ?>
    </button>
    <div class="ns-popup header-search-modal">
    <div class="container">
    <div class="ns-popup-header">
        <h6><?php _e('جستجو در سایت', 'negarshop'); ?></h6>
        <button aria-label="<?= __('بستن جستجو', 'negarshop') ?>" type="button" class="ns-popup-close">
            <i class="far fa-times"></i>
        </button>
    </div>
<?php endif; ?>

    <div data-type="<?php echo $postType; ?>" data-mode="<?php echo esc_attr($searchMode); ?>"
         class="search-box <?php echo esc_attr($widgetClasses); ?>">
        <form class="search-form-tag" action="<?php echo site_url(); ?>">
            <input type="hidden" name="post_type" value="<?php echo $postType; ?>"/>
            <div class="search-form-fields">
                <input type="search" autocomplete="off" name="s" value="<?php echo get_search_query(); ?>"
                       class="search-input search-field" placeholder="<?php echo $optsText; ?>">

                <div class="search-buttons-group">
                    <?php if ($opts_filter) { ?>
                        <button aria-label="<?= __('فیلتر های جستجو', 'negarshop') ?>" type="button"
                                class="btn btn-transparent search-filters">
                            <i class="far fa-sliders-h"></i>
                        </button>
                    <?php } ?>
                    <button class="btn search-submit" aria-label="<?= __('جستجو', 'negarshop') ?>" type="submit">
                        <?php
                        if (!empty($btnLabel)) {
                            echo '<span class="button-text">' . esc_html($btnLabel) . '</span>';
                        }
                        if (!empty($btnIcon)) {
                            printf('<i class="%s search-standby"></i>', $btnIcon['value']);
                            echo '<i class="far fa-spinner fa-spin search-loading"></i>';
                        }
                        ?>
                    </button>
                </div>
            </div>

            <?php if ($opts_filter) { ?>
                <div class="search-options">
                    <div class="filters-parent">
                        <div class="list-item mb-3">
                            <label for="header-search-cat"><?php _e('دسته بندی ها', 'negarshop'); ?></label>
                            <?php
                            $wc_cats = ($postType == "product") ? get_terms('product_cat') : get_terms('category');
                            ?>
                            <select name="pcat" id="header-search-cat" class="negar-select">
                                <option value="" selected><?php _e('همه دسته ها', 'negarshop'); ?></option>
                                <?php if (!empty($wc_cats) && !is_wp_error($wc_cats)) {
                                    foreach ($wc_cats as $item): ?>
                                        <option value="<?php echo $item->term_id; ?>" <?php if ($item->term_id == $current_cat) {
                                            echo 'selected';
                                        } ?>><?php echo $item->name; ?></option>
                                    <?php endforeach;
                                } ?>
                            </select>
                        </div>
                        <?php if ($postType == "product") { ?>
                            <div class="list-item">
                                <label for="header-search-stock"><?php _e('وضعیت محصول', 'negarshop'); ?></label>
                                <select name="stock" id="header-search-stock" class="negar-select">
                                    <option value="" selected><?php _e('همه محصولات', 'negarshop'); ?></option>
                                    <option value="instock" <?php echo ($current_stock == "instock") ? 'selected' : ''; ?>><?php _e('فقط موجود ها', 'negarshop'); ?></option>
                                </select>
                            </div>
                        <?php } ?>


                        <button aria-label="<?php _e('اعمال فیلتر', 'negarshop'); ?>"
                                class="btn close-popup w-100 mt-4">
                            <?php _e('اعمال فیلتر', 'negarshop'); ?>
                        </button>
                    </div>
                </div>
            <?php } ?>
        </form>
        <?php if ($opts_ajax) {
            echo '<ul class="search-result ' . ($searchMode !== '' ? $searchMode . '-mode' : '') . '"></ul>';
        } ?>
    </div>

    <?php if ($searchType === 'popup'): ?>
    </div>
    </div>
    <div class="ns-closer"></div>
<?php endif; ?>
    <?php
    echo '</div>';
}

