<?php

/**
 * Template Name: About
 * Template Post Type: page
 */

if (! defined('ABSPATH')) {
    exit;
}

get_header();

while (have_posts()) :
    the_post();
    ?>

    <section class="page-hero page-hero--about">
        <div class="container about-hero">
            <div class="about-hero__copy">
                <?php mytheme_breadcrumb([get_the_title() => '']); ?>
                <h1 class="page-hero__title"><?php the_title(); ?></h1>
                <?php if (has_excerpt()) : ?>
                    <p class="page-hero__lead"><?php echo esc_html(get_the_excerpt()); ?></p>
                <?php endif; ?>
            </div>
            <div class="about-hero__media">
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('mytheme-card', ['alt' => esc_attr(get_the_title())]); ?>
                <?php else : ?>
                    <span class="media-placeholder media-placeholder--dots"><?php echo mytheme_icon('image', 40); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="section section--tight-top">
        <div class="container split">
            <div class="split__label"><?php mytheme_eyebrow(__('What I do', 'my-theme')); ?></div>
            <div class="split__body entry-content entry-content--lead">
                <?php the_content(); ?>
            </div>
        </div>
    </section>

    <section class="section section--tinted">
        <div class="container">
            <h2 class="section-title"><?php esc_html_e('Services', 'my-theme'); ?></h2>
            <?php get_template_part('template-parts/sections/services', null, ['layout' => 'list']); ?>
        </div>
    </section>

    <section class="section">
        <div class="container two-up">
            <div class="panel">
                <?php mytheme_eyebrow(__('Why work with me', 'my-theme')); ?>
                <h3 class="panel__title"><?php esc_html_e('Tailored work, not templates.', 'my-theme'); ?></h3>
                <p><?php esc_html_e('Every service is shaped around your business, with one focus: a website that performs better and is easier to find.', 'my-theme'); ?></p>
            </div>
            <div class="panel panel--blue">
                <?php mytheme_eyebrow(__('Values', 'my-theme')); ?>
                <h3 class="panel__title"><?php esc_html_e('Quality, transparency and your satisfaction.', 'my-theme'); ?></h3>
                <p><?php esc_html_e('Clear communication from the first call, careful work, and support after launch so your business keeps growing online.', 'my-theme'); ?></p>
            </div>
        </div>
    </section>

    <section class="section section--tight-top">
        <div class="container">
            <div class="cta-panel cta-panel--row">
                <div>
                    <h2 class="cta-panel__title cta-panel__title--sm"><?php esc_html_e('Looking for a trusted partner?', 'my-theme'); ?></h2>
                    <p class="cta-panel__text"><?php esc_html_e('Design a new website or improve the one you have. Take the next step today.', 'my-theme'); ?></p>
                </div>
                <a class="button button--light" href="<?php echo esc_url(mytheme_contact_url()); ?>"><?php esc_html_e('Get in touch', 'my-theme'); ?> <?php echo mytheme_icon('arrow', 18); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
            </div>
        </div>
    </section>

    <?php
endwhile;

get_footer();
