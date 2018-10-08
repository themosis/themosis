<?php

return [

    /**
     * Edit this file in order to configure your theme
     * settings or preferences.
     *
     */

    /* --------------------------------------------------------------- */
    // Theme textdomain
    /* --------------------------------------------------------------- */
    'textdomain' => 'themosis',

    /* --------------------------------------------------------------- */
    // Global Javascript namespace of your theme
    /* --------------------------------------------------------------- */
    'namespace' => 'themosis',

    /* --------------------------------------------------------------- */
    // Set WordPress admin ajax file without the PHP extension
    /* --------------------------------------------------------------- */
    'ajaxurl' => 'admin-ajax',

    /* --------------------------------------------------------------- */
    // Cleanup Header
    /* --------------------------------------------------------------- */
    'cleanup' => true,

    /* --------------------------------------------------------------- */
    // Restrict access to the WordPress Admin for users with a
    // specific role. 
    // Once the theme is activated, you can only log in by going
    // to 'wp-login.php' or 'login' (if permalinks changed) urls.
    // By default, allows 'administrator', 'editor', 'author',
    // 'contributor' and 'subscriber' to access the ADMIN area.
    // Edit this configuration in order to limit access.
    /* --------------------------------------------------------------- */
    'access' => [
        'administrator',
        'editor',
        'author',
        'contributor',
        'subscriber',
    ],

    /* --------------------------------------------------------------- */
    // Theme class aliases
    /* --------------------------------------------------------------- */
    'aliases' => [
        'Action' => Themosis\Facades\Action::class,
        'Ajax' => Themosis\Facades\Ajax::class,
        'Asset' => Themosis\Facades\Asset::class,
        'Blade' => Themosis\Facades\Blade::class,
        'Config' => Themosis\Facades\Config::class,
        'DB' => Themosis\Facades\DB::class,
        'Field' => Themosis\Facades\Field::class,
        'Filter' => Themosis\Facades\Filter::class,
        'Form' => Themosis\Facades\Form::class,
        'Html' => Themosis\Facades\Html::class,
        'Input' => Themosis\Facades\Input::class,
        'Loop' => Themosis\Facades\Loop::class,
        'Meta' => Themosis\Metabox\Meta::class,
        'Metabox' => Themosis\Facades\Metabox::class,
        'Option' => Themosis\Page\Option::class,
        'Page' => Themosis\Facades\Page::class,
        'PostType' => Themosis\Facades\PostType::class,
        'Request' => Themosis\Facades\Request::class,
        'Route' => Themosis\Facades\Route::class,
        'Section' => Themosis\Facades\Section::class,
        'TaxField' => Themosis\Taxonomy\TaxField::class,
        'TaxMeta' => Themosis\Taxonomy\TaxMeta::class,
        'Taxonomy' => Themosis\Facades\Taxonomy::class,
        'User' => Themosis\Facades\User::class,
        'Validator' => Themosis\Facades\Validator::class,
        'View' => Themosis\Facades\View::class,
    ]

];
