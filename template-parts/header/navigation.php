<?php

if (! defined('ABSPATH')) {
    exit;
}

?>
<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-navigation">
    <span class="nav-toggle__open"><?php echo mytheme_icon('menu', 22); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
    <span class="nav-toggle__close"><?php echo mytheme_icon('close', 22); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
    <span class="screen-reader-text"><?php esc_html_e('Menu', 'my-theme'); ?></span>
</button>

<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e('Main', 'my-theme'); ?>">
    <?php
    wp_nav_menu([
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'menu',
        'depth'          => 1,
        'fallback_cb'    => 'mytheme_menu_fallback',
    ]);
    ?>

    <a class="button button--dark button--sm" href="<?php echo esc_url(mytheme_contact_url()); ?>">
        <?php esc_html_e('Get a quote', 'my-theme'); ?>
        <?php echo mytheme_icon('arrow', 16); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
    </a>
</nav>
