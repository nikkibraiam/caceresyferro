<?php
/**
 * Misc Customizer Settings
 *
 * @package RH
 */

if ( ! function_exists( 'inspiry_misc_customizer' ) ) :
	function inspiry_misc_customizer( WP_Customize_Manager $wp_customize ) {
				
		/**
		 * Misc Section
		 */
		$wp_customize->add_section( 'inspiry_misc_section', array(
			'title'    => esc_html__( 'Misc', 'framework' ),
			'priority' => 140,
		) );


		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			/* Change 'View Property' across the theme */
			$wp_customize->add_setting( 'inspiry_property_detail_page_link_text', array(
				'type' 				=> 'option',
				'transport'			=> 'postMessage',
				'default'			=> esc_html__( 'View Property', 'framework' ),
				'sanitize_callback'	=> 'sanitize_text_field',
			) );
			$wp_customize->add_control( 'inspiry_property_detail_page_link_text', array(
				'label' 	        => esc_html__( 'Property Detail Page Link Text', 'framework' ),
				'description'       => esc_html__( 'You can change "View Property" button text ( appears on hovering over property card image ) with any other text across the theme here.', 'framework' ),
				'type' 		        => 'text',
				'section'           => 'inspiry_misc_section',
			) );
		}

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			/* Change 'Know More' across theme */
			$wp_customize->add_setting( 'inspiry_string_know_more', array(
				'type'              => 'option',
				'default'           => esc_html__( 'Know More', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( 'inspiry_string_know_more', array(
				'label'       => esc_html__( 'Replace "Know More" Button Text', 'framework' ),
				'description' => esc_html__( 'You can change "Know More" button text with any other text across the theme here', 'framework' ),
				'type'        => 'text',
				'section'     => 'inspiry_misc_section',
			) );
		}

		/* Light Box Plugin */
		$wp_customize->add_setting( 'theme_lightbox_plugin', array(
			'type'    => 'option',
			'default' => 'venobox',
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'theme_lightbox_plugin', array(
			'label'       => esc_html__( 'Lightbox Plugin', 'framework' ),
			'description' => esc_html__( 'Select the lightbox plugin that you want to use', 'framework' ),
			'type'        => 'select',
			'section'     => 'inspiry_misc_section',
			'choices'     => array(
				'venobox'      => esc_html__( 'VenoBox Plugin', 'framework' ),
				'swipebox'     => esc_html__( 'Swipebox Plugin', 'framework' ),
				'pretty-photo' => esc_html__( 'Pretty Photo Plugin', 'framework' ),
			),
		) );


		$wp_customize->add_setting( 'inspiry_properties_placeholder_image', array(
			'type'              => 'option',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'inspiry_properties_placeholder_image', array(
			'label'       => esc_html__( 'Properties Custom Placeholder Image', 'framework' ),
			'description' => esc_html__( 'Upload an image bigger than 1200px width and 680px height.', 'framework' ),
			'section'     => 'inspiry_misc_section',
		) ) );

		$wp_customize->add_setting( 'inspiry_optimise_css', array(
			'type'    => 'option',
			'default' => 'true',
			'transport' => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_optimise_css', array(
			'label'       => esc_html__( 'Optimise Styles to Improve Performance', 'framework' ),
			'description' => esc_html__( 'Enabling this will include compressed version of few big css files.', 'framework' ),
			'type'        => 'radio',
			'section'     => 'inspiry_misc_section',
			'choices'     => array(
				'true'  => esc_html__( 'Yes', 'framework' ),
				'false' => esc_html__( 'No', 'framework' ),
			),
		) );


		$wp_customize->add_setting( 'inspiry_scroll_to_top', array(
			'type'    => 'option',
			'default' => 'true',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_scroll_to_top', array(
			'label'       => esc_html__( 'Show Scroll To Top Button', 'framework' ),
			'type'        => 'radio',
			'section'     => 'inspiry_misc_section',
			'choices'     => array(
				'true'  => esc_html__( 'Yes', 'framework' ),
				'false' => esc_html__( 'No', 'framework' ),
			),
		) );

		$wp_customize->add_setting( 'inspiry_select2_no_result_string', array(
			'type' 				=> 'option',
			'default'			=> esc_html__( 'No Results Found!', 'framework' ),
			'sanitize_callback'	=> 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_select2_no_result_string', array(
			'label' 	        => esc_html__( 'Select Drop Down No Result Text', 'framework' ),
			'type' 		        => 'text',
			'section'           => 'inspiry_misc_section',
		) );

		$wp_customize->add_setting( 'inspiry_unset_default_image_sizes', array(
			'type'    => 'option',
			'default' => 'false',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_unset_default_image_sizes', array(
			'label'       => esc_html__( 'Disable Default Image Sizes ?', 'framework' ),
			'description'  => esc_html__( 'Choosing "Yes" will disable WordPress default cropped image sizes (small, medium, medium_large, large) whenever an image is being uploaded' , 'framework' ),
			'type'        => 'radio',
			'section'     => 'inspiry_misc_section',
			'choices'     => array(
				'true'  => esc_html__( 'Yes', 'framework' ),
				'false' => esc_html__( 'No', 'framework' ),
			),
		) );
		
	}
	
	add_action( 'customize_register', 'inspiry_misc_customizer' );
endif;


if ( ! function_exists( 'inspiry_misc_defaults' ) ) :
	/**
	 * Set default values for misc settings
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	function inspiry_misc_defaults( WP_Customize_Manager $wp_customize ) {
		$misc_settings_ids = array(
			'theme_lightbox_plugin',
			'inspiry_optimise_css',
		);
		inspiry_initialize_defaults( $wp_customize, $misc_settings_ids );
	}
	
	add_action( 'customize_save_after', 'inspiry_misc_defaults' );
endif;
