<?php

if (! defined('ABSPATH')) {
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
            array($this, 'check_update')
        );

        add_filter(
            'upgrader_source_selection',
            array($this, 'fix_github_folder'),
            10,
            4
        );
    }

    public function check_update($transient)
    {

        if (empty($transient->checked)) {
            return $transient;
        }

        $response = wp_remote_get(
            $this->github_api_url,
            array(
                'headers' => array(
                    'Accept' => 'application/vnd.github+json',
                    'User-Agent' => 'WordPress'
                )
            )
        );

        if (is_wp_error($response)) {
            return $transient;
        }

        $release = json_decode(
            wp_remote_retrieve_body($response)
        );

        if (! isset($release->tag_name)) {
            return $transient;
        }

        $latest_version = ltrim($release->tag_name, 'v');

        $current_version = $this->theme_data->get('Version');

        if (version_compare($current_version, $latest_version, '<')) {

            $update = array(
                'theme'       => $this->theme_slug,
                'new_version' => $latest_version,
                'url'         => $release->html_url,
                'package'     => $release->zipball_url,
            );

            $transient->response[$this->theme_slug] = $update;
        }

        return $transient;
    }

    public function fix_github_folder($source, $remote_source, $upgrader, $hook_extra)
    {

        if (isset($hook_extra['theme']) && $hook_extra['theme'] === $this->theme_slug) {

            $corrected_source = trailingslashit($remote_source) . $this->theme_slug;

            if (rename($source, $corrected_source)) {

                return $corrected_source;
            }
        }

        return $source;
    }
}
