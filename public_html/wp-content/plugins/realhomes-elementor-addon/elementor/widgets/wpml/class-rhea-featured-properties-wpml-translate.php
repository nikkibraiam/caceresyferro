<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class inspiry_featured_properties_to_translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_featured_properties_to_translate'
		] );

	}
	public function inspiry_featured_properties_to_translate( $widgets ) {

		$widgets['ere-featured-properties-widget'] = [
			'conditions' => [ 'widgetType' => 'ere-featured-properties-widget' ],
			'fields'     => [
				[
					'field'       => 'ere_property_bedrooms_label',
					'type'        => esc_html__( 'Featured Properties: Bedrooms', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_property_bathrooms_label',
					'type'        => esc_html__( 'Featured Properties: Bathrooms', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_property_area_label',
					'type'        => esc_html__( 'Featured Properties: Area', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_property_featured_label',
					'type'        => esc_html__( 'Featured Properties: Featured', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
			],
		];

		return $widgets;

	}
}

new inspiry_featured_properties_to_translate();