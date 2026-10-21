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

/*
|--------------------------------------------------------------------------
| Theme updates
|--------------------------------------------------------------------------
| Handled by the separate "GitHub Theme Updater" plugin on the live site,
| not by code in this theme: https://github.com/Abdulrahman14Salah/github-theme-updater
|
| (Removed: the former in-theme updater class, and the one-time
| theme_mods_a-salah.dev -> theme_mods_a-salah-theme Customizer migration —
| both already served their purpose and are confirmed done on the live
| site, so they no longer need to ship in every release.)
*/
