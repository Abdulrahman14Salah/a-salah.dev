<?php

if (! defined('ABSPATH')) {
    exit;
}

get_header();

while (have_posts()) :
    the_post();

    $details = [];
    foreach (['project_client', 'project_service', 'project_language', 'project_year'] as $key) {
        $value = get_post_meta(get_the_ID(), $key, true);
        if ($value !== '') {
            $details[mytheme_project_fields()[$key]] = $value;
        }
    }

    $live_url = get_post_meta(get_the_ID(), 'project_url', true);
    $work_url = get_post_type_archive_link('project');
    ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class('case-study'); ?>>
        <header class="page-hero">
            <div class="container">
                <?php mytheme_breadcrumb([__('Work', 'my-theme') => $work_url, get_the_title() => '']); ?>
                <div class="case-study__head">
                    <h1 class="page-hero__title page-hero__title--xl"><?php the_title(); ?></h1>
                    <?php if (has_excerpt()) : ?>
                        <p class="page-hero__lead"><?php echo esc_html(get_the_excerpt()); ?></p>
                    <?php endif; ?>
                </div>

                <?php if ($details || $live_url) : ?>
                    <dl class="case-study__meta">
                        <?php foreach ($details as $label => $value) : ?>
                            <div><dt class="eyebrow eyebrow--muted"><?php echo esc_html($label); ?></dt><dd><?php echo esc_html($value); ?></dd></div>
                        <?php endforeach; ?>
                        <?php if ($live_url) : ?>
                            <div><dt class="eyebrow eyebrow--muted"><?php esc_html_e('Live site', 'my-theme'); ?></dt><dd><a href="<?php echo esc_url($live_url); ?>" rel="noopener" target="_blank"><?php esc_html_e('Visit website', 'my-theme'); ?> <?php echo mytheme_icon('external', 16); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></dd></div>
                        <?php endif; ?>
                    </dl>
                <?php endif; ?>
            </div>
        </header>

        <?php if (has_post_thumbnail()) : ?>
            <div class="container case-study__figure">
                <?php the_post_thumbnail('mytheme-wide', ['alt' => mytheme_thumbnail_alt(null, __('project screenshot', 'my-theme')), 'loading' => 'eager', 'fetchpriority' => 'high']); ?>
            </div>
        <?php endif; ?>

        <div class="container container--narrow section section--tight-top">
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </div>
    </article>

    <section class="section section--tight-top">
        <div class="container">
            <div class="cta-panel cta-panel--row">
                <h2 class="cta-panel__title cta-panel__title--sm"><?php esc_html_e('Want a website like this?', 'my-theme'); ?></h2>
                <a class="button button--light" href="<?php echo esc_url(mytheme_contact_url()); ?>"><?php esc_html_e('Start your project', 'my-theme'); ?></a>
            </div>
        </div>
    </section>

    <?php
endwhile;

get_footer();
