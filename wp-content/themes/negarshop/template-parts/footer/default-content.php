<div class="container">
    <?php
    $logo = negarshop_option('footer-type-picker');
    negarshop_footer_about([
        'title'=> get_bloginfo('name'),
        'logo'=> $logo['def']['footer_logo']['url'],
        'desc'=>get_bloginfo('description'),
    ]); ?>
    <?php negarshop_footer_copyright(["text"=>__('تمامی محتوا اعم از مطالب، تصاویر و... متعلق به این سایت می باشد.','negarshop')]); ?>
</div>