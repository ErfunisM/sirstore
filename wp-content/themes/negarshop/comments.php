<?php
if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php
    // You can start editing here -- including this comment!
    if ( have_comments() ) : ?>
        <h2 class="comments-title">
            <i class="fal fa-comment"></i>
            <?php
            $comments_number = get_comments_number();
            if ( '1' === $comments_number ) {
                /* translators: %s: post title */
                printf( _x( 'یک دیدگاه برای &ldquo;%s&rdquo;', 'comments title','negarshop'), get_the_title() );
            } else {
                printf(
                /* translators: 1: number of comments, 2: post title */
                    _nx(
                        '%1$s دیدگاه برای &ldquo;%2$s&rdquo;',
                        '%1$s دیدگاه برای &ldquo;%2$s&rdquo;',
                        $comments_number,
                        'comments title',
                        'negarshop'
                    ),
                    number_format_i18n( $comments_number ),
                    get_the_title()
                );
            }
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments( array(
                'avatar_size' => 100,
                'style'       => 'ul',
                'short_ping'  => true,
                'reply_text'    =>  __("پاسخ دادن",'negarshop')
            ) );
            ?>
        </ol>

        <?php the_comments_pagination();

    endif; // Check for have_comments().

    // If comments are closed and there are comments, let's leave a little note, shall we?
    if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

        <p class="no-comments"><?php _e( 'Comments are closed.' ); ?></p>
        <?php
    endif;

    comment_form(array('class_submit'   =>  'btn btn-primary'));
    ?>

</div><!-- #comments -->
