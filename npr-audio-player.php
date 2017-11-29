<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://labs.inn.org
 * @since             1.0.0
 * @package           NPR_Audio_Player
 *
 * @wordpress-plugin
 * Plugin Name:       NPR Audio Player
 * Plugin URI:        https://labs.inn.org/tools/npr-audio-player
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            INN Labs
 * Author URI:        https://labs.inn.org
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       npr-audio-player
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-npr-audio-player-activator.php
 */
function activate_npr_audio_player() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-npr-audio-player-activator.php';
	Npr_Audio_Player_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-npr-audio-player-deactivator.php
 */
function deactivate_npr_audio_player() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-npr-audio-player-deactivator.php';
	Npr_Audio_Player_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_npr_audio_player' );
register_deactivation_hook( __FILE__, 'deactivate_npr_audio_player' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-npr-audio-player.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_npr_audio_player() {

	$plugin = new Npr_Audio_Player();
	$plugin->run();

}
run_npr_audio_player();

/**
 * Registers the audio player widget
 */
require_once( 'includes/widget.php' );

add_action( 'widgets_init', function() { register_widget( 'npr_audio_widget' ); } );

/**
 * Registers the audio player settings
 */
require_once( 'includes/settings.php' );
new NPR_Audio_Player_Settings();

?>
