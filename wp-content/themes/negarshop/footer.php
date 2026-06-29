<?php if ( negarshop_option('to_top') === 'true' ):
	$picker = negarshop_option('to_top_picker');
	$picker = $picker['true'];
	?>
    <div class="container">
        <ul class="fixed-bottom-bar <?php echo $picker['style']; ?>">
			<?php if ( $picker['compare'] && !defined('YITH_WOOCOMPARE') ):
				?>
                <li>
                    <button class="btn negarshop-show-compare-table" type="button" aria-label="<?php _e("مقایسه", 'negarshop') ?>"
                            data-toggle="tooltip" data-placement="top"
                            title="<?php _e("مقایسه", 'negarshop') ?>"><i class="fal fa-random"></i></button>
                </li>
			<?php endif; ?>
			<?php
			if ( $picker['favs'] && function_exists('wc_get_account_endpoint_url') ): ?>
                <li><a class="btn" href="<?php echo wc_get_account_endpoint_url('favorites'); ?>" data-toggle="tooltip"
                       data-placement="top" title="<?php _e("علاقه مندی ها", 'negarshop') ?>"><i
                                class="far fa-heart"></i></a></li>
			<?php endif; ?>
			<?php
			if ( isset($picker['cart']) && $picker['cart'] && function_exists('wc_get_cart_url') ): ?>
                <li><a class="btn" href="<?php echo wc_get_cart_url(); ?>" data-toggle="tooltip" data-placement="top"
                       title="<?php _e("سبد خرید", 'negarshop') ?>"><i class="far fa-shopping-cart"></i></a></li>
			<?php endif; ?>
            <li>
                <button class="btn" type="button" aria-label="<?= __('برو بالا', 'negarshop') ?>" id="negarshop-to-top"><span><i
                                class="far fa-angle-up"></i></span></button>
            </li>
        </ul>
    </div>
<?php endif; ?>

<footer class="site-footer">
	<?php
	$footer_type_opts = negarshop_option('footer-type');
	$footer_type      = negarshop_option('footer-type-picker');

	if ( $footer_type_opts === "def" ) {
		negarshop_get_part('footer/default-content');
	} else {
		if ( !function_exists('elementor_theme_do_location') || !elementor_theme_do_location('footer') ) {
			echo '<div class="elementor-need">لطفا پابرگ خود را از طریق المنتور ایجاد نمایید!</div>';
		}
	}
	?>
</footer>
<?php negarshop_get_part('footer/responsive-bar'); ?>
</div>
<?php wp_footer(); ?>
</body>
</html>
