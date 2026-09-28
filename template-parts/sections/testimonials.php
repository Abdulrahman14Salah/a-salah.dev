<?php

if (! defined('ABSPATH')) {
    exit;
}

$testimonials = new WP_Query([
    'post_type'           => 'testimonial',
    'post_status'         => 'publish',
    'posts_per_page'      => 6,
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
]);

if (! $testimonials->have_posts()) {
    return;
}

?>
<section class="section">
    <div class="container">
        <div class="section-head">
            <?php mytheme_eyebrow(__('Testimonials', 'my-theme')); ?>
            <h2 class="section-title"><?php esc_html_e('What clients say', 'my-theme'); ?></h2>
        </div>

        <div class="testimonial-grid">
            <?php
            while ($testimonials->have_posts()) :
                $testimonials->the_post();

                $role        = get_post_meta(get_the_ID(), 'role', true);
                $company     = get_post_meta(get_the_ID(), 'company', true);
                $project_url = get_post_meta(get_the_ID(), 'project_url', true);
                $byline      = implode(' · ', array_filter([$role, $company]));
                ?>
                <figure class="testimonial">
                    <blockquote class="testimonial__quote">
                        <?php echo wp_kses_post(wpautop(get_the_content())); ?>
                    </blockquote>
                    <figcaption class="testimonial__author">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('thumbnail', ['class' => 'testimonial__avatar', 'alt' => '', 'loading' => 'lazy']); ?>
                        <?php endif; ?>
                        <span>
                            <strong class="testimonial__name"><?php the_title(); ?></strong>
                            <?php if ($byline) : ?>
                                <span class="testimonial__role"><?php echo esc_html($byline); ?></span>
                            <?php endif; ?>
                            <?php if ($project_url) : ?>
                                <a class="testimonial__link" href="<?php echo esc_url($project_url); ?>"><?php esc_html_e('See the project', 'my-theme'); ?></a>
                            <?php endif; ?>
                        </span>
                    </figcaption>
                </figure>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
</section>
