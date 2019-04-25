<?php

namespace nebula\events;

if (!class_exists('event_post_type')) {

    class event_post_type {

        public function __construct()  {

        add_action( 'init', array($this, 'register_event_post_type') );

        }
        /**
         * Register the custom post type.
         *
         * @since 1.0.0
         *
         * @return void
         */
        function register_event_post_type() {
        $labels = array(
                        'name'               => _x( 'Events', 'post type general name', 'eventsnebula' ),
                        'singular_name'      => _x( 'Event', 'post type singular name', 'eventsnebula' ),
                        'menu_name'          => _x( 'Events', 'admin menu', 'eventsnebula' ),
                        'name_admin_bar'     => _x( 'Event', 'add new on admin bar', 'eventsnebula' ),
                        'add_new'            => _x( 'Add New', 'event', 'eventsnebula' ),
                        'add_new_item'       => __( 'Add New Event', 'eventsnebula' ),
                        'new_item'           => __( 'New Event', 'eventsnebula' ),
                        'edit_item'          => __( 'Edit Event', 'eventsnebula' ),
                        'view_item'          => __( 'View Event', 'eventsnebula' ),
                        'all_items'          => __( 'All Events', 'eventsnebula' ),
                        'search_items'       => __( 'Search Events', 'eventsnebula' ),
                        'parent_item_colon'  => __( 'Parent Events:', 'eventsnebula' ),
                        'not_found'          => __( 'No events found.', 'eventsnebula' ),
                        'not_found_in_trash' => __( 'No events found in Trash.', 'eventsnebula' ),
                        'featured_image' => __( 'Event Image', 'eventsnebula' )
                );

        $args = array(

                        'labels'             => $labels,
                        'description'        => __( 'Description.', 'eventsnebula' ),
                        'public'             => true,
                        'publicly_queryable' => true,
                        'show_ui'            => true,
                        'show_in_menu'       => true,
                        'show_in_nav_menus'  => true,
                        'query_var'          => true,
                        'rewrite'            => array( 'slug' => 'event' ),
                        'capability_type'    => 'post',
                        'has_archive'        => true,
                        'hierarchical'       => true,
                        'menu_position'      => null,
                        'supports'           => array( 'title', 'editor', 'thumbnail' )
                );


                register_post_type( 'nebula-event', $args );

        }

    }
}
