<?php
/**
 * WordPress general hooks and functions.
 *
 * @package negarshop
 */

function negarshop_remove_array_element(&$array, $a, $b)
{
    $out = array_splice($array, $a, 1);
    array_splice($array, $b, 0, $out);
}

function negarshop_load_tr_mofile($mofile, $domain)
{
    if ('dokan-lite' === $domain) {
        return get_template_directory() . '/includes/languages/dokan-lite-fa_IR.mo';
    }
    if ('premmerce-brands' === $domain) {
        return get_template_directory() . '/includes/languages/premmerce-brands-fa_IR.mo';
    }

    return $mofile;
}

function negarshop_excerpt_crop($text, $char)
{
    if (mb_strlen($text) > $char) {
        $exctext = mb_substr($text, 0, $char);
        $exctext = explode(' ', $exctext);
        unset($exctext[count($exctext) - 1]);

        return implode(' ', $exctext) . ' ...';
    } else {
        return $text;
    }
}

function negarshop_get_nav_menus_array(): array
{
    $menus = wp_get_nav_menus();
    $tmp_arr = [];

    foreach ($menus as $menu) {
        $tmp_arr[$menu->term_id] = $menu->name;
    }

    return $tmp_arr;
}

function negarshop_get_part($slug = null, $slug2 = null)
{
    if ($slug !== null) {
        if ($slug2 !== null) {
            get_template_part('/template-parts/' . $slug, $slug2);
        } else {
            get_template_part('/template-parts/' . $slug);
        }
    }
}

function negarshop_enable_extended_upload($mime_types = [])
{
    $mime_types['obj'] = 'text/plain';
    $mime_types['mtl'] = 'text/plain';

    $mime_types['woff'] = 'font/woff|application/font-woff|application/x-font-woff|application/octet-stream';
    $mime_types['woff2'] = 'font/woff2|application/octet-stream|font/x-woff2';
    $mime_types['ttf'] = 'application/x-font-ttf|application/octet-stream|font/ttf';
    $mime_types['svg'] = 'image/svg+xml|application/octet-stream|image/x-svg+xml';
    $mime_types['eot'] = 'application/vnd.ms-fontobject|application/octet-stream|application/x-vnd.ms-fontobject';

    return $mime_types;

}

function negarshop_filter_fix_wp_check_filetype_and_ext($data, $file, $filename, $mimes)
{
    if (!empty($data['ext']) && !empty($data['type'])) {
        return $data;
    }

    $registered_file_types = negarshop_enable_extended_upload();
    $filetype = wp_check_filetype($filename, $mimes);

    if (!isset($registered_file_types[$filetype['ext']])) {
        return $data;
    }
    // Fix incorrect file mime type
    $filetype['type'] = explode('|', $filetype['type'])[0];

    return [
        'ext' => $filetype['ext'],
        'type' => $filetype['type'],
        'proper_filename' => $data['proper_filename'],
    ];
}

function negarshop_get_font_face_from_data($font_family, $data)
{
    $src = [];
    foreach (['eot', 'woff2', 'woff', 'ttf', 'svg'] as $type) {
        if (!isset($data[$type]) || !isset($data[$type]['url']) || empty($data[$type]['url'])) {
            continue;
        }

        if ('svg' === $type) {
            $data[$type]['url'] .= '#' . str_replace(' ', '', $font_family);
        }

        $src[] = negarshop_get_font_src_per_type($type, $data[$type]['url']);
    }

    $font_face = '@font-face {' . PHP_EOL;
    $font_face .= "\tfont-family: '" . $font_family . "';" . PHP_EOL;

    if (isset($data['eot']) && isset($data['eot']['url']) && !empty($data['eot']['url'])) {
        $font_face .= "\tsrc: url('" . esc_attr($data['eot']['url']) . "');" . PHP_EOL;
    }

    $font_face .= "\tsrc: " . implode(',' . PHP_EOL . "\t\t", $src) . ';' . PHP_EOL . '}';

    return $font_face;
}

