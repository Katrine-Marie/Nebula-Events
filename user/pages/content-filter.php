<?php

namespace nebula\events;

class event_content {
    public function __construct() {
        add_filter( 'the_content', array($this,'filter_the_content_in_the_main_loop'));
        add_action( 'wp_enqueue_scripts', array($this,'content_style'),100 );
    }

    function filter_the_content_in_the_main_loop( $content ) {

        if ( is_single() && is_main_query() ) {
            if ( get_post_type( get_the_ID() ) == 'nebula-event') {
                wp_enqueue_style('user-content');
                   ob_start();
                    include nebula_EVENTS_DIR . 'user/pages/content_templates/event-page.php';
                    $msg = ob_get_contents();
                    ob_end_clean();
            }else {
							$msg = $content;
						}
            return  $msg;
        }
        // we are in the loop to will be called for each archive entry.
        if ( is_post_type_archive( 'nebula-event' ) ) {
            return  $content;
        }else {
					return $content;
				}
    }

    function content_style () {
        wp_register_style(
                'user-content',
                nebula_EVENTS_URL . 'user/css/content.css',
                array()
        );
    }

}
