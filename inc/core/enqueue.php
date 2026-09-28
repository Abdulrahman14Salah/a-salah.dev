<?php

if (! defined('ABSPATH')) {
    exit;
}

/*
|--------------------------------------------------------------------------
| Front-end assets
|--------------------------------------------------------------------------
*/

function mytheme_asset_version($relative_path)
{
    $file = get_template_directory() . '/' . ltrim($relative_path, '/');

    return file_exists($file) ? (string) filemtime($file) : MYTHEME_VERSION;
}

function mytheme_enqueue_assets()
{
    wp_enqueue_style(
        'mytheme-fonts',
        'https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,600;12..96,700&family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600&family=JetBrains+Mono:wght@500&display=swap',
        [],
        null
    );

    $style_deps = ['mytheme-fonts'];

    if (is_rtl()) {
        wp_enqueue_style(
            'mytheme-fonts-arabic',
            'https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&display=swap',
            [],
            null
        );
        $style_deps[] = 'mytheme-fonts-arabic';
    }

    wp_enqueue_style(
        'mytheme-main',
        mytheme_css('main.css'),
        $style_deps,
        mytheme_asset_version('assets/css/main.css')
    );

    wp_enqueue_script(
        'mytheme-main',
        mytheme_js('main.js'),
        [],
        mytheme_asset_version('assets/js/main.js'),
        ['in_footer' => true, 'strategy' => 'defer']
    );

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'mytheme_enqueue_assets');

/**
 * Preconnect to Google Fonts.
 */
function mytheme_resource_hints($urls, $relation_type)
{
    if ('preconnect' === $relation_type) {
        $urls[] = ['href' => 'https://fonts.googleapis.com'];
        $urls[] = ['href' => 'https://fonts.gstatic.com', 'crossorigin'];
    }

    return $urls;
}

add_filter('wp_resource_hints', 'mytheme_resource_hints', 10, 2);
