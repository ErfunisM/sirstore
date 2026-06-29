<?php
/**
 * Quick view feature hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_quick_view_btn($id)
{
    if (is_numeric($id)) {
        echo '<button type="button" aria-label="' . __('مشاهده سریع', 'negarshop') . '"  data-toggle="tooltip" data-placement="bottom" data-original-title="' . __('مشاهده سریع محصول', 'negarshop') . '" class="cb-quick-view" data-id="' . $id . '"><i class="far fa-search"></i></button>';
    }
}

function negarshop_quick_view_ajax()
{
    header("Content-type:application/json");
    $json_array = [
        'status' => false,
        'data' => ''
    ];
    if (isset($_POST['id']) and is_numeric($_POST['id'])) {
        $id = $_POST['id'];
        $pf = new WC_Product_Factory();
        $prd = $pf->get_product($id);
        $product_gallery_html = '';
        $product_img_ids = $prd->get_gallery_image_ids();
        if (has_post_thumbnail($id)) {
            $product_img_ids[] = get_post_thumbnail_id($id);
        }
        if (!empty($product_img_ids)) {
            $product_gallery_html = '<div class="col-lg-5 thumbnail mb-5 mb-lg-0"><div id="cbQVModalCarousel" class="carousel dark" data-ride="carousel"><ol class="carousel-indicators">';

            $i1 = 0;
            foreach ($product_img_ids as $item) {
                $itemClass = ($i1 == 0) ? 'active' : '';
                $product_gallery_html .= '<li data-target="#cbQVModalCarousel" data-slide-to="' . $i1 . '" class="' . $itemClass . '"></li>';
                $i1++;
            }
            $product_gallery_html .= '</ol><div class="carousel-inner">';

            $i2 = 0;
            foreach ($product_img_ids as $item) {
                $itemClass = ($i2 == 0) ? 'active' : '';
                $product_gallery_html .= '
                    <div class="carousel-item ' . $itemClass . '">
                      <img class="d-block w-100" src="' . wp_get_attachment_url($item) . '">
                    </div>';
                $i2++;
            }
            $product_gallery_html .= '</div><a class="carousel-control-prev" href="#cbQVModalCarousel" role="button" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">' . __("قبلی", 'negarshop') . '</span></a><a class="carousel-control-next" href="#cbQVModalCarousel" role="button" data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">' . __("بعدی", 'negarshop') . '</span></a></div></div>';
        }
        $add2cartHTML = negarshop_add_to_cart_btn($id, __('افزودن به سبد خرید', 'negarshop'), 'btn btn-primary', 99999);


        $html_output = '
            <div class="cb-qv-modal-content p-5">
                <div class="row align-items-center">
                    
                    ' . $product_gallery_html . '
                    <div class="col-lg info">
                    <h2 class="ribbs">' . negarshop_get_print_ribbons($id, true) . '</h2>
                    <h2 class="title">' . $prd->get_title() . '</h2>
                    <h6 class="sub-title">' . negarshop_option('product_title_field', 'posts', $id) . '</h6>
                    <div class="price">' . $prd->get_price_html() . '</div>
                    <div class="add-to-cart text-left">
                        ' . $add2cartHTML . '
                        <a class="btn btn-transparent" href="' . $prd->get_permalink() . '">
                            ' . __('مشاهده محصول', 'negarshop') . '
                        </a>
                    </div>
                    </div>
                </div>
            </div>';
        $json_array['status'] = true;
        $json_array['data'] = $html_output;
    }
    echo json_encode($json_array);
    wp_die();
}

function negarshop_quick_view_modal()
{
    if (!is_user_logged_in() && function_exists('woocommerce_login_form')) {
        ?>
        <div class="modal fade" id="login-popup-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered <?php echo negarshop_option('sms_smart_login') === 'true' ? '' : 'modal-lg'; ?>">
                <div class="modal-content">

                    <button type="button" class="btn close-modal cb-custom-close" data-dismiss="modal">
                        <i class="far fa-times"></i>
                    </button>
                    <div class="modal-body p-5">
                        <?php
                        if (negarshop_option('sms_smart_login') === 'true') {
                            global $smart_login_page;
                            $smart_login_page = true;
                            echo '<div class="smart-login-page">';
                            negarshop_smart_login_content();
                            echo '</div>';
                            return;
                        } else {
                            ?>
                            <div class="row py-2">
                                <div class="col-lg-6">
                                    <h6 class="modal-title"><?php _e('ورود به حساب کاربری', 'negarshop'); ?></h6>
                                    <div class="negarshop-login-box">
                                        <div class="login-result"></div>
                                        <div class="login-loading" style="display: none">
                                            <div class="spinner"></div>
                                        </div>
                                        <?php
                                        global $wp;
                                        woocommerce_login_form(['redirect' => home_url($wp->request)]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="sign-up-box">
                                        <i class="sign-up-vector"></i>
                                        <div class="sign-up-message"><?php esc_html_e('حساب کاربری ندارید؟', 'negarshop'); ?>
                                            <a href="<?php echo add_query_arg('register', '', wc_get_page_permalink('myaccount')); ?>">
                                                <?php _e('ساخت حساب کاربری', 'negarshop'); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="modal fade cb-quick-view-modal-lg" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn close-modal" data-dismiss="modal">
                    <i class="far fa-times"></i>
                </button>
                <div class="w-100"></div>
                <div class="loading"><span class="spinner"></span></div>
                <div class="content"></div>
            </div>
        </div>
    </div>
    <?php
}

function negarshop_custom_modals()
{
    negarshop_get_part('modals/custom', 'modals');
}


add_action('wp_ajax_negarshop_quick_view_ajax', 'negarshop_quick_view_ajax');
add_action('wp_ajax_nopriv_negarshop_quick_view_ajax', 'negarshop_quick_view_ajax');
add_action('wp_footer', 'negarshop_quick_view_modal');
add_action('wp_footer', 'negarshop_custom_modals');