<?php

if (! defined('ABSPATH')) {
    exit;
}

$layout = $args['layout'] ?? 'grid';

?>
<?php if ('list' === $layout) : ?>
    <ol class="service-list">
        <?php foreach (mytheme_services() as $index => $service) : ?>
            <li class="service-list__item <?php echo $service['url'] ? 'service-list__item--link' : ''; ?>">
                <span class="service-list__num"><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                <h3 class="service-list__title">
                    <?php if ($service['url']) : ?>
                        <a class="service-list__link" href="<?php echo esc_url($service['url']); ?>"><?php echo esc_html($service['title']); ?></a>
                    <?php else : ?>
                        <?php echo esc_html($service['title']); ?>
                    <?php endif; ?>
                </h3>
                <p class="service-list__text"><?php echo esc_html($service['text']); ?></p>
            </li>
        <?php endforeach; ?>
    </ol>
<?php else : ?>
    <div class="service-grid">
        <?php foreach (mytheme_services() as $index => $service) : ?>
            <?php $tag = $service['url'] ? 'a' : 'article'; ?>
            <<?php echo $tag; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- fixed tag name ?> class="service-card <?php echo $service['url'] ? 'service-card--link' : ''; ?>"<?php echo $service['url'] ? ' href="' . esc_url($service['url']) . '"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                <div class="service-card__top">
                    <span class="icon-tile"><?php echo mytheme_icon($service['icon']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                    <span class="service-card__num"><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                </div>
                <h3 class="service-card__title"><?php echo esc_html($service['title']); ?></h3>
                <p class="service-card__text"><?php echo esc_html($service['text']); ?></p>
                <?php if ($service['url']) : ?>
                    <span class="text-link service-card__more"><?php esc_html_e('Learn more', 'my-theme'); ?> <?php echo mytheme_icon('arrow', 16); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                <?php endif; ?>
            </<?php echo $tag; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- fixed tag name ?>>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
