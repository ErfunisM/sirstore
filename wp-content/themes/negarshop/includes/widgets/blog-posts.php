<?php
/**
 * Blog posts widget hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_page_widget_blog_main($atts, $pb = "unyson") {
    ?>

    <section class="content-widget blog-home transparent <?php echo $atts['style']; ?>"
             id="content-widget-<?php echo $atts['id']; ?>">
        <?php
        $posts_pp = $atts['items_type_picker'];
        $slide_products = $posts_pp['products'];
        $posts_pp = (int)$slide_products['products_count'];
        $product_picker = $slide_products['products_type_picker'];
        $paged = 1;
        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } else if (get_query_var('page')) {
            $paged = get_query_var('page');
        }
        $args = [
            'paged' => $paged,
            'post_type' => 'post',
            'posts_per_page' => $posts_pp,
            'cb_opt' => true
        ];
        if (isset($slide_products['products_offset']) and (int)$slide_products['products_offset'] > 0) {
            $args['offset'] = (int)$slide_products['products_offset'];

            if ($args['paged'] > 1) {
                $args['offset'] += ($args['posts_per_page'] * ($paged - 1));
                unset($args['paged']);
            }

        }

        if ($product_picker['products_type'] === "ids") {
            $ids_list = $product_picker['ids'];
            $ids_list = $ids_list['product_ids'];
            $ids_list = explode(',', $ids_list);
            $args['post__in'] = $ids_list;
        }
        if ($product_picker['products_type'] === "category") {
            $categories = $product_picker['category'];
            $args['tax_query'] = [
                [
                    'taxonomy' => 'category',
                    'field' => 'id',
                    'terms' => $categories['woo_categories'],
                ]
            ];
        }
        $the_query = new WP_Query($args);
        if ($the_query->have_posts()) {
            while ($the_query->have_posts()) {
                $the_query->the_post();
                ?>
                <article <?php post_class("post-item"); ?> id="post-<?php the_id(); ?>">
                    <?php
                    negarshop_get_part('single/header', get_post_format(get_the_ID()));
                    ?>
                    <div class="title">
                        <a href="<?php the_permalink(); ?>">
                            <h2 class="title-tag"><?php the_title(); ?></h2>
                        </a>
                    </div>
                    <div class="excerpt">
                        <?php echo negarshop_excerpt_crop(get_the_excerpt(), 250); ?>
                    </div>
                    <div class="info">
                        <ul>
                            <li><i class="fal fa-user"></i><span><?php the_author(); ?></span></li>
                            <li><i class="fal fa-calendar"></i><span><?php echo get_the_date(); ?></span></li>
                            <li><i class="fal fa-archive"></i><span><?php the_category(); ?></span></li>
                        </ul>
                    </div>
                </article>
                <?php
            }
            $GLOBALS['wp_query']->max_num_pages = $the_query->max_num_pages;
            the_posts_pagination([
                'screen_reader_text' => __('صفحات:', 'negarshop'),
                'format' => 'page/%#%',
                'current' => $paged
            ]);
            wp_reset_postdata();
        }
        ?>
    </section>

    <?php
}