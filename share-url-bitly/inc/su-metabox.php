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

function su_add_meta_box_to_post_types() {
    $su_settings = new SU_URLSettings();
    $active_post_types = $su_settings->get_su_active_post_status();

    foreach ($active_post_types as $post_type) {
        add_meta_box(
            'su-bitly-url-metabox',
            __( 'Bitly Short URL', 'su-bitly' ),
            'su_add_meta_box_content',
            $post_type,
            'side',
            'default'
        );
    }
}
add_action('add_meta_boxes', 'su_add_meta_box_to_post_types');

function su_add_meta_box_content($post) {
    $post_id = $post->ID;

    if ('publish' != get_post_status($post_id)) {
        echo '<h4>Publish to Generate Bitly URL<h4>';
        return;
    }

    $su_settings = new SU_URLSettings();
    $access_token = $su_settings->get_su_bitly_access_token();
    $guid = $su_settings->get_su_bitly_guid();

    if (!$access_token || !$guid) {
        $plugin_url = admin_url('tools.php?page=su-bitly');
        echo '<a class="su_settings" href="' . $plugin_url . '">Get Started</a>';
    } else {
        echo '<div class="su_metabox_container su-mt-5">';

        $bitly_url = get_su_bitly_short_url($post_id);
        if ($bitly_url) {
            ?>
            <div class="su_tooltip su copy_bitly">
                <p><span class="copy_bitly_link su-meta-bg-link"><?php echo $bitly_url; ?></span> <span class="su_tooltiptext">Click to Copy</span></p>
            </div>
            <?php

            $su_social_share_status = $su_settings->get_su_social_share_status();

            if ($su_social_share_status) {
                su_get_template('share.php');
            }
        } else {
            ?>
            <div class="su_tooltip">
                <p><?php echo $bitly_url; ?></p>
                <button class="su generate_bitly" data-post_id="<?php echo $post_id; ?>">
                    <span class="su_tooltiptext">Click to Generate</span>Generate URL
                </button>
            </div>
            <?php
        }

        echo "</div>";
    }
}

function add_su_shortlink_frontend($wp_admin_bar) {
    $su_settings = new SU_URLSettings();
    $active_post_types = $su_settings->get_su_active_post_status();
    $default_roles = ['administrator'];
    $allowed_roles = apply_filters('su_script_for_allowed_roles', $default_roles);

    foreach ($allowed_roles as $role) {
        if (current_user_can($role)) {
            foreach ($active_post_types as $post_type) {
                if (is_singular($post_type)) {
                    global $post;

                    $post_id = $post->ID;
                    $bitly_url = get_su_bitly_short_url($post_id);

                    if ($bitly_url) {
                        $args = array(
                            'id' => 'su_link' . $post_id,
                            'title' => 'Click to Copy Bitly Link',
                            'href' => $bitly_url,
                            'meta' => array(
                                'class' => 'su-copy-class',
                                'title' => 'Click to Copy Bitly Link',
                            )
                        );

                        $wp_admin_bar->add_node($args);
                    }
                }
            }
        }
    }
}
add_action('admin_bar_menu', 'add_su_shortlink_frontend', 999);
