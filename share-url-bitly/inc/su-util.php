<?php

/**
 * @Author: Zeppelin
 * @Date:   2024-07-08 
 * @Last Modified by:   Zeppelin
 * @Website: https://github.com/madnansultandotme/Share-Url-Bitly-Plugin.git
 * @Email: info.adnansultan@gmail.com
 * @Last Modified time: 2024-07-08 
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!function_exists('get_su_bitly_short_url')) {
    function get_su_bitly_short_url($post_id = null) {
        if (!$post_id) {
            global $post;
            $post_id = isset($post->ID) ? $post->ID : 0;
        }

        if (!$post_id) {
            return false;
        }

        $su_bitly_url = get_post_meta($post_id, '_su_bitly_shorturl', true);
        return $su_bitly_url ? $su_bitly_url : false;
    }
}

if (!function_exists('save_su_bitly_short_url')) {
    function save_su_bitly_short_url($shorten_url, $post_id = null) {
        if (!$post_id) {
            global $post;
            $post_id = isset($post->ID) ? $post->ID : 0;
        }

        if (!$post_id) {
            return false;
        }

        update_post_meta($post_id, '_su_bitly_shorturl', $shorten_url);
        do_action('su_bitly_shorturl_updated', $shorten_url);
    }
}

if (!function_exists('get_su_bitly_headers')) {
    function get_su_bitly_headers() {
        $su_settings = new SU_URLSettings();
        $access_token = $su_settings->get_su_bitly_access_token();

        $headers = array(
            "Host" => "api-ssl.bitly.com",
            "Authorization" => "Bearer " . $access_token,
            "Content-Type" => "application/json"
        );

        return $headers;
    }
}

if (!function_exists('su_write_log')) {
    function su_write_log($log) {
        if (true === WP_DEBUG) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }
}

if (!function_exists('su_get_template')) {
    function su_get_template($template_name, $template_path = '', $default_path = '') {
        $located = su_locate_template($template_name, $template_path, $default_path);

        if (!file_exists($located)) {
            _doing_it_wrong(__FUNCTION__, sprintf('<code>%s</code> does not exist.', esc_html($located)), SUBITLY_PLUGIN_VERSION);
            return;
        }

        include($located);
    }
}

if (!function_exists('su_locate_template')) {
    function su_locate_template($template_name, $default_path = '') {
        if (!$default_path) {
            $default_path = untrailingslashit(SUBITLY_PLUGIN_PATH) . '/templates/';
        }

        $template = $default_path . $template_name;
        return $template;
    }
}
