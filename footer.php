<?php

if (! defined('ABSPATH')) {
    exit;
}

$credit = mytheme_option('footer_credit');

?>

    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="site-footer__grid">
                <div class="site-footer__brand">
                    <?php mytheme_logo(); ?>
                    <p><?php bloginfo('description'); ?></p>
                </div>

                <?php
                mytheme_footer_menu_column('footer', __('Pages', 'my-theme'), 'mytheme_menu_fallback');
                mytheme_footer_menu_column('footer_social', __('Follow', 'my-theme'), 'mytheme_social_menu_fallback');
                mytheme_footer_menu_column('footer_legal', __('Legal', 'my-theme'), 'mytheme_legal_menu_fallback');
                ?>
            </div>

            <div class="site-footer__bottom">
                <span>&copy; <?php echo esc_html(wp_date('Y')); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('All rights reserved.', 'my-theme'); ?></span>
                <?php if ($credit) : ?>
                    <span><?php echo esc_html($credit); ?></span>
                <?php endif; ?>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>

</body>

</html>
