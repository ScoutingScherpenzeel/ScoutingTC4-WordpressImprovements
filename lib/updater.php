<?php

namespace ScoutingImprovements\Updates;
/**
 * GitHub Releases auto-updates
 */

add_action('after_setup_theme', __NAMESPACE__ . '\\bootstrap');

function bootstrap()
{

    if (!defined('GITHUB_OWNER')) define('GITHUB_OWNER', 'ScoutingScherpenzeel');
    if (!defined('GITHUB_REPO'))  define('GITHUB_REPO',  'ScoutingTC4-WordpressImprovements');

    if (is_admin() || wp_doing_cron()) {
        add_filter('pre_set_site_transient_update_themes', __NAMESPACE__ . '\\update_themes_check');
        add_filter('themes_api', __NAMESPACE__ . '\\themes_api', 10, 3);
    }
}

/**
 * Inject update info into the site transient if a newer GitHub release exists.
 */
function update_themes_check($transient)
{
    if (empty($transient) || !is_object($transient)) $transient = new \stdClass();

    $slug = get_stylesheet();
    $current_version = wp_get_theme($slug)->get('Version');

    $release = fetch_latest_release();
    if (!$release) return $transient;

    $new_version = ltrim($release['version'], 'v');
    if (version_compare($new_version, $current_version, '<=')) {
        return $transient;
    }

    $package_url = $release['asset_zip_url'];
    if (!$package_url) return $transient;

    $update = array(
        'theme' => $slug,
        'new_version' => $new_version,
        'url' => $release['html_url'],
        'package' => $package_url,
        'requires' => '6.0',
        'tested' => '6.8',
    );

    if (!isset($transient->response)) $transient->response = array();
    $transient->response[$slug] = $update;

    return $transient;
}

/**
 * Provide the “View details” modal content using the release notes.
 */
function themes_api($result, $action, $args)
{
    if ($action !== 'theme_information') return $result;

    $slug = get_stylesheet();
    if (empty($args->slug) || $args->slug !== $slug) return $result;

    $theme   = wp_get_theme($slug);
    $release = fetch_latest_release();
    if (!$release) return $result;

    $version = ltrim($release['version'], 'v');

    $info = new \stdClass();
    $info->name = $theme->get('Name');
    $info->slug = $slug;
    $info->version = $version;
    $info->author = $theme->get('Author');
    $info->homepage = $release['html_url'];
    $info->download_link = $release['asset_zip_url'];
    $info->sections = array(
        'description' => wp_kses_post($theme->get('Description')),
        'changelog'   => wpautop(esc_html($release['body'] ?: '')),
    );

    return $info;
}

/**
 * Get the latest GitHub release (cached for 5 minutes).
 */
function fetch_latest_release()
{
    $api = sprintf(
        'https://api.github.com/repos/%s/%s/releases/latest',
        GITHUB_OWNER,
        GITHUB_REPO
    );

    $headers = [
        'Accept'     => 'application/vnd.github+json',
        'User-Agent' => 'WordPress/' . get_bloginfo('version') . '; ' . home_url('/'),
    ];

    if (defined('GITHUB_TOKEN') && GITHUB_TOKEN) {
        $headers['Authorization'] = 'Bearer ' . GITHUB_TOKEN;
    }

    $res = wp_remote_get($api, ['headers' => $headers, 'timeout' => 15]);
    if (is_wp_error($res)) return null;

    $code = wp_remote_retrieve_response_code($res);
    $body = json_decode(wp_remote_retrieve_body($res), true);

    if ($code !== 200 || !is_array($body)) return null;

    $asset_zip_url = '';
    if (!empty($body['assets']) && is_array($body['assets'])) {
        $slug = get_stylesheet();
        foreach ($body['assets'] as $asset) {
            $name = isset($asset['name']) ? strtolower($asset['name']) : '';
            $url  = $asset['browser_download_url'] ?? '';
            if ($url && preg_match('/\.zip$/i', $name)) {
                // Prefer one that contains the slug in its name
                if (stripos($name, strtolower($slug)) !== false) {
                    $asset_zip_url = $url;
                    break;
                }
                // Fallback: first .zip asset
                if (!$asset_zip_url) {
                    $asset_zip_url = $url;
                }
            }
        }
    }

    return [
        'version'       => $body['tag_name'] ?? '',
        'html_url'      => $body['html_url'] ?? '',
        'body'          => $body['body'] ?? '',
        'asset_zip_url' => $asset_zip_url,
    ];
}
