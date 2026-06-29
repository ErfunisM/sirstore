<?php $unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="input-group">
        <input type="search" class="form-control" placeholder="<?php _e("جستجو در وبلاگ",'negarshop') ?>" id="<?php echo $unique_id; ?>" value="<?php echo get_search_query(); ?>" name="s" >
        <div class="input-group-append">
            <button class="btn" type="submit"><?php _e("جستجو",'negarshop') ?></button>
        </div>
    </div>
    <p class="mb-0 sub-text"><?php _e("جستجو در بین محتوای وبلاگ",'negarshop') ?></p>
</form>
