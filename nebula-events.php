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

// include any post types we need defined
include_once ( nebula_EVENTS_DIR . 'init/class-event-post-type.php');


$startup = new Initialization();















/*******************************************************************************/
/*
 * Initiate the plugin routines.
 * keep with root file.
 */
class Initialization{

    public function __construct(){
        register_activation_hook( __FILE__, array($this, 'plugin_activated' ));
        register_deactivation_hook( __FILE__, array($this, 'plugin_deactivated' ));
        register_uninstall_hook( __FILE__, array($this, 'plugin_uninstall' ) );
    }

    public static function plugin_activated(){
        set_transient(nebula_EVENTS_transient, true,30);

        $register_post_type = new event_post_type();
        $register_post_type->register_event_post_type();
        flush_rewrite_rules();
    }
    public function plugin_deactivated(){
        delete_transient( nebula_EVENTS_transient );
    }
    public function plugin_uninstall() {
        delete_transient( nebula_EVENTS_transient );
    }
}
