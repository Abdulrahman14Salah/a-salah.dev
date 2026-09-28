<?php

if (! defined('ABSPATH')) {
    exit;
}

get_header();

while (have_posts()) :
    the_post();
    get_template_part('template-parts/content/content', 'post');

    if (comments_open() || get_comments_number()) :
        ?>
        <div class="container container--narrow">
            <?php comments_template(); ?>
        </div>
        <?php
    endif;
endwhile;

get_template_part('template-parts/sections/contact-cta');

get_footer();
