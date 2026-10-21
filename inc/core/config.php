<?php

if (! defined('ABSPATH')) {
    exit;
}

/*
|--------------------------------------------------------------------------
| Theme Configuration
|--------------------------------------------------------------------------
| Theme updates are handled by a separate plugin ("GitHub Theme Updater",
| https://github.com/Abdulrahman14Salah/github-theme-updater) installed on
| the live site, not by code in this theme — update-checking logic should
| never live inside the folder it would have to replace. Configure the
| GitHub repo/token in the plugin's settings page instead of here.
*/

define('MYTHEME_NAME', 'A-Salah');

define('MYTHEME_SLUG', wp_get_theme()->get_stylesheet());

define('MYTHEME_THEME_SITE', 'https://a-salah.dev');
