<?php

if (! defined('ABSPATH')) {
    exit;
}

get_header();

if (is_search()) {
    /* translators: %s: search query */
    $title = sprintf(__('Results for “%s”', 'my-theme'), get_search_query());
} else {
    $title = __('Blog', 'my-theme');
}

get_template_part('template-parts/sections/page-hero', null, ['title' => $title]);

get_template_part('template-parts/sections/post-loop');

get_footer();
