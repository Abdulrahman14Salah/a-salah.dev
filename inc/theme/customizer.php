<?php

if (! defined('ABSPATH')) {
    exit;
}

/*
|--------------------------------------------------------------------------
| Customizer: contact details, social links and hero copy
|--------------------------------------------------------------------------
|
| Everything a site owner may want to change without touching code lives
| under Appearance → Customize → Theme Options.
|
*/

function mytheme_option_defaults()
{
    return [
        'contact_email'     => 'me@a-salah.dev',
        'contact_phone'     => '+201121600780',
        'contact_whatsapp'  => '201121600780',
        'social_github'     => 'https://github.com/Abdulrahman14Salah',
        'social_linkedin'   => 'https://www.linkedin.com/in/abdulrahman-salah-hassanein/',
        'contact_form'      => '',
        'hero_eyebrow'      => __('WordPress & Laravel Developer', 'my-theme'),
        'hero_title'        => __('Websites that load fast, rank well and', 'my-theme'),
        'hero_title_accent' => __('keep working.', 'my-theme'),
        'hero_text'         => __("I'm Abdulrahman Salah. I design and build WordPress and Laravel websites for companies, organizations and public figures, then keep them secure and up to date.", 'my-theme'),
        'footer_credit'     => __('Designed and developed by Arqam Web', 'my-theme'),
    ];
}

function mytheme_option($key)
{
    $defaults = mytheme_option_defaults();
    $default  = $defaults[$key] ?? '';

    return get_theme_mod('mytheme_' . $key, $default);
}

function mytheme_customize_register($wp_customize)
{
    $wp_customize->add_section('mytheme_options', [
        'title'    => __('Theme Options', 'my-theme'),
        'priority' => 30,
    ]);

    $fields = [
        'hero_eyebrow'      => [__('Hero label', 'my-theme'), 'text', 'sanitize_text_field'],
        'hero_title'        => [__('Hero title', 'my-theme'), 'text', 'sanitize_text_field'],
        'hero_title_accent' => [__('Hero title (blue part)', 'my-theme'), 'text', 'sanitize_text_field'],
        'hero_text'         => [__('Hero text', 'my-theme'), 'textarea', 'sanitize_textarea_field'],
        'contact_email'     => [__('Email', 'my-theme'), 'email', 'sanitize_email'],
        'contact_phone'     => [__('Phone (international format)', 'my-theme'), 'text', 'sanitize_text_field'],
        'contact_whatsapp'  => [__('WhatsApp number (digits only)', 'my-theme'), 'text', 'sanitize_text_field'],
        'social_github'     => [__('GitHub URL', 'my-theme'), 'url', 'esc_url_raw'],
        'social_linkedin'   => [__('LinkedIn URL', 'my-theme'), 'url', 'esc_url_raw'],
        'contact_form'      => [__('Contact form shortcode (e.g. Contact Form 7)', 'my-theme'), 'text', 'mytheme_sanitize_shortcode'],
        'footer_credit'     => [__('Footer credit', 'my-theme'), 'text', 'sanitize_text_field'],
    ];

    $defaults = mytheme_option_defaults();

    foreach ($fields as $key => [$label, $type, $sanitize]) {
        $wp_customize->add_setting('mytheme_' . $key, [
            'default'           => $defaults[$key],
            'sanitize_callback' => $sanitize,
        ]);

        $wp_customize->add_control('mytheme_' . $key, [
            'label'   => $label,
            'section' => 'mytheme_options',
            'type'    => $type,
        ]);
    }
}

add_action('customize_register', 'mytheme_customize_register');

/**
 * Keep a shortcode as plain text: strip tags, keep the brackets and attributes.
 */
function mytheme_sanitize_shortcode($value)
{
    return trim(wp_strip_all_tags((string) $value));
}

/**
 * Render the configured contact form, or nothing when none is set.
 */
function mytheme_contact_form()
{
    $shortcode = mytheme_option('contact_form');

    if ($shortcode === '' || strpos($shortcode, '[') !== 0) {
        return '';
    }

    return do_shortcode($shortcode);
}

function mytheme_whatsapp_url()
{
    $number = preg_replace('/\D+/', '', (string) mytheme_option('contact_whatsapp'));

    return $number ? 'https://wa.me/' . $number : '';
}

function mytheme_phone_href()
{
    $phone = preg_replace('/[^\d+]/', '', (string) mytheme_option('contact_phone'));

    return $phone ? 'tel:' . $phone : '';
}
