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

// stop unwanted visitors calling directly
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

function launch () {

	include_once nebula_EVENTS_DIR .'admin/pages/class-options.php';
	$my_options = new options_admin();
	add_action( 'admin_menu', array( $my_options, 'add_options_page' ) );

	require_once ( nebula_EVENTS_DIR . 'admin/class-welcome.php');
	$my_welcome = new welcome_class();

	$my_event_post_type = new event_post_type();

	if (is_admin()) {
  	include_once ( nebula_EVENTS_DIR . 'admin/class-admin-control.php');
    $my_control = new admin_control();
  }

	if (!is_admin()) {

 		include (nebula_EVENTS_DIR . 'user/pages/class-custom-meta-data.php');

		switch( $my_options->GetOption('single-layout')) {
			case 'content1';
				include nebula_EVENTS_DIR . 'user/pages/content-filter.php';
				$do_content = new event_content();
				break;
			case 'template1';
				include nebula_EVENTS_DIR . 'user/pages/post-type-templates.php';
				$post_templates = new custom_templates();
				break;
			}

	}



}
launch();



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
