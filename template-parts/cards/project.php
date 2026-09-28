<?php

if (! defined('ABSPATH')) {
    exit;
}

$tags = mytheme_project_tags(get_the_ID());

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('project-card'); ?>>
    <a class="project-card__link" href="<?php the_permalink(); ?>">
        <div class="project-card__media">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('mytheme-card', ['alt' => '', 'loading' => 'lazy']); ?>
            <?php else : ?>
                <span class="media-placeholder"><?php echo mytheme_icon('image', 40); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
            <?php endif; ?>
        </div>
        <div class="project-card__body">
            <div>
                <h3 class="project-card__title"><?php the_title(); ?></h3>
                <?php if (has_excerpt()) : ?>
                    <p class="project-card__text"><?php echo esc_html(get_the_excerpt()); ?></p>
                <?php endif; ?>
            </div>
            <?php if ($tags) : ?>
                <ul class="chips">
                    <?php foreach (array_slice($tags, 0, 3) as $i => $tag) : ?>
                        <li class="chip <?php echo 0 === $i ? 'chip--blue' : ''; ?>"><?php echo esc_html($tag); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </a>
</article>
