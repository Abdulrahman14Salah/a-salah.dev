<?php

if (! defined('ABSPATH')) {
    exit;
}

$layout = $args['layout'] ?? 'grid';

?>
<?php if ('list' === $layout) : ?>
    <ol class="service-list">
        <?php foreach (mytheme_services() as $index => $service) : ?>
            <li class="service-list__item">
                <span class="service-list__num"><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                <h3 class="service-list__title"><?php echo esc_html($service['title']); ?></h3>
                <p class="service-list__text"><?php echo esc_html($service['text']); ?></p>
            </li>
        <?php endforeach; ?>
    </ol>
<?php else : ?>
    <div class="service-grid">
        <?php foreach (mytheme_services() as $index => $service) : ?>
            <article class="service-card">
                <div class="service-card__top">
                    <span class="icon-tile"><?php echo mytheme_icon($service['icon']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                    <span class="service-card__num"><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                </div>
                <h3 class="service-card__title"><?php echo esc_html($service['title']); ?></h3>
                <p class="service-card__text"><?php echo esc_html($service['text']); ?></p>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
