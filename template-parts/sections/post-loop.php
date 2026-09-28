<?php

if (! defined('ABSPATH')) {
    exit;
}

$card = $args['card'] ?? 'post';

?>
<section class="section section--tight-top">
    <div class="container">
        <?php if (have_posts()) : ?>
            <div class="<?php echo 'project' === $card ? 'project-grid' : 'post-grid'; ?>">
                <?php
                while (have_posts()) :
                    the_post();
                    get_template_part('template-parts/cards/' . $card);
                endwhile;
                ?>
            </div>

            <?php
            the_posts_pagination([
                'mid_size'  => 1,
                'prev_text' => __('Previous', 'my-theme'),
                'next_text' => __('Next', 'my-theme'),
            ]);
            ?>
        <?php else : ?>
            <div class="empty-state">
                <h2><?php esc_html_e('Nothing here yet', 'my-theme'); ?></h2>
                <p><?php esc_html_e('New content is on the way. Check back soon.', 'my-theme'); ?></p>
                <?php if (is_search()) : ?>
                    <?php get_search_form(); ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
