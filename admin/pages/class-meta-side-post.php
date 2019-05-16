<?php

namespace nebula\events;

if (!class_exists('side_meta_post')) {

    class side_meta_post {

        public function __construct ()  {
            $this->meta_options = array();
            $this->default_meta_options = array();
            $this->nebula_prefix = 'apcdem_';
            $this->nebula_data_name = 'meta-side-options';
            add_action( 'add_meta_boxes', array($this,'create_meta_boxes' ));
            add_action( 'admin_enqueue_scripts', array($this,'enqueue_styles')  );
            add_action( 'admin_enqueue_scripts', array($this,'enqueue_scripts') );
            add_action( 'save_post', array($this,'save_complex_metabox'), 10, 3);
        }
        /*
         *  Setup all initial/default values in a table
         */
        function InitOptions () {
            // set a default version number
            // add in all default value fields here
            // then saved values will be loaded on top.
            $this->default_meta_options[$this->nebula_prefix . 'version'] = 1.0;
            $this->default_meta_options[$this->nebula_prefix . 'event_date'] = '';
            $this->default_meta_options[$this->nebula_prefix . 'time_start'] = '';
            $this->default_meta_options[$this->nebula_prefix . 'time_end'] = '';
            $this->default_meta_options[$this->nebula_prefix . 'allday'] = '0';
            $this->default_meta_options[$this->nebula_prefix . 'no_end'] = '0';
            $this->default_meta_options[$this->nebula_prefix . 'date_sort'] = '';

            }
        /**
         * Upgrade data from old version
         * change or introduce new value from releases
         */
        function UpgradeOptions () {
            if ( $this->meta_options[$this->nebula_prefix . 'version'] < 1.0) {
                 $this->meta_options[$this->nebula_prefix . 'version'] = '1.0';
            }
        }
        /**
         *  Loads options from database.
         * loops through Only values that already known in the settings.
         * and laods any stored values
         * update_post_meta($post_id, $this->nebula_data_name, $this->meta_options);
         * get_post_meta($post->ID, $this->nebula_data_name, true))
         */
        function LoadOptions () {
            global $post;
            $this->InitOptions();
            // load default values
            foreach ($this->default_meta_options as $key => $value) {
                $this->meta_options[$key] = $value;
            }
            // bring in loaded values
            $storedoptions = get_post_meta($post->ID, $this->nebula_data_name, true);
            if ($storedoptions && is_array($storedoptions)) {
                foreach ($storedoptions as $key => $value) {
                    $this->meta_options[$key] = $value;
                }
            } else
               //update_option($this->nebula_data_name, $this->nebula_default_options);
                update_post_meta($post->ID, $this->nebula_data_name, $this->default_meta_options);
        }
        /*
         * add_meta_box( string $id, string $title, callable $callback, string|array|WP_Screen $screen = null, string $context = 'advanced', string $priority = 'default', array $callback_args = null )
         */
        public function create_meta_boxes() { // add the meta box
            $this->LoadOptions ();
            $this->UpgradeOptions ();
            // string: box name, string: title, Callback, register_post_type: name given
            add_meta_box( 'event_side_metabox', 'Event Date/Time',  array($this,'array_metabox'), 'nebula-event', 'side','high' );

            }

        public function array_metabox($object) {
            wp_enqueue_style('event_meta_admin');
            wp_enqueue_script('event_meta_admin');
            wp_enqueue_script('events_timepicker');
            wp_enqueue_style('jquery_ui');
            wp_enqueue_style( 'timepicker');
            include_once(  nebula_EVENTS_DIR . '/admin/views/meta-dates.php' );
            // include_once(  nebula_EVENTS_DIR . '/admin/views/meta/meta-accord.php' );

            // Noncename needed to verify where the data originated
            echo '<input type="hidden" name="meta-side-nonce" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
            //        wp_nonce_field(plugin_basename(__FILE__), "meta-box-nonce");
                }

        public function save_complex_metabox($post_id, $post, $update)
        {

        // basename will not wotrk if reacted nonce is different file (it is code above^^^
         if (!isset( $_POST["meta-side-nonce"]) || !wp_verify_nonce($_POST["meta-side-nonce"], plugin_basename(__FILE__)) )
        // if (!isset( $_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], 'event-meta-box' ) )
                return $post_id;

            if(!current_user_can("edit_post", $post_id))
                return $post_id;

            if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
                return $post_id;
            // must be post type slug
            $slug = "nebula-event";
            if($slug != $post->post_type)
                return $post_id;
          /*
           * now it is safe to save data. but will we save each field into its own data record, or put them all in an array.
           * we must load the defaults as this is a new page request
           */
            $this->InitOptions();
            foreach ( $this->default_meta_options as $key => $value) {
                $targ = substr($key, strlen($this->nebula_prefix));

                switch ($targ) {
                    case 'string';
                    case 'version';
                    case 'event_date';
                    case 'time_start';
                    case 'time_end';
                    case 'date_sort';
                        $this->meta_options[$key] = sanitize_text_field($_POST[$targ]);
                        break;
                    case 'checkbox';
                    case 'allday';
                    case 'no_end';
                        if (isset($_POST[$targ])) {
                            $this->meta_options[$key] = 1;
                        }   else $this->meta_options[$key] = 0;
                        break;
                }
           }
            update_post_meta($post_id, $this->nebula_data_name, $this->meta_options);

        }





        /**
         * Registers the JavaScript for handling the media uploader.
         *
         * @since 0.1.0
         */
        public function enqueue_scripts() {
            wp_register_script('event_meta_admin', nebula_EVENTS_URL . 'admin/jscript/meta-admin.js',
                array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker','jquery-ui-accordion','jquery-ui-tabs'), '1.0', 'all'
                );
            wp_register_script('events_timepicker', nebula_EVENTS_URL . 'admin/jscript/jquery.timepicker.min.js',
            array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'), '1.0', 'all'
            );
        }
        /**
         * Registers the stylesheets for handling the meta box
         *
         * @since 0.2.0
         * keep names so duplicates will be caught
         */
        public function enqueue_styles() {
                wp_register_style(
                        'event_meta_admin', nebula_EVENTS_URL . '/admin/css/meta.css', array()
                );
                wp_register_style(
                         'jquery_ui', nebula_EVENTS_URL . 'admin/css/jquery-ui.css', array()
                );
                wp_register_style( 'timepicker', nebula_EVENTS_URL . 'admin/css/jquery.timepicker.css', array() );

       }


           /**
            *  Returns option value for given key
            *  from array already loaded
            */
           public function GetMetaOption($key) {
               $key = $this->nebula_prefix . $key;
               if (array_key_exists($key, $this->meta_options)) {
                   return $this->meta_options[$key];
               } else
                   return null;
           }
        /*
         * For checkboxes:
         * @returns checked if value is active
         */
        public function GetMetaCheckbox($key) {
            $key = $this->nebula_prefix . $key;
            if (array_key_exists($key, $this->meta_options)) {
                if ($this->meta_options[$key]==1) {
                    return 'checked';
                } else return;
            } else
                return $key;
        }



    } //end Class

}
