<?php
/**
 * Plugin Name: Nebula Events
 * Description: Easy event management in Wordpress
 * Version:     1.0.0
 * Author:      Katrine-Marie Burmeister
 * Author URI:  https://fjordstudio.dk
 * Text Domain: events-nebula
 * License:     GNU General Public License v3.0
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */

// plugin namespace to keep code seperated
namespace nebula\events;

// stop unwatned visitors calling directly
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Go away!' );
}

$myplugin_url = plugin_dir_url(__FILE__);
if ( is_ssl() ) {
  $myplugin_url = str_replace('http://', 'https://', $myplugin_url);
}

define ( 'nebula_EVENTS_URL', $myplugin_url);
define ( 'nebula_EVENTS_DIR', plugin_dir_path( __FILE__));
define ( 'nebula_EVENTS_VERS', '1.0.0');
define ( 'nebula_EVENTS_transient', '_nebula_events_welcome' );
