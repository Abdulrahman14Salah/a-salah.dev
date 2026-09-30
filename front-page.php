<?php

if (! defined('ABSPATH')) {
    exit;
}

get_header();

$posts = new WP_Query([
    'post_type'           => 'post',
    'posts_per_page'      => 3,
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
]);

$about_page = get_page_by_path('about-abdulrahman') ?: get_page_by_path('about');
$hero_photo = (int) mytheme_option('hero_photo');
$hero_photo = wp_attachment_is_image($hero_photo) ? $hero_photo : 0;

?>

<section class="hero">
    <div class="container hero__grid">
        <div class="hero__copy">
            <p class="pill"><span class="pill__dot" aria-hidden="true"></span><?php echo esc_html(mytheme_option('hero_eyebrow')); ?></p>
            <h1 class="hero__title">
                <?php echo esc_html(mytheme_option('hero_title')); ?>
                <span class="text-accent"><?php echo esc_html(mytheme_option('hero_title_accent')); ?></span>
            </h1>
            <p class="hero__text"><?php echo esc_html(mytheme_option('hero_text')); ?></p>
            <div class="button-row">
                <a class="button" href="<?php echo esc_url(mytheme_contact_url()); ?>"><?php esc_html_e('Start your website', 'my-theme'); ?> <?php echo mytheme_icon('arrow', 18); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
                <a class="button button--outline" href="#work"><?php esc_html_e('See my work', 'my-theme'); ?></a>
            </div>
        </div>

        <div class="hero__visual <?php echo $hero_photo ? 'hero__visual--photo' : ''; ?>" aria-hidden="true">
            <?php if ($hero_photo) : ?>
                <?php
                echo wp_get_attachment_image($hero_photo, 'large', false, [
                    'class'         => 'hero__photo',
                    'loading'       => false,
                    'fetchpriority' => 'high',
                    'decoding'      => 'async',
                    'sizes'         => '(max-width: 900px) 100vw, 600px',
                ]);
                ?>
            <?php else : ?>
                <img class="hero__mark" src="<?php echo esc_url(mytheme_image('mark.svg')); ?>" alt="" width="380" height="376">
            <?php endif; ?>
            <div class="float-card float-card--stack">
                <p class="eyebrow eyebrow--muted"><?php esc_html_e('Core stack', 'my-theme'); ?></p>
                <ul class="chips">
                    <li class="chip chip--blue"><?php esc_html_e('WordPress', 'my-theme'); ?></li>
                    <li class="chip chip--blue"><?php esc_html_e('Laravel', 'my-theme'); ?></li>
                    <li class="chip"><?php esc_html_e('PHP', 'my-theme'); ?></li>
                    <li class="chip"><?php esc_html_e('Tailwind', 'my-theme'); ?></li>
                </ul>
            </div>
            <div class="float-card float-card--badge">
                <?php echo mytheme_icon('shield', 22); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                <span><?php esc_html_e('Maintained & secured', 'my-theme'); ?></span>
            </div>
        </div>
    </div>
</section>

<section class="stack-strip">
    <div class="container">
        <div class="stack-strip__inner">
            <p class="eyebrow eyebrow--muted"><?php esc_html_e('Tools I work with', 'my-theme'); ?></p>
            <ul class="stack-strip__list">
                <?php foreach (mytheme_stack() as $tool) : ?>
                    <li><?php echo esc_html($tool); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>

<section id="services" class="section">
    <div class="container">
        <div class="section-head section-head--split">
            <div>
                <?php mytheme_eyebrow(__('Services', 'my-theme')); ?>
                <h2 class="section-title"><?php esc_html_e('Built for businesses like yours', 'my-theme'); ?></h2>
            </div>
            <p class="section-lead"><?php esc_html_e('From the first design to the monthly updates: WordPress sites, custom plugins and themes, speed and SEO work, maintenance, Laravel applications, and hosting and domains.', 'my-theme'); ?></p>
        </div>
        <?php get_template_part('template-parts/sections/services'); ?>
    </div>
</section>

