<?php

if (! defined('ABSPATH')) {
    exit;
}

get_header();

while (have_posts()) :
    the_post();

    get_template_part('template-parts/sections/page-hero', null, [
        'lead' => has_excerpt() ? get_the_excerpt() : '',
    ]);

    get_template_part('template-parts/content/content', 'page');
endwhile;

get_footer();
