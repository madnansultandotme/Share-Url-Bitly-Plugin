<?php


/*
Plugin Name: Share URL Bitly
Plugin URI: https://github.com/madnansultandotme/Share-Url-Bitly-Plugin.git
Description: A plugin to shorten URLs using Bitly and add share buttons.
Version: 1.0.0
Author: Zeppelin Team
Author URI: https://github.com/madnansultandotme/Share-Url-Bitly-Plugin.git
 * @Author: Zeppelin
 * @Date:   2024-07-08 
 * @Last Modified by:   Zeppelin
 * @Website: https://github.com/madnansultandotme/Share-Url-Bitly-Plugin.git
 * @Email: info.adnansultan@gmail.com
 * @Last Modified time: 2024-07-08 
*License: GPLv2 or later
*Text Domain: su-bitly
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

define('SUBITLY_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('SUBITLY_PLUGIN_URL', plugin_dir_url(__FILE__));
define('SUBITLY_PLUGIN_VERSION', '1.09');
define('SUBITLY_API_URL', 'https://api-ssl.bitly.com');
define('SUBITLY_BASENAME', plugin_basename(__FILE__));
define('SUBITLY_SETTINGS_URL', admin_url('options-general.php?page=su-bitly'));

/**
 * Load Admin Assets
 */
require_once 'inc/su-assets.php';

/**
 * Load Util Functions
 */
require_once 'inc/su-util.php';

/**
 * Load Settings file
 */
require_once 'inc/su-settings.php';

/**
 * Load Bitly Integration
 */
require_once 'inc/su-integration.php';

/**
 * Load WordPress related hooks
 */
require_once 'inc/su-wp-functions.php';

/**
 * Meta Box
 */
require_once 'inc/su-metabox.php';

/**
 * Widget
 
 */
require_once 'inc/su-share-widget.php';