<section id="work" class="section section--tinted">
    <div class="container">
        <div class="work-panel">
            <div class="work-panel__copy">
                <p class="work-panel__eyebrow">
                    <span class="eyebrow"><?php esc_html_e('Selected work', 'my-theme'); ?></span>
                    <span class="work-panel__dot" aria-hidden="true"></span>
                    <span class="eyebrow eyebrow--muted"><?php esc_html_e('At Arqam Web', 'my-theme'); ?></span>
                </p>
                <h2 class="section-title work-panel__title">
                    <?php
                    printf(
                        /* translators: %s: agency name, highlighted. */
                        esc_html__('My client work lives at %s.', 'my-theme'),
                        '<span class="text-accent">' . esc_html__('Arqam Web', 'my-theme') . '</span>'
                    );
                    ?>
                </h2>
                <p class="section-lead work-panel__text"><?php esc_html_e("I build websites as part of Arqam Web, a Cairo web agency working with clients in Egypt, Saudi Arabia, the UAE and the US. You can browse the projects I've worked on, along with the rest of the team's work, in the Arqam Web portfolio.", 'my-theme'); ?></p>
            </div>

            <div class="work-panel__aside">
                <div class="work-panel__agency">
                    <span class="work-panel__mark" aria-hidden="true">A</span>
                    <span class="work-panel__agency-text">
                        <span class="work-panel__agency-name"><?php esc_html_e('Arqam Web', 'my-theme'); ?></span>
                        <span class="work-panel__agency-meta"><?php esc_html_e('Web & digital agency · Cairo', 'my-theme'); ?></span>
                    </span>
                </div>
                <a class="button" href="https://www.arqamweb.com/our-projects/" target="_blank" rel="noopener">
                    <?php esc_html_e('See projects on Arqam Web', 'my-theme'); ?>
                    <?php echo mytheme_icon('external', 18); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    <span class="screen-reader-text"><?php esc_html_e('(opens in a new tab)', 'my-theme'); ?></span>
                </a>
                <a class="button button--outline" href="<?php echo esc_url(mytheme_contact_url()); ?>"><?php esc_html_e('Get a quote', 'my-theme'); ?></a>
            </div>
        </div>
    </div>
</section>

<?php get_template_part('template-parts/sections/testimonials'); ?>

<?php get_template_part('template-parts/sections/pricing'); ?>

<section class="section">
    <div class="container about-teaser">
        <div class="about-teaser__head">
            <?php mytheme_eyebrow(__('About', 'my-theme')); ?>
            <h2 class="section-title"><?php esc_html_e('One developer, from the first line to launch day.', 'my-theme'); ?></h2>
        </div>
        <div class="about-teaser__body">
            <p class="section-lead section-lead--dark"><?php esc_html_e("I specialize in professional, high-performance websites built around each client's needs. The goal is always the same: meet the technical requirements, and make the site easier to use, more engaging, and better at bringing in business.", 'my-theme'); ?></p>
            <ul class="values">
                <li><strong><?php esc_html_e('Quality', 'my-theme'); ?></strong><span><?php esc_html_e('Clean code and careful builds.', 'my-theme'); ?></span></li>
                <li><strong><?php esc_html_e('Transparency', 'my-theme'); ?></strong><span><?php esc_html_e('Clear scope, clear updates.', 'my-theme'); ?></span></li>
                <li><strong><?php esc_html_e('Satisfaction', 'my-theme'); ?></strong><span><?php esc_html_e("Done when you're happy with it.", 'my-theme'); ?></span></li>
            </ul>
            <?php if ($about_page) : ?>
                <a class="text-link" href="<?php echo esc_url(get_permalink($about_page)); ?>"><?php esc_html_e('More about Abdulrahman', 'my-theme'); ?> <?php echo mytheme_icon('arrow', 16); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php if ($posts->have_posts()) : ?>
    <section class="section section--tight-top">
        <div class="container">
            <div class="section-head section-head--row">
                <div>
                    <?php mytheme_eyebrow(__('From the blog', 'my-theme')); ?>
                    <h2 class="section-title section-title--sm"><?php esc_html_e('Latest writing', 'my-theme'); ?></h2>
                </div>
                <a class="text-link" href="<?php echo esc_url(mytheme_blog_url()); ?>"><?php esc_html_e('All articles', 'my-theme'); ?></a>
            </div>

            <div class="post-grid <?php echo 1 === $posts->post_count ? 'post-grid--single' : ''; ?>">
                <?php
                while ($posts->have_posts()) :
                    $posts->the_post();
                    get_template_part('template-parts/cards/post', null, ['variant' => 1 === $posts->post_count ? 'wide' : 'card']);
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php get_template_part('template-parts/sections/audit'); ?>

<?php get_template_part('template-parts/sections/contact-cta'); ?>

<?php
get_footer();
