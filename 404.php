<?php

if (! defined('ABSPATH')) {
    exit;
}

get_header();

?>
<section class="section not-found">
    <div class="container container--narrow">
        <p class="eyebrow">404</p>
        <h1 class="page-hero__title"><?php esc_html_e('Page not found', 'my-theme'); ?></h1>
        <p class="page-hero__lead"><?php esc_html_e("The page you're looking for doesn't exist or has moved.", 'my-theme'); ?></p>
        <div class="button-row">
            <a class="button" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Back to homepage', 'my-theme'); ?></a>
            <a class="button button--outline" href="<?php echo esc_url(mytheme_contact_url()); ?>"><?php esc_html_e('Contact me', 'my-theme'); ?></a>
        </div>
    </div>
</section>
<?php

get_footer();
