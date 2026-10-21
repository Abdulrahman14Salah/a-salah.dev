<?php

if (! defined('ABSPATH')) {
    exit;
}

/*
|--------------------------------------------------------------------------
| Theme Constants
|--------------------------------------------------------------------------
*/

define('MYTHEME_VERSION', wp_get_theme()->get('Version'));
define('MYTHEME_DIR', get_template_directory());
define('MYTHEME_URI', get_template_directory_uri());
define('MYTHEME_INC', MYTHEME_DIR . '/inc');


/*
|--------------------------------------------------------------------------
| Autoload PHP Files from /inc
|--------------------------------------------------------------------------
*/

function a_salah_autoload_inc()
{

    $inc_dir = get_template_directory() . '/inc';

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($inc_dir, RecursiveDirectoryIterator::SKIP_DOTS)
    );

    foreach ($iterator as $file) {

        if ($file->getExtension() === 'php') {
            require_once $file->getRealPath();
        }
    }
}

a_salah_autoload_inc();


add_action('after_setup_theme', function () {

    if (class_exists('MyTheme_GitHub_Updater')) {
        new MyTheme_GitHub_Updater();
    }
});

/*
|--------------------------------------------------------------------------
| One-time Customizer settings migration
|--------------------------------------------------------------------------
| The theme's folder slug changed from "a-salah.dev" to "a-salah-theme"
| (WordPress core strips dots when sanitizing theme slugs in its own
| update/AJAX handlers, which silently broke both manual and automatic
| theme updates). Customizer settings are stored per-stylesheet as
| `theme_mods_{slug}`, so without this copy the switch would reset the
| hero text, contact details and social links back to defaults. Safe to
| remove once confirmed migrated — it no-ops forever after.
*/
add_action('after_setup_theme', function () {

    $old_slug = 'a-salah.dev';
    $new_slug = get_stylesheet();

    if ($new_slug === $old_slug) {
        return;
    }

    $old_mods = get_option("theme_mods_{$old_slug}");
    $new_mods = get_option("theme_mods_{$new_slug}");

    if ($old_mods !== false && $new_mods === false) {
        update_option("theme_mods_{$new_slug}", $old_mods);
    }
});
