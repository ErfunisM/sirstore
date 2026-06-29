<div class="container">
    <div class="row align-items-center my-3">
        <div class="col mb-2">
            <?php negarshop_header_bar_menu(); ?>
        </div>
        <div class="w-100"></div>
        <div class="col-lg-auto">
            <?php
            $logo = negarshop_option('header-type-picker');

            negarshop_header_logo([
                'url' => site_url(),
                'image' => empty($logo) ? '' : $logo['def']['header_logo']['url'],
                'title' => get_bloginfo('name')
            ]); ?>
        </div>
        <div class="col-lg">
            <?php negarshop_header_search(); ?>
        </div>
        <div class="col-lg-auto ">
            <?php negarshop_header_account([
                'show_account_avatar' => 'yes',
                'show_account_title' => 'yes',
                'show_account_sub_title' => 'yes',
                'show_account_icon' => 'yes',
            ]); ?>
        </div>
        <div class="w-100 py-2"></div>
        <div class="col-lg">
            <?php negarshop_header_menu(['menu' => ['mini_menu' => true, 'mm_title' => 'دسـته بـندی محـصولات']]); ?>
        </div>
        <div class="col-lg-auto">
            <?php negarshop_header_basket(); ?>
        </div>
    </div>
</div>