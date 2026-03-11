<?php

if (!defined('ABSPATH')) {
    exit;
}

class MyTheme_GitHub_Updater
{

    private $theme_slug;
    private $theme_data;
    private $github_api_url;

    public function __construct()
    {

        $this->theme_slug = get_template();
        $this->theme_data = wp_get_theme($this->theme_slug);
        $this->github_api_url = MYTHEME_UPDATE_API;

        add_filter(
            'pre_set_site_transient_update_themes',
            [$this, 'check_update']
        );
    }

    public function check_update($transient)
    {

        if (empty($transient->checked)) {
            return $transient;
        }

        // cache GitHub response
        $release = get_transient('mytheme_github_release');

        if (!$release) {

            $response = wp_remote_get(
                $this->github_api_url,
                [
                    'headers' => [
                        'Accept' => 'application/vnd.github+json',
                        'User-Agent' => 'WordPress'
                    ]
                ]
            );

            if (is_wp_error($response)) {
                return $transient;
            }

            $release = json_decode(
                wp_remote_retrieve_body($response)
            );

            set_transient(
                'mytheme_github_release',
                $release,
                HOUR_IN_SECONDS
            );
        }

        if (!isset($release->tag_name)) {
            return $transient;
        }

        $latest_version  = ltrim($release->tag_name, 'v');
        $current_version = $this->theme_data->get('Version');

        if (version_compare($current_version, $latest_version, '<')) {

            $package = '';

            if (!empty($release->assets)) {
                foreach ($release->assets as $asset) {

                    if ($asset->name === 'a-salah.dev.zip') {
                        $package = $asset->browser_download_url;
                        break;
                    }
                }
            }

            if (!$package) {
                return $transient;
            }

            $update = [
                'theme'       => $this->theme_slug,
                'new_version' => $latest_version,
                'url'         => $release->html_url,
                'package'     => $package,
            ];

            $transient->response[$this->theme_slug] = $update;
        }

        return $transient;
    }
}
