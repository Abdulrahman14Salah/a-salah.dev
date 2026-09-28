<?php

if (! defined('ABSPATH')) {
    exit;
}

get_header();

$title = wp_strip_all_tags(get_the_archive_title());
$lead  = wp_strip_all_tags(get_the_archive_description());

get_template_part('template-parts/sections/page-hero', null, [
    'title' => $title,
    'lead'  => $lead,
    'trail' => [__('Blog', 'my-theme') => mytheme_blog_url(), $title => ''],
]);

get_template_part('template-parts/sections/post-loop');

get_footer();
