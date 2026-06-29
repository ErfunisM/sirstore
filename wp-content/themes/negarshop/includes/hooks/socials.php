<?php
/**
 * Socials hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_social_sharing_buttons(): string {
    global $post;
    $content = "";
    if (is_singular() || is_home()) {
        // Get current page URL
        $crunchifyURL = urlencode(get_permalink());
        $crunchifyTitle = htmlspecialchars(urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
        $crunchifyThumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
        $twitterURL = 'https://twitter.com/intent/tweet?text=' . $crunchifyTitle . '&amp;url=' . $crunchifyURL . '&amp;via=Crunchify';
        $facebookURL = 'whatsapp://send?text=' . $crunchifyURL;
        $teleURL = 'https://telegram.me/share/url?url=' . $crunchifyURL;
        $smsURL = 'sms:?body=' . $crunchifyURL;
        $content .= '<div class="crunchify-social">';
        $content .= '<h5 class="share-title">' . __('ارسال به شبکه های اجتماعی', 'negarshop') . '</h5><h6 class="share-desc">' . __('اشتراک گذاری در شبکه های اجتماعی', 'negarshop') . '</h6>';
        $content .= '<input id="product-url-inpt" type="text" value="' . site_url() . '?p=' . $post->ID . '" readonly>';
        $content .= '<a class="crunchify-link crunchify-twitter" href="' . $twitterURL . '" target="_blank"><i class="fab fa-twitter"></i></a>';
        $content .= '<a class="crunchify-link crunchify-facebook" href="' . $facebookURL . '" target="_blank"><i class="fab fa-whatsapp"></i></a>';
        $content .= '<a class="crunchify-link crunchify-telegram" href="' . $teleURL . '" data-pin-custom="true" target="_blank"><i class="fas fa-paper-plane"></i></a>';
        $content .= '<a class="crunchify-link crunchify-sms" href="' . $smsURL . '" data-pin-custom="true" target="_blank"><i class="fas fa-envelope"></i></a>';
        $content .= '<a class="crunchify-link crunchify-clipboard"  data-toggle="tooltip" data-placement="bottom" data-original-title="' . __('کپی به کلیپ بورد', 'negarshop') . '"  href="javascript:void(0);"><i class="fas fa-clipboard"></i></a>';
        $content .= '</div>';
    }

    return $content;
}

function negarshop_print_share_btn() {
    echo '<li>';
    echo '<a href="javascript:void(0);" data-toggle="modal" data-target=".product-share-modal" class="action-btn-product-share">' . __('ارسال', 'negarshop') . '</a>';
    echo '</li>';
    add_action('wp_footer', function () {
        ?>
        <div class="modal fade product-share-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <button type="button" class="btn close-modal" data-dismiss="modal">
                        <i class="far fa-times"></i>
                    </button>
                    <div class="product-share-modal-inner">
                        <h5 class="share-title"><?php _e('اشتراک گذاری', 'negarshop'); ?></h5>
                        <h6 class="share-desc"><?php _e('اشتراک گذاری محصول با دوستان خود', 'negarshop'); ?></h6>
                        <form action="#send-product-email" class="sharing-box email-sharing mb-3">
                            <h5 class="share-title"><?php _e('ارسال از طریق ایمیل', 'negarshop'); ?></h5>
                            <h6 class="share-desc"><?php _e('می توانید از طریق ایمیل به دوستان خود ارسال نمائید!', 'negarshop'); ?></h6>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><?php _e('به آدرس', 'negarshop'); ?></span>
                                </div>
                                <input type="email" dir="ltr" class="form-control light-input" id="share-email-address">
                                <div class="input-group-append">
                                    <button id="send-product-email" data-id="<?php the_ID(); ?>" class="btn btn-primary"
                                            type="button"><?php _e('ارسال ایمیل', 'negarshop'); ?></button>
                                </div>
                            </div>
                        </form>
                        <div class="product-shortlinks">
                            <label for="product-shortlink">لینک کوتاه:</label>
                            <input type="text" onfocus="this.select(); document.execCommand('copy');"
                                   id="product-shortlink"
                                   class="form-control" value="<?= wp_get_shortlink() ?>" readonly>
                        </div>
                        <div class="sharing-box">
                            <?= negarshop_social_sharing_buttons() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    });
}