<?php
/**
 * Plugin Name: SU Share Widget
 * Description: A widget that displays share buttons for Facebook, LinkedIn, and Email.
 * Author: Zeppelin
 */
/**
 * @Author: Zeppelin
 * @Date:   2024-07-08 
 * @Last Modified by:   Zeppelin
 * @Website: https://github.com/madnansultandotme/Share-Url-Bitly-Plugin.git
 * @Email: info.adnansultan@gmail.com
 * @Last Modified time: 2024-07-08 
 */

class SU_Share_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'su_share_widget', 
            __('SU Share Widget', 'su-bitly'), 
            array('description' => __('A widget that displays share buttons for Facebook, LinkedIn, and Email', 'su-bitly'))
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        echo '<div class="su_social_share_buttons">';
        echo '<a href="https://www.facebook.com/sharer/sharer.php?u=' . urlencode(get_permalink()) . '" target="_blank" class="su_share_button su_facebook_share">
                <i class="fab fa-facebook-f"></i>
            </a>';
        echo '<a href="https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode(get_permalink()) . '" target="_blank" class="su_share_button su_linkedin_share">
                <i class="fab fa-linkedin-in"></i>
            </a>';
        echo '<a href="mailto:?subject=I wanted to share this post with you&body=' . urlencode(get_permalink()) . '" class="su_share_button su_email_share">
                <i class="fas fa-envelope"></i>
            </a>';
        echo '</div>';
        echo $args['after_widget'];
    }

    public function form($instance) {
        // Form options in the widget admin
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        return $instance;
    }
}

function register_su_share_widget() {
    register_widget('SU_Share_Widget');
}
add_action('widgets_init', 'register_su_share_widget');
