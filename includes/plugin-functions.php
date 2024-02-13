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

function itip_cps__remove_woocommerce_template_loop_product_thumbnail() {
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' );
}

// add_action( 'wp_head', 'itip_cps__remove_woocommerce_template_loop_product_thumbnail' );

function itip_cps__woocommerce_template_loop_product_thumbnail( $size = 'woocommerce_thumbnail', $attr = array(), $placeholder = true ) {
	global $product;

	if ( ! is_array( $attr ) ) {
		$attr = array();
	}

	if ( ! is_bool( $placeholder ) ) {
		$placeholder = true;
	}

	$image_size = apply_filters( 'single_product_archive_thumbnail_size', $size );

	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $product ? $product->get_image( $image_size, $attr, $placeholder ) : '';
}

// add_action( 'woocommerce_before_shop_loop_item_title', 'itip_cps__woocommerce_template_loop_product_thumbnail', 10, 3 );

function aaa( $image ) {
	$old_image = $image;

	if ( ! function_exists( 'get_field' ) ) {
		return $old_image;
	}

	$product_cropper_image = get_field( 'product_cropper_image' );

	if ( ! $product_cropper_image ) {
		return $old_image;
	}

	$product_cropper_image_html = wp_get_attachment_image( $product_cropper_image, 'woocommerce_thumbnail' );

	$images  = '<div class="swiper itip-cps"><div class="swiper-wrapper">';
	$images .= '<div class="swiper-slide">' . $old_image . '</div>';
	$images .= '<div class="swiper-slide">' . $product_cropper_image_html . '</div>';
	$images .= '</div><div class="swiper-pagination"></div>';
	$images .= '</div>';

	return $images;
}

add_filter( 'woocommerce_product_get_image', 'aaa', 10, 6 );
