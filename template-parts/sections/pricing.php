<?php

if (! defined('ABSPATH')) {
    exit;
}

/*
 * Pricing: one card per price set in Customizer → Theme Options. The whole
 * section stays hidden until at least one price is filled in.
 */

$plans = array_filter([
    [
        'price'    => mytheme_option('price_website'),
        'title'    => __('WordPress website', 'my-theme'),
        'prefix'   => __('Starting from', 'my-theme'),
        'suffix'   => '',
        'text'     => __('A one-off build, designed around your business and ready to launch.', 'my-theme'),
        'featured' => false,
        'items'    => [
            __('Custom design for your brand', 'my-theme'),
            __('Fast and mobile-first', 'my-theme'),
            __('On-page SEO set up from day one', 'my-theme'),
            __('Contact form and WhatsApp button', 'my-theme'),
            __('A walkthrough so you can edit your own content', 'my-theme'),
        ],
    ],
    [
        'price'    => mytheme_option('price_maintenance'),
        'title'    => __('Monthly maintenance', 'my-theme'),
        'prefix'   => '',
        'suffix'   => __('/ month', 'my-theme'),
        'text'     => __('I keep your site updated, secure and fast, so you never have to think about it.', 'my-theme'),
        'featured' => true,
        'items'    => [
            __('WordPress, theme and plugin updates', 'my-theme'),
            __('Security monitoring and fixes', 'my-theme'),
            __('Regular backups', 'my-theme'),
            __('Speed checks', 'my-theme'),
            __('Small content edits', 'my-theme'),
        ],
    ],
    [
        'price'    => mytheme_option('price_hosting'),
        'title'    => __('Hosting', 'my-theme'),
        'prefix'   => '',
        'suffix'   => __('/ year', 'my-theme'),
        'text'     => __('Managed hosting for WordPress, set up and looked after for you.', 'my-theme'),
        'featured' => false,
        'items'    => [
            __('Server set up for WordPress', 'my-theme'),
            __('SSL certificate', 'my-theme'),
            __('Domain connection', 'my-theme'),
            __('Uptime monitoring', 'my-theme'),
        ],
    ],
], function ($plan) {
    return '' !== trim((string) $plan['price']);
});

if (! $plans) {
    return;
}

?>
<section id="pricing" class="section">
    <div class="container">
        <div class="section-head section-head--split">
            <div>
                <?php mytheme_eyebrow(__('Pricing', 'my-theme')); ?>
                <h2 class="section-title"><?php esc_html_e('Clear prices, no surprises', 'my-theme'); ?></h2>
            </div>
            <p class="section-lead"><?php esc_html_e('Every project gets a fixed quote before any work starts. These are the starting points.', 'my-theme'); ?></p>
        </div>

        <div class="price-grid price-grid--<?php echo (int) count($plans); ?>">
            <?php foreach ($plans as $plan) : ?>
                <article class="price-card <?php echo $plan['featured'] ? 'price-card--featured' : ''; ?>">
                    <div class="price-card__head">
                        <h3 class="price-card__title"><?php echo esc_html($plan['title']); ?></h3>
                        <?php if ($plan['featured']) : ?>
                            <span class="price-card__badge"><?php esc_html_e('Recommended', 'my-theme'); ?></span>
                        <?php endif; ?>
                    </div>
                    <p class="price-card__price">
                        <span class="price-card__prefix"><?php echo $plan['prefix'] ? esc_html($plan['prefix']) : '&nbsp;'; ?></span>
                        <strong><?php echo esc_html($plan['price']); ?></strong>
                        <?php if ($plan['suffix']) : ?>
                            <span class="price-card__suffix"><?php echo esc_html($plan['suffix']); ?></span>
                        <?php endif; ?>
                    </p>
                    <p class="price-card__text"><?php echo esc_html($plan['text']); ?></p>
                    <ul class="price-card__list">
                        <?php foreach ($plan['items'] as $item) : ?>
                            <li><?php echo esc_html($item); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <a class="button <?php echo $plan['featured'] ? 'button--light' : 'button--outline'; ?>" href="<?php echo esc_url(mytheme_contact_url()); ?>"><?php esc_html_e('Get a quote', 'my-theme'); ?></a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
