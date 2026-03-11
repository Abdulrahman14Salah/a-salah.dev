<?php

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Remove WP Bloat
 */

remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');

/**
 * Disable emojis
 */

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');


/**
 * Enable lazy loading for images and iframes
 */

add_filter('wp_lazy_loading_enabled', '__return_true');
