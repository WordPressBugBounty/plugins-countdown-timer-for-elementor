<?php
/**
 * Plugin Name: Countdown Timer for Elementor
 * Description: Showcase a countdown timer for your next upcoming event or offers with elementor page builder.
 * Plugin URI: https://flickdevs.com/elementor/
 * Author: FlickDevs
 * Version: 1.3.6
 * Elementor tested up to: 3.19.0
 * Author URI: https://flickdevs.com
 *
 * Text Domain: countdown-timer-for-elementor
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

define('COUNTDOWN_TIMER_ELEMENTOR_URL', plugins_url('/', __FILE__));  // Define Plugin URL
define('COUNTDOWN_TIMER_ELEMENTOR_PATH', plugin_dir_path(__FILE__));  // Define Plugin Directory Path
define('CTW_DOMAIN', 'countdown-timer-for-elementor');

/*
 * Load the plugin Category
 */
require_once COUNTDOWN_TIMER_ELEMENTOR_PATH . 'inc/elementor-helper.php';

/*
 * Register the widgtes file in elementor widgtes.
 */
function countdown_timer_widget_register() {
    require_once COUNTDOWN_TIMER_ELEMENTOR_PATH . 'widgets/countdown-timer-widget.php';
}
//abc add_action('elementor/widgets/widgets_registered', 'countdown_timer_widget_register');

add_action('elementor/widgets/register', 'countdown_timer_widget_register');
/*
 * Load countdown timer scripts and styles
 * @since v1.0.0
 */
function countdown_timer_widget_scripts() {
    wp_enqueue_script('countdown-timer-script', COUNTDOWN_TIMER_ELEMENTOR_URL . 'assets/js/jquery.countdownTimer.js', array('jquery'), '1.0.0', true);
  
	
    wp_enqueue_style('countdown-timer-style', COUNTDOWN_TIMER_ELEMENTOR_URL . 'assets/css/countdown-timer-widget.css', true);
	
	wp_register_style( 'fontawesome-all-css', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.css', array(), '5.15.4' );
	
	
}
add_action('wp_enqueue_scripts', 'countdown_timer_widget_scripts');

/**
 *   Check the elementor current version.
 */
function countdown_timer_plugin_load() {
    load_plugin_textdomain('CTE_DOMAIN');

    if (!did_action('elementor/loaded')) {
        add_action('admin_notices', 'countdown_timer_widget_fail_load');
        return;
    }
    $elementor_version_required = '2.6.0';
    if (!version_compare(ELEMENTOR_VERSION, $elementor_version_required, '>=')) {
        add_action('admin_notices', 'countdown_timer_elementor_update_notice');
        return;
    }
}
add_action('plugins_loaded', 'countdown_timer_plugin_load');


/**
 * This notice will appear if Elementor is not installed or activated or both
 */
function countdown_timer_widget_fail_load() {
    $screen = get_current_screen();
    if (isset($screen->parent_file) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id) {
        return;
    }

    $plugin = 'elementor/elementor.php';

    if (_is_elementor_installed()) {
        if (!current_user_can('activate_plugins')) {
            return;
        }
        $activation_url = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin);

        $message = '<p>' . __('<strong>Countdown Timer<strong> widgets not working because you need to activate the Elementor plugin.', CTW_DOMAIN) . '</p>';
        $message .= '<p>' . sprintf('<a href="%s" class="button-primary">%s</a>', $activation_url, __('Activate Elementor Now', CTW_DOMAIN)) . '</p>';
    } else {
        if (!current_user_can('install_plugins')) {
            return;
        }

        $install_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=elementor'), 'install-plugin_elementor');

        $message = '<p>' . __('<strong>Countdown Timer</strong> widgets not working because you need to install the Elemenor plugin', CTW_DOMAIN) . '</p>';
        $message .= '<p>' . sprintf('<a href="%s" class="button-primary">%s</a>', $install_url, __('Install Elementor Now', CTW_DOMAIN)) . '</p>';
    }

    echo '<div class="error"><p>' . $message . '</p></div>';
}

/**
 * Display admin notice for elementor update if elementor version is old
 */
function countdown_timer_elementor_update_notice() {
    if (!current_user_can('update_plugins')) {
        return;
    }

    $file_path = 'elementor/elementor.php';

    $upgrade_link = wp_nonce_url(self_admin_url('update.php?action=upgrade-plugin&plugin=') . $file_path, 'upgrade-plugin_' . $file_path);
    $message = '<p>' . __('<strong>Countdown Timer</strong> widgets not working because you are using an old version of Elementor.', CTW_DOMAIN) . '</p>';
    $message .= '<p>' . sprintf('<a href="%s" class="button-primary">%s</a>', $upgrade_link, __('Update Elementor Now', CTW_DOMAIN)) . '</p>';
    echo '<div class="error">' . $message . '</div>';
}

if (!function_exists('_is_elementor_installed')) {

    function _is_elementor_installed() {
        $file_path = 'elementor/elementor.php';
        $installed_plugins = get_plugins();

        return isset($installed_plugins[$file_path]);
    }

}

/**
 * Add reviews metadata  on plugin activation
 */
function countdown_timer_plugin_activation() {
    $notices = get_option('countdown_timer_reviews', array());
    $notices[] = '<p>Hi, you are now using <strong>Countdown Timer</strong> plugin. I would really appreciate it if you could give me the five star to our plugin. </p><p><a href="https://wordpress.org/plugins/" target="_blank" class="rating-link"><strong> Yes, you deserv it </strong></a></p>';
    update_option('countdown_timer_reviews', $notices);
}
register_activation_hook(__FILE__, 'countdown_timer_plugin_activation');

/**
 * Display admin notice on countdown timer activation for ratings
 */
add_action('admin_notices', 'countdown_timer_reviews_notices');

function countdown_timer_reviews_notices() {
    if ($notices = get_option('countdown_timer_reviews')) {
        foreach ($notices as $notice) {
            echo "<div class='notice notice-success is-dismissible'><p>$notice</p></div>";
        }
        delete_option('countdown_timer_reviews');
    }
}

/**
 * Remove reviews metadata on plugin deactivation.
 */
register_deactivation_hook(__FILE__, 'countdown_timer_plugin_deactivation');
function countdown_timer_plugin_deactivation() {
    delete_option('countdown_timer_reviews');
}

add_action( 'wp_enqueue_scripts', 'prefix_enqueue_awesome' );
/**
 * Register and load font awesome CSS files using a CDN.
 */
function prefix_enqueue_awesome() {
//wp_enqueue_style( 'font-awesome-5', COUNTDOWN_TIMER_ELEMENTOR_URL . 'assets/fonts', array(),'5.3.0');
}