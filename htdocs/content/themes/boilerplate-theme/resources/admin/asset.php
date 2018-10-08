<?php
/**
 * Created by PhpStorm.
 * User: danfulcher
 * Date: 20/09/2018
 * Time: 17:22
 */

// Import assets

Asset::add('css/bootstrap', '../node_modules/bootstrap/dist/css/bootstrap-grid.css', false, '1.0', 'all');
Asset::add('css/main.css', '../dist/css/app.css', false, '1.0', 'all');

Asset::add('js/theme.min.js', '../dist/js/app.js', false, '1.0', 'all');

// Asset functions

function themeSVG($name) {
	return themosis_theme_assets()."/images/svg/$name.svg";
}

function themeJPG($name) {
	return themosis_theme_assets()."/images/jpg/$name.jpg";
}

function themePNG($name) {
	return themosis_theme_assets()."/images/png/$name.png";
}

