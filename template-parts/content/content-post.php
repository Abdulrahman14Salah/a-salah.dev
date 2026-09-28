<?php

if (! defined('ABSPATH')) {
    exit;
}

$categories = get_the_category();

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('article'); ?>>
    <header class="article__header">
        <div class="container container--narrow">
            <?php
            mytheme_breadcrumb([
                __('Blog', 'my-theme') => mytheme_blog_url(),
                get_the_title()        => '',
            ]);
            ?>
            <h1 class="article__title"><?php the_title(); ?></h1>
            <p class="article__meta">
                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time>
                <?php if ($categories) : ?>
                    <span aria-hidden="true">·</span>
                    <a href="<?php echo esc_url(get_category_link($categories[0])); ?>"><?php echo esc_html($categories[0]->name); ?></a>
                <?php endif; ?>
            </p>
        </div>
    </header>

    <?php if (has_post_thumbnail()) : ?>
        <div class="container article__figure">
            <?php the_post_thumbnail('mytheme-wide', ['loading' => 'eager', 'fetchpriority' => 'high']); ?>
        </div>
    <?php endif; ?>

    <div class="container container--narrow">
        <div class="entry-content">
            <?php
            the_content();

            wp_link_pages([
                'before' => '<nav class="page-links">' . esc_html__('Pages:', 'my-theme'),
                'after'  => '</nav>',
            ]);
            ?>
        </div>

        <?php the_tags('<ul class="chips article__tags"><li class="chip">', '</li><li class="chip">', '</li></ul>'); ?>

        <nav class="post-nav" aria-label="<?php esc_attr_e('More articles', 'my-theme'); ?>">
            <?php previous_post_link('<div class="post-nav__prev">%link</div>', '← %title'); ?>
            <?php next_post_link('<div class="post-nav__next">%link</div>', '%title →'); ?>
        </nav>
    </div>
</article>
