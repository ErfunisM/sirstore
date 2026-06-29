<?php

class Negarshop_Sender
{

    public function EnglishNumberMobile($mobile)
    {
        if (is_array($mobile)) {
            return array_map([$this, __FUNCTION__], $mobile);
        } else {

            $mobile = sanitize_text_field($mobile);

            $mobile = str_ireplace(['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'],
                ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'], $mobile); //farsi
            $mobile = str_ireplace(['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'],
                ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'], $mobile); //arabi

            return $mobile;
        }
    }

    public function modifyMobile($mobile)
    {

        if (is_array($mobile)) {
            return array_map([$this, __FUNCTION__], $mobile);
        }

        $mobile = $this->EnglishNumberMobile($mobile);

        $modified = preg_replace('/\D/is', '', (string)$mobile);

        if (substr($mobile, 0, 1) == '+') {
            return '+' . $modified;
        } elseif (substr($modified, 0, 2) == '00') {
            return '+' . substr($modified, 2);
        } elseif (substr($modified, 0, 1) == '0') {
            return $modified;
        } elseif (!empty($modified)) {
            $modified = '0' . $modified;
        }

        return str_replace('+980', '0', $modified);
    }

    public function send($data)
    {
        $message = !empty($data['message']) ? esc_textarea($data['message']) : '';

        $mobile = !empty($data['mobile']) ? $data['mobile'] : '';
        $token = !empty($data['token']) ? $data['token'] : '';
        if (!is_array($mobile)) {
            $mobile = explode(',', $mobile);
        }

        $mobile = $this->modifyMobile($mobile);

        $mobile = explode(',', implode(',', (array)$mobile));
        $mobile = array_map('trim', $mobile);
        $mobile = array_unique(array_filter($mobile));

        $gateway_method = negarshop_option('sms_gateway');
        if (empty($gateway_method)) {
            return "وب سرویس تنظیم نشده است!";
        }
        $gateway_method = $gateway_method == 'none' ? '' : $gateway_method;

        $gateway_object = Negarshop_SMS_Gateways::init();

        if (empty($mobile)) {
            $result = 'شماره موبایل خالی است.';
        } elseif (empty($message) && empty($token)) {
            $result = 'متن پیامک خالی است.';
        } elseif (empty($gateway_method)) {
            $result = 'تنظیمات درگاه پیامک انجام نشده است.';
        } elseif (!method_exists($gateway_object, $gateway_method)) {
            $result = 'تابع درگاه پیامکی شما داخل کلاس درگاه های پیامکی وجود ندارد.';
        } else {

            try {

                $gateway_object->mobile = $mobile;
                $gateway_object->message = $message;
                $gateway_object->token = $token;

                $result = $gateway_object->$gateway_method($data);
            } catch (Exception $e) {
                $result = $e->getMessage();
            }
        }


        if ($result !== true && !is_string($result)) {
            ob_start();
            var_dump($result);
            $result = ob_get_clean();
            error_log($result);
        }

        return $result;
    }

}