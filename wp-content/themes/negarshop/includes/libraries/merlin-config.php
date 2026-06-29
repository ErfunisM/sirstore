<?php
/**
 * Merlin WP configuration file.
 */

if (!class_exists('Merlin')) {
    return;
}

/**
 * Set directory locations, text strings, and settings.
 */
$wizard = new Merlin(

    $config = array(
        'directory' => 'includes/libraries/merlin', // Location / directory where Merlin WP is placed in your theme.
        'merlin_url' => 'negarshop_installer', // The wp-admin page slug where Merlin WP loads.
        'parent_slug' => 'themes.php', // The wp-admin parent page slug for the admin menu item.
        'capability' => 'manage_options', // The capability required for this menu to be displayed to the user.
        'dev_mode' => true, // Enable development mode for testing.
        'license_step' => false, // EDD license activation step.
        'license_required' => false, // Require the license activation step.
        'license_help_url' => '', // URL for the 'license-tooltip'.
        'edd_remote_api_url' => '', // EDD_Theme_Updater_Admin remote_api_url.
        'edd_item_name' => '', // EDD_Theme_Updater_Admin item_name.
        'edd_theme_slug' => '', // EDD_Theme_Updater_Admin item_slug.
        'ready_big_button_url' => site_url(), // Link for the big button on the ready step.
    ),
    $strings = array(
        'admin-menu' => esc_html__('نصب آسان', 'negarshop'),

        /* translators: 1: Title Tag 2: Theme Name 3: Closing Title Tag */
        'title%s%s%s%s' => esc_html__('%1$s%2$s قالب &lsaquo; نصب قالب: %3$s%4$s', 'negarshop'),
        'return-to-dashboard' => esc_html__('بازگشت به پیشخوان', 'negarshop'),
        'ignore' => esc_html__('غیرفعال کردن مراحل', 'negarshop'),

        'btn-skip' => esc_html__('گذشتن', 'negarshop'),
        'btn-next' => esc_html__('بعدی', 'negarshop'),
        'btn-start' => esc_html__('شروع', 'negarshop'),
        'btn-no' => esc_html__('لغو', 'negarshop'),
        'btn-plugins-install' => esc_html__('نصب', 'negarshop'),
        'btn-child-install' => esc_html__('نصب', 'negarshop'),
        'btn-content-install' => esc_html__('نصب', 'negarshop'),
        'btn-import' => esc_html__('درون ریزی', 'negarshop'),
        'btn-license-activate' => esc_html__('فعال سازی', 'negarshop'),
        'btn-license-skip' => esc_html__('بعدا', 'negarshop'),

        /* translators: Theme Name */
        'license-header%s' => esc_html__('فعال سازی %s', 'negarshop'),
        /* translators: Theme Name */
        'license-header-success%s' => esc_html__('%s فعال شده', 'negarshop'),

        /* translators: Theme Name */
        'welcome-header%s' => esc_html__('به %s خوش آمدید', 'negarshop'),
        'welcome-header-success%s' => esc_html__('سلام. خوش آمدید', 'negarshop'),
        'welcome%s' => esc_html__('این دستیار تم شما را تنظیم می کند، افزونه ها را نصب می کند و محتوا را وارد می کند. اختیاری است و باید فقط چند دقیقه طول بکشد.', 'negarshop'),
        'welcome-success%s' => esc_html__('ممکن است قبلاً این دستیار تنظیم تم را اجرا کرده باشید. اگر می خواهید به هر حال ادامه دهید، روی دکمه "شروع" در زیر کلیک کنید.', 'negarshop'),

        'child-header' => esc_html__('نصب تم کودک', 'negarshop'),
        'child-header-success' => esc_html__('شما آماده اید!', 'negarshop'),
        'child' => esc_html__('بیایید یک تم کودک بسازیم و فعال کنیم تا بتوانید به راحتی تم را تغییر دهید.', 'negarshop'),
        'child-success%s' => esc_html__('تم فرزند شما قبلاً نصب شده است و اگر قبلاً فعال نشده بود، اکنون فعال شده است.', 'negarshop'),
        'child-action-link' => esc_html__('در مورد این تم کودک بدانید!', 'negarshop'),
        'child-json-success%s' => esc_html__('عالی. تم فرزند شما نصب شده است و اکنون فعال شده است.', 'negarshop'),
        'child-json-already%s' => esc_html__('عالی. تم فرزند شما ایجاد شده و اکنون فعال شده است.', 'negarshop'),

        'plugins-header' => esc_html__('نصب افزونه ها', 'negarshop'),
        'plugins-header-success' => esc_html__('شما به سرعت عمل کردید!', 'negarshop'),
        'plugins' => esc_html__('بیایید چند پلاگین ضروری وردپرس را نصب کنیم تا سرعت سایت شما را افزایش دهیم.', 'negarshop'),
        'plugins-success%s' => esc_html__('افزونه های مورد نیاز وردپرس همگی نصب و به روز شدند. "بعدی" را فشار دهید تا جادوگر راه اندازی ادامه یابد.', 'negarshop'),
        'plugins-action-link' => esc_html__('پیشرفته', 'negarshop'),

        'import-header' => esc_html__('وارد کردن محتوا', 'negarshop'),
        'import' => esc_html__('بیایید محتوا را به وب سایت خود وارد کنیم تا به شما در آشنایی با تم کمک کنیم.', 'negarshop'),
        'import-action-link' => esc_html__('پیشرفته', 'negarshop'),

        'ready-header' => esc_html__('همه چی تمومه. لذت ببرید!', 'negarshop'),

        /* translators: Theme Author */
        'ready%s' => esc_html__('قالب شما کاملاً تنظیم شده است. از قالب جدید %s لذت ببرید.', 'negarshop'),
        'ready-action-link' => esc_html__('اضافات', 'negarshop'),
        'ready-big-button' => esc_html__('مشاهده سایت شما', 'negarshop'),
        'ready-link-1' => sprintf('<a href="%1$s" target="_blank">%2$s</a>', 'https://coderboy.ir/ne', esc_html__('مشاهده پسرک کدنویس', 'negarshop')),
        'ready-link-2' => sprintf('<a href="%1$s" target="_blank">%2$s</a>', 'https://www.rtl-theme.com/negarshop-woocommerce-wordpress-theme/', esc_html__('مشاهده راست چین', 'negarshop')),
        'ready-link-3' => sprintf('<a href="%1$s">%2$s</a>', admin_url('admin.php?page=fw-settings'), esc_html__('شروع سفارشی سازی', 'negarshop')),
        'types' => [
            'footer' => __('پابرگ', 'negarshop'),
            'header' => __('سربرگ', 'negarshop'),
            'homepage' => __('صفحه نخست', 'negarshop'),
            'pages' => __('برگه ها', 'negarshop'),
            'content' => __('محتوا', 'negarshop'),
            'widgets' => __('ابزارک های سایدبار', 'negarshop'),
            'options' => __('تنظیمات سفارشی سازی', 'negarshop'),
            'unyson' => __('تنظیمات قالب', 'negarshop'),
            'elementor_kit' => __('کیت المنتور', 'negarshop'),
            'media' => __('رسانه ها', 'negarshop'),
            'products' => __('محصولات', 'negarshop'),
        ]
    )
);

