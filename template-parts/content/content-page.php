<?php

if (! defined('ABSPATH')) {
    exit;
}

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('section section--tight-top'); ?>>
    <div class="container container--narrow">
        <?php if (has_post_thumbnail()) : ?>
            <figure class="entry-figure"><?php the_post_thumbnail('mytheme-wide'); ?></figure>
        <?php endif; ?>

        <div class="entry-content">
            <?php
            the_content();

            wp_link_pages([
                'before' => '<nav class="page-links">' . esc_html__('Pages:', 'my-theme'),
                'after'  => '</nav>',
            ]);
            ?>
        </div>
    </div>
</article>
