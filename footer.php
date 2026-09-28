<?php

if (! defined('ABSPATH')) {
    exit;
}

$github   = mytheme_option('social_github');
$linkedin = mytheme_option('social_linkedin');
$credit   = mytheme_option('footer_credit');

?>

    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="site-footer__grid">
                <div class="site-footer__brand">
                    <?php mytheme_logo(); ?>
                    <p><?php bloginfo('description'); ?></p>
                </div>

                <div class="site-footer__col">
                    <p class="eyebrow eyebrow--muted"><?php esc_html_e('Pages', 'my-theme'); ?></p>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer',
                        'container'      => false,
                        'menu_class'     => 'footer-menu',
                        'depth'          => 1,
                        'fallback_cb'    => 'mytheme_menu_fallback',
                    ]);
                    ?>
                </div>

                <?php if ($github || $linkedin) : ?>
                    <div class="site-footer__col">
                        <p class="eyebrow eyebrow--muted"><?php esc_html_e('Follow', 'my-theme'); ?></p>
                        <ul class="footer-menu">
                            <?php if ($github) : ?>
                                <li><a href="<?php echo esc_url($github); ?>" rel="noopener" target="_blank">GitHub</a></li>
                            <?php endif; ?>
                            <?php if ($linkedin) : ?>
                                <li><a href="<?php echo esc_url($linkedin); ?>" rel="noopener" target="_blank">LinkedIn</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="site-footer__col">
                    <p class="eyebrow eyebrow--muted"><?php esc_html_e('Legal', 'my-theme'); ?></p>
                    <ul class="footer-menu">
                        <?php
                        $privacy = get_privacy_policy_url();
                        $terms   = get_page_by_path('terms-conditions');
                        ?>
                        <?php if ($privacy) : ?>
                            <li><a href="<?php echo esc_url($privacy); ?>"><?php esc_html_e('Privacy Policy', 'my-theme'); ?></a></li>
                        <?php endif; ?>
                        <?php if ($terms) : ?>
                            <li><a href="<?php echo esc_url(get_permalink($terms)); ?>"><?php esc_html_e('Terms & Conditions', 'my-theme'); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
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
