<?php

if (! defined('ABSPATH')) {
    exit;
}

$status   = isset($_GET['audit']) ? sanitize_key(wp_unslash($_GET['audit'])) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- display only
$messages = [
    'sent'    => __("Thanks! I'll look at your site and email you what I find.", 'my-theme'),
    'invalid' => __('Please add your name, a valid email and your website address.', 'my-theme'),
    'error'   => __('Something went wrong. Please try again, or message me on WhatsApp.', 'my-theme'),
];

?>
<section id="audit" class="section section--tight-top">
    <div class="container">
        <div class="audit-panel">
            <div class="audit-panel__copy">
                <?php mytheme_eyebrow(__('Free website audit', 'my-theme')); ?>
                <h2 class="section-title section-title--sm"><?php esc_html_e('Not sure what your site needs? Start with a free audit.', 'my-theme'); ?></h2>
                <p class="section-lead"><?php esc_html_e("Send me your website address. I'll check its speed, SEO basics, security and mobile layout, and email you a short list of what to fix first.", 'my-theme'); ?></p>
            </div>

            <form class="audit-form" action="<?php echo esc_url(mytheme_audit_action_url()); ?>" method="post">
                <?php if (isset($messages[$status])) : ?>
                    <p class="form-notice form-notice--<?php echo 'sent' === $status ? 'success' : 'error'; ?>" role="status"><?php echo esc_html($messages[$status]); ?></p>
                <?php endif; ?>

                <input type="hidden" name="action" value="mytheme_audit">
                <?php wp_nonce_field('mytheme_audit', 'mytheme_audit_nonce'); ?>

                <div class="audit-form__hp" aria-hidden="true">
                    <label for="company_site"><?php esc_html_e('Leave this empty', 'my-theme'); ?></label>
                    <input type="text" id="company_site" name="company_site" tabindex="-1" autocomplete="off">
                </div>

                <label for="audit_website"><?php esc_html_e('Your website', 'my-theme'); ?>
                    <input type="text" id="audit_website" name="audit_website" placeholder="example.com" required inputmode="url" autocomplete="url">
                </label>
                <div class="audit-form__row">
                    <label for="audit_name"><?php esc_html_e('Name', 'my-theme'); ?>
                        <input type="text" id="audit_name" name="audit_name" autocomplete="name" required>
                    </label>
                    <label for="audit_email"><?php esc_html_e('Email', 'my-theme'); ?>
                        <input type="email" id="audit_email" name="audit_email" autocomplete="email" required>
                    </label>
                </div>
                <label for="audit_goal"><?php esc_html_e('What would you like to improve? (optional)', 'my-theme'); ?>
                    <textarea id="audit_goal" name="audit_goal" rows="3"></textarea>
                </label>
                <button type="submit"><?php esc_html_e('Get my free audit', 'my-theme'); ?></button>
            </form>
        </div>
    </div>
</section>
