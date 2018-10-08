<?php

return [

    /**
     * Edit this file to add widget sidebars to your theme.
     * Place WordPress default settings for sidebars.
     * Add as many as you want, watch-out your commas!
     */
    [
        'name' => __('First sidebar', THEME_TEXTDOMAIN),
        'id' => 'first-sidebar',
        'description' => __('Area of first sidebar', THEME_TEXTDOMAIN),
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ]

];
