<?php
if( !function_exists( 'wpt_admin_enqueue' ) ){
    /**
     * CSS or Style file add for Admin Section. 
     * 
     * @since 1.0.0
     * @update 1.0.3
     */
    function wpt_admin_enqueue(){

        wp_enqueue_style( 'wpt-admin', WPT_Product_Table::getPath( 'BASE_URL' ) . 'assets/css/admin.css', array(), WPT_DEV_VERSION, 'all' );

        /**
         * Including UltraAddons CSS form Style
         */
        wp_enqueue_style( 'ultraaddons-css', WPT_Product_Table::getPath( 'BASE_URL' ) . 'assets/css/admin-common.css', array(), WPT_DEV_VERSION, 'all' );
        wp_enqueue_style('ultraaddons-css');

        /**
         * Select2 CSS file including. 
         * 
         * @since 1.0.3
         */    
        wp_enqueue_style( 'select2', WPT_Product_Table::getPath( 'BASE_URL' ) . 'assets/css/select2.min.css', array(), '1.8.2', 'all' );

        //jQuery file including. jQuery is a already registerd to WordPress
        wp_enqueue_script( 'jquery' );

        //Includeing jQuery UI Core
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script( 'jquery-ui-sortable' );

        /**
         * Select2 js file has been updated to 4.1.0 at 13.12.2020
         * 
         * Select2 jQuery Plugin file including. 
         * Here added min version. But also available regular version in same directory
         * 
         * @since 1.0.3
         */
        wp_enqueue_script( 'select2', WPT_Product_Table::getPath( 'BASE_URL' ) . 'assets/js/select2.min.js', array( 'jquery' ), '4.0.5', true );

        //Includeing Color Picker js and css at version 4.4
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_style( 'wp-color-picker' );

        //WordPress Default Media Added only for addmin
        wp_enqueue_media();
    }
}
add_action( 'admin_enqueue_scripts', 'wpt_admin_enqueue', 99 );


if( !function_exists( 'wpt_admin_js_fast_load' ) ){
    /**
     * For first load, It's specially loaded
     */
    function wpt_admin_js_fast_load(){
        wp_enqueue_script( 'wpt-admin', WPT_Product_Table::getPath( 'BASE_URL' ) . 'assets/js/admin.js', array( 'jquery' ), '1.0.0', true );
        
        $ajax_url = admin_url( 'admin-ajax.php' );
        $version = class_exists( 'WOO_Product_Table' ) && WOO_Product_Table::getVersion() ? __( 'WTP Pro: ', 'wpt_pro' ) . WOO_Product_Table::getVersion() : WPT_Product_Table::getVersion();
        $WPT_DATA = array( 
           'ajaxurl' => $ajax_url,
           'ajax_url' => $ajax_url,
           'site_url' => site_url(),
           'checkout_url' => wc_get_checkout_url(),
           'cart_url' => wc_get_cart_url(),
           'priceFormat' => wpt_price_formatter(),
           'version' => $version,
           );
        $WPT_DATA = apply_filters( 'wpto_localize_data', $WPT_DATA );
       wp_localize_script( 'wpt-admin', 'WPT_DATA_ADMIN', $WPT_DATA );
    }
}
add_action( 'admin_enqueue_scripts', 'wpt_admin_js_fast_load', 1 );

if( !function_exists( 'wpt_remove_wpseo_meta' ) ){
    /**
     * For removing Yoast SEO conflict
     */
    function wpt_remove_wpseo_meta(){
        remove_meta_box('wpseo_meta', 'wpt_product_table', 'normal');
    }
}
add_action('add_meta_boxes','wpt_remove_wpseo_meta',100);

if( ! function_exists( 'wpt_add_tabs' ) ){
    function wpt_add_tabs(){
        $screen = get_current_screen();
        $is_wpt_page = strpos($screen->id, 'wpt_product_table');
        
		if ( ! $screen || !( false !== $is_wpt_page ) ) {
            return;
		}
        // var_dump($is_wpt_page,false !== $is_wpt_page,$screen);

        $screen->add_help_tab(
			array(
				'id'      => 'wpt_support_tab',
				'title'   => __( 'Help &amp; Support', 'wpt_pro' ),
				'content' =>
					'<h2>' . __( 'Help &amp; Support', 'wpt_pro' ) . '</h2>' .
					'<p>' . sprintf(
						/* translators: %s: Documentation URL */
						__( 'Should you need help understanding, using, or extending Product Table for WooCommerce, <a href="%s">please read our documentation</a>. You will find all kinds of resources including snippets, tutorials and much more.', 'wpt_pro' ),
						'https://wooproducttable.com/documentation/?utm_source=helptab&utm_content=docs&utm_campaign=wptplugin'
					) . '</p>' .
					'<p>' . sprintf(
						/* translators: %s: Forum URL */
						__( 'For further assistance with Product Table for WooCommerce, use the <a href="%1$s">community forum</a>. For help with premium support, <a href="%2$s">open a support request at CodeAstrology.com</a>.', 'wpt_pro' ),
						'https://wordpress.org/support/plugin/woo-product-table/',
						'https://codeastrology.com/support/submit-ticket/?utm_source=helptab&utm_content=tickets&utm_campaign=wptplugin'
					) . '</p>' .
					'<p><a href="https://wordpress.org/support/plugin/woo-product-table/" class="button">' . __( 'Community forum', 'wpt_pro' ) . '</a> <a href="https://codeastrology.com/support/submit-ticket/?utm_source=helptab&utm_content=tickets&utm_campaign=wptplugin" class="button">' . __( 'CodeAstrology.com support', 'wpt_pro' ) . '</a></p>',
			)
		);

        $screen->set_help_sidebar(
			'<p><strong>' . __( 'For more information:', 'wpt_pro' ) . '</strong></p>' .
			'<p><a href="https://wooproducttable.com/?utm_source=helptab&utm_content=about&utm_campaign=wptplugin" target="_blank">' . __( 'About Product Table', 'wpt_pro' ) . '</a></p>' .
			'<p><a href="https://wordpress.org/support/plugin/woo-product-table/" target="_blank">' . __( 'WordPress.org', 'wpt_pro' ) . '</a></p>' .
			'<p><a href="https://codecanyon.net/item/woo-product-table-pro/20676867" target="_blank">' . __( 'Premium Plugin ', 'wpt_pro' ) . '</a></p>' .
			'<p><a href="https://github.com/codersaiful/woo-product-table/" target="_blank">' . __( 'Github project', 'wpt_pro' ) . '</a></p>' .
			'<p><a href="https://wordpress.org/themes/astha/" target="_blank">' . __( 'Official theme', 'wpt_pro' ) . '</a></p>' .
			'<p><a href="https://codecanyon.net/user/codeastrology/?utm_source=helptab&utm_content=wptotherplugins&utm_campaign=wptplugin" target="_blank">' . __( 'Other Premium Plugins', 'wpt_pro' ) . '</a></p>'
		);

    }
}
add_action( 'current_screen', 'wpt_add_tabs', 50 );