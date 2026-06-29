<?php
/**
 * Plugins customize hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_string_compress_encode($string): string
{
    $output = rtrim(strtr(base64_encode(gzdeflate($string, 9)), '+/', '-_'), '=');

    return $output;
}

function negarshop_string_compress_decode($string)
{
    $output = gzinflate(base64_decode(strtr($string, '-_', '+/')));

    return $output;
}

function negarshop_add_translate($dir, $file, $to, $replace = false): bool
{
    $exs = $replace || !file_exists($to);
    if (file_exists($dir) and $exs) {
        $copy = copy($file, $to);
        if ($copy) {
            return true;
        }
    }

    return false;
}

function negarshop_yith_woocompare_popup_head()
{
    $font_family = negarshop_option('site_font');
    $fontLink = "";
    if ($font_family == 'Vazir') {
        $fontLink = get_theme_file_uri('/statics/fonts/vazir/vazir.css');
    } else if ($font_family == 'shabnam') {
        $fontLink = get_theme_file_uri('/statics/fonts/shabnam/shabnam.css');
    } else if ($font_family == 'parastoo') {
        $fontLink = get_theme_file_uri('/statics/fonts/parastoo/parastoo.css');
    } else if ($font_family == 'IRANYekan, IRANSans_Fa') {
        $fontLink = get_theme_file_uri('/statics/fonts/iranyekan/style.css');
    } else if ($font_family == 'IRANSans_Fa') {
        $fontLink = get_theme_file_uri('/statics/fonts/iransans/iransans.css');
    } else if ($font_family == 'IRANSans') {
        $fontLink = get_theme_file_uri('/statics/fonts/iransans/iransans-en.css');
    } else if (mb_stripos($font_family, 'Dima') !== false) {
        $fontLink = get_theme_file_uri('/statics/fonts/dima/' . $font_family . '.css');
    }
    if (!empty($fontLink)) {
        echo '<link rel="stylesheet" href="' . $fontLink . '" />';
    }
    if ($font_family === "custom") {
        add_action('wp_head', function () {
            echo '<style>';
            $opt = negarshop_option('site_font_picker');
            echo negarshop_get_font_face_from_data('custom', $opt['custom']);
            echo '</style>';
        });
    }

    ?>
    <style>
        body {
            font-family: <?= $font_family ?> !important;
            direction: rtl;
        }

        body h1 {
            border-radius: 20px;
        }

        .woocommerce-variation-price, .woocommerce-variation-price *, .woocommerce p.price span.amount, .woocommerce p.price span.amount *, article.product div.price span, .woocommerce-Price-amount.amount, .woocommerce-Price-amount.amount * {
            unicode-bidi: plaintext;
            direction: ltr;
        }
    </style>
    <?php
}

if (!function_exists('array_swap_assoc')) {
    function array_swap_assoc($key1, $key2, $array): array
    {
        $newArray = [];
        foreach ($array as $key => $value) {
            if ($key == $key1) {
                $newArray[$key2] = $array[$key2];
            } elseif ($key == $key2) {
                $newArray[$key1] = $array[$key1];
            } else {
                $newArray[$key] = $value;
            }
        }

        return $newArray;
    }
}

function negarshop_register_required_plugins()
{
    $plugins = [
        [
            'name' => 'ووکامرس',
            'slug' => 'woocommerce',
            'required' => true,
        ],
        [
            'name' => 'صفحه ساز المنتور',
            'slug' => 'elementor',
            'required' => true,
        ],
        [
            'name' => 'برند ها (Premmerce woocommerce brands)',
            'slug' => 'premmerce-woocommerce-brands',
        ],
        [
            'name' => 'محصولات متغیر حرفه ای (YITH)',
            'slug' => 'yith-color-and-label-variations-for-woocommerce',
        ],
        [
            'name' => 'المنتور پرو',
            'slug' => 'elementor-pro',
            'source' => 'https://cdn.coderboy.ir/plugins/elementor-pro.zip',
            'external_url' => 'https://cdn.coderboy.ir/plugins/elementor-pro.zip',
        ]
    ];
    $config = [
        'id' => 'negarshop_tgmpa',
        // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',
        // Default absolute path to bundled plugins.
        'menu' => 'negarshop-install-plugins',
        // Menu slug.
        'parent_slug' => 'themes.php',
        // Parent menu slug.
        'capability' => 'edit_theme_options',
        // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices' => true,
        // Show admin notices or not.
        'dismissable' => true,
        // If false, a user cannot dismiss the nag message.
        'dismiss_msg' => '',
        // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,
        // Automatically activate plugins after installation or not.
        'message' => 'افزونه های مورد نیاز پوسته نگارشاپ',
        // Message to output right before the plugins table.

    ];
    tgmpa_edited($plugins, $config);
    update_option('negarshop_installer_ready', $GLOBALS['tgmpa']->required_plugins_installed());
}

function negarshop_yith_woocommerce_affiliates_translates($translate, $text, $domain)
{
    $out = $translate;
    if ($domain === 'yith-woocommerce-affiliates') {
        switch ($text) {
            case 'Payment email':
                $out = 'شماره کارت';
                break;
            default:
                $out = $translate;
                break;

        }
    }

    return $out;
}

function negarshop_yith_wcaf_settings_form_start()
{
    $card = get_user_meta(get_current_user_id(), 'ns_affiliate_card_number', true);
    if (isset($_POST['bank_card'])) {
        $card = $_POST['bank_card'];
        update_user_meta(get_current_user_id(), 'ns_affiliate_card_number', $card);
        $affiliate = YITH_WCAF_Affiliate_Handler()->get_affiliate_by_user_id(get_current_user_id());
        YITH_WCAF_Affiliate_Handler()->update($affiliate['ID'], ['payment_email' => $card]);
    }
    ?>
    <p class="form form-row">
        <label for="bank_card"><?php esc_html_e('شماره کارت', 'negarshop'); ?></label>
        <input type="text" name="bank_card" id="bank_card" value="<?php echo esc_attr($card); ?>"/>
        <small><?php esc_html_e(
                'توجه داشته باشید که شماره کارت حتما باید به نام دارنده این حساب کاربری باشد.', 'negarshop'
            ); ?></small>
    </p>
    <?php
}

function negarshop_print_waiting_btn()
{
    $form = (do_shortcode(
            "[ywcwtl_form product_id='" . get_the_id() . "']"
        ) !== "[ywcwtl_form product_id='" . get_the_id() . "']") ? do_shortcode(
        "[ywcwtl_form product_id='" . get_the_id() . "']"
    ) : '';
    ob_start();
    do_shortcode("[woo_ps_sms]");
    $sms_form = ob_get_clean();
    if (!empty($form) or !empty($sms_form)) {
        echo '<li>';
        echo '<a href="javascript:void(0);" data-toggle="modal" data-target=".product-ywcwtl-modal" class="action-btn-product-ywcwtl">' . __(
                'خبر بده', 'negarshop'
            ) . '</a>';
        echo '</li>';

        add_action(
            'wp_footer', function () use ($sms_form, $form) {
            ?>
            <div class="modal fade product-ywcwtl-modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <button type="button" class="btn close-modal" data-dismiss="modal">
                            <i class="far fa-times"></i>
                        </button>
                        <div class="product-share-modal-inner">
                            <h5 class="share-title"><?php _e('اطلاع رسانی هنگام موجود شدن', 'negarshop'); ?></h5>
                            <h6 class="share-desc"><?php _e('با خبر شدن از تغییرات محصول', 'negarshop'); ?></h6>
                            <?php echo $form; ?>
                            <?php echo $sms_form; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        );
    }
}

function negarshop_print_compare_btn($id = null, $text = null, $echo = true, $class = "")
{
    if (!$echo) {
        ob_start();
    }
    if ($id === null) {
        $id = get_the_ID();
    }
    if (empty($text)) {
        $text = '<i class="far fa-random"></i> ' . __('مقایسه', 'negarshop');
    }
    if (defined('YITH_WOOCOMPARE')) {
        echo do_shortcode(
            '[yith_compare_button product="' . $id . '" container="no" type="a"]' . $text . '[/yith_compare_button]'
        );
    } else if (function_exists('wooscp_init')) {
        echo '<button type="button" aria-label="' . __(
                'مقایسه', 'negarshop'
            ) . '"  class="compare wooscp-btn wooscp-btn-' . $id . '" data-toggle="tooltip" data-placement="bottom" data-original-title="' . __(
                'مقایسه محصول', 'negarshop'
            ) . '" data-id="' . $id . '">' . $text . '</button>';
    } else if (negarshop_option('negarshop_compare') === 'true') {
        echo '<button type="button" aria-label="' . __(
                'مقایسه', 'negarshop'
            ) . '"  class="compare negarshop-add-to-compare ' . $class . ' ' . (negarshop_in_compare_list($id) ? 'added' : '') . '" data-nonce="' . wp_create_nonce('negarshop_compare_nonce') . '" data-toggle="tooltip" data-placement="bottom" data-original-title="' . __(
                'مقایسه محصول', 'negarshop'
            ) . '" data-product-id="' . $id . '">' . $text . '</button>';
    }
    if (!$echo) {
        return ob_get_clean();
    }
}

function negarshop_deactive_plugins()
{
    if (!function_exists('is_plugin_active')) {
        require_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }
    if (is_plugin_active('unyson/unyson.php')) {
        deactivate_plugins(['unyson/unyson.php']);
    }
}

function negarshop_yith_wcbr_brands_label()
{
    return 'برند:';
}

add_filter('yith_wcaf_payment_email_required', '__return_false');
add_filter('gettext', 'negarshop_yith_woocommerce_affiliates_translates', 10, 3);
add_action('yith_wcaf_settings_form_start', 'negarshop_yith_wcaf_settings_form_start');
add_action('yith_woocompare_popup_head', 'negarshop_yith_woocompare_popup_head');
remove_action('admin_init', ['YITH_System_Status', 'check_system_status']);
add_action('admin_init', 'negarshop_deactive_plugins');
add_filter('pre_option_yith_wcbr_brands_label', 'negarshop_yith_wcbr_brands_label');