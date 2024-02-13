/**
 * Webpack configuration
 *
 * @package Ipit_Category_Product_Slider
 */

// External dependencies.
const path = require( 'path' );

// WordPress Dependencies.
const defaultConfig = require( '@wordpress/scripts/config/webpack.config.js' );

// Internal dependencies.
const { getWebpackEntryPoints } = require( '@wordpress/scripts/utils' );

const userConfig = {
	entry: {
		'js/main': path.resolve( process.cwd(), 'js/main.js' ),
		'css/main': path.resolve( process.cwd(), 'scss/main.scss' ),
	},
	output: {
		path: path.resolve( process.cwd(), '../build/' ),
	},
};

const config = {
	...defaultConfig,
	...userConfig
};

module.exports = config;
