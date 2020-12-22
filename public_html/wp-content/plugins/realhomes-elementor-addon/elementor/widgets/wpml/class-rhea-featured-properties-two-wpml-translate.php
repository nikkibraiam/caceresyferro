<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Featured_Properties_Two_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_featured_properties_two_to_translate'
		] );

	}
	public function inspiry_featured_properties_two_to_translate( $widgets ) {

		$widgets['ere-featured-properties-two-widget'] = [
			'conditions' => [ 'widgetType' => 'ere-featured-properties-two-widget' ],
			'fields'     => [
				[
					'field'       => 'ere_property_bedrooms_label',
					'type'        => esc_html__( 'Featured Properties Two: Bedrooms', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_property_bathrooms_label',
					'type'        => esc_html__( 'Featured Properties Two: Bathrooms', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_property_area_label',
					'type'        => esc_html__( 'Featured Properties Two: Area', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_property_features_label',
					'type'        => esc_html__( 'Featured Properties Two: Featured', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_property_fav_label',
					'type'        => esc_html__( 'Featured Properties Two: Add To Favourite', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_property_fav_added_label',
					'type'        => esc_html__( 'Featured Properties Two: Added To Favourite', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_property_compare_label',
					'type'        => esc_html__( 'Featured Properties Two: Add To Compare', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_property_compare_added_label',
					'type'        => esc_html__( 'Featured Properties Two: Added To Compare', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
			],
		];

		return $widgets;

	}
}

new RHEA_Featured_Properties_Two_WPML_Translate();