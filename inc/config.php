<?php

if (! defined('ABSPATH')) {
    exit;
}

/*
|--------------------------------------------------------------------------
| Theme Configuration
|--------------------------------------------------------------------------
*/

define('MYTHEME_NAME', 'My Theme');

define('MYTHEME_SLUG', 'my-theme');


/*
|--------------------------------------------------------------------------
| GitHub Repository
|--------------------------------------------------------------------------
*/

define('MYTHEME_GITHUB_USER', 'YOUR_GITHUB_USERNAME');

define('MYTHEME_GITHUB_REPO', 'my-theme');


/*
|--------------------------------------------------------------------------
| Update API
|--------------------------------------------------------------------------
*/

define('MYTHEME_UPDATE_API', 'https://api.github.com/repos/' . MYTHEME_GITHUB_USER . '/' . MYTHEME_GITHUB_REPO . '/releases/latest');


/*
|--------------------------------------------------------------------------
| Theme Website (future license server)
|--------------------------------------------------------------------------
*/

define('MYTHEME_THEME_SITE', 'https://your-domain.com');
