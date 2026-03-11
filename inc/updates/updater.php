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

        add_filter(
            'upgrader_source_selection',
            [$this, 'fix_github_folder'],
            10,
            4
        );

        add_filter(
            'upgrader_post_install',
            [$this, 'rename_theme_folder'],
            10,
            3
        );
    }

    public function check_update($transient)
    {

        if (empty($transient->checked)) {
            return $transient;
        }

        // cache release data
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
                6 * HOUR_IN_SECONDS
            );
        }

        if (!isset($release->tag_name)) {
            return $transient;
        }

        $latest_version = ltrim($release->tag_name, 'v');

        $current_version = $this->theme_data->get('Version');

        if (version_compare($current_version, $latest_version, '<')) {

            $package = sprintf(
                'https://github.com/%s/%s/archive/refs/tags/%s.zip',
                MYTHEME_GITHUB_USER,
                MYTHEME_GITHUB_REPO,
                $release->tag_name
            );

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

    public function fix_github_folder($source, $remote_source, $upgrader, $hook_extra)
    {

        if (!isset($hook_extra['theme'])) {
            return $source;
        }

        if ($hook_extra['theme'] !== $this->theme_slug) {
            return $source;
        }

        global $wp_filesystem;

        if (!$wp_filesystem) {
            return $source;
        }

        $files = $wp_filesystem->dirlist($source);

        if (!$files) {
            return $source;
        }

        foreach ($files as $file => $details) {

            $possible = trailingslashit($source) . $file;

            if ($wp_filesystem->exists($possible . '/style.css')) {

                $corrected = trailingslashit($remote_source) . $this->theme_slug;

                $wp_filesystem->move($possible, $corrected);

                return $corrected;
            }
        }

        return $source;
    }


    public function rename_theme_folder($response, $hook_extra, $result)
    {

        global $wp_filesystem;

        if (!isset($hook_extra['theme'])) {
            return $response;
        }

        if ($hook_extra['theme'] !== $this->theme_slug) {
            return $response;
        }

        if (!$wp_filesystem) {
            return $response;
        }

        $correct_dir = trailingslashit(get_theme_root()) . $this->theme_slug;

        $installed_dir = $result['destination'];

        if ($installed_dir !== $correct_dir) {

            $wp_filesystem->move($installed_dir, $correct_dir);

            $result['destination'] = $correct_dir;
        }

        return $result;
    }
}
