<?php

if (! defined('ABSPATH')) {
    exit;
}

/*
|--------------------------------------------------------------------------
| AdSense and affiliate links
|--------------------------------------------------------------------------
|
| Ads load on single blog posts only, never on the home page or the service
| pages, and only once a publisher ID is set in the Customizer. The same ID
| serves /ads.txt, so there is no file to upload by hand.
|
*/

function mytheme_adsense_client()
{
    return (string) mytheme_option('adsense_client');
}

function mytheme_show_ads()
{
    return mytheme_adsense_client() && is_singular('post');
}

function mytheme_adsense_script()
{
    if (! mytheme_show_ads()) {
        return;
    }

    printf(
        '<script async src="%s" crossorigin="anonymous"></script>' . "\n",
        esc_url('https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-' . mytheme_adsense_client())
    );
}

add_action('wp_head', 'mytheme_adsense_script', 20);

/**
 * Serve /ads.txt from the publisher ID. Nothing is served until one is set,
 * so the URL 404s instead of returning an HTML page.
 */
function mytheme_serve_ads_txt()
{
    $path = wp_parse_url(home_url('/ads.txt'), PHP_URL_PATH);
    $uri  = isset($_SERVER['REQUEST_URI']) ? wp_parse_url(sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'])), PHP_URL_PATH) : '';

    if ($uri !== $path) {
        return;
    }

    $client = mytheme_adsense_client();

    if (! $client) {
        status_header(404);
        header('Content-Type: text/plain; charset=utf-8');
        exit;
    }

    status_header(200);
    header('Content-Type: text/plain; charset=utf-8');
    header('Cache-Control: public, max-age=86400');
    echo 'google.com, ' . esc_html($client) . ", DIRECT, f08c47fec0942fa0\n";
    exit;
}

add_action('init', 'mytheme_serve_ads_txt', 0);

/**
 * Affiliate disclosure: tick "Contains affiliate links" on a post and the
 * notice shows above the article. [affiliate_disclosure] places it by hand.
 */
function mytheme_affiliate_disclosure_html()
{
    return '<aside class="affiliate-note" role="note"><strong>' . esc_html__('Affiliate links:', 'my-theme') . '</strong> ' . esc_html__('some links in this article are affiliate links. If you buy through them I may earn a commission, at no extra cost to you. I only recommend services I use or would use on client sites.', 'my-theme') . '</aside>';
}

add_shortcode('affiliate_disclosure', 'mytheme_affiliate_disclosure_html');

function mytheme_prepend_affiliate_disclosure($content)
{
    if (! is_singular('post') || ! in_the_loop() || ! is_main_query()) {
        return $content;
    }

    if (! get_post_meta(get_the_ID(), 'has_affiliate_links', true) || has_shortcode($content, 'affiliate_disclosure')) {
        return $content;
    }

    return mytheme_affiliate_disclosure_html() . $content;
}

add_filter('the_content', 'mytheme_prepend_affiliate_disclosure', 5);

function mytheme_affiliate_meta_box()
{
    add_meta_box('mytheme_affiliate', __('Affiliate links', 'my-theme'), 'mytheme_render_affiliate_meta_box', 'post', 'side');
}

add_action('add_meta_boxes', 'mytheme_affiliate_meta_box');

function mytheme_render_affiliate_meta_box($post)
{
    wp_nonce_field('mytheme_affiliate', 'mytheme_affiliate_nonce');
    printf(
        '<label><input type="checkbox" name="has_affiliate_links" value="1" %s> %s</label><p class="description">%s</p>',
        checked((bool) get_post_meta($post->ID, 'has_affiliate_links', true), true, false),
        esc_html__('Contains affiliate links', 'my-theme'),
        esc_html__('Shows the disclosure notice above the article. Mark the links themselves rel="sponsored".', 'my-theme')
    );
}

function mytheme_save_affiliate_meta($post_id)
{
    if (! isset($_POST['mytheme_affiliate_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mytheme_affiliate_nonce'])), 'mytheme_affiliate')) {
        return;
    }

    if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || ! current_user_can('edit_post', $post_id)) {
        return;
    }

    if (empty($_POST['has_affiliate_links'])) {
        delete_post_meta($post_id, 'has_affiliate_links');
    } else {
        update_post_meta($post_id, 'has_affiliate_links', 1);
    }
}

add_action('save_post_post', 'mytheme_save_affiliate_meta');

/**
 * Let the scheduled routine set the flag through the REST API.
 */
function mytheme_register_affiliate_meta()
{
    register_post_meta('post', 'has_affiliate_links', [
        'type'          => 'boolean',
        'single'        => true,
        'show_in_rest'  => true,
        'auth_callback' => function () {
            return current_user_can('edit_posts');
        },
    ]);
}

add_action('init', 'mytheme_register_affiliate_meta');