function negarshop_get_font_src_per_type($type, $url)
{
    $src = 'url(\'' . esc_attr($url) . '\') ';
    switch ($type) {
        case 'woff':
        case 'woff2':
        case 'svg':
            $src .= 'format(\'' . $type . '\')';
            break;

        case 'ttf':
            $src .= 'format(\'truetype\')';
            break;

        case 'eot':
            $src = 'url(\'' . esc_attr($url) . '?#iefix\') format(\'embedded-opentype\')';
            break;
    }

    return $src;
}

function negarshop_no_gravatars($avatar)
{
    return preg_replace("/http.*?gravatar\.com[^\']*/", get_template_directory_uri() . '/statics/images/default-profile.png', $avatar);
}

function negarshop_remove_wp_adminbaritems($wp_admin_bar)
{
    if (get_post_meta(get_the_id(), 'fw:opt:ext:pb:page-builder:json', true) !== '[]') {
        $wp_admin_bar->remove_node('elementor_edit_page');
    }
}

function negarshop_disable_safari_check()
{
    global $is_safari;
    $is_safari = false;
}

function negarshop_print_terms($terms, $args = [], $parent = [])
{
    if (empty($terms)) {
        return;
    }

    $defaultArgs = [
        'class' => 'terms-list'
    ];

    $args = array_merge($defaultArgs, $args);

    $childrenObj = [];

    echo '<ul class="' . $args['class'] . '">';


    if (!empty($parent)) {
        echo '<li class="item-parent" data-parent="' . $parent->term_id . '"><span class="arrow"><i class="fas fa-angle-right"></i></span> ' . $parent->name . '</li>';
    }


    /**
     * @var $term \WP_Term
     */
    foreach ($terms as $term) {
        if (is_wp_error($term) || is_wp_error(get_term_link($term))) {
            continue;
        }
        echo '<li class="term-item-' . $term->term_id . '">';
        echo '<a href="' . get_term_link($term) . '">';
        $thumbnailId = get_term_meta($term->term_id, 'thumbnail_id', true);
        if (!empty($thumbnailId)) {
            echo '<img class="cat-image" src="' . wp_get_attachment_url($thumbnailId) . '">';
        }

        echo '<span class="cat-name">' . $term->name . '</span>';

        $children = get_terms($term->taxonomy, [
            'parent' => $term->term_id
        ]);
        if (!empty($children)) {
            echo '<span class="arrow" data-target="' . $term->term_id . '"><i class="fas fa-angle-left"></i></span>';
            $childrenObj[$term->term_id] = [
                'parent' => $term,
                'children' => $children
            ];
        }

        echo '</a>';
        echo '</li>';
    }
    echo '</ul>';

    if (!empty($childrenObj)) {
        foreach ($childrenObj as $key => $children) {
            negarshop_print_terms($children['children'], ['class' => 'terms-list child-term child-term-' . $key], $children['parent']);
        }
    }

}

/**
 * Validates the input data as a JSON string and returns a boolean indicating the validation result.
 *
 * @param mixed $data The input data to be validated as a JSON string
 * @return bool
 */
function negarshop_json_validator($data): bool
{
    if (!empty($data)) {
        return is_string($data) &&
            is_array(json_decode($data, true));
    }
    return false;
}

/**
 * Function to disable lazy loading.
 *
 * @param array $attr The array of attributes.
 * @return array The modified array of attributes.
 */
function negarshop_disable_lazy_loading($attr)
{
    $attr['loading'] = 'eager';
    return $attr;
}

function negarshop_is_checked($mixed): bool
{
    return in_array($mixed, ['true', '1', 'on', 'yes', 'ok', 'show', 'active', 1, true]);
}

add_filter('upload_mimes', 'negarshop_enable_extended_upload');
add_filter('wp_check_filetype_and_ext', 'negarshop_filter_fix_wp_check_filetype_and_ext', 10, 4);
add_action('init', 'negarshop_disable_safari_check');
add_action('admin_bar_menu', 'negarshop_remove_wp_adminbaritems', 999);
add_filter('fw_use_sessions', '__return_false');
add_filter('get_avatar', 'negarshop_no_gravatars');
add_filter('load_textdomain_mofile', 'negarshop_load_tr_mofile', 10, 2);
add_filter('wp_lazy_loading_enabled', '__return_false');
add_filter('wp_get_attachment_image_attributes', 'negarshop_disable_lazy_loading', 99, 1);
