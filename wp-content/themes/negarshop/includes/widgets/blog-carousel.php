<?php
/**
 * Blog carousel widget hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_page_widget_blog_carousel ($atts, $pb = "unyson") {

    $color = "";
    if ( $pb === "unyson" ) {
        if ( $atts['color_t'] === "default" ) {
            $color = negarshop_option('main_color');
        } else {
            $color = $atts['color_t_picker'];
            $color = $color['custom'];
            $color = $color['color'];
        }
    }
    ?>
    <section class="content-widget blog-posts <?php echo $atts['style']; ?>"
             id="content-widget-<?php echo $atts['id']; ?>">
        <div class="owl-carousel blog-posts" id="blog-posts-<?php echo $atts['id']; ?>">
            <?php
            $slides = [];
            if ( $atts['items_type'] === 'custom' ) {
                $slideAtts = $atts['items_type_picker'];
                $slideAtts = $slideAtts['custom'];
                $slideAtts = $slideAtts['slides'];
                $slides    = $slideAtts;
            } else {
                $posts_pp        = $atts['items_type_picker'];
                $slide_products  = $posts_pp['products'];
                $posts_pp        = (int) $slide_products['products_count'];
                $product_picker  = $slide_products['products_type_picker'];
                $products_offset = (int) isset($slide_products['products_offset']) ? $slide_products['products_offset'] : 0;

                $args = [
                    'post_type'      => 'post',
                    'posts_per_page' => $posts_pp,
                    'offset'         => $products_offset
                ];
                if ( $product_picker['products_type'] === "ids" ) {
                    $ids_list         = $product_picker['ids'];
                    $ids_list         = $ids_list['product_ids'];
                    $ids_list         = explode(',', $ids_list);
                    $args['post__in'] = $ids_list;
                }
                if ( $product_picker['products_type'] === "category" ) {
                    $categories        = $product_picker['category'];
                    $args['tax_query'] = [
                        [
                            'taxonomy' => 'category',
                            'field'    => 'id',
                            'operator' => 'IN',
                            'terms'    => $categories['woo_categories'],
                        ]
                    ];
                }
                $the_query = new WP_Query($args);
                if ( $the_query->have_posts() ) {
                    while ( $the_query->have_posts() ) {
                        $the_query->the_post();
                        $slides[] = [
                            'id'    => get_the_id(),
                            'title' => get_the_title(),
                            'link'  => get_the_permalink(),
                            'photo' => [
                                'url' => get_the_post_thumbnail_url(get_the_id(), 'medium_large')
                            ],
                        ];
                    }
                    wp_reset_postdata();
                }
            }
            ?>
            <?php $fint = 0;
            foreach ( $slides as $item ): ?>
                <div>
                    <article class="blog-item">
                        <a href="<?php echo $item['link']; ?>">
                            <figure class="thumbnail">
                                <?php $photo = $item['photo'];
                                if ( $photo['url'] !== false ) { ?>
                                    <img class="lazy" data-src="<?php echo $photo['url']; ?>"
                                         alt="<?php echo $item['title']; ?>">
                                <?php }
                                ?>
                                <div class="post-format">
                                    <?php if ( get_post_format($item['id']) === "video" ) {
                                        echo '<i class="fal fa-video"></i>';
                                    } ?>
                                    <?php if ( get_post_format($item['id']) == false ) {
                                        echo '<i class="fal fa-file-alt"></i>';
                                    } ?>
                                </div>
                                <time>
                                    <span class="day"><?php echo ns_jdate('d', get_post_datetime($item['id'])->getTimestamp()); ?></span>
                                    <span class="month"><?php echo ns_jdate('F', get_post_datetime($item['id'])->getTimestamp()); ?></span>
                                </time>
                            </figure>
                        </a>
                        <div class="item-footer">
                            <a href="<?php echo $item['link']; ?>">
                                <h3 class="title"><?php echo $item['title']; ?></h3>
                            </a>
                            <div class="cats"><?php the_category('، ', '«', $item['id']); ?></div>
                        </div>
                    </article>
                </div>
                <?php $fint++; endforeach; ?>

        </div>
        <?php if ( $pb === "unyson" ) { ?>
            <style>
                #content-widget-header-<?php echo $atts['id']; ?> a.archive {
                    background-color: <?php echo $color; ?>;
                }

                #content-widget-<?php echo $atts['id']; ?> article.item figcaption time {
                    background-color: <?php echo $color; ?>;
                }
            </style>
        <?php } ?>
        <script>
            jQuery(document).ready(function ($) {
                $('#blog-posts-<?php echo $atts['id']; ?>').owlCarousel({
                    items     : <?php echo $atts['slide_per_count']; ?>,
                    autoplay  : true,
                    rtl       : true,
                    nav       : false,
                    loop      : true,
                    dots      : true,
                    responsive: {
                        0  : {
                            items: 1,
                        },
                        480: {
                            items: 2,
                        },
                        700: {
                            items: 2,
                        },
                        991: {
                            items: <?php echo $atts['slide_per_count']; ?>,
                        },
                    },
                    margin    : 15
                });
            });
        </script>
    </section>
    <?php
}