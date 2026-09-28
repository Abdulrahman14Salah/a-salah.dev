<?php

/**
 * Template Name: Contact
 * Template Post Type: page
 */

if (! defined('ABSPATH')) {
    exit;
}

get_header();

$email    = mytheme_option('contact_email');
$phone    = mytheme_option('contact_phone');
$whatsapp = mytheme_whatsapp_url();
$form     = mytheme_contact_form();

while (have_posts()) :
    the_post();
    ?>

    <section class="section contact">
        <div class="container contact__grid">
            <div class="contact__intro">
                <?php mytheme_breadcrumb([__('Contact', 'my-theme') => '']); ?>
                <h1 class="page-hero__title"><?php the_title(); ?></h1>
                <div class="entry-content entry-content--lead"><?php the_content(); ?></div>

                <ul class="contact-cards">
                    <?php if ($phone) : ?>
                        <li><a class="contact-card" href="<?php echo esc_attr(mytheme_phone_href()); ?>"><span class="icon-tile"><?php echo mytheme_icon('phone', 22); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><span><span class="eyebrow eyebrow--muted"><?php esc_html_e('Phone', 'my-theme'); ?></span><strong dir="ltr"><?php echo esc_html($phone); ?></strong></span></a></li>
                    <?php endif; ?>
                    <?php if ($email) : ?>
                        <li><a class="contact-card" href="mailto:<?php echo esc_attr($email); ?>"><span class="icon-tile"><?php echo mytheme_icon('mail', 22); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><span><span class="eyebrow eyebrow--muted"><?php esc_html_e('Email', 'my-theme'); ?></span><strong><?php echo esc_html($email); ?></strong></span></a></li>
                    <?php endif; ?>
                    <?php if ($whatsapp) : ?>
                        <li><a class="contact-card" href="<?php echo esc_url($whatsapp); ?>" rel="noopener" target="_blank"><span class="icon-tile"><?php echo mytheme_icon('chat', 22); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><span><span class="eyebrow eyebrow--muted">WhatsApp</span><strong dir="ltr"><?php echo esc_html($phone); ?></strong></span></a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="form-card form-card--large">
                <h2 class="form-card__title"><?php esc_html_e('Send a message', 'my-theme'); ?></h2>
                <?php if ($form) : ?>
                    <?php echo $form; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- shortcode output ?>
                <?php else : ?>
                    <?php if (current_user_can('edit_theme_options')) : ?>
                        <p class="admin-hint"><?php esc_html_e('Only you can see this: add your contact form shortcode in Appearance → Customize → Theme Options.', 'my-theme'); ?></p>
                    <?php endif; ?>
                    <p><?php esc_html_e('Prefer email? Write to me directly:', 'my-theme'); ?></p>
                    <?php if ($email) : ?>
                        <a class="button" href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php
endwhile;

get_footer();
