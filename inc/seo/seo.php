<?php
add_theme_support('title-tag');
add_theme_support('post-thumbnails');
add_theme_support('html5', [
    'search-form',
    'comment-form',
    'gallery',
]);

/**
 * Rank Math falls back to its default share image; when none is set, pages
 * without a featured image (Contact, for one) end up with no og:image at all.
 * Use the hero photo, else the site icon, so every page has a share image.
 */
function mytheme_fallback_share_image($url)
{
    if ('' !== trim((string) $url)) {
        return $url;
    }

    $photo = (int) mytheme_option('hero_photo');

    if ($photo && wp_attachment_is_image($photo)) {
        return (string) wp_get_attachment_image_url($photo, 'large');
    }

    return (string) get_site_icon_url(512);
}

add_filter('rank_math/opengraph/facebook/image', 'mytheme_fallback_share_image');
add_filter('rank_math/opengraph/twitter/image', 'mytheme_fallback_share_image');
