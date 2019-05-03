<?php

namespace nebula\events;

class welcome_class {
    public function __construct()  {
        // Bail if activating from network, or bulk
        if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
            return;
        }
        add_action( 'admin_init', array($this,'welcome_do_activation_redirect') );
        // add to menu
        add_action('admin_menu', array($this, 'welcome_pages') );
        add_action('admin_head', array($this, 'welcome_remove_menus' ) );
    }


    public function welcome_do_activation_redirect() {
      // Bail if no activation redirect
        if ( ! get_transient( '_nebula_events_welcome' ) ) {
            return;
          }
      // Redirect
      wp_safe_redirect( add_query_arg( array( 'page' => 'nebula-event-about' ), admin_url( 'index.php' ) ) );
    }


    /*
     * add a menu item
     */
    public function welcome_pages() {
      add_dashboard_page(
        'Plugin Welcome',
        'Plugin Welcome',
        'read',
        'nebula-event-about',
        array( $this,'welcome_content')
      );
    }

    public function welcome_remove_menus() {
        remove_submenu_page( 'index.php', 'nebula-event-about' );
    }



    /*
     * The Welcome screen
     */
    public static function welcome_content() {
        include(  nebula_EVENTS_DIR . '/admin/views/welcome_content.php' );
        include (  nebula_EVENTS_DIR . '/admin/views/admin-footer.php' );

        // now page is seen you can delete the transient
        delete_transient( '_nebula_events_welcome' );
    }



}
