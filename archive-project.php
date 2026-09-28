<?php

if (! defined('ABSPATH')) {
    exit;
}

get_header();

get_template_part('template-parts/sections/page-hero', null, [
    'title' => __('Work', 'my-theme'),
    'lead'  => __('Websites and applications built for companies, organizations and public figures.', 'my-theme'),
]);

get_template_part('template-parts/sections/post-loop', null, ['card' => 'project']);

get_template_part('template-parts/sections/contact-cta');

get_footer();
