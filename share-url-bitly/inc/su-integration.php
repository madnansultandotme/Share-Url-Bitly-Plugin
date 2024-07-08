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

function su_generate_shorten_url($long_url) {
    $su_settings = new SU_URLSettings();
    $access_token = $su_settings->get_su_bitly_access_token(); // Get access token from settings

    if (!$access_token) {
        return array('error' => true, 'message' => 'Access token is missing');
    }

    $api_url = 'https://api-ssl.bitly.com/v4/shorten';

    $data = array(
        'long_url' => $long_url,
        'domain' => 'bit.ly'
    );

    $response = wp_remote_post($api_url, array(
        'method' => 'POST',
        'headers' => array(
            'Authorization' => 'Bearer ' . $access_token,
            'Content-Type' => 'application/json',
        ),
        'body' => json_encode($data),
    ));

    if (is_wp_error($response)) {
        return array('error' => true, 'message' => $response->get_error_message());
    } else {
        $body = json_decode($response['body'], true);
        return isset($body['link']) ? array('error' => false, 'link' => $body['link']) : array('error' => true, 'message' => 'Unknown error');
    }
}

if (!function_exists('generate_su_bitly_url_via_ajax')) {
    function generate_su_bitly_url_via_ajax() {
        if (!isset($_POST['post_id'])) {
            echo json_encode(['status' => false, 'message' => 'Post ID not provided']);
            die();
        }

        $post_id = (int) $_POST['post_id'];
        $permalink = get_permalink($post_id);

        if (!$permalink) {
            echo json_encode(['status' => false, 'message' => 'Invalid post ID']);
            die();
        }

        $bitly_link_data = su_generate_shorten_url($permalink);

        if ($bitly_link_data['error']) {
            echo json_encode(['status' => false, 'message' => $bitly_link_data['message']]);
            die();
        }

        $bitly_link = $bitly_link_data['link'];

        if ($bitly_link) {
            save_su_bitly_short_url($bitly_link, $post_id);
        }

        $bitly_link_html = '<div class="su_tooltip su copy_bitly">
            <p><span class="copy_bitly_link">' . $bitly_link . '</span> <span class="su_tooltiptext">Click to Copy</span></p>
        </div>';

        echo json_encode(['status' => true, 'bitly_link_html' => $bitly_link_html]);
        die();
    }
    add_action('wp_ajax_generate_su_bitly_url_via_ajax', 'generate_su_bitly_url_via_ajax');
}