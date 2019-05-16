<?php

namespace nebula\events;

if (!class_exists('table_meta_post')) {

    class table_meta_post {

        public function __construct ()  {
            $this->meta_options = array();
            $this->default_meta_options = array();
            $this->nebula_prefix = 'apcdem_';
            $this->nebula_data_name = 'meta-array-options';
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
            // Location
            $this->default_meta_options[$this->nebula_prefix . 'location_plysical'] = 0;
            $this->default_meta_options[$this->nebula_prefix . 'venue_name'] = '';
            $this->default_meta_options[$this->nebula_prefix . 'venue_address'] = '';
            $this->default_meta_options[$this->nebula_prefix . 'venue_town'] = '';
            $this->default_meta_options[$this->nebula_prefix . 'venue_postcode'] = '';
            $this->default_meta_options[$this->nebula_prefix . 'venue_phone'] = '';
            $this->default_meta_options[$this->nebula_prefix . 'venue_web_site'] = '';
            $this->default_meta_options[$this->nebula_prefix . 'venue_map'] = '';
            //Organiser Information
            $this->default_meta_options[$this->nebula_prefix . 'organiser_show'] = 1;
            $this->default_meta_options[$this->nebula_prefix . 'organiser'] = '';
            $this->default_meta_options[$this->nebula_prefix . 'organiser_company'] = '';
            $this->default_meta_options[$this->nebula_prefix . 'organiser_address'] = '';
            $this->default_meta_options[$this->nebula_prefix . 'organiser_town'] = '';
            $this->default_meta_options[$this->nebula_prefix . 'organiser_Email'] = '';
            $this->default_meta_options[$this->nebula_prefix . 'organiser_Number'] = '';
            $this->default_meta_options[$this->nebula_prefix . 'organiser_Web'] = '';


            }

        function UpgradeOptions () {
            if ( $this->meta_options[$this->nebula_prefix . 'version'] < 1.0) {
                 $this->meta_options[$this->nebula_prefix . 'version'] = '1.0';
            }
        }

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
                update_post_meta($post->ID, $this->nebula_data_name, $this->default_meta_options);
        }

        public function create_meta_boxes() { // add the meta box
            $this->LoadOptions ();
            $this->UpgradeOptions ();
            add_meta_box( 'event_array_metabox', 'Event Info',  array($this,'array_metabox'), 'nebula-event', 'normal' );

            }

        public function array_metabox($object) {
            include_once(  nebula_EVENTS_DIR . '/admin/views/meta-info.php' );
            // Noncename needed to verify where the data originated
            echo '<input type="hidden" name="meta-array-nonce" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
                }

        public function save_complex_metabox($post_id, $post, $update)
        {

        // basename will not work if nonce is different file (it is code above^^^
         if (!isset( $_POST["meta-array-nonce"]) || !wp_verify_nonce($_POST["meta-array-nonce"], plugin_basename(__FILE__)) )
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

            $this->InitOptions();
            foreach ( $this->default_meta_options as $key => $value) {
                $targ = substr($key, strlen($this->nebula_prefix));

                switch ($targ) {
                    case 'version';
                    case 'venue_name';
                    case 'venue_address';
                    case 'venue_town';
                    case 'venue_postcode';
                    case 'venue_phone';
                    case 'venue_web_site';
                    case 'organiser';
                    case 'organiser_address';
                    case 'organiser_town';
                    case 'organiser_Email';
                    case 'organiser_Number';
                    case 'organiser_Web';
                    case 'organiser_company';
                        $this->meta_options[$key] = sanitize_text_field($_POST[$targ]);
                        break;

                    case 'checkbox';
                    case 'location_plysical';
                    case 'organiser_show';
                        if (isset($_POST[$targ])) {
                            $this->meta_options[$key] = 1;
                        }   else $this->meta_options[$key] = 0;
                        break;
                }
           }
            update_post_meta($post_id, $this->nebula_data_name, $this->meta_options);
        }

        public function enqueue_scripts() {
            global $post_id;
            if ( get_post_type( $post_id ) == 'nebula-event') {
                wp_enqueue_script('demo_meta_admin', nebula_EVENTS_URL . 'admin/jscript/meta-admin.js',
                    array('jquery', 'jquery-ui-core', 'jquery-ui-accordion','jquery-ui-datepicker'), '1.0', 'all'
                    );
                }
            }

        public function enqueue_styles() {
              global $post_id;
              if ( get_post_type( $post_id ) == 'nebula-event') {
                wp_enqueue_style(
                        'meta_admin', nebula_EVENTS_URL . 'admin/css/meta.css', array()
                );
              }
       }

           public function GetMetaOption($key) {
               $key = $this->nebula_prefix . $key;
               if (array_key_exists($key, $this->meta_options)) {
                   return $this->meta_options[$key];
               } else
                   return null;
           }

            public function GetMetaSelected($key, $value) {
                $key = $this->nebula_prefix . $key;
                if (array_key_exists($key, $this->meta_options)) {
                    if ($this->meta_options[$key]==$value) {
                                    return 'selected';
                    }
                }
            }

            public function GetMetaRadio($key, $value) {
                $key = $this->nebula_prefix . $key;
                if (array_key_exists($key, $this->meta_options)) {
                    if ($this->meta_options[$key]==$value) {
                                    return 'checked="checked"';

                    }
                }
            }

    }

}
