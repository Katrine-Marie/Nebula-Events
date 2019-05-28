<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace nebula\events;


class event_content {
    public function __construct() {
        add_filter( 'the_content', array($this,'filter_the_content_in_the_main_loop'));
        add_action( 'wp_enqueue_scripts', array($this,'content_style'),100 );
    }


    /*
     * Note that you are filtering the content of the main loop. That means for almost all themes -
     the Header title is already out there !!!!
     */

    function filter_the_content_in_the_main_loop( $content ) {



        // Check if we're inside the main loop in a single post page.

        if ( is_single() && in_the_loop() && is_main_query() ) {
            if ( get_post_type( get_the_ID() ) == 'nebula-event') {
                wp_enqueue_style('user-content');
                   ob_start();
                    include nebula_EVENTS_DIR . 'user/pages/content_templates/event-page.php';
                    $msg = ob_get_contents();
                    ob_end_clean();
            }
            return  $msg;

        }
        // we are in the loop to will be called for each archive entry.
        if ( is_post_type_archive( 'nebula-event' ) ) {
            return  'archive' .  $content;
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


    
