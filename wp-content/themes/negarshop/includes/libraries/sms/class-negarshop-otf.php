<?php

class Negarshop_Otf
{
    private static string $meta_key = 'negarshop_user_login';
    public static int $time = 120;

    public static function create_code(int $userID, string $target, string $mobile = '')
    {
        if (!self::can_create($userID)) {
            return false;
        }
        $code = rand(10000, 99999);
        if (empty($mobile)) {
            $mobile = Negarshop_Smart_Auth::get_user_mobile($userID);
        }

        if (!negarshop_is_mobile($mobile)) {
            return false;
        }

        $sender = new Negarshop_Sender();
        $sender->send([
            'message' => sprintf('کد ورود شما:%s', $code),
            'token' => $code,
            'mobile' => $mobile,
        ]);

        update_user_meta($userID, self::$meta_key, [
            'code' => md5($code),
            'target' => $target,
            'expire' => time() + self::$time
        ]);

        return true;
    }

    private static function can_create(int $userID)
    {
        $meta = get_user_meta($userID, self::$meta_key, true);

        return empty($meta['expire']) || time() > $meta['expire'];
    }

    public static function verify(int $userID, string $code, string $target)
    {
        if (negarshop_is_demo() && $code === '12345') {
            return true;
        }

        $code = str_replace(['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'], [0, 1, 2, 3, 4, 5, 6, 7, 8, 9], $code);
        $meta = get_user_meta($userID, self::$meta_key, true);
        if (!is_array($meta) || empty($meta)) {
            return false;
        }

        if (empty($meta['code']) || $meta['code'] !== md5($code)) {
            return 0;
        }

        if (empty($meta['target']) || $meta['target'] !== $target) {
            return -1;
        }

        if (empty($meta['expire']) || time() > $meta['expire']) {
            return -2;
        }

        update_user_meta($userID, self::$meta_key, [
            'code' => false,
            'target' => false,
            'expire' => 0
        ]);

        return true;
    }
}