/**
 * Main script
 *
 * @package Ipit_Category_Product_Slider
 */

import Swiper from 'swiper';
import { Pagination, EffectFade } from 'swiper/modules';

document.addEventListener( 'DOMContentLoaded', init );

function init() {
	const elsProductSwiper =
		document.getElementsByClassName( 'swiper itip-cps' );

	if ( 0 === elsProductSwiper.length ) {
		return;
	}

	Array.from( elsProductSwiper ).forEach( ( elProductSwiper ) => {
		const productSwiperOptions = {
			modules: [ Pagination, EffectFade ],
			pagination: {
				el: '.swiper-pagination',
			},
			speed: 1250,
			effect: 'fade',
			fadeEffect: {
				crossFade: true,
			},
		};

		const productSwiper = new Swiper(
			elProductSwiper,
			productSwiperOptions
		);

		const elProductSwiperWrapper =
			elProductSwiper.querySelector( '.swiper-wrapper' );

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
