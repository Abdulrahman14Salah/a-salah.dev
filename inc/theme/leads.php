<?php

if (! defined('ABSPATH')) {
    exit;
}

/*
|--------------------------------------------------------------------------
| Free website audit requests
|--------------------------------------------------------------------------
|
| The short form on the home page posts here. Each request is saved as a
| private "Audit request" in the admin (so nothing is lost if mail fails)
| and emailed to the contact address from the Customizer.
|
*/

function mytheme_register_lead_post_type()
{
    register_post_type('audit_request', [
        'labels' => [
            'name'          => __('Audit requests', 'my-theme'),
            'singular_name' => __('Audit request', 'my-theme'),
            'all_items'     => __('Audit requests', 'my-theme'),
            'edit_item'     => __('Audit request', 'my-theme'),
        ],
        'public'       => false,
        'show_ui'      => true,
        'menu_icon'    => 'dashicons-search',
        'supports'     => ['title', 'editor'],
        'capabilities' => ['create_posts' => 'do_not_allow'],
        'map_meta_cap' => true,
    ]);
}

add_action('init', 'mytheme_register_lead_post_type');

function mytheme_audit_action_url()
{
    return admin_url('admin-post.php');
}

function mytheme_handle_audit_request()
{
    $back = wp_get_referer() ?: home_url('/');
    $back = remove_query_arg('audit', $back);

    $done = function ($status) use ($back) {
        wp_safe_redirect(add_query_arg('audit', $status, $back) . '#audit');
        exit;
    };

    if (! isset($_POST['mytheme_audit_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mytheme_audit_nonce'])), 'mytheme_audit')) {
        $done('error');
    }

    // Honeypot: people never see this field, bots fill it in.
    if (! empty($_POST['company_site'])) {
        $done('sent');
    }

    $name    = sanitize_text_field(wp_unslash($_POST['audit_name'] ?? ''));
    $email   = sanitize_email(wp_unslash($_POST['audit_email'] ?? ''));
    $website = esc_url_raw(trim(wp_unslash($_POST['audit_website'] ?? '')));
    $goal    = sanitize_textarea_field(wp_unslash($_POST['audit_goal'] ?? ''));

    if ($website && ! preg_match('#^https?://#i', $website)) {
        $website = esc_url_raw('https://' . $website);
    }

    if (! $name || ! is_email($email) || ! $website) {
        $done('invalid');
    }

    // At most five requests an hour from one address.
    $ip_key = 'mytheme_audit_' . md5(sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'] ?? '')));
    $count  = (int) get_transient($ip_key);

    if ($count >= 5) {
        $done('error');
    }

    set_transient($ip_key, $count + 1, HOUR_IN_SECONDS);

    $body = implode("\n", [
        /* translators: %s: the visitor's name. */
        sprintf(__('Name: %s', 'my-theme'), $name),
        /* translators: %s: the visitor's email address. */
        sprintf(__('Email: %s', 'my-theme'), $email),
        /* translators: %s: the website to audit. */
        sprintf(__('Website: %s', 'my-theme'), $website),
        '',
        /* translators: %s: what the visitor wants to improve. */
        $goal ? sprintf(__('What they want to improve: %s', 'my-theme'), $goal) : '',
    ]);

    wp_insert_post([
        'post_type'    => 'audit_request',
        'post_status'  => 'private',
        'post_title'   => sprintf('%s — %s', $name, wp_parse_url($website, PHP_URL_HOST) ?: $website),
        'post_content' => $body,
    ]);

    $to = mytheme_option('contact_email') ?: get_option('admin_email');

    wp_mail(
        $to,
        /* translators: %s: the website's domain. */
        sprintf(__('Free audit request: %s', 'my-theme'), wp_parse_url($website, PHP_URL_HOST) ?: $website),
        $body,
        ['Reply-To: ' . $name . ' <' . $email . '>']
    );

    $done('sent');
}

add_action('admin_post_nopriv_mytheme_audit', 'mytheme_handle_audit_request');
add_action('admin_post_mytheme_audit', 'mytheme_handle_audit_request');
