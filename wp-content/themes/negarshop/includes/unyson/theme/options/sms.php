<?php if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'sms_tab' => array(
        'title' => 'خدمات پیامکی',
        'type' => 'tab',
        'options' => array(
            'sms_gateway' => array(
                'title' => 'وب سرویس',
                'type' => 'tab',
                'options' => array(
                    'sms_gateway' => [
                        'type'    => 'select',
                        'label'   => 'پنل پیامکی',
                        'value'   => 'none',
                        'choices' => [
                            'none'  =>  'انتخاب کنید',
                            array( // optgroup
                                'attr'    => array('label' => 'پنل های پترنی'),
                                'choices' => Negarshop_SMS_Gateways::get_tested_sms_gateway(),
                            ),
                            array( // optgroup
                                'attr'    => array('label' => 'پنل های متنی'),
                                'choices' => Negarshop_SMS_Gateways::get_sms_gateway(),
                            ),
                        ]
                    ],
                    'sms_gateway_username' => [
                        'type'    => 'text',
                        'label'   => 'نام کاربری پنل پیامکی',
                        'desc'  =>  'در صورتی که کلید API دارید در این قسمت قرار دهید.',
                        'value'   => '',
                    ],
                    'sms_gateway_password' => [
                        'type'    => 'text',
                        'label'   => 'رمز عبور پنل پیامکی',
                        'desc'  =>  'اگر از کلید API استفاده می کنید نیازی به پر کردن این قسمت نیست.',
                        'value'   => '',
                    ],
                    'sms_gateway_sender' => [
                        'type'    => 'text',
                        'label'   => 'شماره ارسالی',
                        'value'   => '',
                    ],

                    'sms_gateways_multi' => array(
                        'type' => 'multi-picker',
                        'picker' => 'sms_gateway',
                        'choices' => array(
                            'kavenegar_lookUp' => array(
                                'ms' => array(
                                    'type'  => 'html',
                                    'label' =>  'راهنما',
                                    'html'  => '
                                    <div class="notice notice-warning">
                                        <p>برای استفاده از پنل پیامکی کاوه نگار به نکات زیر دقت نمایید:</p>
                                        <ol>
                                            <li>از متغیر %token در الگوی خود جهت نمایش کد تایید استفاده نمایید.</li>
                                            <li>کد API را از "حساب من" دریافت کرده و در این قسمت به جای نام کاربری پنل قرار دهید.</li>
                                            <li>نیازی به شماره ارسال در پنل پیامکی کاوه نگار نمی باشد.</li>
                                        </ol>
                                    </div>
                                    ',
                                ),
                                'pid' => array(
                                    'type' => 'text',
                                    'label' =>  'نام پترن',
                                    'desc'  =>  'متغیر اول به عنوان توکن استفاده خواهد شد.'
                                ),
                            ),
                            'ippanel' => array(
                                'ms' => array(
                                    'type'  => 'html',
                                    'label' =>  'راهنما',
                                    'html'  => '
                                    <div class="notice notice-warning">
                                        <p>برای استفاده از پنل پیامکی ippanel به نکات زیر دقت نمایید:</p>
                                        <ol>
                                            <li>از متغیر %token% در الگوی خود جهت نمایش کد تایید استفاده نمایید.</li>
                                            <li>شماره ارسالی در این پنل ضروری می باشد.</li>
                                            <li>از مسیر "خدمات وب سرویس » کلید های دسترسی" کلید API را ایجاد کنید و در این قسمت بجای نام کاربری پنل استفاده نمایید.</li>
                                        </ol>
                                    </div>
                                    ',
                                ),
                                'pid' => array(
                                    'type' => 'text',
                                    'label' =>  'نام پترن',
                                    'desc'  =>  'از کلید token برای جایگذاری رمز ارسالی در پترن خود استفاده کنید.'
                                ),
                            ),
                            'melipayamakpattern' => array(
                                'ms' => array(
                                    'type'  => 'html',
                                    'label' =>  'راهنما',
                                    'html'  => '
                                    <div class="notice notice-warning">
                                        <p>برای استفاده از پنل پیامکی ملی پیامک به نکات زیر دقت نمایید:</p>
                                        <ol>
                                            <li>کد تایید در متغیر {0} نمایش داده خواهد شد.</li>
                                            <li>از نام کاربری و رمز عبور پنل پیامکی خود استفاده نمایید.</li>
                                        </ol>
                                    </div>
                                    ',
                                ),
                                'pid' => array(
                                    'type' => 'text',
                                    'label' =>  'کد پترن',
                                    'desc'  =>  'متغیر اول به عنوان توکن استفاده خواهد شد.'
                                ),
                            ),
                        )
                    ),
                )
            ),
            'sms_login' => array(
                'title' => 'ورود با موبایل',
                'type' => 'tab',
                'options' => array(
                    'sms_smart_login'      => [
                        'type'    => 'select',
                        'label'   => 'ورود هوشمند با موبایل',
                        'value'   => 'false',
                        'choices' => [
                            'false'  => 'غیرفعال',
                            'true'  => 'فعال',
                        ],
                    ],
                )
            )
        )
    ),
);