<?php
/**
 * Mega menu hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_mega_menu_contents($item_id): array {
    $json_array = [
        'status' => false,
        'data' => ''
    ];
    if ($item_id !== false):
        $atts = 'false';
        if ($item_type = fw_ext_mega_menu_get_db_item_option($item_id, 'type')) {
            $atts = fw_ext_mega_menu_get_db_item_option($item_id, $item_type);
        }

        $json_array['type'] = $atts['mega_menu_type'];
        if ($atts['mega_menu_type'] === 'menu') {
            $image_url = $atts['multi-picker']['menu']['image']['url'] ?? '';
            ob_start();
            wp_nav_menu([
                'menu' => (int)$atts['multi-picker']['menu']['menu'][0],
                'menu_class' => 'sub-menu is-mega-menu-con container exclude',
                'container' => 'ul',
            ]);
            $sub_menus = ob_get_clean();

            $sub_menus = str_replace('class="sub-menu is-mega-menu-con container exclude"', 'class="sub-menu is-mega-menu-con container exclude" style="background-image:url(' . $image_url . ')"', $sub_menus);
            $json_array['status'] = true;
            $json_array['data'] = $sub_menus;
        } else if ($atts['mega_menu_type'] === 'product') {
            $content = '<ul class="sub-menu is-mega-menu-con is-product-mega-menu container exclude">';
            $content .= '<li class="tabs">';
            $tabs = $atts['multi-picker']['product']['tabs'];
            $content .= '<ul>';
            $i = 0;
            foreach ($tabs as $tab) {
                $i++;
                $content .= '<li><a data-tab="' . $i . '" data-query="' . negarshop_string_compress_encode(json_encode($tab)) . '" href="' . $tab['link'] . '">' . $tab['title'] . '</a></li>';
            }
            $content .= '</ul>';
            $content .= '</li>';
            $content .= '<li class="contents">';
            $content .= '</li>';
            $content .= '</ul>';
            $json_array['status'] = true;
            $json_array['data'] = $content;
        } else if ($atts['mega_menu_type'] === 'two_level') {
            $menu_image = isset($atts['multi-picker']['two_level']['image']['url']) ? ' style="background-image:url(\'' . $atts['multi-picker']['two_level']['image']['url'] . '\')"' : '';
            $content = '<ul class="sub-menu is-mega-menu-con is-two-level-mega-menu  container exclude"' . $menu_image . '>';
            $content .= '<li class="tabs">';
            $tabs = $atts['multi-picker']['two_level']['tabs'];
            $content .= '<ul>';
            $i = 0;
            foreach ($tabs as $tab) {
                $i++;
                $content .= '<li><a class="loaded" data-query="" data-tab="' . $i . '" href="' . $tab['link'] . '">' . $tab['title'] . '</a></li>';
            }
            $content .= '</ul>';
            $content .= '</li>';
            $content .= '<li class="contents tl-contents">';

            $i = 0;
            foreach ($tabs as $tab) {
                $i++;

                ob_start();
                wp_nav_menu([
                    'menu' => (int)$tab['menu'][0],
                    'menu_class' => 'sub-menu is-mega-menu-menu-type container exclude menu-col-' . $tab['col'] . ' tl-tabs tab-' . $i . ' ' . ($i == 1 ? 'show' : ''),
                    'container' => false,
                ]);
                $sub_menus = ob_get_clean();

                $content .= $sub_menus;

            }


            $content .= '</li>';
            $content .= '</ul>';
            $json_array['status'] = true;
            $json_array['data'] = $content;
        }
    endif;

    return $json_array;
}

function negarshop_ajax_megamenu() {
    $json_array = [
        'status' => false,
        'data' => ''
    ];
    $item_id = (is_numeric($_POST['menu_id'])) ? (int)$_POST['menu_id'] : false;
    if ($item_id !== false):
        $json_array = negarshop_mega_menu_contents($item_id);
    endif;
    wp_send_json($json_array);
    wp_die();
}

function negarshop_ajax_megamenu_products() {
    $json_array = [
        'status' => false,
        'data' => ''
    ];
    $item_query = (isset($_POST['query'])) ? $_POST['query'] : false;
    $item_tab = (isset($_POST['tab'])) ? $_POST['tab'] : 0;
    if ($item_query !== false) {
        $atts = negarshop_string_compress_decode($item_query);
        $atts = json_decode($atts, true);
        if (!empty($atts)) {

            $posts_pp = (int)$atts['products_count'];
            $product_picker = $atts['products_type_picker'];

            $args = [
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page' => $posts_pp
            ];
            if ($product_picker['products_type'] == "ids") {
                $ids_list = $product_picker['ids'];
                $ids_list = $ids_list['product_ids'];
                $ids_list = explode(',', $ids_list);
                $args['post__in'] = $ids_list;
            }
            if ($product_picker['products_type'] == "category") {
                $categories = $product_picker['category'];
                $args['tax_query'] = [
                    [
                        'taxonomy' => 'product_cat',
                        'field' => 'id',
                        'terms' => $categories['woo_categories'],
                    ]
                ];
            }
            $the_query = new WP_Query($args);
            if ($the_query->have_posts()) {
                $slider_OPT = [
                    'items' => 4,
                    'rtl' => true,
                    'dots' => false,
                    'nav' => true,
                ];
                $posts = '<div class="owl-carousel tab-' . $item_tab . ' owl-hidden" data-owl-options=\'' . json_encode($slider_OPT) . '\'>';
                while ($the_query->have_posts()) {
                    $the_query->the_post();

                    $pf = new WC_Product_Factory();
                    $prd = $pf->get_product(get_the_id());
                    ob_start();
                    negarshop_carousel_item($prd);
                    $posts .= ob_get_clean();
                }
                $posts .= '</div>';
                $json_array['data'] = [];
                $json_array['data']['htmlContent'] = $posts;
                $json_array['data']['classAttr'] = $item_tab;
                wp_reset_postdata();
            } else {
                $json_array['data'] = false;
            }

            $json_array['status'] = true;
        }
    }
    wp_send_json($json_array);
    wp_die();
}


add_action('wp_ajax_negarshop_ajax_megamenu', 'negarshop_ajax_megamenu');
add_action('wp_ajax_nopriv_negarshop_ajax_megamenu', 'negarshop_ajax_megamenu');
add_action('wp_ajax_negarshop_ajax_megamenu_producs', 'negarshop_ajax_megamenu_products');
add_action('wp_ajax_nopriv_negarshop_ajax_megamenu_producs', 'negarshop_ajax_megamenu_products');