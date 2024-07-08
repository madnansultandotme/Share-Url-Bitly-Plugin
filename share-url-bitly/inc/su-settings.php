<?php

class SU_URLSettings {
    private $bitly_url_options;

    public function __construct() {
        add_action('admin_menu', array($this, 'su_url_add_plugin_page'));
        add_action('admin_init', array($this, 'su_url_page_init'));
        add_action('init', array($this, 'su_redirect_to_get_guid'));
        add_action('admin_notices', array($this, 'show_success_when_getting_guid'));
        add_action('admin_notices', array($this, 'show_error_when_getting_guid'));
    }

    public function su_url_add_plugin_page() {
        add_management_page(
            'Share URL Bitly Settings',
            'Share URL Bitly',
            'manage_options',
            'su-bitly',
            array($this, 'su_url_create_admin_page')
        );
    }

    public function su_url_create_admin_page() {
        $this->bitly_url_options = get_option('su_url_option_name'); ?>
        <div class="wrap">
            <h2>Share URL Bitly Settings</h2>
            <?php settings_errors(); ?>
            <form method="post" action="options.php">
                <?php
                settings_fields('su_url_option_group');
                do_settings_sections('su-url-admin');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function su_url_page_init() {
        register_setting(
            'su_url_option_group',
            'su_url_option_name',
            array($this, 'su_url_sanitize')
        );

        add_settings_section(
            'su_url_setting_section',
            'Settings',
            array($this, 'su_url_section_info'),
            'su-url-admin'
        );

        add_settings_field(
            'access_token',
            'Access Token',
            array($this, 'access_token_callback'),
            'su-url-admin',
            'su_url_setting_section'
        );

        add_settings_field(
            'group_guid',
            'Group Guid',
            array($this, 'group_guid_callback'),
            'su-url-admin',
            'su_url_setting_section'
        );

        add_settings_field(
            'bitly_domain',
            'Domain (Optional)',
            array($this, 'bitly_domain_callback'),
            'su-url-admin',
            'su_url_setting_section'
        );

        add_settings_field(
            'su_socal_share',
            'Enable Social Share Button',
            array($this, 'add_su_social_share_button'),
            'su-url-admin',
            'su_url_setting_section'
        );

        add_settings_field(
            'su_custom_post',
            'Post Types',
            array($this, 'add_su_custom_posttype_settings'),
            'su-url-admin',
            'su_url_setting_section'
        );
    }

    public function su_url_sanitize($input) {
        $sanitary_values = array();
        if (isset($input['access_token'])) {
            $sanitary_values['access_token'] = sanitize_text_field($input['access_token']);
        }
        if (isset($input['group_guid'])) {
            $sanitary_values['group_guid'] = sanitize_text_field($input['group_guid']);
        }
        if (isset($input['bitly_domain'])) {
            $sanitary_values['bitly_domain'] = sanitize_text_field($input['bitly_domain']);
        }
        if (isset($input['su_socal_share'])) {
            $sanitary_values['su_socal_share'] = sanitize_text_field($input['su_socal_share']);
        }
        if (isset($input['su_custom_post'])) {
            $sanitary_values['su_custom_post'] = $input['su_custom_post'];
        }
        return $sanitary_values;
    }

    public function su_url_section_info() {}

    public function access_token_callback() {
        printf(
            '<input class="regular-text" type="text" name="su_url_option_name[access_token]" id="access_token" value="%s">',
            isset($this->bitly_url_options['access_token']) ? esc_attr($this->bitly_url_options['access_token']) : ''
        );
        echo '<p><small>Tutorial: </small><a href="https://www.zepallien.com/how-to-generate-bitly-oauth-access-token" target="_blank"><small>How to generate Bitly OAuth access token?</small></a></p>';
    }

    public function group_guid_callback() {
        $guid_url = admin_url('tools.php?page=su-bitly&su_guid=update');
        printf(
            '<input class="regular-text" type="text" name="su_url_option_name[group_guid]" id="group_guid" value="%s">',
            isset($this->bitly_url_options['group_guid']) ? esc_attr($this->bitly_url_options['group_guid']) : ''
        );
        echo "<a href='$guid_url' class='button button-primary'>Get GUID</a>";
        echo '<p><small>Save Access Token before getting GUID </small></p>';
    }

    public function bitly_domain_callback() {
        printf(
            '<input class="regular-text" type="text" placeholder="Default: bit.ly" name="su_url_option_name[bitly_domain]" id="bitly_domain" value="%s">',
            isset($this->bitly_url_options['bitly_domain']) ? esc_attr($this->bitly_url_options['bitly_domain']) : ''
        );
        echo '<p><small>Leave blank if you are in Free Plan</small></p>';
    }

    public function add_su_social_share_button() {
        $su_social_share = '';
        if (isset($this->bitly_url_options['su_socal_share'])) {
            $su_social_share = $this->bitly_url_options['su_socal_share'] == "enable" ? "checked" : '';
        }
        printf('<label><input name="su_url_option_name[su_socal_share]" id="su_socal_share" type="checkbox" value="enable" %s> Enable </label>', $su_social_share);
        echo '<p><small>If you enable this you can share the link from your post list/edit screen.</small></p>';
    }

    public function add_su_custom_posttype_settings() {
        $post_types = get_post_types(array('public' => true));
        $current_post_types = [];

        if (isset($this->bitly_url_options['su_custom_post'])) {
            $current_post_types = $this->bitly_url_options['su_custom_post'];
        }

        $output = '<fieldset><legend class="screen-reader-text"><span>Post Types</span></legend>';
        foreach ($post_types as $label) {
            $random = rand();
            $input_label = $label . '_' . $random;
            $output .= '<label for="' . $input_label . '">' . '<input id="' . $input_label . '" type="checkbox" name="su_url_option_name[su_custom_post][]" value="' . $label . '" ' . checked(in_array($label, $current_post_types), true, false) . '>' . $label . '</label><br>';
        }
        echo $output;
    }

    public function su_redirect_to_get_guid() {
        if (current_user_can('administrator')) {
            $queryParam = 'su-bitly';
            $queryParamDecoded = isset($_GET['page']) ? urldecode($_GET['page']) : '';
            if ($queryParam == $queryParamDecoded) {
                if (isset($_GET['su_guid']) && urldecode($_GET['su_guid']) == "update") {
                    $status = $this->su_save_bitly_guid();
                    if ($status) {
                        set_transient('su_guid_success', true, 5);
                    } else {
                        set_transient('su_guid_error', true, 5);
                    }
                    wp_redirect(SUBITLY_SETTINGS_URL);
                    die();
                }
            }
        }
    }

    public function su_save_bitly_guid() {
        $access_token = $this->get_su_bitly_access_token();
        if (!$access_token) {
            return false;
        }
        $guid = $this->su_get_bitly_guid_request($access_token);
        if (!$guid) {
            return false;
        }
        $bitly_url_options_from_db = get_option('su_url_option_name');
        $bitly_url_options_from_db['group_guid'] = trim($guid);
        update_option('su_url_option_name', $bitly_url_options_from_db, true);
        return true;
    }

    public function su_get_bitly_guid_request($access_token) {
        $response = false;
        try {
            $headers = array(
                "Host" => "api-ssl.bitly.com",
                "Authorization" => "Bearer " . $access_token,
                "Content-Type" => "application/json"
            );

            $http_response = wp_remote_get(SUBITLY_API_URL . '/v4/groups', array(
                'timeout' => 0,
                'headers' => $headers
            ));

            if (!is_wp_error($http_response)) {
                $response_array = json_decode($http_response['body']);
                $groups = isset($response_array->groups) ? $response_array->groups : [];
                $guid = isset($groups[0]->guid) ? $groups[0]->guid : '';
                $response = $guid;
            } else {
                $error = $http_response->get_error_message();
                error_log($error, 3, plugin_dir_path(__FILE__) . 'error.log');
            }
        } catch (Exception $e) {
            error_log('Unable to get Bitly GUID', 3, plugin_dir_path(__FILE__) . 'debug.log');
        }
        return $response;
    }

    public function show_success_when_getting_guid() {
        if (get_transient('su_guid_success')) {
            ?>
            <div class="notice notice-success is-dismissible">
                <p><?php _e('Group Guid Successfully Saved', 'su-bitly'); ?></p>
            </div>
            <?php
            delete_transient('su_guid_success');
        }
    }

    public function show_error_when_getting_guid() {
        if (get_transient('su_guid_error')) {
            ?>
            <div class="notice notice-error is-dismissible">
                <p><?php _e('Unable to get Group Guid, please check your Access Token', 'su-bitly'); ?></p>
            </div>
            <?php
            delete_transient('su_guid_error');
        }
    }

    public function get_su_bitly_access_token() {
        $bitly_url_options_from_db = get_option('su_url_option_name');
        $access_token = isset($bitly_url_options_from_db['access_token']) ? $bitly_url_options_from_db['access_token'] : '';
        return $access_token ? trim($access_token) : false;
    }

    public function get_su_bitly_guid() {
        $bitly_url_options_from_db = get_option('su_url_option_name');
        $guid = isset($bitly_url_options_from_db['group_guid']) ? $bitly_url_options_from_db['group_guid'] : '';
        return $guid ? trim($guid) : false;
    }

    public function get_su_bitly_domain() {
        $bitly_url_options_from_db = get_option('su_url_option_name');
        $domain = isset($bitly_url_options_from_db['bitly_domain']) ? $bitly_url_options_from_db['bitly_domain'] : '';
        return $domain ? trim($domain) : "bit.ly";
    }

    public function get_su_social_share_status() {
        $bitly_url_options_from_db = get_option('su_url_option_name');
        $su_social_share = isset($bitly_url_options_from_db['su_socal_share']) ? $bitly_url_options_from_db['su_socal_share'] : '';
        return $su_social_share === "enable" ? true : false;
    }

    public function get_su_active_post_status() {
        $bitly_url_options_from_db = get_option('su_url_option_name');
        $active_post_types = isset($bitly_url_options_from_db['su_custom_post']) ? $bitly_url_options_from_db['su_custom_post'] : ['post'];
        return $active_post_types;
    }
}

new SU_URLSettings();
