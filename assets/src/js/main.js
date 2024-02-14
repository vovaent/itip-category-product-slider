/**
 * Main script
 *
 * @package Ipit_Category_Product_Slider
 */

import Swiper from 'swiper';
import { Pagination, EffectFade } from 'swiper/modules';

document.addEventListener( 'DOMContentLoaded', init );

function init() {
	const elsProduct = document.getElementsByClassName(
		'product type-product'
	);

	if ( 0 === elsProduct.length ) {
		return false;
	}

	new Swiper( '.swiper.itip-cps', {
		modules: [ Pagination, EffectFade ],
		pagination: {
			el: '.swiper-pagination',
		},
		speed: 1250,
		effect: 'fade',
		fadeEffect: {
			crossFade: true,
		},
	} );

	Array.from( elsProduct ).forEach( ( product ) => {
		const elProductSwiper = product.querySelector( '.swiper' );
		if ( ! elProductSwiper ) {
			return false;
		}

		const elProductSwiperWrapper =
			elProductSwiper.querySelector( '.swiper-wrapper' );
		const productSwiper = elProductSwiper.swiper;

		elProductSwiperWrapper.addEventListener( 'mouseenter', () =>
			toggleToAdditionalSlide( productSwiper )
		);
		elProductSwiperWrapper.addEventListener( 'mouseleave', () =>
			toggleToMainSlide( productSwiper )
		);
	} );
}

function toggleToAdditionalSlide( productSwiper ) {
	productSwiper.slideNext();
}

function toggleToMainSlide( productSwiper ) {
	productSwiper.slidePrev();
}
