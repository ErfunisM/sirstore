<?php if(!has_post_thumbnail()){return;} ?>
<figure class="post-thumb">
    <a href="<?php the_permalink(); ?>">
        <img data-src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>" class="lazy">
    </a>
</figure>