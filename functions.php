<?php
function atvtours_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'atvtours-google-fonts', 'https://fonts.googleapis.com/css?family=Bowlby+One+SC', false );

}
add_action( 'wp_enqueue_scripts', 'atvtours_enqueue_styles' );


add_action( 'wp_enqueue_scripts', 'atvtours_scripts' );

function atvtours_scripts() {
  wp_enqueue_script( 'atvtours-script', get_stylesheet_directory_uri() . '/atc-scripts.js', array( 'jquery' )
  );
}


/**
* Add SVG Support
*/
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');


/**
* Page Slug Body Class
*/
function add_slug_body_class( $classes ) {
	global $post;
	if ( isset( $post ) ) {
	$classes[] = $post->post_type . '-' . $post->post_name;
	}
	return $classes;
	}
	add_filter( 'body_class', 'add_slug_body_class' );

	/*
	 WooCommerce
	*/ 

/**
 * Add Content After Shop Loop
 */

	add_action( 'woocommerce_after_shop_loop', 'atvtours_custom_msg', 9 );
 
function atvtours_custom_msg() {
echo "<h3 style='margin:1rem auto cd pu	50px; max-width:80vw;'> Didn’t find what you were looking for?  Don’t worry, we have many other tours not listed here, like our Lobster ATV tour and combo tours. Just contact our team and we will create the perfect vacation tour for you, your family and your friends.</h3><br/>";
}

/**
 * Remove existing tabs from single product pages.
 */

function remove_woocommerce_product_tabs( $tabs ) {
	unset( $tabs['description'] );
	unset( $tabs['reviews'] );
	unset( $tabs['additional_information'] );
	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'remove_woocommerce_product_tabs', 98 );

/**
 * Hook in each tabs callback function after single content.
 */

add_action( 'woocommerce_after_single_product_summary', 'woocommerce_product_description_tab' );
// add_action( 'woocommerce_after_single_product_summary', 'woocommerce_product_additional_information_tab' );
// add_action( 'woocommerce_after_single_product_summary', 'comments_template' );


/**
 * Remove Price Range
 */

function wc_varb_price_range( $wcv_price, $product ) {
 
    $prefix = sprintf('%s: ', __('From', 'wcvp_range'));
 
    $wcv_reg_min_price = $product->get_variation_regular_price( 'min', true );
    $wcv_min_sale_price    = $product->get_variation_sale_price( 'min', true );
    $wcv_max_price = $product->get_variation_price( 'max', true );
    $wcv_min_price = $product->get_variation_price( 'min', true );
 
    $wcv_price = ( $wcv_min_sale_price == $wcv_reg_min_price ) ?
        wc_price( $wcv_reg_min_price ) :
        '<del>' . wc_price( $wcv_reg_min_price ) . '</del>' . '<ins>' . wc_price( $wcv_min_sale_price ) . '</ins>';
 
    return ( $wcv_min_price == $wcv_max_price ) ?
        $wcv_price :
        sprintf('%s%s', $prefix, $wcv_price);
}
 
add_filter( 'woocommerce_variable_sale_price_html', 'wc_varb_price_range', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'wc_varb_price_range', 10, 2 );
