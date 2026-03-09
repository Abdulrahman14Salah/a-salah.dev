<?php get_header(); ?>

<div class="container">

    <?php

    if (have_posts()) :

        while (have_posts()) :

            the_post();

            get_template_part('template-parts/content/content', 'post');

        endwhile;

    endif;

    ?>

</div>

<?php get_footer(); ?>