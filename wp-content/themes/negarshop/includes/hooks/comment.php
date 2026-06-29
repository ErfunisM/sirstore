<?php
/**
 * Comment hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_comment_attach_remove() {
    $attachID = $_POST['attach'] ?? '0';
    $comment = $_POST['comment'] ?? '0';
    if ($attachID !== '0' && $comment !== '0') {
        $getCommentAttachments = get_comment_meta($comment, 'comment_attachments', true);
        if (($key = array_search($attachID, $getCommentAttachments, true)) !== false) {
            unset($getCommentAttachments[$key]);
        }
        if (update_comment_meta($comment, 'comment_attachments', $getCommentAttachments)) {
            wp_send_json([
                'success' => true,
                'message' => 'مورد پاک شد!'
            ]);
        }
    }
    wp_send_json_error(['message' => 'خطایی رخ داد!']);
}

function negarshop_comment_attachments() {
    if (!is_user_logged_in() || negarshop_option('comment_upload_files') !== 'true') {
        wp_send_json_error([
            'message' => 'شما مجاز به ارسال درخواست نمی باشید!'
        ]);
    }
    if (!isset($_FILES['file'], $_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'dropzone-nonce')) {
        wp_send_json_error([
            'message' => 'شما مجاز به ارسال درخواست نمی باشید!'
        ]);
    }

    if (!function_exists('wp_handle_upload')) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');
    }
    // for multiple file upload.
    $upload_overrides = [
        'test_form' => false,
        'mimes' => [
            'png' => 'image/png',
            'jpg|jpeg|jpe' => 'image/jpeg'
        ]
    ];
    $files = $_FILES['file'];

    if ($files['size'] > 2000000) {
        wp_send_json_error([
            'message' => 'اندازه فایل بیش از حد مجاز می باشد!'
        ]);
    }

    if (isset($files['name'])) {
        $fileType = explode('.', $files['name']);
        $fileName = 'comment_' . md5($files['name']) . '.' . $fileType[count($fileType) - 1];
        $file = [
            'name' => $fileName,
            'type' => $files['type'],
            'tmp_name' => $files['tmp_name'],
            'error' => $files['error'],
            'size' => $files['size']
        ];

        $movefile = wp_handle_upload($file, $upload_overrides);

        if (isset($movefile['url'])) {
            $insertImage = wp_insert_attachment([
                'guid' => $movefile['url'],
                'post_mime_type' => $movefile['type'],
                'post_title' => preg_replace('/\.[^.]+$/', '', $fileName),
                'post_content' => '',
                'post_status' => 'inherit'
            ], $movefile['file'], 0, true);

            if (!is_wp_error($insertImage)) {
                $attach_data = wp_generate_attachment_metadata($insertImage, $movefile['file']);
                wp_update_attachment_metadata($insertImage, $attach_data);
                wp_send_json([
                    'success' => true,
                    'attach' => $insertImage
                ]);
            }
        }
    }
    wp_send_json_error([
        'message' => 'خطایی رخ داده است!'
    ]);

}

function negarshop_update_comment_fields($fields) {

    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    $label = $req ? '*' : ' ' . __('(optional)', 'text-domain');
    $aria_req = $req ? "aria-required='true'" : '';

    $fields['author'] = '<p class="comment-form-author">
            <label for="author">' . __('نام شما (اجباری)', 'negarshop') . '</label>
			<input id="author" name="author" type="text" class="form-control" placeholder="' . __('نام خود را بنویسید', 'negarshop') . '" value="' . esc_attr($commenter['comment_author']) . '" size="30" ' . $aria_req . ' />
		</p>';

    $fields['email'] = '<p class="comment-form-email">
            <label for="email">' . __('ایمیل شما (اجباری)', 'negarshop') . '</label>
			<input id="email" name="email" type="email" class="form-control" placeholder="' . __('ایمیل خود را بنویسید', 'negarshop') . '" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" ' . $aria_req . ' />
		</p>';

    $fields['url'] = '';
    $consent = empty($commenter['comment_author_email']) ? '' : ' checked="checked"';
    $fields['cookies'] = '<p class="comment-form-cookies-consent ns-checkbox"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' />' . ' <label for="wp-comment-cookies-consent">' . __('اطلاعات مرا در مرورگر ذخیره کن', 'negarshop') . '</label></p>';

    return $fields;
}

function negarshop_comment_form_field_comment($comment_field) {
    $comment_field = str_replace('name="comment"', 'name="comment" class="form-control" placeholder="' . __('متن دیدگاه خود را بنویسید', 'negarshop') . '"', $comment_field);
    if (!(is_singular('post') && negarshop_option('blog_single_comment_adv') === "simple")) {
        $comment_field .= '<div class="row"><div class="col-lg"><div class="comment-form-chip plus-cfc"><label>' . __('نقاط قوت:', 'negarshop') . ' </label><span class="cb-chips" data-name="plus-rate" data-phold="' . __('نقاط قوت را بنویسید', 'negarshop') . '"></span></div></div>';
        $comment_field .= '<div class="col-lg"><div class="comment-form-chip nega-cfc"><label>' . __('نقاط ضعف:', 'negarshop') . ' </label><span class="cb-chips" data-name="negative-rate" data-phold="' . __('نقاط ضعف را بنویسید', 'negarshop') . '"></span></div></div></div>';

        if (is_user_logged_in() && is_singular('product') && negarshop_option('comment_upload_files') === 'true') {
            $comment_field .= '<div id="comment-attachments" class="dropzone">
			<input type="hidden" name="attachments" id="comment-attach-ids">
		    <div class="fallback">
			    <input name="file" type="file" multiple />
		    </div>
	    </div>';
        }

    }

    return $comment_field;
}

function negarshop_save_comment_meta_data($comment_id) {
    if (isset($_POST['cb_feature'])) {
        add_comment_meta($comment_id, 'cb_feature', $_POST['cb_feature']);
    }

    if (!empty($_POST['attachments'])) {
        $attachs = explode(',', $_POST['attachments']);
        if (!empty($attachs) && !empty($attachs[0])) {
            add_comment_meta($comment_id, 'comment_attachments', $attachs);
        }
    }

    if (isset($_POST['plus-rate'])) {
        add_comment_meta($comment_id, 'plus-rate', $_POST['plus-rate']);
    }
    if (isset($_POST['negative-rate'])) {
        add_comment_meta($comment_id, 'negative-rate', $_POST['negative-rate']);
    }
    $user = get_current_user_id();
    if ($user !== 0 and isset($_POST['comment_post_ID']) and is_numeric($_POST['comment_post_ID']) and get_post_type(
            $_POST['comment_post_ID']
        ) == "product") {
        $customer_email = get_user_meta($user, 'billing_email', true);
        $is_bought = wc_customer_bought_product($customer_email, $user, $_POST['comment_post_ID']);
        if ($is_bought) {
            add_comment_meta($comment_id, 'is_buyer', '1');
        }
    }
    add_comment_meta($comment_id, 'cb_like', 0);
    add_comment_meta($comment_id, 'cb_dislike', 0);
}

function negarshop_get_comment_likes($id) {
    $key = "cb_like";
    $likes = (get_comment_meta($id, $key, true) != null) ? get_comment_meta($id, $key, true) : 0;

    return $likes;
}

function negarshop_get_comment_dislikes($id) {
    $key = "cb_dislike";
    $likes = (get_comment_meta($id, $key, true) != null) ? get_comment_meta($id, $key, true) : 0;

    return $likes;
}

function negarshop_comment_like($id) {
    $key = "cb_like";
    $likes = get_comment_meta($id, $key, true);
    if ($likes == null) {
        $likes = 1;
        add_comment_meta($id, $key, $likes);
    } else {
        $likes++;
        update_comment_meta($id, $key, $likes);
    }

    return $likes;
}

function negarshop_comment_dislike($id) {
    $key = "cb_dislike";
    $likes = get_comment_meta($id, $key, true);
    if ($likes == null) {
        $likes = 1;
        add_comment_meta($id, $key, $likes);
    } else {
        $likes++;
        update_comment_meta($id, $key, $likes);
    }

    return $likes;
}

function negarshop_comment_rates() {
    header("Content-type:application/json");
    $json_array = [
        'status' => false,
        'data' => ''
    ];
    $id = $_POST['id'];
    $action = $_POST['act'];
    if (is_numeric($id)) {
        $count = 0;
        if ($action == "like") {
            $json_array['status'] = true;
            $count = negarshop_comment_like($id);
        } else if ($action == "dislike") {
            $json_array['status'] = true;
            $count = negarshop_comment_dislike($id);
        }
        $json_array['data'] = $count;
    }
    die(json_encode($json_array));
}

function negarshop_get_comments_html($post_id, $order, $page) {
    $arg = [
        'post_id' => $post_id,
        'status' => 'approve',
        'type' => ['comment', 'review']
    ];
    if ($order === "buyers") {
        $arg['meta_key'] = "is_buyer";
    }
    if ($order === "useful") {
        $arg['meta_key'] = "cb_like";
        $arg['orderby'] = "meta_value_num";
    } else {
        $arg['orderby'] = 'comment_date_gmt';
        $arg['order'] = 'DESC';
    }
    $comments = get_comments($arg);
    $render_arg = [
        'callback' => 'woocommerce_comments',
    ];

    if (wp_doing_ajax()) {
        $render_arg['per_page'] = -1;
        $render_arg['page'] = $page;
    }

    return negarshop_get_wp_list_comments(apply_filters('woocommerce_product_review_list_args', $render_arg), $comments);
}

function negarshop_comment_tabs() {
    header("Content-type:application/json");
    $json_array = [
        'status' => false,
        'data' => ''
    ];
    $post_id = $_POST['id'];
    $page = (isset($_POST['page'])) ? $_POST['page'] : 0;
    $order = (isset($_POST['order'])) ? $_POST['order'] : "news";
    if (is_numeric($post_id) and is_numeric($page)) {
        $html = negarshop_get_comments_html($post_id, $order, $page);
        $json_array['status'] = true;
        if (!empty($html)) {
            $json_array['data'] = $html;
        } else {
            $json_array['data'] = '<li class="not-found"><p>' . __('دیدگاهی پیدا نشد!', 'negarshop') . '</p></li>';
        }
    }
    die(json_encode($json_array));
}

function negarshop_get_wp_list_comments($args, $comments) {
    ob_start();
    wp_list_comments($args, $comments);
    if (!wp_doing_ajax()) {
        echo '<div class="woocommerce-pagination">';
        echo '<div class="comments-pagination">';
        paginate_comments_links($args);
        echo '</div>';
        echo '</div> ';
    }
    $html = ob_get_clean();

    return $html;
}


function negarshop_comment_rates_print($comment = null) {
    if ($comment === null) {
        global $comment;
    }
    if (!isset($comment->comment_ID) || empty($comment->comment_ID)) {
        return;
    }

    $plus_rates = get_comment_meta($comment->comment_ID, 'plus-rate', true);
    $plus_rates = (!empty($plus_rates)) ? array_filter($plus_rates) : [];
    $nega_rates = get_comment_meta($comment->comment_ID, 'negative-rate', true);
    $nega_rates = (!empty($nega_rates)) ? array_filter($nega_rates) : [];
    if (!empty($plus_rates) || !empty($nega_rates)) {
        echo '<div class="row align-items-center comment-rates-sec">';
        if (!empty($plus_rates)) {
            echo '<div class="col-sm comment-plus-rates"><span class="sec-title">' . __('نقاط قوت', 'negarshop') . '</span><ul class="comment-rates plus-rates">';
            foreach ($plus_rates as $plus_rate) {
                echo '<li>' . $plus_rate . '</li>';
            }
            echo '</ul></div>';
        }
        if (!empty($nega_rates)) {
            echo '<div class="col-sm comment-nega-rates"><span class="sec-title">' . __('نقاط ضعف', 'negarshop') . '</span><ul class="comment-rates negative-rates">';
            foreach ($nega_rates as $nega_rate) {
                echo '<li>' . $nega_rate . '</li>';
            }
            echo '</ul></div>';
        }
        echo '</div>';
    }

}

function negarshop_comment_text($comment_text, $comment, $args) {
    if ($comment->comment_type === 'ns_question' && is_admin()) {
        $comment_text = '<b>پرسش و پاسخ:</b> ' . $comment_text;
    }

    negarshop_comment_rates_print($comment);

    $comment_attachs = get_comment_meta($comment->comment_ID, 'comment_attachments', true);

    if (!empty($comment_attachs) && is_array($comment_attachs)) {
        $comment_text .= '<ul class="comment-attachments">';
        foreach ($comment_attachs as $comment_attach) {
            $comment_text .= '<li>';
            if ($comment->comment_approved === "1" || is_admin()) {
                $comment_text .= '<a href="' . wp_get_attachment_url($comment_attach) . '">';
                $comment_text .= wp_get_attachment_image($comment_attach, 'thumbnail');
                $comment_text .= '</a>';
            }
            if (is_admin()) {
                $comment_text .= '<button type="button" data-comment-id="' . $comment->comment_ID . '" data-attach-id="' . $comment_attach . '" class="button remove-item">حذف</button>';
            }
            $comment_text .= '</li>';
        }
        $comment_text .= '</ul>';

    }

    return $comment_text;
}

function negarshop_preprocess_comment($commentdata) {
    if ((isset($_POST['comment_type'])) && ($_POST['comment_type'] !== '')) {
        $commentdata['comment_type'] = wp_filter_nohtml_kses($_POST['comment_type']);
    }
    if (isset($_POST['comment_ID']) && get_comment_type($_POST['comment_ID']) === 'ns_question') {
        //$_POST['comment_type'] = 'ns_question';
        $commentdata['comment_type'] = 'ns_question';
    }
    return $commentdata;
}

function negarshop_get_comment_link($link, $comment, $args, $cpage) {
    if ($comment->comment_type === 'ns_question') {
        return str_replace('#comment-', '#question-', $link);
    }

    return $link;
}

add_action('wp_ajax_negarshop_comment_attachments', 'negarshop_comment_attachments');
add_action('wp_ajax_nopriv_negarshop_comment_attachments', 'negarshop_comment_attachments');
add_action('wp_ajax_negarshop_comment_attach_remove', 'negarshop_comment_attach_remove');
add_filter('comment_form_default_fields', 'negarshop_update_comment_fields');
add_filter('comment_form_field_comment', 'negarshop_comment_form_field_comment');
add_filter('comment_text', 'negarshop_comment_text', 1, 3);
add_filter('preprocess_comment', 'negarshop_preprocess_comment', 12, 1);
add_filter('get_comment_link', 'negarshop_get_comment_link', 10, 4);
add_action('wp_ajax_negarshop_comment_tabs', 'negarshop_comment_tabs');
add_action('wp_ajax_nopriv_negarshop_comment_tabs', 'negarshop_comment_tabs');
add_action('comment_post', 'negarshop_save_comment_meta_data');
add_action('wp_ajax_negarshop_comment_rates', 'negarshop_comment_rates');
add_action('wp_ajax_nopriv_negarshop_comment_rates', 'negarshop_comment_rates');