<?php

namespace NegarshopElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Elementor_Live_Price_Widget extends Widget_Base
{

    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);

        wp_register_script('negarshop-live-price-widget', get_theme_file_uri('/includes/elementor/element-live-price.js'), ['elementor-frontend'], '1.0.0', true);
    }

    public function get_script_depends()
    {
        return ['negarshop-live-price-widget'];
    }

    public function get_name()
    {
        return 'negarshop_live_price';
    }

    public function get_title()
    {
        return 'قیمت زنده';
    }

    public function get_icon()
    {
        return 'eicon-price-list';
    }

    public function get_categories()
    {
        return ['Negarshop_main'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => 'محتوا',
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control('target_data', [
            'label' => 'اطلاعات جهت نمایش',
            'type' => Controls_Manager::SELECT,
            'default' => '',
            'options' => [
                '' => 'انتخاب کنید',
                "ons" => "انس طلا",
                "silver" => "انس نقره",
                "platinum" => "انس پلاتین",
                "palladium" => "انس پالادیوم",
                "geram18" => "طلای 18 عیار",
                "geram24" => "طلای 24 عیار",
                "gold_mini_size" => "طلای دست دوم",
                "silver_999" => "گرم نقره ۹۹۹",
                "mesghal" => "مثقال طلا",
                "gold_futures" => "آبشده نقدی",
                "gold_17_transfer" => "حباب آبشده",
                "gold_17" => "مثقال / بدون حباب",
                "gc3" => "صندوق طلای مفید",
                "gc1" => "صندوق طلای لوتوس",
                "gc11" => "صندوق طلای زر",
                "gc10" => "صندوق طلای گوهر",
                "sekee" => "سکه امامی",
                "sekeb" => "سکه بهار آزادی",
                "nim" => "نیم سکه",
                "rob" => "ربع سکه",
                "gerami" => "سکه گرمی",
                "coin_blubber" => "حباب سکه امامی",
                "sekeb_blubber" => "حباب سکه بهار آزادی",
                "nim_blubber" => "حباب نیم سکه",
                "rob_blubber" => "حباب ربع سکه",
                "gerami_blubber" => "حباب سکه گرمی",
                "retail_sekee" => "سکه امامی",
                "retail_sekeb" => "سکه بهار آزادی",
                "retail_nim" => "نیم سکه",
                "retail_rob" => "ربع سکه",
                "retail_gerami" => "سکه گرمی",
                "gc19" => "تمام سکه صادرات",
                "gc14" => "تمام سکه ملت",
                "gc15" => "تمام سکه رفاه",
                "gc18" => "تمام سکه آینده",
                "gc17" => "تمام سکه سامان",
                "price_dollar_rl" => "دلار",
                "price_eur" => "یورو",
                "price_aed" => "درهم امارات",
                "price_gbp" => "پوند انگلیس",
                "price_try" => "لیر ترکیه",
                "price_chf" => "فرانک سوئیس",
                "price_cny" => "یوان چین",
                "price_jpy" => "ین ژاپن",
                "price_krw" => "وون کره جنوبی",
                "price_cad" => "دلار کانادا",
                "price_aud" => "دلار استرالیا",
                "price_nzd" => "دلار نیوزیلند",
                "price_sgd" => "دلار سنگاپور",
                "price_inr" => "روپیه هند",
                "price_pkr" => "روپیه پاکستان",
                "price_iqd" => "دینار عراق",
                "price_syp" => "لیر سوریه",
                "price_afn" => "افغانی",
                "price_dkk" => "کرون دانمارک",
                "price_sek" => "کرون سوئد",
                "price_nok" => "کرون نروژ",
                "price_sar" => "ریال عربستان",
                "price_qar" => "ریال قطر",
                "price_omr" => "ریال عمان",
                "price_kwd" => "دینار کویت",
                "price_bhd" => "دینار بحرین",
                "price_myr" => "رینگیت مالزی",
                "price_thb" => "بات تایلند",
                "price_hkd" => "دلار هنگ کنگ",
                "price_rub" => "روبل روسیه",
                "price_azn" => "منات آذربایجان",
                "price_amd" => "درام ارمنستان",
                "price_gel" => "لاری گرجستان",
                "price_kgs" => "سوم قرقیزستان",
                "price_tjs" => "سامانی تاجیکستان",
                "price_tmt" => "منات ترکمنستان",
                "sana_sell_usd" => "دلار",
                "sana_sell_eur" => "یورو",
                "sana_sell_gbp" => "پوند انگلیس",
                "sana_sell_aed" => "درهم",
                "sana_sell_try" => "لیر ترکیه",
                "sana_sell_chf" => "فرانک سوئیس",
                "sana_sell_cny" => "یوان چین",
                "sana_sell_jpy" => "100 ین ژاپن",
                "sana_sell_krw" => "وون کره جنوبی",
                "sana_sell_cad" => "دلار کانادا",
                "sana_sell_aud" => "دلار استرالیا",
                "sana_sell_rub" => "روبل روسیه",
                "sana_sell_inr" => "روپیه هند",
                "sana_sell_iqd" => "دینار عراق",
                "sana_sell_sek" => "کرون سوئد",
                "sana_sell_nok" => "کرون نروژ",
                "crypto-bitcoin" => "بیت کوین",
                "crypto-ethereum" => "اتریوم",
                "crypto-litecoin" => "لایت کوین",
                "crypto-bitcoin-cash" => "بیت کوین کش",
                "crypto-tether" => "تتر",
                "crypto-tron" => "ترون",
                "crypto-binance-coin" => "بایننس کوین",
                "crypto-stellar" => "استلار",
                "crypto-ripple" => "ریپل",
                "crypto-dogecoin" => "دوج کوین",
                "crypto-dash" => "دش",
                "crypto-cardano" => "کاردانو",
                "crypto-polkadot" => "پولکادات",
                "crypto-solana" => "سولانا",
                "crypto-avalanche" => "آوالانچ",
                "diff_eur_usd" => " EUR/USD",
                "diff_gbp_usd" => " GBP/USD",
                "diff_usd_cad" => " USD/CAD",
                "diff_usd_jpy" => " USD/JPY",
                "diff_usd_chf" => " USD/CHF",
                "diff_aud_usd" => " AUD/USD",
                "diff_usd_try" => " USD/TRY",
                "diff_usd_aed" => " USD/AED",
                "diff_usd_nzd" => " USD/NZD",
                "diff_usd_krw" => " USD/KRW",
                "diff_usd_cny" => " USD/CNY",
                "diff_usd_azn" => " USD/AZN",
                "oil" => " نفت سبک",
                "oil_brent" => " نفت برنت",
                "oil_opec" => " نفت اپک",
                "general_9" => " بنزین (گالن)",
                "general_10" => " گاز طبیعی",
                "general_11" => " گازوئیل",
                "general_3" => "آلومینیوم",
                "general_4" => " نیکل (تن)",
                "general_5" => " سرب (تن)",
                "general_6" => " روی (تن)",
                "general_7" => " مس (تن)",
                "base_global_tin" => "قلع",
                "general_12" => " پنبه",
                "general_13" => " شکر",
                "general_14" => " سویا",
                "general_15" => " گندم",
                "general_16" => " ذرت",
                "commodity_rough_rice" => "برنج",
                "bourse_nasdaq" => "نزدک",
                "bourse_dow" => "داوجونز",
                "bourse_ftse-100" => "فتسی بریتانیا",
                "bourse_dax" => "دکس آلمان",
                "bourse_cac-40" => "کک فرانسه",
                "bourse_ibex-35" => "آیبکس اسپانیا",
                "bourse_sp-500" => "اس & پی 500",
                "bourse_euro-stoxx-50" => "استاکس اروپا",
                "bourse_nikkei-225" => "نیکی ژاپن",
                "bourse_hang-seng" => "هنگ سنگ",
                "bourse_shanghai" => "شانگهای چین",
                "bourse_singapore" => "سنگاپور",
            ],
        ]);
        $this->add_control('label', [
            'label' => 'عنوان',
            'type' => Controls_Manager::TEXT,
            'default' => '',
        ]);
        $this->add_control('symb', [
            'label' => 'واحد',
            'type' => Controls_Manager::TEXT,
            'default' => '',
        ]);
        $this->add_control(
            'reload',
            [
                'label' => 'بروزرسانی دستی',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => '',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'style_section',
            [
                'label' => 'طراحی',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .widget-negarshop-live-price',
            ]
        );
        $this->add_control(
            'text_color',
            [
                'label' => 'رنگ',
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .widget-negarshop-live-price' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $settings['id'] = $this->get_id();
        printf('<div class="widget-negarshop-live-price" id="ns-live-%s" data-target="%s" data-symb="%s">',
            esc_attr($settings['id']),
            esc_attr($settings['target_data']),
            esc_attr($settings['symb'])
        );
        echo $settings['label'];
        echo '<span></span>';
        if ($settings['reload'] === 'yes') {
            echo ' <i class="fas fa-rotate-right reload"></i>';
        }
        echo '</div>';
    }

}
