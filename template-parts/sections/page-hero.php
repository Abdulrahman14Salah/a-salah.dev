<?php

if (! defined('ABSPATH')) {
    exit;
}

$title = $args['title'] ?? get_the_title();
$lead  = $args['lead'] ?? '';
$trail = $args['trail'] ?? [$title => ''];

?>
<section class="page-hero">
    <div class="container">
        <?php mytheme_breadcrumb($trail); ?>
        <h1 class="page-hero__title"><?php echo esc_html($title); ?></h1>
        <?php if ($lead) : ?>
            <p class="page-hero__lead"><?php echo esc_html($lead); ?></p>
        <?php endif; ?>
    </div>
</section>
