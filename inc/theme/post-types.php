<?php

if (! defined('ABSPATH')) {
    exit;
}

/*
|--------------------------------------------------------------------------
| Projects (portfolio)
|--------------------------------------------------------------------------
|
| Registered as "project" so existing URLs such as /project/aawan-website/
| keep working. If a plugin already registers the same post type, the
| theme steps aside.
|
*/

function mytheme_register_project_post_type()
{
    if (post_type_exists('project')) {
        return;
    }

    register_post_type('project', [
        'labels' => [
            'name'          => __('Projects', 'my-theme'),
            'singular_name' => __('Project', 'my-theme'),
            'add_new_item'  => __('Add New Project', 'my-theme'),
            'edit_item'     => __('Edit Project', 'my-theme'),
            'all_items'     => __('All Projects', 'my-theme'),
        ],
        'public'       => true,
        'has_archive'  => 'work',
        'rewrite'      => ['slug' => 'project', 'with_front' => false],
        'menu_icon'    => 'dashicons-portfolio',
        'show_in_rest' => true,
        'supports'     => ['title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'],
    ]);
}

add_action('init', 'mytheme_register_project_post_type');

/**
 * Case-study details shown on single projects.
 * Stored as post meta so they can be edited from the "Project details" box.
 */
function mytheme_project_fields()
{
    return [
        'project_client'   => __('Client', 'my-theme'),
        'project_service'  => __('Service', 'my-theme'),
        'project_language' => __('Language', 'my-theme'),
        'project_year'     => __('Year', 'my-theme'),
        'project_url'      => __('Live URL', 'my-theme'),
        'project_tags'     => __('Tags (comma separated)', 'my-theme'),
        'service_slug'     => __('Service page slug (shows this project on that service page)', 'my-theme'),
    ];
}

function mytheme_project_meta_box()
{
    add_meta_box('mytheme_project_details', __('Project details', 'my-theme'), 'mytheme_render_project_meta_box', 'project', 'side');
}

add_action('add_meta_boxes', 'mytheme_project_meta_box');

function mytheme_render_project_meta_box($post)
{
    wp_nonce_field('mytheme_project_details', 'mytheme_project_nonce');

    foreach (mytheme_project_fields() as $key => $label) {
        $value = get_post_meta($post->ID, $key, true);
        printf(
            '<p><label for="%1$s"><strong>%2$s</strong></label><br><input type="text" class="widefat" id="%1$s" name="%1$s" value="%3$s"></p>',
            esc_attr($key),
            esc_html($label),
            esc_attr($value)
        );
    }
}

function mytheme_save_project_meta($post_id)
{
    if (! isset($_POST['mytheme_project_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mytheme_project_nonce'])), 'mytheme_project_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (! current_user_can('edit_post', $post_id)) {
        return;
    }

    foreach (array_keys(mytheme_project_fields()) as $key) {
        if (! isset($_POST[$key])) {
            continue;
        }

        $raw   = wp_unslash($_POST[$key]);
        if ('project_url' === $key) {
            $value = esc_url_raw($raw);
        } elseif ('service_slug' === $key) {
            $value = sanitize_title($raw);
        } else {
            $value = sanitize_text_field($raw);
        }

        update_post_meta($post_id, $key, $value);
    }
}

add_action('save_post_project', 'mytheme_save_project_meta');

function mytheme_project_tags($post_id)
{
    $raw = (string) get_post_meta($post_id, 'project_tags', true);

    return array_values(array_filter(array_map('trim', explode(',', $raw))));
}

/*
|--------------------------------------------------------------------------
| Testimonials
|--------------------------------------------------------------------------
|
| Title = client name, content = the quote, featured image = avatar or
| logo. Not public on their own: they only appear in the home page section,
| and only once at least one is published.
|
*/

function mytheme_register_testimonial_post_type()
{
    if (post_type_exists('testimonial')) {
        return;
    }

    register_post_type('testimonial', [
        'labels' => [
            'name'          => __('Testimonials', 'my-theme'),
            'singular_name' => __('Testimonial', 'my-theme'),
            'add_new_item'  => __('Add New Testimonial', 'my-theme'),
            'edit_item'     => __('Edit Testimonial', 'my-theme'),
            'all_items'     => __('All Testimonials', 'my-theme'),
        ],
        'public'       => false,
        'show_ui'      => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-format-quote',
        'supports'     => ['title', 'editor', 'thumbnail'],
    ]);
}

add_action('init', 'mytheme_register_testimonial_post_type');

function mytheme_testimonial_fields()
{
    return [
        'role'        => __('Role', 'my-theme'),
        'company'     => __('Company', 'my-theme'),
        'project_url' => __('Project URL', 'my-theme'),
    ];
}

function mytheme_testimonial_meta_box()
{
    add_meta_box('mytheme_testimonial_details', __('Testimonial details', 'my-theme'), 'mytheme_render_testimonial_meta_box', 'testimonial', 'side');
}

add_action('add_meta_boxes', 'mytheme_testimonial_meta_box');

function mytheme_render_testimonial_meta_box($post)
{
    wp_nonce_field('mytheme_testimonial_details', 'mytheme_testimonial_nonce');

    foreach (mytheme_testimonial_fields() as $key => $label) {
        printf(
            '<p><label for="%1$s"><strong>%2$s</strong></label><br><input type="%4$s" class="widefat" id="%1$s" name="%1$s" value="%3$s"></p>',
            esc_attr($key),
            esc_html($label),
            esc_attr(get_post_meta($post->ID, $key, true)),
            'project_url' === $key ? 'url' : 'text'
        );
    }
}

function mytheme_save_testimonial_meta($post_id)
{
    if (! isset($_POST['mytheme_testimonial_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mytheme_testimonial_nonce'])), 'mytheme_testimonial_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (! current_user_can('edit_post', $post_id)) {
        return;
    }

    foreach (array_keys(mytheme_testimonial_fields()) as $key) {
        if (! isset($_POST[$key])) {
            continue;
        }

        $raw   = wp_unslash($_POST[$key]);
        $value = 'project_url' === $key ? esc_url_raw($raw) : sanitize_text_field($raw);

        update_post_meta($post_id, $key, $value);
    }
}

add_action('save_post_testimonial', 'mytheme_save_testimonial_meta');

/**
 * Flush rewrite rules once after the theme is switched on, so /project/ URLs resolve.
 */
function mytheme_flush_rewrites_on_switch()
{
    mytheme_register_project_post_type();
    flush_rewrite_rules();
}

add_action('after_switch_theme', 'mytheme_flush_rewrites_on_switch');
