<?php if(negarshop_option('popup_ac') == 'true'){ ?>
    <div class="modal fade negarshop-popup-box" tabindex="-1" role="dialog" id="negarshop-popup" data-time="<?php echo negarshop_option('popup_time'); ?>">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn close-modal cb-custom-close" data-dismiss="modal">
                    <i class="far fa-times"></i>
                </button>
                <?php if(negarshop_option('popup_type') == 'pic'):
                    $photo_url = negarshop_option('popup_type_picker');
                $photo_url = $photo_url['pic']; $photo_url = $photo_url['popup_image']; ?>

                    <?php $opt_footer_pl = negarshop_option('popup_link'); if(!empty($opt_footer_pl)){ ?><a href="<?php echo negarshop_option('popup_link'); ?>"><?php } ?>
                    <img class="lazy" data-src="<?php echo (isset($photo_url['url']))?$photo_url['url']:''; ?>" alt="<?php echo negarshop_option('popup_title'); ?>"/>
                    <?php $opt_footer_pl = negarshop_option('popup_link'); if(!empty($opt_footer_pl)){ ?></a><?php } ?>
                <?php else:
                    $pop_shortcode = negarshop_option('popup_type_picker');
                    $pop_shortcode = $pop_shortcode['shortcode'];
                    $pop_shortcode = $pop_shortcode['shorcode_code'];
                    echo '<div class="popup-shortcode-content">';
                    echo do_shortcode($pop_shortcode);
                    echo '</div>';
                endif; ?>
            </div>
        </div>
    </div>
<?php }
do_action('negarshop_modals');
if (is_singular('product')){

	$features = negarshop_option('product_features');
	if(!empty($features)) {
	    $ipf = 1;
		foreach ($features as $feature) {
		    if(isset($feature['content']) and !empty($feature['content'])){
?>
<div class="modal fade product-features-modal" id="product-modal-<?php echo $ipf; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $feature['title'] . ' ' . $feature['desc']; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
	            <?php echo $feature['content']; ?>
            </div>
        </div>
    </div>
</div>
<?php }$ipf++;
        }
    }
}