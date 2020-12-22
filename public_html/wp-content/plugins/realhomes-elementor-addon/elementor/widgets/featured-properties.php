<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Featured_Properties_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ere-featured-properties-widget';
	}

	public function get_title() {
		return esc_html__( 'Featured Properties Carousel', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-post-slider';
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	protected function _register_controls() {


		$this->start_controls_section(
			'ere_featured_properties_section',
			[
				'label' => esc_html__( 'Featured Properties Carousel', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'number_of_properties',
			[
				'label'   => esc_html__( 'Number of Properties', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 50,
				'step'    => 1,
				'default' => 5,
			]
		);

		$this->add_control(
			'featured_excerpt_length',
			[
				'label'   => esc_html__( 'Excerpt Length (Words)', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 5,
				'max'     => 100,
				'default' => 15,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order By', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'date'       => esc_html__( 'Date', 'realhomes-elementor-addon' ),
					'price'      => esc_html__( 'Price', 'realhomes-elementor-addon' ),
					'title'      => esc_html__( 'Title', 'realhomes-elementor-addon' ),
					'menu_order' => esc_html__( 'Menu Order', 'realhomes-elementor-addon' ),
					'rand'       => esc_html__( 'Random', 'realhomes-elementor-addon' ),
				],
				'default' => 'date',
			]
		);



		$this->end_controls_section();

		$this->start_controls_section(
			'ere_featured_typo_section',
			[
				'label' => esc_html__( 'Typography', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_heading_typography',
				'label'    => esc_html__( 'Heading', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor h3 a',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_excerpt_typography',
				'label'    => esc_html__( 'Excerpt', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor .rh_prop_card__excerpt',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_label_typography',
				'label'    => esc_html__( 'Label', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor .rh_prop_card__meta .rhea_meta_titles',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_figure_typography',
				'label'    => esc_html__( 'Figure', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_prop_card__details_elementor .rh_prop_card__meta .figure',
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_area_postfix_typography',
				'label'    => esc_html__( 'Area Postfix', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_prop_card__details_elementor .rh_prop_card__meta .label',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_status_typography',
				'label'    => esc_html__( 'Status', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor .rh_prop_card__priceLabel .rh_prop_card__status',
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_price_typography',
				'label'    => esc_html__( 'Price', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor .rh_prop_card__priceLabel .rh_prop_card__price',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'ere_featured_properties_labels',
			[
				'label' => esc_html__( 'Property Meta Labels', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'ere_property_bedrooms_label',
			[
				'label'   => esc_html__( 'Bedrooms', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Bedrooms', 'realhomes-elementor-addon' ),
			]
		);
		$this->add_control(
			'ere_property_bathrooms_label',
			[
				'label'   => esc_html__( 'Bathrooms', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Bathrooms', 'realhomes-elementor-addon' ),
			]
		);
		$this->add_control(
			'ere_property_area_label',
			[
				'label'   => esc_html__( 'Area', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Area', 'realhomes-elementor-addon' ),
			]
		);
		if ( inspiry_is_rvr_enabled() ) {
			$this->add_control(
				'ere_property_guests_label',
				[
					'label'   => esc_html__( 'Guests Capacity', 'realhomes-elementor-addon' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Guests', 'realhomes-elementor-addon' ),
				]
			);
		}
		$this->add_control(
			'ere_property_featured_label',
			[
				'label'   => esc_html__( 'Featured', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Featured', 'realhomes-elementor-addon' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ere_feature_properties_sizes',
			[
				'label' => esc_html__( 'Slider Sizes', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'ere_featured_slider_width',
			[
				'label'           => esc_html__( 'Slider width (%)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 52,
					'unit' => '%',
				],
				'tablet_default'  => [
					'size' => 100,
					'unit' => '%',
				],
				'mobile_default'  => [
					'size' => 100,
					'unit' => '%',
				],
				'selectors'       => [
					'{{WRAPPER}} .rh_section__featured_elementor' => 'max-width: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_featured_slide_content_width',
			[
				'label'           => esc_html__( 'Slide Contents Width (%)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 82,
					'unit' => '%',
				],
				'tablet_default'  => [
					'size' => 100,
					'unit' => '%',
				],
				'mobile_default'  => [
					'size' => 100,
					'unit' => '%',
				],
				'selectors'       => [
					'{{WRAPPER}} .rh_wrapper--featured_elementor .rh_prop_card__featured' => 'max-width: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_featured_property_content_padding',
			[
				'label'      => esc_html__( 'Content Area Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rh_section__featured_elementor .rh_prop_card__featured' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'ere_featured_slide_content_position',
			[
				'label'           => esc_html__( 'Slide Contents Position (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => - 150,
						'max' => 0,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => - 70,
					'unit' => 'px',
				],
				'tablet_default'  => [
					'size' => '',
					'unit' => 'px',
				],
				'mobile_default'  => [
					'size' => '',
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .rh_wrapper--featured_elementor .rh_prop_card__featured' => 'margin-top: {{SIZE}}{{UNIT}};',

				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'ere_feature_properties_nav_button',
			[
				'label' => esc_html__( 'Slider Nav Buttons', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]


		);


		$this->add_control(
			'ere_show_featured_nav_buttons',
			[
				'label'        => esc_html__( 'Show Slider Nav Buttons', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'Hide', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_responsive_control(
			'ere_featured_nav_position_horizontal',
			[
				'label'           => esc_html__( 'Nav Button Horizontal Position (%)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'condition'       => [
					'ere_show_featured_nav_buttons' => 'yes',
				],
				'range'           => [
					'%' => [
						'min' => - 200,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => - 22,
					'unit' => '%',
				],
				'tablet_default'  => [
					'size' => -8,
					'unit' => '%',
				],
				'mobile_default'  => [
					'size' => '',
					'unit' => '%',
				],
				'selectors'       => [
					'{{WRAPPER}} .rh_section__featured_elementor .rh_flexslider__nav_elementor .rh_flexslider__prev' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rh_section__featured_elementor .rh_flexslider__nav_elementor .rh_flexslider__next' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_featured_nav_position_vertical',
			[
				'label'           => esc_html__( 'Nav Buttons Vertical Position (%)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'condition'       => [
					'ere_show_featured_nav_buttons' => 'yes',
				],
				'range'           => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => '',
					'unit' => '%',
				],
				'tablet_default'  => [
					'size' => '',
					'unit' => '%',
				],
				'mobile_default'  => [
					'size' => '',
					'unit' => '%',
				],
				'selectors'       => [
					'{{WRAPPER}} .rh_section__featured_elementor .rh_flexslider__nav_elementor a' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_featured_nav_button_size',
			[
				'label'           => esc_html__( 'Nav Buttons Size (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'condition'       => [
					'ere_show_featured_nav_buttons' => 'yes',
				],
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 73,
					'unit' => 'px',
				],
				'tablet_default'  => [
					'size' => '',
					'unit' => 'px',
				],
				'mobile_default'  => [
					'size' => '',
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .rh_section__featured_elementor .rh_flexslider__nav_elementor a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_featured_nav_button_arrow_size',
			[
				'label'           => esc_html__( 'Nav Buttons Arrow Size (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'condition'       => [
					'ere_show_featured_nav_buttons' => 'yes',
				],
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 40,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 40,
					'unit' => 'px',
				],
				'tablet_default'  => [
					'size' => '',
					'unit' => 'px',
				],
				'mobile_default'  => [
					'size' => '',
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .rh_section__featured_elementor .rh_flexslider__nav_elementor a svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ere_feature_properties_spaces',
			[
				'label' => esc_html__( 'Spaces', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'ere_featured_main_title_margin',
			[
				'label' => esc_html__( 'Title Bottom Margin (px)', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,

				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => '',
					'unit' => 'px',
				],
				'tablet_default'  => [
					'size' => '',
					'unit' => 'px',
				],
				'mobile_default'  => [
					'size' => '',
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .rh_prop_card__details_elementor h3' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_featured_excerpt_margin',
			[
				'label' => esc_html__( 'Excerpt Bottom Margin (px)', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,

				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => '',
					'unit' => 'px',
				],
				'tablet_default'  => [
					'size' => '',
					'unit' => 'px',
				],
				'mobile_default'  => [
					'size' => '',
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .rh_prop_card__details_elementor p' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_featured_meta_margin',
			[
				'label' => esc_html__( 'Meta Bottom Margin (px)', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,

				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => '',
					'unit' => 'px',
				],
				'tablet_default'  => [
					'size' => '',
					'unit' => 'px',
				],
				'mobile_default'  => [
					'size' => '',
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .rh_prop_card__meta_wrap_elementor' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_prop_card_meta_icon_size',
			[
				'label' => esc_html__( 'Meta Icon Size (px)', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,

				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => '',
					'unit' => 'px',
				],
				'tablet_default'  => [
					'size' => '',
					'unit' => 'px',
				],
				'mobile_default'  => [
					'size' => '',
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .rh_prop_card__details_elementor .rh_prop_card__meta svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_featured_status_margin',
			[
				'label' => esc_html__( 'Status Bottom Margin (px)', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,

				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => '',
					'unit' => 'px',
				],
				'tablet_default'  => [
					'size' => '',
					'unit' => 'px',
				],
				'mobile_default'  => [
					'size' => '',
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .rh_prop_card__details_elementor .rh_prop_card__status' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'ere_feature_properties_styles',
			[
				'label' => esc_html__( 'Property Colors', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'ere_property_bg_color',
			[
				'label'     => esc_html__( 'Property Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor' => 'background: {{VALUE}}',
				],
			]
		);


		$this->add_control(
			'ere_property_featured_label_bg_color',
			[
				'label'     => esc_html__( 'Feature Tag Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_label_elementor'      => 'background: {{VALUE}}',
					'{{WRAPPER}} .rh_label_elementor span' => 'border-left-color: {{VALUE}}; border-right-color: {{VALUE}};',
					'{{WRAPPER}} [data-tooltip]::after'    => 'background: {{VALUE}}',
					'{{WRAPPER}} [data-tooltip]::before'   => 'border-top-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_featured_label_text_color',
			[
				'label'     => esc_html__( 'Feature Tag Text', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_label_elementor .rh_label__wrap_elementor' => 'color: {{VALUE}}',
					'{{WRAPPER}} [data-tooltip]::after'                         => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_heading_color',
			[
				'label'     => esc_html__( 'Property Heading', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor h3 a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_heading_hover_color',
			[
				'label'     => esc_html__( 'Property Heading Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor h3 a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_excerpt_color',
			[
				'label'     => esc_html__( 'Property Excerpt', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor .rh_prop_card__excerpt' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_meta_label_color',
			[
				'label'     => esc_html__( 'Meta Label', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor .rh_prop_card__meta .rhea_meta_titles' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_meta_svg_color',
			[
				'label'     => esc_html__( 'SVG Meta Icon', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor .rh_prop_card__meta svg' => 'fill: {{VALUE}}',
					'{{WRAPPER}} .rh_prop_card__details_elementor .rh_prop_card__meta .rhea_guests' => 'fill: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'ere_property_meta_figure_color',
			[
				'label'     => esc_html__( 'Meta Figure', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor .rh_prop_card__meta .figure' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor .rh_prop_card__meta .label'  => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'ere_property_status_color',
			[
				'label'     => esc_html__( 'Status', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor .rh_prop_card__priceLabel .rh_prop_card__status' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'ere_property_price_color',
			[
				'label'     => esc_html__( 'Price', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor .rh_prop_card__priceLabel .rh_prop_card__price' => 'color: {{VALUE}}',
				],
			]
		);

		if ( inspiry_is_rvr_enabled() ) {
			$this->add_control(
				'rhea_property_rating_stars',
				[
					'label'     => esc_html__( 'Rating Stars', 'realhomes-elementor-addon' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .rh_rvr_price_rating_wrapper .rating-stars i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .rhea_stars_avg_rating .rhea_rating_percentage .rhea_rating_line .rhea_rating_line_inner' => 'background: {{VALUE}};',
						'{{WRAPPER}} .rating-stars i.rated' => 'color: {{VALUE}};',
					],
				]
			);
		}

		$this->add_control(
			'ere_nav_button_color',
			[
				'label'     => esc_html__( 'Slider Nav Button Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_flexslider__nav_elementor a' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_nav_button_hover_color',
			[
				'label'     => esc_html__( 'Slider Nav Button Background Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_flexslider__nav_elementor a:hover' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'ere_nav_button_arrow_color',
			[
				'label'     => esc_html__( 'Slider Nav Button Arrow', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_flexslider__nav_elementor a svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_nav_button_arrow_hover_color',
			[
				'label'     => esc_html__( 'Slider Nav Button Arrow Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_flexslider__nav_elementor a:hover svg' => 'fill: {{VALUE}}',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'ere_featured_properties_box_shadow',
			[
				'label' => esc_html__( 'Box Shadow', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'realhomes-elementor-addon' ),
				'selector' => '{{WRAPPER}} .rh_section__featured_elementor .rh_prop_card__featured',
			]
		);


		$this->end_controls_section();


	}

	protected function render() {
		global $settings;
		$settings = $this->get_settings_for_display();

		// Number of Properties
		if ( ! $settings['number_of_properties'] ) {
			$settings['number_of_properties'] = 5;
		}


		// Featured Properties Query Arguments.
		$featured_properties_args = array(
			'post_type'      => 'property',
			'post_status'    => 'publish',
			'posts_per_page' => $settings['number_of_properties'],
			'meta_query'     => array(
				array(
					'key'     => 'REAL_HOMES_featured',
					'value'   => 1,
					'compare' => '=',
					'type'    => 'NUMERIC',
				),
			),
		);

		if ( 'price' === $settings['orderby'] ) {
			$featured_properties_args['orderby']  = 'meta_value_num';
			$featured_properties_args['meta_key'] = 'REAL_HOMES_property_price';
		} else {
			// for date, title, menu_order and rand
			$featured_properties_args['orderby'] = $settings['orderby'];
		}


		$featured_properties_query = new WP_Query( apply_filters( 'rhea_modern_featured_properties_widget', $featured_properties_args ) );

		if ( $featured_properties_query->have_posts() ) {

			?>
            <section class="rh_elementor_widget rh_wrapper--featured_elementor">
				<?php


				if ( $featured_properties_query->have_posts() ) {
					?>
                    <div class="rh_section__featured rh_section__featured_elementor clearfix" id="rh-<?php echo esc_attr( $this->get_id() ); ?>">
                        <div class="flexslider loading">
                            <ul class="slides">
								<?php
								while ( $featured_properties_query->have_posts() ) {
									$featured_properties_query->the_post();
									rhea_get_template_part( 'assets/partials/home-featured-property' );
								}
								wp_reset_postdata();
								?>
                            </ul>
                        </div>

						<?php
						if ( $settings['ere_show_featured_nav_buttons'] == 'yes' ) {
							?>

                            <div class="rh_flexslider__nav_elementor">
                                <a href="#" class="flex-prev rh_flexslider__prev nav-mod">
									<?php include RHEA_ASSETS_DIR . '/icons/left.svg'; ?>
                                </a>
                                <a href="#" class="flex-next rh_flexslider__next nav-mod">
									<?php include RHEA_ASSETS_DIR . '/icons/right.svg'; ?>
                                </a>
                            </div>
							<?php
						}
						?>

                    </div>
					<?php
				}
				?>

            </section>
            <script type="application/javascript">
                function RHEAloadFeaturedProperties() {
                    if (jQuery().flexslider) {
                        jQuery('#rh-<?php echo esc_attr( $this->get_id() );?> .flexslider').each(function () {
                            jQuery(this).flexslider({
                                animation: "fade",
                                slideshowSpeed: 7000,
                                animationSpeed: 1500,
                                slideshow: false,
                                directionNav: true,
                                controlNav: false,
                                keyboardNav: true,
                                // directionNav: false,
                                // customDirectionNav: $(".rh_flexslider__nav_main_gallery .nav-mod"),
                                customDirectionNav: jQuery(this).next('.rh_flexslider__nav_elementor').find('.nav-mod'),
                                start: function (slider) {
                                    slider.removeClass('loading');
                                }
                            });
                        });
                    }
                }

                RHEAloadFeaturedProperties();
                jQuery(document).on('ready', RHEAloadFeaturedProperties);


            </script>
			<?php
		}

	}

}

?>