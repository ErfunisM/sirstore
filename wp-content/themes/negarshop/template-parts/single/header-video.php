<?php
$content = apply_filters( 'the_content', get_the_content() );
$video = false;
if ( false === strpos( $content, 'wp-playlist-script' ) ) {
    $video = get_media_embedded_in_content( $content, array( 'video', 'object', 'embed', 'iframe' ) );
}
if ( '' !== get_the_post_thumbnail() && empty( $video ) ) : ?>
    <figure class="post-thumb">
        <a href="<?php the_permalink(); ?>">
            <img data-src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>" class="lazy">
        </a>
    </figure>
<?php endif;
if ( ! is_single() ) {
    if ( ! empty( $video ) ) {
         $video_html = $video[0];
            echo '<div class="entry-video"><div class="inner">';
            echo str_replace("controls","custom-control",$video_html);
            echo '</div></div>';
    };
};