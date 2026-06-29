<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-attributes.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! $product_attributes ) {
    return;
}
$attrs_TMP = [];
foreach ( $product_attributes as $product_attribute_key => $product_attribute ){
    $parent = get_post_meta( $product->get_id(), $product_attribute_key."_parent", true);
    if(!empty($parent)){
        $attrs_TMP[$parent][$product_attribute_key] = $product_attribute;
    }else{
        $attrs_TMP["cb_no_parent"][$product_attribute_key] = $product_attribute;
    }
}


?>
<table class="shop_attributes table table-borderless">
    <?php foreach ( $attrs_TMP as $key => $prd_atts ) : ?>
        <tr class="woocommerce-product-attributes-item woocommerce-product-attributes-parent">
            <th class="woocommerce-product-attributes-item__label table-title"><?php if($key !== "cb_no_parent"){echo $key;} ?></th>
        </tr>
        <?php foreach ( $prd_atts as $product_attribute_key => $product_attribute ) :

		    $product_attribute['value'] = str_replace(',','<span class="dem">,</span>'.PHP_EOL,$product_attribute['value']);
            ?>
            <tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--<?php echo esc_attr( $product_attribute_key ); ?>">
                <th class="woocommerce-product-attributes-item__label table-title"><?php echo wp_kses_post( $product_attribute['label'] ); ?></th>
                <td class="woocommerce-product-attributes-item__value table-gray"><?php echo wp_kses_post( $product_attribute['value'] ); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
</table>