function negarshop_generate_child_functions_php($output, $slug): string
{

    $slug_no_hyphens = strtolower(preg_replace('#[^a-zA-Z]#', '', $slug));

    $output = "
		<?php
		/**
		 * Theme functions and definitions.
		 */
		function {$slug_no_hyphens}_child_enqueue_styles() {
		    wp_enqueue_style( '{$slug}-child-style',
		        get_stylesheet_directory_uri() . '/style.css',
		        [],
		        wp_get_theme()->get('Version')
		    );
		}

		add_action(  'wp_enqueue_scripts', '{$slug_no_hyphens}_child_enqueue_styles' );\n
	";

    $output = trim(preg_replace('/\t+/', '', $output));
    return $output;
}

function negarshop_merlin_import_files(): array
{
    return array(
        array(
            'import_file_name' => 'کلاسیک',
            'homepage' => trailingslashit(get_template_directory()) . 'demos/classic/home.xml',
            'elementor_kit' => trailingslashit(get_template_directory()) . 'demos/classic/elementor-kit.zip',
            'header' => trailingslashit(get_template_directory()) . 'demos/classic/header.xml',
            'footer' => trailingslashit(get_template_directory()) . 'demos/classic/footer.xml',
            'pages' => trailingslashit(get_template_directory()) . 'demos/classic/pages.xml',
            'products' => trailingslashit(get_template_directory()) . 'demos/classic/products.xml',
            'media' => trailingslashit(get_template_directory()) . 'demos/classic/media.xml',
            'local_import_widget_file' => trailingslashit(get_template_directory()) . 'demos/classic/widgets.wie',
            'unyson' => trailingslashit(get_template_directory()) . 'demos/classic/theme-options.dat',
            'import_preview_image_url' => get_template_directory_uri() . '/demos/classic/screen.png',
            'import_notice' => '',
            'preview_url' => 'https://demo.coderboy.ir/negarshop/digital',
        ),
        array(
            'import_file_name' => 'دیجیتال',
            'homepage' => trailingslashit(get_template_directory()) . 'demos/digital/home.xml',
            'elementor_kit' => trailingslashit(get_template_directory()) . 'demos/digital/elementor-kit.zip',
            'header' => trailingslashit(get_template_directory()) . 'demos/digital/header.xml',
            'footer' => trailingslashit(get_template_directory()) . 'demos/digital/footer.xml',
            'pages' => trailingslashit(get_template_directory()) . 'demos/digital/pages.xml',
            'products' => trailingslashit(get_template_directory()) . 'demos/digital/products.xml',
            'media' => trailingslashit(get_template_directory()) . 'demos/digital/media.xml',
            'local_import_widget_file' => trailingslashit(get_template_directory()) . 'demos/digital/widgets.wie',
            'unyson' => trailingslashit(get_template_directory()) . 'demos/digital/theme-options.dat',
            'import_preview_image_url' => get_template_directory_uri() . '/demos/digital/screen.png',
            'import_notice' => '',
            'preview_url' => 'https://demo.coderboy.ir/negarshop/digital',
        ),
        array(
            'import_file_name' => 'مد و فشن',
            'homepage' => trailingslashit(get_template_directory()) . 'demos/fashion/home.xml',
            'elementor_kit' => trailingslashit(get_template_directory()) . 'demos/fashion/elementor-kit.zip',
            'header' => trailingslashit(get_template_directory()) . 'demos/fashion/header.xml',
            'footer' => trailingslashit(get_template_directory()) . 'demos/fashion/footer.xml',
            'pages' => trailingslashit(get_template_directory()) . 'demos/fashion/pages.xml',
            'products' => trailingslashit(get_template_directory()) . 'demos/fashion/products.xml',
            'media' => trailingslashit(get_template_directory()) . 'demos/fashion/media.xml',
            'local_import_widget_file' => trailingslashit(get_template_directory()) . 'demos/fashion/widgets.wie',
            'unyson' => trailingslashit(get_template_directory()) . 'demos/fashion/theme-options.dat',
            'import_preview_image_url' => get_template_directory_uri() . '/demos/fashion/screen.png',
            'import_notice' => '',
            'preview_url' => 'https://demo.coderboy.ir/negarshop/fashion',
        ),
        array(
            'import_file_name' => 'پوشاک',
            'homepage' => trailingslashit(get_template_directory()) . 'demos/clothes/home.xml',
            'elementor_kit' => trailingslashit(get_template_directory()) . 'demos/clothes/elementor-kit.zip',
            'header' => trailingslashit(get_template_directory()) . 'demos/clothes/header.xml',
            'footer' => trailingslashit(get_template_directory()) . 'demos/clothes/footer.xml',
            'pages' => trailingslashit(get_template_directory()) . 'demos/clothes/pages.xml',
            'products' => trailingslashit(get_template_directory()) . 'demos/clothes/products.xml',
            'media' => trailingslashit(get_template_directory()) . 'demos/clothes/media.xml',
            'local_import_widget_file' => trailingslashit(get_template_directory()) . 'demos/clothes/widgets.wie',
            'unyson' => trailingslashit(get_template_directory()) . 'demos/clothes/theme-options.dat',
            'import_preview_image_url' => get_template_directory_uri() . '/demos/clothes/screen.png',
            'import_notice' => '',
            'preview_url' => 'https://demo.coderboy.ir/negarshop/clothes',
        ),
        array(
            'import_file_name' => 'زیبایی و بهداشتی',
            'homepage' => trailingslashit(get_template_directory()) . 'demos/beauty/home.xml',
            'elementor_kit' => trailingslashit(get_template_directory()) . 'demos/beauty/elementor-kit.zip',
            'header' => trailingslashit(get_template_directory()) . 'demos/beauty/header.xml',
            'footer' => trailingslashit(get_template_directory()) . 'demos/beauty/footer.xml',
            'pages' => trailingslashit(get_template_directory()) . 'demos/beauty/pages.xml',
            'products' => trailingslashit(get_template_directory()) . 'demos/beauty/products.xml',
            'media' => trailingslashit(get_template_directory()) . 'demos/beauty/media.xml',
            'local_import_widget_file' => trailingslashit(get_template_directory()) . 'demos/beauty/widgets.wie',
            'local_import_customizer_file' => trailingslashit(get_template_directory()) . 'demos/beauty/theme-options.dat',
            'import_preview_image_url' => get_template_directory_uri() . '/demos/beauty/screen.png',
            'import_notice' => '',
            'preview_url' => 'https://demo.coderboy.ir/negarshop/beauty',
        ),
        array(
            'import_file_name' => 'ابزار آلات صنعتی',
            'homepage' => trailingslashit(get_template_directory()) . 'demos/tools/home.xml',
            'elementor_kit' => trailingslashit(get_template_directory()) . 'demos/tools/elementor-kit.zip',
            'header' => trailingslashit(get_template_directory()) . 'demos/tools/header.xml',
            'footer' => trailingslashit(get_template_directory()) . 'demos/tools/footer.xml',
            'pages' => trailingslashit(get_template_directory()) . 'demos/tools/pages.xml',
            'products' => trailingslashit(get_template_directory()) . 'demos/tools/products.xml',
            'media' => trailingslashit(get_template_directory()) . 'demos/tools/media.xml',
            'local_import_widget_file' => trailingslashit(get_template_directory()) . 'demos/tools/widgets.wie',
            'local_import_customizer_file' => trailingslashit(get_template_directory()) . 'demos/tools/theme-options.dat',
            'import_preview_image_url' => get_template_directory_uri() . '/demos/tools/screen.png',
            'import_notice' => '',
            'preview_url' => 'https://demo.coderboy.ir/negarshop/tools',
        ),
        array(
            'import_file_name' => 'کودکانه',
            'homepage' => trailingslashit(get_template_directory()) . 'demos/kids/home.xml',
            'elementor_kit' => trailingslashit(get_template_directory()) . 'demos/kids/elementor-kit.zip',
            'header' => trailingslashit(get_template_directory()) . 'demos/kids/header.xml',
            'footer' => trailingslashit(get_template_directory()) . 'demos/kids/footer.xml',
            'pages' => trailingslashit(get_template_directory()) . 'demos/kids/pages.xml',
            'products' => trailingslashit(get_template_directory()) . 'demos/kids/products.xml',
            'media' => trailingslashit(get_template_directory()) . 'demos/kids/media.xml',
            'local_import_widget_file' => trailingslashit(get_template_directory()) . 'demos/kids/widgets.wie',
            'local_import_customizer_file' => trailingslashit(get_template_directory()) . 'demos/kids/theme-options.dat',
            'import_preview_image_url' => get_template_directory_uri() . '/demos/kids/screen.png',
            'import_notice' => '',
            'preview_url' => 'https://demo.coderboy.ir/negarshop/kids',
        ),
        array(
            'import_file_name' => 'جواهرات',
            'homepage' => trailingslashit(get_template_directory()) . 'demos/jewelry/home.xml',
            'elementor_kit' => trailingslashit(get_template_directory()) . 'demos/jewelry/elementor-kit.zip',
            'header' => trailingslashit(get_template_directory()) . 'demos/jewelry/header.xml',
            'footer' => trailingslashit(get_template_directory()) . 'demos/jewelry/footer.xml',
            'pages' => trailingslashit(get_template_directory()) . 'demos/jewelry/pages.xml',
            'products' => trailingslashit(get_template_directory()) . 'demos/jewelry/products.xml',
            'media' => trailingslashit(get_template_directory()) . 'demos/jewelry/media.xml',
            'local_import_widget_file' => trailingslashit(get_template_directory()) . 'demos/jewelry/widgets.wie',
            'local_import_customizer_file' => trailingslashit(get_template_directory()) . 'demos/jewelry/theme-options.dat',
            'import_preview_image_url' => get_template_directory_uri() . '/demos/jewelry/screen.png',
            'import_notice' => '',
            'preview_url' => 'https://demo.coderboy.ir/negarshop/jewelry',
        ),
        array(
            'import_file_name' => 'بازی و گیمینگ',
            'homepage' => trailingslashit(get_template_directory()) . 'demos/gaming/home.xml',
            'elementor_kit' => trailingslashit(get_template_directory()) . 'demos/gaming/elementor-kit.zip',
            'header' => trailingslashit(get_template_directory()) . 'demos/gaming/header.xml',
            'footer' => trailingslashit(get_template_directory()) . 'demos/gaming/footer.xml',
            'pages' => trailingslashit(get_template_directory()) . 'demos/gaming/pages.xml',
            'products' => trailingslashit(get_template_directory()) . 'demos/gaming/products.xml',
            'media' => trailingslashit(get_template_directory()) . 'demos/gaming/media.xml',
            'local_import_widget_file' => trailingslashit(get_template_directory()) . 'demos/gaming/widgets.wie',
            'local_import_customizer_file' => trailingslashit(get_template_directory()) . 'demos/gaming/theme-options.dat',
            'import_preview_image_url' => get_template_directory_uri() . '/demos/gaming/screen.png',
            'import_notice' => '',
            'preview_url' => 'https://demo.coderboy.ir/negarshop/gaming',
        ),
        array(
            'import_file_name' => 'قهوه و شکلات',
            'homepage' => trailingslashit(get_template_directory()) . 'demos/coffee/home.xml',
            'elementor_kit' => trailingslashit(get_template_directory()) . 'demos/coffee/elementor-kit.zip',
            'header' => trailingslashit(get_template_directory()) . 'demos/coffee/header.xml',
            'footer' => trailingslashit(get_template_directory()) . 'demos/coffee/footer.xml',
            'pages' => trailingslashit(get_template_directory()) . 'demos/coffee/pages.xml',
            'products' => trailingslashit(get_template_directory()) . 'demos/coffee/products.xml',
            'media' => trailingslashit(get_template_directory()) . 'demos/coffee/media.xml',
            'local_import_widget_file' => trailingslashit(get_template_directory()) . 'demos/coffee/widgets.wie',
            'local_import_customizer_file' => trailingslashit(get_template_directory()) . 'demos/coffee/theme-options.dat',
            'import_preview_image_url' => get_template_directory_uri() . '/demos/coffee/screen.png',
            'import_notice' => '',
            'preview_url' => 'https://demo.coderboy.ir/negarshop/coffee',
        ),
        array(
            'import_file_name' => 'سوپر مارکت',
            'homepage' => trailingslashit(get_template_directory()) . 'demos/supermarket/home.xml',
            'elementor_kit' => trailingslashit(get_template_directory()) . 'demos/supermarket/elementor-kit.zip',
            'header' => trailingslashit(get_template_directory()) . 'demos/supermarket/header.xml',
            'footer' => trailingslashit(get_template_directory()) . 'demos/supermarket/footer.xml',
            'pages' => trailingslashit(get_template_directory()) . 'demos/supermarket/pages.xml',
            'products' => trailingslashit(get_template_directory()) . 'demos/supermarket/products.xml',
            'media' => trailingslashit(get_template_directory()) . 'demos/supermarket/media.xml',
            'local_import_widget_file' => trailingslashit(get_template_directory()) . 'demos/supermarket/widgets.wie',
            'local_import_customizer_file' => trailingslashit(get_template_directory()) . 'demos/supermarket/theme-options.dat',
            'import_preview_image_url' => get_template_directory_uri() . '/demos/supermarket/screen.png',
            'import_notice' => '',
            'preview_url' => 'https://demo.coderboy.ir/negarshop/supermarket',
        ),
        array(
            'import_file_name' => 'تکنولوژی',
            'homepage' => trailingslashit(get_template_directory()) . 'demos/tech/home.xml',
            'elementor_kit' => trailingslashit(get_template_directory()) . 'demos/tech/elementor-kit.zip',
            'header' => trailingslashit(get_template_directory()) . 'demos/tech/header.xml',
            'footer' => trailingslashit(get_template_directory()) . 'demos/tech/footer.xml',
            'pages' => trailingslashit(get_template_directory()) . 'demos/tech/pages.xml',
            'products' => trailingslashit(get_template_directory()) . 'demos/tech/products.xml',
            'media' => trailingslashit(get_template_directory()) . 'demos/tech/media.xml',
            'local_import_widget_file' => trailingslashit(get_template_directory()) . 'demos/tech/widgets.wie',
            'local_import_customizer_file' => trailingslashit(get_template_directory()) . 'demos/tech/theme-options.dat',
            'import_preview_image_url' => get_template_directory_uri() . '/demos/tech/screen.png',
            'import_notice' => '',
            'preview_url' => 'https://demo.coderboy.ir/negarshop/tech',
        ),
    );
}

add_filter('merlin_generate_child_functions_php', 'negarshop_generate_child_functions_php', 11, 2);
add_filter('merlin_import_files', 'negarshop_merlin_import_files');
