<?php get_header();?>
    <main id="main">
        <div class="container">
            <div class="row">
                <div class="col-lg <?php if(negarshop_option('sidebar','posts',get_the_ID()) == "right"){echo "order-lg-2";} ?>">
                    <section class="blog-home">
                        <?php
                        if ( have_posts() ) :

                            /* Start the Loop */
                            while ( have_posts() ) : the_post();
                                ?>
                                <article <?php post_class("post-item"); ?> id="post-<?php the_id(); ?>">
                                    <?php if(has_post_thumbnail()): ?>
                                        <figure class="post-thumb">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail(); ?>
                                            </a>
                                        </figure>
                                    <?php endif; ?>
                                    <div class="title">
										<h1 class="title-tag"><?php the_title(); ?></h1>
                                    </div>
                                    <div class="content">
                                        <?php the_content(); ?>
                                    </div>
                                </article>
                                <?php

                                // If comments are open or we have at least one comment, load up the comment template.
                                if ( comments_open() || get_comments_number() ) :
                                    echo '<div class="post-comments post-wg">';
                                        comments_template();
                                    echo '</div>';
                                endif;
                            endwhile;


                        endif;
                        ?>

                    </section>
                </div>
                <?php if(negarshop_option('sidebar','posts',get_the_ID()) != "full"): ?>
                    <div class="col-lg-auto">
                        <?php get_sidebar('blog'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </main>
<?php get_footer(); ?>