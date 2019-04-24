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
