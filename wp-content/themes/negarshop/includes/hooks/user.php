<?php
/**
 * User hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_ajax_login() {
    header("Content-type:application/json");

    $json_array = [
        'status' => false,
        'data' => ''
    ];

    $_POST['login'] = true;

    try {
        \WC_Form_Handler::process_login();
    } catch (Exception $exception) {
        $json_array['data'] = $exception->getMessage();
        $json_array['type'] = 'error';
        echo json_encode($json_array);
        wp_die();
    }
    $notices = wc_get_notices();

    if (!empty($notices['error'])) {
        $errors_list = array();
        foreach ($notices['error'] as $notice) {
            $errors_list[] = $notice['notice'];
        }

        $json_array['data'] = implode(PHP_EOL, $errors_list);
        $json_array['type'] = 'error';
        echo json_encode($json_array);
        wp_die();
    }

    $json_array['status'] = true;
    $json_array['data'] = __('وارد شدید! درحال انتقال...', 'negarshop');
    $json_array['type'] = 'success';

    echo json_encode($json_array);
    wp_die();
}

function negarshop_login_user($user_name_email, $user_pass, $remember, $other) {

    if (is_email($user_name_email) !== false) {

        if (!negarshop_user_exist_email($user_name_email)) {
            return __("ایمیل وارد شده اشتباه است!", 'negarshop');
        } else {
            if ($remember == '1') {
                $remb = true;
            } else {
                $remb = false;
            }

            $userobj = get_user_by('email', $user_name_email);
            $other_output = [];
            $login_res = false;
            parse_str($other, $other_output);
            $login_res = wp_authenticate($userobj->user_login, $user_pass);

            if (get_class($login_res) == "WP_Error") {

                $le = negarshop_login_err_dec(key($login_res->errors));

                return $le;

            } elseif (get_class($login_res) == "WP_User") {

                wp_set_auth_cookie($login_res->ID, $remb);

                return true;

            } else {
                echo __('خطا هنگام ورود، مجددا تلاش کنید!', 'negarshop');
            }
        }

    } else {

        if (!negarshop_user_exist_name($user_name_email)) {
            return __('نام کاربری وارد شده اشتباه است.', 'negarshop');
        } else {
            if ($remember == '1') {
                $remb = true;
            } else {
                $remb = false;
            }

            $login_res = wp_authenticate($user_name_email, $user_pass);

            if (get_class($login_res) == "WP_Error") {

                $le = negarshop_login_err_dec(key($login_res->errors));

                return $le;

            } elseif (get_class($login_res) == "WP_User") {

                wp_set_auth_cookie($login_res->ID, $remb);

                return true;

            } else {
                echo __('مشکلی هنگام ورود به وجود آمده است، لطفا مجددا سعی نمایید.', 'negarshop');
            }
        }

    }
}

function negarshop_login_err_dec($err_name): ?string {
    $err_dec = $err_name;
    if ($err_dec === 'incorrect_password') {
        $err_dec = __('رمز عبور وارد شده صحیح نمی باشد!', 'negarshop');
    } elseif ($err_dec === 'invalid_username') {
        $err_dec = __('کاربری با مشخصات وارد شده یافت نشد!', 'negarshop');
    } else {
        $err_dec = __('مشکلی هنگام ورود به وجود آمده است!', 'negarshop') . ' ' . $err_name;
    }

    return $err_dec;
}

function negarshop_user_exist_email($user_mail): bool {
    return email_exists($user_mail);
}

function negarshop_user_exist_name($user_name): bool {
    return username_exists($user_name);
}

add_action('wp_ajax_negarshop_ajax_login', 'negarshop_ajax_login');
add_action('wp_ajax_nopriv_negarshop_ajax_login', 'negarshop_ajax_login');