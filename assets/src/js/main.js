/**
 * Main script
 *
 * @package Ipit_Category_Product_Slider
 */

import Swiper from 'swiper';
import { Pagination } from 'swiper/modules';

document.addEventListener( 'DOMContentLoaded', init );

function init() {
	const elsProduct = document.getElementsByClassName(
		'product type-product'
	);

	if ( 0 < elsProduct.length ) {
		Array.from(elsProduct).forEach( ( product ) => {

			// product.classList.add( 'test' );
		} );
	}

	const itipCategoryProductSlider = new Swiper( '.swiper.itip-cps', {
		modules: [ Pagination ],
		pagination: {
			el: '.swiper-pagination',
		},
	} );
	console.log( itipCategoryProductSlider );
}
