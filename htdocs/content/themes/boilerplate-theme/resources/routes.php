<?php

/**
 * Define your routes and which views to display
 * depending of the query.
 *
 * Based on WordPress conditional tags from the WordPress Codex
 * http://codex.wordpress.org/Conditional_Tags
 *
 */

/**
 * Examples Custom Post Type
 */
Route::get('postTypeArchive', ['example', 'uses' => 'ExampleController@index' ]);
Route::get('singular', ['example', 'uses' => 'ExampleController@show' ]);

/**
 * 404 page
 */
Route::get('404', 'PageController@notFound');

// Pages
Route::get('front', 'PageController@home');
Route::get('page', 'PageController@show');
