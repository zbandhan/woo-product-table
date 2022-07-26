<div id="wpt_configuration_form" class="wpt_shortcode_gen_panel ultraaddons ultraaddons-wrapper">
    
    <?php 
    $max_input_vars = ini_get('max_input_vars');
    var_dump($max_input_vars);
    do_action( 'wpto_form_top', $post ); ?>
    <!-- New Version's Warning. We will remove it from 5.00 | End -->
    <?php
    /**
     * Tab Maintenance. Table will be come from [tabs] folder based on $tab_array
     * this $tab_arry will define, how much tab and tab content
     */
    $tab_array = array(
        'column_settings'   => __( 'Column', 'wpt_pro' ),
        'query'            => __( 'Query', 'wpt_pro' ),
        // 'basics'            => __( 'Basics', 'wpt_pro' ), //Has removed @version 3.1.9.5
        'table_style'       => sprintf(__( 'Design %sLimited%s', 'wpt_pro' ), '<i class="wpt_limited_badge">', '</i>' ),
        'options'            => __( 'Options/Basics/Conditions', 'wpt_pro' ),
        // 'conditions'        => __( 'Extra Options', 'wpt_pro' ), //Has removed @version 3.1.9.5
        'search_n_filter'   => __( 'Search & Filter','wpt_pro' ),
        'config'            => sprintf(__( 'Configuration %sPro%s', 'wpt_pro' ), '<i class="wpt_pro_badge">', '</i>' ),
    );
    $tab_array = apply_filters( 'wpto_admin_tab_array', $tab_array, $post );
    
    $supported_css_property = array(
        'color'        =>  __( 'Text Color', 'wpt_pro' ),
        'background-color'=>__('Background Color' , 'wpt_pro' ),
        'border'=>__('Border' , 'wpt_pro' ),
        'text-align'=>__('Text Align' , 'wpt_pro' ),
        'vertical-align'=>__('Vertical Align' , 'wpt_pro' ),
    );
    $supported_css_property = apply_filters( 'wpto_supported_css_property', $supported_css_property, $tab_array, $post );

    $supported_terms    = array(
        'product_cat'       =>  __( 'Product Categories', 'wpt' ),
        'product_tag'       =>  __( 'Product Tags', 'wpt' ),
    );
    $supported_terms    = apply_filters( 'wpt_supported_terms', $supported_terms, $tab_array, $post  );

    $additional_variable = array(
        'tab_array' => $tab_array,
        'css_property' => $supported_css_property,
    );
    $additional_data = apply_filters( 'wpto_additional_variable', $additional_variable, $post );
    
    echo '<nav class="nav-tab-wrapper">';
    $active_nav = 'nav-tab-active';
    foreach ($tab_array as $nav => $title) {
        echo "<a href='#{$nav}' data-tab='{$nav}' class='wpt_nav_for_{$nav} wpt_nav_tab nav-tab " . esc_attr( $active_nav ) . "'>" . wp_kses_post( $title ). "</a>";
        $active_nav = false;
    }
    echo '</nav>';

    //Now start for Tab Content
    $active_tab_content = 'tab-content-active';
    foreach ($tab_array as $tab => $title) {
        echo '<div class="wpt_tab_content tab-content ' . esc_attr( $active_tab_content ) . '" id="' . esc_attr( $tab ) . '">';
        echo '<div class="fieldwrap">';
        
        /**
         * @Hook Action: wpto_form_tab_top_{$tab}
         * 
         * To add content at the top of Specific TAB for any field to the specific Tab.
         * such TAB: Column, Basic, Configuration ETC
         * @since 6.1.0.5
         * @date 8 July, 2020
         */
        do_action( 'wpto_form_tab_top_' . $tab, $post );
        
        $tab_validation = apply_filters( 'wpto_form_tab_validation_' . $tab, true, $post, $tab_array  );
        
        $tab_dir_loc = WPT_BASE_DIR . 'admin/tabs/';
        $tab_dir_loc = apply_filters( 'wpto_admin_tab_folder_dir', $tab_dir_loc, $tab, $post, $tab_array );
        
        $tab_file = $tab_dir_loc . $tab . '.php';
        $tab_file_admin = apply_filters( 'wpto_admin_tab_file_loc', $tab_file, $tab, $post, $tab_array );
        $tab_file_of_admin = apply_filters( 'wpto_admin_tab_file_loc_' . $tab, $tab_file_admin, $post, $tab_array );
        if ( $tab_validation && is_file( $tab_file_of_admin ) ) {
            
            /**
             * Adding content to Any admin Tab of Form
             */
            do_action( 'wpto_admin_tab_' . $tab, $post, $tab_array );
            include $tab_file_of_admin; 
            do_action( 'wpto_admin_tab_bottom_' . $tab, $post, $tab_array );
        }elseif( $tab_validation ){
            echo '<h2>' . $tab . '.php ' . esc_html__( 'file is not found in tabs folder','wpt_pro' ) . '</h2>';
        }
        
        /**
         * @Hook Action: wpto_form_tab_bottom_{$tab}
         * 
         * To add content at the Bottom of Specific TAB for any field to the specific Tab.
         * such TAB: Column, Basic, Configuration ETC
         * @since 6.1.0.5
         * @date 8 July, 2020
         */
        do_action( 'wpto_form_tab_bottom_' . $tab, $post );
        
        echo '</div>'; //End of .fieldwrap
        echo '</div>'; //End of Tab content div
        $active_tab_content = false; //Active tab content only for First
    }
    ?>

    <?php 
    /**
     * @Hook Action: wpto_form_bottom
     * Add Element/Content to All Form Bottom
     * 
     * @since 6.1.0.5
     * @date 7.7.2020
     */
    do_action( 'wpto_form_bottom', $post ); 
    
    ?>

    <?php
    
    $ajax_submit_btn = isset( $post->post_status ) && $post->post_status == 'publish' ? 'wpt_ajax_update' : false;
    
    /**
     * @Hook Filter: wpto_ajax_form_submit
     * To Disable ajax Save Option, Just need return false.
     * if any one want to add new event, Do return a string, which will go the save button and 
     * user able to set javascript event/ jquery event by that class
     * 
     * @return String|Bool To off Ajax Form Save of Woo Product Table, need false return, Otherwise, our predefine class name: wpt_ajax_update
     * Or user can use own class name and will control by his own javascript
     */
    $ajax_submit_btn = apply_filters( 'wpto_ajax_form_submit', $ajax_submit_btn, $post);
    
    $post_title = isset( $post->post_title ) ? $post->post_title : '';
    ?>
    
    <div class="form_bottom form_bottom_submit_button wrapper_<?php echo esc_attr( $ajax_submit_btn ); ?> ultraaddons-button-wrapper ultraaddons-panel no-background">
        <button type="submit" 
                name="wpt_post_submit" 
                data-title="<?php echo esc_attr( $post_title ); ?>" 
                class="button-primary button-primary primary button <?php echo esc_attr( $ajax_submit_btn ); ?>"
                ><?php esc_html_e( 'Save Change', 'wpt_pro' );?></button>
    </div>

    <?php do_action( 'wpt_offer_here' ); ?>
</div>

<style>
/*****For Column Moveable Item*******/
ul#wpt_column_sortable li>span.handle{
    background-image: url('<?php echo WPT_BASE_URL . 'assets/images/move_color_3.png'; ?>');
}
ul#wpt_column_sortable li.wpt_sortable_peritem.enabled>span.handle{
    background-image: url('<?php echo WPT_BASE_URL . 'assets/images/move_color_3.png'; ?>');
}
</style>
