<?php

if (! defined('ABSPATH')) {
    exit;
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <a class="skip-link" href="#primary"><?php esc_html_e('Skip to content', 'my-theme'); ?></a>

    <header class="site-header">
        <div class="container site-header__inner">
            <div class="site-branding">
                <?php mytheme_logo(); ?>
            </div>

            <?php get_template_part('template-parts/header/navigation'); ?>
        </div>
    </header>

    <main id="primary" class="site-main">
