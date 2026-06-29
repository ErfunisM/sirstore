<?php
get_header(); ?>
<main id="main">
    <div class="container">
		<?php if ( function_exists('woocommerce_breadcrumb') ) {
			woocommerce_breadcrumb();
		} ?>
        <div class="row">
			<?php
			$sidebar_order = negarshop_option('blogsingle_sidebar');
			$order_class   = ($sidebar_order === "right") ? 'order-lg-2' : '';
			?>
            <div class="col-lg <?php echo $order_class; ?>">
                <section class="blog-home">
					<?php
					if ( have_posts() ) :

						/* Start the Loop */
						while ( have_posts() ) : the_post();
							?>
                            <article <?php post_class("post-item entry-content"); ?> id="post-<?php the_id(); ?>">
								<?php if ( has_post_thumbnail() ): ?>
                                    <figure class="post-thumb">
                                        <a href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail('large'); ?>
                                        </a>
                                    </figure>
								<?php endif; ?>
                                <div class="title">
                                    <h1 class="title-tag"><?php the_title(); ?></h1>
                                </div>
                                <div class="content">
									<?php the_content(); ?>
                                </div>
                                <div class="tags"><?php the_tags(); ?></div>
                                <div class="info">
                                    <ul>
                                        <li><i class="fal fa-user"></i><span><?php the_author(); ?></span></li>
                                        <li><i class="fal fa-calendar"></i><span><?php echo get_the_date(); ?></span>
                                        </li>
                                        <li><i class="fal fa-archive"></i><span><?php the_category(); ?></span></li>
                                        <li><i class="fal fa-eye"></i><span><?php echo negarshop_get_post_views();
												_e(' بازدید', 'negarshop'); ?></span></li>
                                    </ul>
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
			<?php if ( $sidebar_order !== "full" ) { ?>
                <div class="col-lg-auto">
					<?php get_sidebar('blog'); ?>
                </div>
			<?php } ?>
        </div>
    </div>

</main>
<?php get_footer();
?>
