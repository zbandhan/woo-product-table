<?php
 
if ( $product->get_type() == 'variable' ) {
    foreach ( $product->get_available_variations() as $key ) {
        $attr_strings = array();
        foreach ( $key['attributes'] as $attr_name => $attr_value ) {
            $attr_strings[] = $attr_value;
        }
        //echo '<br/>' . implode( ', ', $attr_string );
        $attr_string = implode( ', ', $attr_strings );
        echo '<br/>' . ucfirst ($attr_string );
    }
}