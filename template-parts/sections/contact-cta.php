<?php

if (! defined('ABSPATH')) {
    exit;
}

$email    = mytheme_option('contact_email');
$phone    = mytheme_option('contact_phone');
$whatsapp = mytheme_whatsapp_url();
$form     = mytheme_contact_form();

?>
<section id="contact" class="section section--tight-top">
    <div class="container">
        <div class="cta-panel <?php echo $form ? 'cta-panel--split' : ''; ?>">
            <div class="cta-panel__copy">
                <p class="eyebrow eyebrow--light"><?php esc_html_e("Let's talk", 'my-theme'); ?></p>
                <h2 class="cta-panel__title"><?php esc_html_e("Have a website idea? Let's build it.", 'my-theme'); ?></h2>
                <p class="cta-panel__text"><?php esc_html_e("Send a few lines about your project. I'll reply with next steps and a quote.", 'my-theme'); ?></p>

                <ul class="cta-panel__contacts">
                    <?php if ($email) : ?>
                        <li><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo mytheme_icon('mail', 20); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html($email); ?></a></li>
                    <?php endif; ?>
                    <?php if ($phone) : ?>
                        <li><a href="<?php echo esc_attr(mytheme_phone_href()); ?>"><?php echo mytheme_icon('phone', 20); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span dir="ltr"><?php echo esc_html($phone); ?></span></a></li>
                    <?php endif; ?>
                    <?php if ($whatsapp) : ?>
                        <li><a href="<?php echo esc_url($whatsapp); ?>" rel="noopener" target="_blank"><?php echo mytheme_icon('chat', 20); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php esc_html_e('WhatsApp', 'my-theme'); ?></a></li>
                    <?php endif; ?>
                </ul>

                <?php if (! $form) : ?>
                    <a class="button button--light" href="<?php echo esc_url(mytheme_contact_url()); ?>"><?php esc_html_e('Send a message', 'my-theme'); ?> <?php echo mytheme_icon('arrow', 18); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
                <?php endif; ?>
            </div>

            <?php if ($form) : ?>
                <div class="cta-panel__form form-card">
                    <?php echo $form; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- shortcode output ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
