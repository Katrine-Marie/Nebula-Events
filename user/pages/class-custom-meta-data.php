<?php
/*
 * load and retrieve meta data from options or meta-data array.
 * Provides the functions for data retrival. does not have save and validation abilities.
 * $my_table_data = new custom_meta_data('meta-array-options','apcdem_','meta');
 * @params Data table name,
 *    data field prefix
 *    type: meta, options
 */
namespace nebula\events;
if (!class_exists('custom_meta_data')) {


    class custom_meta_data {


        public function __construct ( $data_name, $prefix, $meta  )  {
            global $post;
            $this->meta_options = array();
            $this->default_meta_options = array();
            $this->nebula_prefix = $prefix;
            $this->nebula_data_name = $data_name;
            // $this->LoadOptions($meta,$post->ID);
            $this->meta = $meta;
        }

        /**
         *  Loads options from database.
         * loops through Only values that already known in the settings.
         * does not take advantage of the default options.
         * and loads any stored values
         * get_post_meta($post->ID, $this->nebula_data_name, true))
         */
        function LoadOptions ( $post_id = 0 ) {
            global $post;
            switch ($this->meta)
            {
                case 'meta':
                // bring in loaded values
                $storedoptions = get_post_meta($post->ID, $this->nebula_data_name, true);
                if ($storedoptions && is_array($storedoptions)) {
                    foreach ($storedoptions as $key => $value) {
                        $this->meta_options[$key] = $value;
                    }
                }
                break;
                case 'options':

                $storedoptions = get_option($this->nebula_data_name);
                if ($storedoptions && is_array($storedoptions)) {
                 foreach ($storedoptions as $key => $value) {
                 $this->meta_options[$key] = $value;
                 }
               }
               break;
           default :
               return;
            }

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
     * echo out content plus BR or nothing if empty
     */
    public function ShowOption($key) {
               $key = $this->nebula_prefix . $key;
               if (array_key_exists($key, $this->meta_options)) {
                   if (strlen($this->meta_options[$key])>1) {
                       return $this->meta_options[$key].'<br/>';
                   }
               } else
                   return null;
           }
    public function Optionhasvalue($key) {
               $key = $this->nebula_prefix . $key;
               if (array_key_exists($key, $this->meta_options)) {
                   if (strlen($this->meta_options[$key])>1) {
                       return true;
                   }
               }
               return false;
           }
    public function test() {
      global $post;
      echo "test". $post->ID;
    }


    } //end Class

}
