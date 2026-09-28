<?php

if (! defined('ABSPATH')) {
    exit;
}

$variant = $args['variant'] ?? 'card';

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post-card post-card--' . $variant); ?>>
    <a class="post-card__link" href="<?php the_permalink(); ?>">
        <div class="post-card__media">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('mytheme-card', ['alt' => '', 'loading' => 'lazy']); ?>
            <?php else : ?>
                <img class="post-card__mark" src="<?php echo esc_url(mytheme_image('mark.svg')); ?>" alt="" width="96" height="95" loading="lazy">
            <?php endif; ?>
        </div>
        <div class="post-card__body">
            <p class="eyebrow eyebrow--muted"><?php echo esc_html(mytheme_post_meta_line()); ?></p>
            <h3 class="post-card__title"><?php the_title(); ?></h3>
            <p class="post-card__excerpt"><?php echo esc_html(wp_strip_all_tags(get_the_excerpt())); ?></p>
            <span class="text-link"><?php esc_html_e('Read article', 'my-theme'); ?> <?php echo mytheme_icon('arrow', 16); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
        </div>
    </a>
</article>
