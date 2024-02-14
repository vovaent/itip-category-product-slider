<?php
/**
 * IPIT Category Product Slider functions
 *
 * @package Ipit_Category_Product_Slider
 */

/**
 * Enqueue scripts and styles
 *
 * @return void
 */
function itip_cps__enqueue_scripts_and_styles(): void {
	$js_main_asset  = require_once plugin_dir_path( __FILE__ ) . '../assets/build/js/main.asset.php';
	$css_main_asset = require_once plugin_dir_path( __FILE__ ) . '../assets/build/css/main.asset.php';

	wp_enqueue_script( 'itip-cps-script', plugin_dir_url( __FILE__ ) . '../assets/build/js/main.js', array(), $js_main_asset['version'], true );
	wp_enqueue_style( 'itip-cps-style', plugin_dir_url( __FILE__ ) . '../assets/build/css/main.css', array(), $css_main_asset['version'] );
}

add_action( 'wp_enqueue_scripts', 'itip_cps__enqueue_scripts_and_styles' );

/**
 * Adds slider layout and a second image for the product.
 *
 * @param string $image HTML-code image.
 *
 * @return string
 */
function itip_cps__add_slider_markup_and_second_image( string $image ): string {
	$old_image = $image;

	if ( function_exists( 'get_field' ) ) {
		$product_cropper_image = get_field( 'product_cropper_image' );
	} else {
		global $post;
		$product_cropper_image = get_post_meta( $post->ID, 'product_cropper_image', true );
	}

	if ( ! $product_cropper_image ) {
		return $old_image;
	}

	if ( is_numeric( $product_cropper_image ) ) {
		$product_cropper_image_html = wp_get_attachment_image( $product_cropper_image, 'large' );
	} elseif ( is_array( $product_cropper_image ) ) {
		$product_cropper_image_html = wp_get_attachment_image( $product_cropper_image['ID'], 'large' );
	} else {
		$product_cropper_image_html = '<img src="' . $product_cropper_image . '">';
	}

	$images  = '<div class="swiper itip-cps"><div class="swiper-wrapper">';
	$images .= '<div class="swiper-slide">' . $old_image . '</div>';
	$images .= '<div class="swiper-slide swiper-slide-additional">' . $product_cropper_image_html . '</div>';
	$images .= '</div><div class="swiper-pagination"></div>';
	$images .= '</div>';

	return $images;
}

add_filter( 'woocommerce_product_get_image', 'itip_cps__add_slider_markup_and_second_image', 10, 6 );
