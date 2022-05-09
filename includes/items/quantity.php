<?php
/**
 * Checking if is_sold_individually
 * then wc will not show qty box
 * that's why, I return default template
 * 
 * rest will handle from WooCommerce
 * 
 * @since 1.0.8
 */

$ID = $table_ID;
$conditions = get_post_meta( $ID, 'conditions', true );
$default_qty = $conditions['default_qty'];

if( $product->is_sold_individually() ) return false;


woocommerce_quantity_input( array( 
    'input_value'   => apply_filters( 'woocommerce_quantity_input_min', $default_qty, $product ),
    'max_value'   => apply_filters( 'woocommerce_quantity_input_max', -1, $product ),
    'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 0, $product ),
    'step'        => apply_filters( 'woocommerce_quantity_input_step', 1, $product ),
) , $product, true );