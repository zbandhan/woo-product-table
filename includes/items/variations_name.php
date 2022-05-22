<?php
 
// if ( $product->get_type() == 'variable' ) {
    // var_dump($id);
    // $variation = wc_get_product( $id );
    // echo $variation->get_attribute_summary();
    //         $stock = $variation->get_availability();
    // var_dump($stock);
    // var_dump($variation->get_title());
    // var_dump($variation->get_attribute_summary());
    // var_dump($variation);

    // foreach ( $product->get_available_variations() as $key ) {
    //     $attr_strings = array();
    //     foreach ( $key['attributes'] as $attr_name => $attr_value ) {
    //         $attr_strings[] = $attr_value;
    //     }
    //     //echo '<br/>' . implode( ', ', $attr_string );
    //     $attr_string = implode( ', ', $attr_strings );
    //     echo '<br/>' . ucfirst ($attr_string );
    // }
// }

/**
 * 
 * 
global $product;
    if ( $product->get_type() == 'variable' ) {
        foreach ( $product->get_available_variations() as $key ) {
            $variation = wc_get_product( $key['variation_id'] );
            $stock = $variation->get_availability();
            $stock_string = $stock['availability'] ? $stock['availability'] : __( 'In stock', 'woocommerce' );
            $attr_string = array();
            foreach ( $key['attributes'] as $attr_name => $attr_value ) {
                $attr_string[] = $attr_value;
            }
            echo '<br/>' . implode( ', ', $attr_string ) . ': ' . $stock_string;
        }
    }
 * 
 * 
 */