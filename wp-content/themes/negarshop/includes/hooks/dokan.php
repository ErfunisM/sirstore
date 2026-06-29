<?php
/**
 * Dokan hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_fix_dokan_edit_product_atts ($attribute_taxonomy, $i) {
    if ( 'colorpicker' == $attribute_taxonomy->attribute_type ) :
        ?>
        <select multiple="multiple" style="width:100%" data-placeholder="<?php esc_attr_e('Select terms', 'dokan'); ?>"
                class="dokan_attribute_values dokan-select2" name="attribute_values[<?php echo $i; ?>][]">
            <?php
            $args      = [
                'orderby'    => 'name',
                'hide_empty' => 0
            ];
            $all_terms = get_terms(
                'pa_' . $attribute_taxonomy->attribute_name, apply_filters('dokan_product_attribute_terms', $args)
            );
            if ( $all_terms ) {
                foreach ( $all_terms as $term ) {
                    echo '<option value="' . esc_attr($term->slug) . '" ' . selected(
                            has_term(
                                absint($term->term_id), 'pa_' . $attribute_taxonomy->attribute_name, get_the_ID()
                            ), true, false
                        ) . '>' . esc_attr(
                            apply_filters(
                                'woocommerce_product_attribute_term_name', $term->name, $term
                            )
                        ) . '</option>';
                }
            }
            ?>
        </select>
        <div class="dokan-pre-defined-attribute-btn-group">
            <button class="dokan-btn dokan-btn-default plus dokan-select-all-attributes"><?php _e(
                    'Select all', 'dokan'
                ); ?></button>
            <button class="dokan-btn dokan-btn-default minus dokan-select-no-attributes"><?php _e(
                    'Select none', 'dokan'
                ); ?></button>
            <!-- <button class="dokan-btn dokan-btn-default fr plus dokan-add-new-attribute"><?php _e(
                'Add new', 'dokan'
            ); ?></button> -->
        </div>
    <?php endif;
}

function negarshop_dokan_remove_hooks()
{
    if (class_exists('Dokan_WC_Booking')) {
        remove_action('admin_notices', [Dokan_WC_Booking::init(), 'dependency_notice']);
    }
    if (class_exists('Dokan_Auction')) {
        remove_action('admin_notices', [Dokan_Auction::init(), 'dependency_notice']);
    }
}


add_action('dokan_product_option_terms', 'negarshop_fix_dokan_edit_product_atts', 20, 2);
add_action('admin_head', 'negarshop_dokan_remove_hooks');