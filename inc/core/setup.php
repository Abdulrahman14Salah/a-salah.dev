<?php

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function mytheme_setup()
{

    /*
    |--------------------------------------------------------------------------
    | Translation
    |--------------------------------------------------------------------------
    */
    load_theme_textdomain(
        'my-theme',
        MYTHEME_DIR . '/languages'
    );

    /*
    |--------------------------------------------------------------------------
    | Theme Supports
    |--------------------------------------------------------------------------
    */

    add_theme_support('title-tag');

    add_theme_support('post-thumbnails');

    add_theme_support('automatic-feed-links');

    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    /*
    |--------------------------------------------------------------------------
    | Custom Logo
    |--------------------------------------------------------------------------
    */

    add_theme_support(
        'custom-logo',
        array(
            'height'      => 80,
            'width'       => 200,
            'flex-width'  => true,
            'flex-height' => true,
        )
    );

    /*
    |--------------------------------------------------------------------------
    | Navigation Menus
    |--------------------------------------------------------------------------
    */

    register_nav_menus(
        array(
            'primary' => __('Primary Menu', 'my-theme'),
            'footer'  => __('Footer Menu', 'my-theme'),
        )
    );
}

add_action('after_setup_theme', 'mytheme_setup');
