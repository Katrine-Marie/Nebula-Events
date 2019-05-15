<?php

namespace nebula\events;

include_once nebula_EVENTS_DIR .'common/class-common.php';

if (!class_exists('options_admin')) {


    class options_admin extends \nebula\common\nebula_Common {

        public function __construct()  {
            global $pagenow;
            // data array for active values
            $this->nebula_options = array();
            // data array for default values
            $this->nebula_default_options = array();
            // prefix for all variables
            $this->nebula_prefix = 'nebulaev_';
            // name of data record in wp_options
            $this->nebula_data = 'nebula-events-options';
            // used for style sheet reg
            $this->myname = 'nebula_events_options';
            // used to seed the setting page nonce field value
            $this->mynonce = 'nebula-demo-settings-save';
            // field name for nonce field
            $this->nonce_field = 'nebula-custom-message';
            // name of options page in url
            $this->mypage = 'events-options-page';
            // name of the form post action
            $this->myaction = 'nebula_event_settings';
            // add the menu if not setup elsewhere
            // add_action( 'admin_menu', array( $options_admin, 'add_options_page' ) );
            add_action( 'admin_post_'.$this->myaction, array( $this, 'validate_options' ) );
            // only call enqueue when our page is being called.
            if (($pagenow == 'options-general.php' ) && ( $_GET["page"] == $this->mypage )) {
                       }
                add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
                add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

            $this->LoadOptions();
            $this->UpgradeOptions();
        }

        /*
         * content of options page
         */
        public function options_page_html()
        {
            // check user capabilities
            if (!current_user_can('manage_options')) {
                return;
            }
            wp_enqueue_style($this->myname);

            wp_enqueue_script($this->myname);

            include (  nebula_EVENTS_DIR . '/admin/views/options-html.php' );
            include (  nebula_EVENTS_DIR . '/admin/views/admin-footer.php' );
        }
        /*
         * create the options menu item
         */
        public function add_options_page() {
        add_options_page(
                'Events Option Page',                   // title
                'Events Settings',                      // menu slug
                'manage_options',                       // admin level
                $this->mypage,                          // page name
                array( $this, 'options_page_html' )     // function called
        );
    }
         /**
         *  Setup all initial/default values in a table
         */
        function InitOptions() {
            // set a default version number
            // add in all default value fields here
            // then saved values will be loaded on top.
            $this->nebula_default_options[$this->nebula_prefix . 'version'] = 1.0;
            $this->nebula_default_options[$this->nebula_prefix . 'user-checkbox'] = 0;
            $this->nebula_default_options[$this->nebula_prefix . 'plugin-serial'] = 'hello';
            $this->nebula_default_options[$this->nebula_prefix . 'single-layout'] = 'Shortcode';
            }
        /**
         * Upgrade data from old version
         * change or introduce new value from releases
         */
        function UpgradeOptions() {
            if ( $this->nebula_options[$this->nebula_prefix . 'version'] < 1.0) {
                $this->nebula_options[$this->nebula_prefix . 'version'] = '1.0';

            }
        }


        public function validate_options() {
            foreach ( $this->nebula_default_options as $key => $value) {
                $targ = substr($key, strlen($this->nebula_prefix));
                switch ($targ) {
                    case 'string':
                    case 'version':
                    case 'user-number':
                    case 'plugin-serial':
                    case 'single-layout':

                        $this->nebula_options[$key] = sanitize_text_field($_POST[$targ]);
                        break;
                    case 'checkbox';
                    case 'user-checkbox';
                        if (isset($_POST[$targ])) {
                            $this->nebula_options[$key] = 1;
                        }   else $this->nebula_options[$key] = 0;
                        break;
                }
           }
           $this->Save_Options($this->nebula_data, $this->nebula_options);
        }
    /**
     * Registers the stylesheets or options page
     *
     * @since 0.2.0
     */
    public function enqueue_styles() {

            wp_register_style(
                    $this->myname,
                    nebula_EVENTS_URL . 'admin/css/options.css',
                    array()
            );


    }

    public function enqueue_scripts() {
            // wp_enqueue_media();
    }
}
}
