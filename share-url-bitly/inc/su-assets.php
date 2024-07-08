<?php

function su_load_public_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('su-public-js', SUBITLY_PLUGIN_URL . 'assets/js/su-public.js', array('jquery'), SUBITLY_PLUGIN_VERSION, true);
    wp_enqueue_style('su-public-css', SUBITLY_PLUGIN_URL . 'assets/css/su-public.css', [], SUBITLY_PLUGIN_VERSION, 'all');
    wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'); // Include FontAwesome
    wp_localize_script('su-public-js', 'suJS', ['ajaxurl' => admin_url('admin-ajax.php')]);
}
add_action('wp_enqueue_scripts', 'su_load_public_scripts');

function su_load_admin_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('su-admin-js', SUBITLY_PLUGIN_URL . 'assets/js/su-bitly.js', array('jquery'), SUBITLY_PLUGIN_VERSION, true);
    wp_enqueue_style('su-admin-css', SUBITLY_PLUGIN_URL . 'assets/css/su-admin.css', [], SUBITLY_PLUGIN_VERSION, 'all');
    wp_localize_script('su-admin-js', 'suJS', ['ajaxurl' => admin_url('admin-ajax.php')]);
    wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'); // Include FontAwesome
}
add_action('admin_enqueue_scripts', 'su_load_admin_scripts');
