<?php get_header(); ?>

<div class="container">

    <?php

    if (have_posts()) :

        while (have_posts()) :

            the_post();

            get_template_part('template-parts/content/content', 'post');

        endwhile;

    else :

        echo '<p>No posts found</p>';

    endif;

    ?>

</div>

<?php get_footer(); ?>