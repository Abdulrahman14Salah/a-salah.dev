<?php

/**
 * Template Name: Service
 * Template Post Type: page
 *
 * One page per service: hero, long copy and FAQ (Details blocks) from the
 * editor, related projects, related articles and the contact CTA.
 */

if (! defined('ABSPATH')) {
    exit;
}

get_header();

while (have_posts()) :
    the_post();

    $slug = get_post_field('post_name', get_the_ID());

    // Projects tagged with this service; the latest ones when none are tagged.
    $project_args = [
        'post_type'           => 'project',
        'posts_per_page'      => 3,
        'ignore_sticky_posts' => true,
        'no_found_rows'       => true,
    ];

    $related_projects = new WP_Query($project_args + [
        'meta_key'   => 'service_slug',
        'meta_value' => $slug,
    ]);

    if (! $related_projects->have_posts()) {
        $related_projects = new WP_Query($project_args);
    }

    // Articles from the category that shares this page's slug.
    $category = get_category_by_slug($slug);
    $related_posts = null;

    if ($category) {
        $related_posts = new WP_Query([
            'post_type'           => 'post',
            'posts_per_page'      => 3,
            'cat'                 => $category->term_id,
            'ignore_sticky_posts' => true,
            'no_found_rows'       => true,
        ]);
    }

    $work_url = get_post_type_archive_link('project');

    get_template_part('template-parts/sections/page-hero', null, [
        'lead' => has_excerpt() ? get_the_excerpt() : '',
    ]);
    ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class('section section--tight-top service-page'); ?>>
        <div class="container container--narrow">
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </div>
    </article>

    <?php if ($related_projects->have_posts()) : ?>
        <section class="section section--tinted">
            <div class="container">
                <div class="section-head section-head--row">
                    <div>
                        <?php mytheme_eyebrow(__('Related work', 'my-theme')); ?>
                        <h2 class="section-title section-title--sm"><?php esc_html_e('Projects', 'my-theme'); ?></h2>
                    </div>
                    <?php if ($work_url) : ?>
                        <a class="text-link" href="<?php echo esc_url($work_url); ?>"><?php esc_html_e('All projects', 'my-theme'); ?> <?php echo mytheme_icon('arrow', 16); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
                    <?php endif; ?>
                </div>

                <div class="project-grid">
                    <?php
                    while ($related_projects->have_posts()) :
                        $related_projects->the_post();
                        get_template_part('template-parts/cards/project');
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($related_posts && $related_posts->have_posts()) : ?>
        <section class="section">
            <div class="container">
                <div class="section-head section-head--row">
                    <div>
                        <?php mytheme_eyebrow(__('From the blog', 'my-theme')); ?>
                        <h2 class="section-title section-title--sm"><?php echo esc_html($category->name); ?></h2>
                    </div>
                    <a class="text-link" href="<?php echo esc_url(get_category_link($category)); ?>"><?php esc_html_e('All articles', 'my-theme'); ?></a>
                </div>

                <div class="post-grid <?php echo 1 === $related_posts->post_count ? 'post-grid--single' : ''; ?>">
                    <?php
                    while ($related_posts->have_posts()) :
                        $related_posts->the_post();
                        get_template_part('template-parts/cards/post', null, ['variant' => 1 === $related_posts->post_count ? 'wide' : 'card']);
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php
endwhile;

get_template_part('template-parts/sections/contact-cta');

get_footer();
