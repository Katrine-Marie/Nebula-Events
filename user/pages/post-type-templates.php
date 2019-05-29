<?php

namespace nebula\events;

class custom_templates {

	public function __construct( ) {
		$this->post_type = 'nebula-event';
		$this->template_file ='event-template.php';
		add_filter( 'template_include', array($this,'custom_template_loader') );
	}

	/**
	 * Template loader.
	 *
	 * The template loader will check if WP is loading a template
	 * for a specific Post Type and will try to load the template
	 * from out 'templates' directory.
	 *
	 * @since 1.0.0
	 *
	 * @param	string	$template	Template file that is being loaded.
	 * @return	string				Template file that should be loaded.
	 */
	function custom_template_loader( $template ) {

		$find = array();
		$file = '';

		if ( is_singular( $this->post_type ) ) :
			$file = $this->template_file;
	        else :
	                    return $template;

		endif;

		if ( file_exists( $this->custom_locate_template( $file ) ) ) :
			$template = $this->custom_locate_template( $file );
		endif;

		return $template;

	}

	/**
	 * Locate template.
	 *
	 * Locate the called template.
	 * Priority:
	 * 1. /child-theme/custom-templates/$template_name.
	 * 2. /themes/yourtheme/custom-templates/$template_name
	 * 3. /themes/yourtheme/$template_name

	 *
	 * @since 1.0.0
	 *
	 * @param 	string 	$template_name			Template to load.
	 * @param 	string 	$string $template_path	Path to templates.
	 * @param 	string	$default_path			Default path to template files.
	 * @return 	string 							Path to the template file.
	 */
	function custom_locate_template( $template_name, $template_path = '', $default_path = '' ) {

		// Set variable to search in 'custom-templates' folder of current theme.
		if ( ! $template_path ) :
			$template_path = 'custom-templates/';
		endif;

		// Set default plugin templates path.
		if ( ! $default_path ) :
			$default_path = ( nebula_EVENTS_DIR . '/templates/'); // Path to the template folder
		endif;

		// Search template file in theme folder.
		$template = locate_template( array(
			$template_path . $template_name,
			$template_name
		) );

		// Get plugins template file.
		if ( ! $template ) :
			$template = $default_path . $template_name;
		endif;

		return apply_filters( 'custom_locate_template', $template, $template_name, $template_path, $default_path );

	}


	/**
	 * Get template.
	 *
	 * Search for the template and include the file.
	 *
	 * @since 1.0.0
	 *
	 * @see custom_locate_template()
	 *
	 * @param string 	$template_name			Template to load.
	 * @param array 	$args					Args passed for the template file.
	 * @param string 	$string $template_path	Path to templates.
	 * @param string	$default_path			Default path to template files.
	 */
	function custom_get_template( $template_name, $args = array(), $tempate_path = '', $default_path = '' ) {

		if ( is_array( $args ) && isset( $args ) ) :
			extract( $args );
		endif;

		$template_file = custom_locate_template( $template_name, $tempate_path, $default_path );

		if ( ! file_exists( $template_file ) ) :
			_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), '1.0.0' );
			return;
		endif;

		include $template_file;

	}

}
