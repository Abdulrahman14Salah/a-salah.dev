<?php

if (! defined('ABSPATH')) {
    exit;
}

/*
|--------------------------------------------------------------------------
| Template tags
|--------------------------------------------------------------------------
*/

/**
 * Inline stroke icon. Returns markup; paths are fixed strings, never user input.
 */
function mytheme_icon($name, $size = 24, $class = '')
{
    $paths = [
        'arrow'    => '<path d="M5 12h14M13 6l6 6-6 6"/>',
        'layout'   => '<rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18M8 14h5"/>',
        'code'     => '<path d="M8 7l-5 5 5 5M16 7l5 5-5 5M13.5 4l-3 16"/>',
        'gauge'    => '<path d="M3.5 18a9 9 0 1 1 17 0"/><path d="M12 14l4.5-4.5"/><circle cx="12" cy="14" r="1.2"/>',
        'shield'   => '<path d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6l8-3z"/><path d="M9 12l2 2 4-4"/>',
        'layers'   => '<path d="M12 3l9 5-9 5-9-5 9-5z"/><path d="M3 13l9 5 9-5"/>',
        'server'   => '<rect x="3" y="4" width="18" height="7" rx="2"/><rect x="3" y="13" width="18" height="7" rx="2"/><path d="M7 7.5h.01M7 16.5h.01"/>',
        'mail'     => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/>',
        'phone'    => '<path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2z"/>',
        'chat'     => '<path d="M21 12a8.5 8.5 0 0 1-12.6 7.4L3 21l1.6-5.2A8.5 8.5 0 1 1 21 12z"/>',
        'image'    => '<rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="9" cy="10" r="2"/><path d="M21 16l-5-5-9 9"/>',
        'menu'     => '<path d="M4 7h16M4 12h16M4 17h16"/>',
        'close'    => '<path d="M6 6l12 12M18 6L6 18"/>',
        'external' => '<path d="M14 4h6v6M20 4l-9 9M18 14v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h5"/>',
    ];

    if (! isset($paths[$name])) {
        return '';
    }

    return sprintf(
        '<svg class="icon %1$s" width="%2$d" height="%2$d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">%3$s</svg>',
        esc_attr($class),
        (int) $size,
        $paths[$name]
    );
}

/**
 * Site logo: the Customizer logo when one is set, otherwise the bundled SVG.
 */
function mytheme_logo($variant = 'dark')
{
    if ('dark' === $variant && has_custom_logo()) {
        the_custom_logo();
        return;
    }

    $file = 'white' === $variant ? 'logo-white.svg' : 'logo.svg';

    printf(
        '<a class="site-logo" href="%1$s" rel="home"><img src="%2$s" alt="%3$s" width="166" height="40"></a>',
        esc_url(home_url('/')),
        esc_url(mytheme_image($file)),
        esc_attr(get_bloginfo('name'))
    );
}

/**
 * Menu fallback when no menu is assigned: Home + top-level pages.
 */
function mytheme_menu_fallback()
{
    echo '<ul class="menu">';
    printf('<li class="%s"><a href="%s">%s</a></li>', is_front_page() ? 'current-menu-item' : '', esc_url(home_url('/')), esc_html__('Home', 'my-theme'));
    wp_list_pages([
        'title_li' => '',
        'depth'    => 1,
        'exclude'  => (int) get_option('page_on_front'),
    ]);
    echo '</ul>';
}

/**
 * The contact page URL: a page using the Contact template, else /contact/, else home.
 */
function mytheme_contact_url()
{
    static $url = null;

    if (null !== $url) {
        return $url;
    }

    $pages = get_pages([
        'meta_key'   => '_wp_page_template',
        'meta_value' => 'page-templates/contact.php',
        'number'     => 1,
    ]);

    if ($pages) {
        $url = get_permalink($pages[0]);
    } elseif ($page = get_page_by_path('contact')) {
        $url = get_permalink($page);
    } else {
        $url = home_url('/#contact');
    }

    return $url;
}

/**
 * Services shown on the home and About pages.
 */
function mytheme_services()
{
    return [
        ['icon' => 'layout', 'title' => __('WordPress Website Design & Development', 'my-theme'), 'text' => __("Professional, high-performance WordPress websites, whether it's a business site, an online store or a portfolio, with a modern design and a smooth experience for your visitors.", 'my-theme')],
        ['icon' => 'code',   'title' => __('WordPress Plugin & Theme Development', 'my-theme'), 'text' => __('Custom plugins and themes built from scratch: secure, scalable and written around exactly what your website needs to do.', 'my-theme')],
        ['icon' => 'gauge',  'title' => __('Website Optimization & SEO', 'my-theme'), 'text' => __('Faster loading, better Core Web Vitals and solid on-page SEO, so your site gets found and people stay on it.', 'my-theme')],
        ['icon' => 'shield', 'title' => __('Website Maintenance & Updates', 'my-theme'), 'text' => __('Regular updates, security patches, bug fixes and performance monitoring, handled for you so the site keeps running smoothly.', 'my-theme')],
        ['icon' => 'layers', 'title' => __('Laravel Web Development', 'my-theme'), 'text' => __('Custom web applications in Laravel: secure, fast and shaped around how your business actually works.', 'my-theme')],
        ['icon' => 'server', 'title' => __('Hosting Management & Domain Registration', 'my-theme'), 'text' => __('Hosting setup, server configuration and domain registration, with reliable performance, security and backups.', 'my-theme')],
    ];
}

function mytheme_stack()
{
    return ['WordPress', 'Laravel', 'PHP', 'SQL', 'HTML', 'CSS', 'JavaScript', 'SCSS', 'Tailwind', 'Bootstrap', 'Shopify', 'GitHub'];
}

/**
 * Eyebrow label above section titles.
 */
function mytheme_eyebrow($text, $class = '')
{
    printf('<p class="eyebrow %s">%s</p>', esc_attr($class), esc_html($text));
}

/**
 * Breadcrumb for inner pages: Home / Parent / Current.
 */
function mytheme_breadcrumb($trail = [])
{
    echo '<nav class="breadcrumb" aria-label="' . esc_attr__('Breadcrumb', 'my-theme') . '">';
    printf('<a href="%s">%s</a>', esc_url(home_url('/')), esc_html__('Home', 'my-theme'));

    foreach ($trail as $label => $url) {
        echo ' <span aria-hidden="true">/</span> ';
        if ($url) {
            printf('<a href="%s">%s</a>', esc_url($url), esc_html($label));
        } else {
            printf('<span aria-current="page">%s</span>', esc_html($label));
        }
    }

    echo '</nav>';
}

/**
 * URL of the posts page (blog), falling back to home.
 */
function mytheme_blog_url()
{
    $posts_page = (int) get_option('page_for_posts');

    return $posts_page ? get_permalink($posts_page) : home_url('/');
}

/**
 * First category name and month/year, e.g. "Blog · July 2025".
 */
function mytheme_post_meta_line($post_id = null)
{
    $post_id    = $post_id ?: get_the_ID();
    $categories = get_the_category($post_id);
    $parts      = [];

    if ($categories) {
        $parts[] = $categories[0]->name;
    }

    $parts[] = get_the_date('F Y', $post_id);

    return implode(' · ', $parts);
}
