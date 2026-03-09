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

function mytheme_autoload_inc_files()
{

    if (! is_dir(MYTHEME_INC)) {
        return;
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(
            MYTHEME_INC,
            RecursiveDirectoryIterator::SKIP_DOTS
        )
    );

    foreach ($iterator as $file) {

        if ($file->isFile() && 'php' === $file->getExtension()) {
            require_once $file->getRealPath();
        }
    }
}

mytheme_autoload_inc_files();
