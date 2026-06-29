<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.3.0
 */

defined('ABSPATH') || exit;

global $product;

if (!comments_open()) {
    return;
}

?>
<div id="reviews" class="woocommerce-Reviews">
    <div id="comments">
        <div class="row">
            <?php
            $get_comments_list = get_comments([
                'post_id' => get_the_id(),
                'status' => 'approve',
                'meta_key' => 'cb_feature',
                'orderby' => 'comment_date_gmt',
                'order' => 'DESC'
            ]);
            $rates = [];
            $total_rate = [];
            if (!empty($get_comments_list)) {
                foreach ($get_comments_list as $item) {
                    $rates[] = get_comment_meta($item->comment_ID, 'cb_feature', true);
                }
            }
            foreach ($rates as $rate) {
                foreach ($rate as $key => $val) {
                    if (isset($total_rate[$key])) {
                        $total_rate[$key] += (int)$val;
                    } else {
                        $total_rate[$key] = (int)$val;
                    }
                }
            }
            foreach ($total_rate as $key => $val) {
                $total_rate[$key] = ($val / count($rates)) * 20;
            }
            if (!empty($total_rate)) {
                ?>
                <div class="col-lg mb-4">
                    <div class="comment-users-reviews">
                        <h5 class="sec-title"><?php _e("امتیازات کاربران", 'negarshop'); ?></h5>
                        <h6 class="sec-desc"><?php _e("میانگین امتیازات کاربران به ویژگی های محصول", 'negarshop'); ?></h6>
                        <div class="product_feature">
                            <?php
                            $rate_items = negarshop_option('product_reviews_rate', 'posts', get_the_id());
                            if (!empty($rate_items)) {
                                foreach ($rate_items as $item):
                                    $item['value'] = (isset($total_rate[$item['id']])) ? $total_rate[$item['id']] : $item['value'];
                                    $item['value'] = round($item['value'], 2);
                                    ?>
                                    <span class="title"><?php echo $item['title']; ?></span>
                                    <span class="value"><?php echo negarshop_percent_to_text($item['value']); ?></span>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                             style="width: <?php echo $item['value']; ?>%"
                                             aria-valuenow="<?php echo $item['value']; ?>" aria-valuemin="0"
                                             aria-valuemax="100"></div>
                                    </div>
                                <?php
                                endforeach;
                            }
                            ?>

                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="col-lg mb-4">
                <div class="comment-req-text">
                    <h5><?php echo esc_html(negarshop_option('comment_title')); ?></h5>
                    <p><?php echo negarshop_option('comment_desc'); ?></p>
                    <a href="#review_form" class="btn"><i
                                class="far fa-comment"></i><?php _e("افزودن دیدگاه جدید", 'negarshop'); ?></a>
                </div>
            </div>
        </div>
        <?php if (have_comments()) : ?>
            <div class="cb-comment-tabs">
                <h6 class="sec-title"><?php _e("مرتب سازی بر اساس:", 'negarshop') ?></h6>
                <ul class="cb-tabs">
                    <li><a href="#news" class="active" data-order="news"
                           data-id="<?php the_ID(); ?>"><?php _e("جدید ترین نظرات", 'negarshop'); ?></a></li>
                    <li><a href="#buyers" data-order="buyers"
                           data-id="<?php the_ID(); ?>"><?php _e("نظر خریداران", 'negarshop'); ?></a></li>
                    <li><a href="#useful" data-order="useful"
                           data-id="<?php the_ID(); ?>"><?php _e("مفید ترین نظرات", 'negarshop'); ?></a></li>
                </ul>
            </div>
            <div class="cb_comment_list">
                <div class="loading">
                    <?php _e("درحال بارگذاری لطفا صبر کنید", 'negarshop'); ?>
                    <span class="spinner"></span>

                </div>
                <ol class="commentlist">
                    <?php echo negarshop_get_comments_html(get_the_ID(), 'news', 1); ?>
                </ol>
            </div>


        <?php else : ?>

            <p class="woocommerce-noreviews"><?php _e('There are no reviews yet.', 'woocommerce'); ?></p>

        <?php endif; ?>
    </div>
    <?php if (get_option('woocommerce_review_rating_verification_required') === 'no' || wc_customer_bought_product('', get_current_user_id(), $product->get_id())) : ?>

        <div id="review_form_wrapper">
            <div id="review_form">
                <?php
                $commenter = wp_get_current_commenter();

                $comment_form = array(
                    'title_reply' => '',
                    'title_reply_to' => __('Leave a Reply to %s', 'woocommerce'),
                    'title_reply_before' => '<span id="reply-title" class="comment-reply-title">',
                    'title_reply_after' => '</span>',
                    'comment_notes_before' => '',
                    'comment_notes_after' => '',
                    'fields' => array(
                        'author' => '<p class="comment-form-author">' .
                            '<label for="author">' . __('نام شما:', 'negarshop') . '</label><input id="author" name="author" placeholder="' . __('نام خود را بنویسید', 'negarshop') . '" class="form-control" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" aria-required="true" required /></p>',
                        'email' => '<p class="comment-form-email">' .
                            '<label for="email">' . __('ایمیل شما:', 'negarshop') . '</label><input id="email" class="form-control" placeholder="' . __('ایمیل خود را بنویسید', 'negarshop') . '" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" aria-required="true" required /></p>',

                    ),
                    'label_submit' => __('ثبت دیدگاه', 'negarshop'),
                    'logged_in_as' => '',
                    'comment_field' => '',
                    'class_submit' => 'btn btn-primary'
                );

                if ($account_page_url = wc_get_page_permalink('myaccount')) {
                    $comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf(__('You must be <a href="%s">logged in</a> to post a review.', 'woocommerce'), esc_url($account_page_url)) . '</p>';
                }
                $comment_form['comment_field'] = '<div class="row comment-form-header">';
                $comment_form['comment_field'] .= '<div class="col-lg"><div class="comment-notes">
<h3>' . negarshop_option('comment_rules_title') . '</h3>
<div>
' . negarshop_option('comment_rules_desc') . '
</div></div></div>';
                $rate_items = negarshop_option('product_reviews_rate', 'posts', get_the_id());
                if (!empty($rate_items)) {
                    $comment_form['comment_field'] .= '<div class="col-lg">';
                    foreach ($rate_items as $item) {
                        $comment_form['comment_field'] .= '<p class="comment-form-slider"><span class="cfs-title">' . $item['title'] . '</span><span class="cb-nouislider" data-name="cb_feature[' . $item['id'] . ']"></span></p>';
                    }
                    $comment_form['comment_field'] .= '</div>';
                }
                $comment_form['comment_field'] .= '</div>';
                $comment_form['comment_field'] .= '<p class="comment-form-comment mt-4"><label for="comment">' . __('متن دیدگاه:', 'negarshop') . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" required></textarea></p>';
                if (get_option('woocommerce_enable_review_rating') === 'yes') {
                    $comment_form['comment_field'] .= '<div class="comment-form-rating"><label for="rating">' . __('امتیاز شما:', 'negarshop') . '</label><select name="rating" id="rating" aria-required="true" required>
							<option value="">' . esc_html__('Rate&hellip;', 'woocommerce') . '</option>
							<option value="5" selected>' . esc_html__('Perfect', 'woocommerce') . '</option>
							<option value="4">' . esc_html__('Good', 'woocommerce') . '</option>
							<option value="3">' . esc_html__('Average', 'woocommerce') . '</option>
							<option value="2">' . esc_html__('Not that bad', 'woocommerce') . '</option>
							<option value="1">' . esc_html__('Very poor', 'woocommerce') . '</option>
						</select></div>';
                }
                comment_form(apply_filters('woocommerce_product_review_comment_form_args', $comment_form));
                ?>
            </div>
        </div>

    <?php else : ?>

        <p class="woocommerce-verification-required"><?php _e('Only logged in customers who have purchased this product may leave a review.', 'woocommerce'); ?></p>

    <?php endif; ?>

    <div class="clear"></div>
</div>
