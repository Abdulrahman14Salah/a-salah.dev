<?php

if (! defined('ABSPATH')) {
    exit;
}

get_header();

$posts_page = (int) get_option('page_for_posts');
$title      = $posts_page ? get_the_title($posts_page) : __('Blog', 'my-theme');
$lead       = $posts_page && has_excerpt($posts_page) ? get_the_excerpt($posts_page) : __('Articles on WordPress and Laravel development: performance, security, custom themes and plugins.', 'my-theme');
$categories = get_categories(['hide_empty' => true]);

?>
<section class="page-hero">
    <div class="container">
        <?php mytheme_breadcrumb([$title => '']); ?>
        <h1 class="page-hero__title"><?php echo esc_html($title); ?></h1>
        <p class="page-hero__lead"><?php echo esc_html($lead); ?></p>

        <?php if (count($categories) > 1) : ?>
            <ul class="filter-pills">
                <li><a class="is-active" href="<?php echo esc_url(mytheme_blog_url()); ?>"><?php esc_html_e('All', 'my-theme'); ?></a></li>
                <?php foreach ($categories as $category) : ?>
                    <li><a href="<?php echo esc_url(get_category_link($category)); ?>"><?php echo esc_html($category->name); ?></a></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>

<?php
get_template_part('template-parts/sections/post-loop');

get_footer();
