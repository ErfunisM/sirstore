<?php
/**
 * Survey hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_survey_post_type () {
    register_post_type('price_survey', [
        'labels'              => [
            'name'          => 'نظرسنجی محصول',
            'singular_name' => 'نظر',
            'add_new'       => 'نظر جدید',
            'new_item'      => 'نظر جدید',
            'all_items'     => 'همه نظرات',
        ],
        'public'              => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
        'has_archive'         => false,
        'menu_icon'           => 'dashicons-clipboard',
        'rewrite'             => ['slug' => 'price_survey'],
        'supports'            => ['title']
    ]);
}

function negarshop_survey_add_meta_boxes () {
    add_meta_box('survey_comment', 'پاسخ نظر سنجی', 'negarshop_survey_comment_meta_box_callback', 'price_survey');
}

function negarshop_survey_comment_meta_box_callback ($post) {
    wp_nonce_field('global_notice_nonce', 'global_notice_nonce');
    echo '<p><b>محصول:</b> <a href="' . get_the_permalink(get_post_meta(get_the_id(), 'survey_prod', true)) . '">' . get_the_title(get_post_meta(get_the_id(), 'survey_prod', true)) . '</a></p>';
    echo '<p><b>کاربر:</b> <a href="' . get_edit_user_link(get_post_meta(get_the_id(), 'survey_user_id', true)) . '">' . esc_html(get_post_meta(get_the_id(), 'survey_user_display', true)) . '</a></p>';
    echo '<p><b>سوال نظر سنجی:</b> ' . esc_html(get_post_meta(get_the_id(), 'survey_user_ques', true)) . '</p>';
    echo '<p><b>پاسخ کاربر:</b> ' . esc_html(get_post_meta(get_the_id(), 'survey_user_answ', true)) . '</p>';
    echo '<p><b>' . esc_html(get_post_meta(get_the_id(), 'survey_user_desc', true)) . '</b> ' . esc_html(get_post_meta(get_the_id(), 'survey_user_desc_ans', true)) . '</p>';
    echo '<p><b>' . esc_html(get_post_meta(get_the_id(), 'survey_user_desc2', true)) . '</b> ' . esc_html(get_post_meta(get_the_id(), 'survey_user_desc2_ans', true)) . '</p>';

}

function negarshop_survey_question () {
    if ( negarshop_option('ps_active') !== "true" ) {
        return;
    }
    global $product;
    if ( negarshop_exist_user_survey(get_current_user_id(), $product) ) {
        return;
    }
    ?>
    <div class="product-survey">
        <span class="thanks"><i class="far fa-check"></i> <?php echo negarshop_option('ps_thanks'); ?></span>
        <span class="question"><?php echo negarshop_option('ps_question'); ?></span>
        <span class="answers">
            <button class="yes btn btn-whiter" data-product="<?php the_ID(); ?>">
                <?php echo negarshop_option('ps_ans1'); ?>
            </button>
            <button class="no btn btn-whiter" data-toggle="modal"
                    data-target="#<?php echo is_user_logged_in() ? 'product-survey' : 'login-popup-modal'; ?>">
                <?php echo negarshop_option('ps_ans2'); ?>
            </button>
        </span>
    </div>
    <?php
}

function negarshop_product_survey_modal () {
    if ( function_exists('is_product') and is_product() ) {
        global $product;
        if ( negarshop_exist_user_survey(get_current_user_id(), $product) ) {
            return;
        }
        ?>
        <!-- Product survey Modal -->
        <div class="modal fade" id="product-survey" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo negarshop_option('ps_question'); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <figure class="thumbnail"><?php the_post_thumbnail('thumbnail'); ?></figure>
                            </div>
                            <div class="col">
                                <p class="title"><?php the_title(); ?></p>
                                <p class="price"><?php echo $product->get_price_html(); ?></p>
                            </div>
                        </div>
                        <form method="post" id="product-survey-form">
                            <?php if ( !empty(negarshop_option('ps_desc')) ) { ?>
                                <div class="form-group">
                                    <label for="desc1"><?php echo negarshop_option('ps_desc'); ?></label>
                                    <input type="text" class="form-control" name="desc1" id="desc1" required>
                                </div>
                            <?php } ?>
                            <?php if ( !empty(negarshop_option('ps_desc2')) ) { ?>
                                <div class="form-group">
                                    <label for="desc2"><?php echo negarshop_option('ps_desc2'); ?></label>
                                    <input type="text" class="form-control" name="desc2" id="desc2" required>
                                </div>
                            <?php } ?>
                            <input type="hidden" value="<?php the_id(); ?>" name="product">
                            <?php wp_nonce_field(); ?>
                            <button type="submit" class="btn btn-primary"><i class="far fa-check"></i> ثبت نظر</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

function negarshop_product_survey_ajax () {
    $data    = [
        'status' => false,
        'data'   => 'هنگام ثبت نظر خطایی رخ داد!'
    ];
    $product = (isset($_POST['product']) and is_numeric($_POST['product'])) ? $_POST['product'] : false;
    $ans     = isset($_POST['answ']) ? $_POST['answ'] : 'yes';
    if ( $ans == "no" ) {
        if ( is_user_logged_in() and isset($_POST['_wpnonce']) and wp_verify_nonce($_POST['_wpnonce']) ) {
            $answ1 = isset($_POST['desc1']) ? esc_html($_POST['desc1']) : '';
            $answ2 = isset($_POST['desc2']) ? esc_html($_POST['desc2']) : '';
            if ( $product !== false ) {
                $user_info = get_userdata(get_current_user_id());
                $post_arr  = [
                    'post_title'  => get_the_title($product) . ' || کاربر:' . $user_info->display_name,
                    'post_status' => 'publish',
                    'post_type'   => 'price_survey',
                    'post_author' => get_current_user_id(),
                    'meta_input'  => [
                        'survey_user_ques'      => negarshop_option('ps_question'),
                        'survey_user_id'        => get_current_user_id(),
                        'survey_user_display'   => $user_info->display_name,
                        'survey_user_answ'      => negarshop_option('ps_ans2'),
                        'survey_user_desc'      => negarshop_option('ps_desc'),
                        'survey_user_desc2'     => negarshop_option('ps_desc2'),
                        'survey_user_desc_ans'  => $answ1,
                        'survey_user_desc2_ans' => $answ2,
                        'survey_prod'           => $product,
                    ],
                ];
                if ( wp_insert_post($post_arr) ) {
                    $pf  = new WC_Product_Factory();
                    $prd = $pf->get_product($product);
                    negarshop_add_user_meta_survey(get_current_user_id(), $prd);
                    $data = [
                        'status' => true,
                        'data'   => 'نظر شما ثبت گردید.',
                    ];
                }
            }
        }
    } else {
        $pf  = new WC_Product_Factory();
        $prd = $pf->get_product($product);
        negarshop_add_user_meta_survey(get_current_user_id(), $prd);
        $data = [
            'status' => true,
            'data'   => 'نظر شما ثبت گردید.',
        ];
    }
    wp_send_json($data);
}

function negarshop_get_user_survey ($user) {
    $meta = get_user_meta($user, 'ns_product_survey', true);
    $meta = empty($meta) ? [] : $meta;

    return $meta;
}

function negarshop_set_user_survey ($user, $data) {
    if ( empty(negarshop_get_user_survey($user)) ) {
        return add_user_meta($user, 'ns_product_survey', $data);
    } else {
        return update_user_meta($user, 'ns_product_survey', $data);
    }
}

function negarshop_exist_user_survey ($user, $product): bool {
    $get = negarshop_get_user_survey($user);
    if ( !empty($get) and isset($get[$product->get_id()]) and $get[$product->get_id()] == $product->get_regular_price() ) {
        return true;
    }

    return false;
}

function negarshop_add_user_meta_survey ($user, $product) {
    $get = negarshop_get_user_survey($user);
    if ( $product !== false ) {
        $get[$product->get_id()] = $product->get_regular_price();

        return negarshop_set_user_survey($user, $get);
    }

    return false;
}


add_action('init', 'negarshop_survey_post_type');
add_action('add_meta_boxes', 'negarshop_survey_add_meta_boxes');
add_filter('woocommerce_after_single_product_summary_left', 'negarshop_survey_question');
add_action('negarshop_modals', 'negarshop_product_survey_modal');
add_action('wp_ajax_negarshop_product_survey_ajax', 'negarshop_product_survey_ajax');
add_action('wp_ajax_nopriv_negarshop_product_survey_ajax', 'negarshop_product_survey_ajax');