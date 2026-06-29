<main id="main">
    <div class="container">
        <div class="row">
            <?php
            $sidebar_order = negarshop_option('blog_sidebar');
            $order_class = ($sidebar_order == "right")?'order-lg-2':'';
            ?>
            <div class="col-lg <?php echo $order_class; ?>">
                <?php if ( is_search() ) : ?>
                    <header class="page-header">
                        <i class="fal fa-search"></i>
                        <?php if ( have_posts() ) : ?>
                            <h1 class="page-title"><?php printf( __(' نتایج جستجو برای "%s"','negarshop'), '<span>' . get_search_query() . '</span>' ); ?></h1>
                        <?php else : ?>
                            <h1 class="page-title"><?php _e("چیزی یافت نشد!",'negarshop'); ?></h1>
                        <?php endif; ?>
                    </header><!-- .page-header -->
                <?php endif; ?>
                <?php if ( is_archive() ) : ?>
                    <header class="page-header">
                        <i class="fal fa-folder"></i>
                       <h1 class="page-title"><?php
                           the_archive_title( '<h1 class="page-title">', '</h1>' ); ?></h1>
                    </header>
                <?php endif; ?>
                <section class="blog-home">
                    <?php
                    if ( have_posts() ) :

                        /* Start the Loop */
                        while ( have_posts() ) : the_post();
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
                                    <?php the_excerpt(); ?>
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

                        endwhile;

                        the_posts_pagination(array('screen_reader_text' =>  'صفحات:'));

                    endif;
                    ?>

                </section>
            </div>
            <?php if($sidebar_order !== "full") {?>
            <div class="col-lg-auto">
               <?php get_sidebar('blog'); ?>
            </div>
            <?php } ?>
        </div>
    </div>

</main>
