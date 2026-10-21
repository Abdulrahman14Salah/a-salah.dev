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

define('MYTHEME_SLUG', wp_get_theme()->get_stylesheet());


/*
|--------------------------------------------------------------------------
| GitHub Repository
|--------------------------------------------------------------------------
*/

define('MYTHEME_GITHUB_USER', 'Abdulrahman14Salah');

define('MYTHEME_GITHUB_REPO', 'a-salah.dev');

define('MYTHEME_GITHUB_TOKEN', getenv('MYTHEME_GITHUB_TOKEN') ?: '');


/*
|--------------------------------------------------------------------------
| Update API
|--------------------------------------------------------------------------
| Shared hosting shares its outbound IP across many tenant sites, so the
| unauthenticated api.github.com quota (60 req/hour, per IP) gets exhausted
| by unrelated neighbours and update checks silently fail. raw.githubusercontent.com
| serves static files through a CDN with a far higher, effectively unlimited
| ceiling for this kind of traffic, so the release workflow publishes a tiny
| JSON manifest (same field names GitHub's release API uses: tag_name,
| html_url, body, assets[].name/.browser_download_url) and the updater reads
| that instead of calling the REST API at all.
*/

define('MYTHEME_UPDATE_API', 'https://raw.githubusercontent.com/' . MYTHEME_GITHUB_USER . '/' . MYTHEME_GITHUB_REPO . '/main/update-manifest.json');


/*
|--------------------------------------------------------------------------
| Theme Website (future license server)
|--------------------------------------------------------------------------
*/

define('MYTHEME_THEME_SITE', 'https://your-domain.com');
