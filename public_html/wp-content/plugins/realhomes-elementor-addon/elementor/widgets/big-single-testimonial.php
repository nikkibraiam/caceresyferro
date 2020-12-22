<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Big_Testimonial_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ere-big-testimonial-widget';
	}

	public function get_title() {
		return esc_html__( 'Big Single Testimonial', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-testimonial';
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Testimonial', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'testimonial_text',
			[
				'label' => esc_html__( 'Testimonial Text', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::TEXTAREA,
				'rows'  => 10,
			]
		);

		$this->add_control(
			'testimonial_name',
			[
				'label'       => esc_html__( 'Author Name', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Author Name', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'testimonial_url',
			[
				'label'         => esc_html__( 'URL', 'realhomes-elementor-addon' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'realhomes-elementor-addon' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'styles_section',
			[
				'label' => esc_html__( 'Styles', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'testimonial_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1ea69a',
				'selectors' => [
					'{{WRAPPER}} .rh_wrapper__testimonial_elementor' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'testimonial_quotes_color',
			[
				'label'     => esc_html__( 'Quotes Marks Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1c9d92',
				'selectors' => [
					'{{WRAPPER}} .rh_wrapper__testimonial_elementor .quotes-marks svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'testimonial_text_color',
			[
				'label'     => esc_html__( 'Testimonial Text Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .rhea_testimonial .rh_testimonial__quote_ele' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'testimonial_author_name_color',
			[
				'label'     => esc_html__( 'Author Name Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .rhea_testimonial .rh_testimonial__author .rh_testimonial__author_name' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'testimonial_author_link_color',
			[
				'label'     => esc_html__( 'Author Link Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .rhea_testimonial .rh_testimonial__author .rh_testimonial__author__link a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ere_testimonials_typo_section',
			[
				'label' => esc_html__( 'Typography', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'testimonials_typography',
				'label'    => esc_html__( 'Testimonials', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_testimonial__quote_ele',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'testimonials_author_typography',
				'label'    => esc_html__( 'Author', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_testimonial__author_name',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'testimonials_author_link_typography',
				'label'    => esc_html__( 'Link', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_testimonial__author__link a',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ere_testimonials_spacing',
			[
				'label' => esc_html__( 'Spacings & Sizes', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]


		);


		$this->add_responsive_control(
			'ere_testimonials_content_padding',
			[
				'label' => esc_html__( 'Area Padding', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .rh_wrapper__testimonial_elementor.elementor_controls' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_testimonials_content_max_width',
			[
				'label'           => esc_html__( 'Testimonials Contents Max Width', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 2500,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 950,
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
					'{{WRAPPER}} .rh_wrapper__testimonial_elementor .rhea_testimonial' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_testimonials_margin_bottom',
			[
				'label'           => esc_html__( 'Testimonials Bottom Spacing (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 50,
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
					'{{WRAPPER}} .rh_testimonial__quote_ele' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();


		$this->start_controls_section(
			'ere_testimonials_quote_position',
			[
				'label' => esc_html__( 'Quote Marks Options', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]


		);

		$this->add_control(
			'ere_show_testimonials_quotes',
			[
				'label'        => esc_html__( 'Show Quote Marks', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'Hide', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);



		$this->add_responsive_control(
			'ere_testimonials_quotes_size',
			[
				'label'           => esc_html__( 'Quote Marks Size (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'condition'       => [
					'ere_show_testimonials_quotes' => 'yes',
				],
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 500,
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
					'{{WRAPPER}} .rh_wrapper__testimonial_elementor .quotes-marks'  => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_testimonials_quotes_vertical_position',
			[
				'label'           => esc_html__( 'Quote Marks Vertical Position (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'condition'       => [
					'ere_show_testimonials_quotes' => 'yes',
				],
				'range'           => [
					'px' => [
						'min' => - 300,
						'max' => 300,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => -55,
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
					'{{WRAPPER}} .rh_wrapper__testimonial_elementor .quotes-marks.mark-left'  => 'top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rh_wrapper__testimonial_elementor .quotes-marks.mark-right' => 'bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'ere_quote_position',
			[
				'label' => esc_html__( 'Quote Position', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'condition'       => [
					'ere_show_testimonials_quotes' => 'yes',
				],
				'options' => [
					'rhea_quote_left' => [
						'title' => esc_html__( 'Quote LTR', 'realhomes-elementor-addon' ),
						'icon' => 'fa fa-align-left',
					],
					'rhea_quote_right' => [
						'title' => esc_html__( 'Quote RTL', 'realhomes-elementor-addon' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'rhea_quote_left',
				'toggle' => false,
			]
		);



		$this->add_responsive_control(
			'ere_testimonials_quotes_horizontal_position',
			[
				'label'           => esc_html__( 'Quote Marks Horizontal Position (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'condition'       => [
					'ere_show_testimonials_quotes' => 'yes',
					'ere_quote_position' => 'rhea_quote_left',
				],
				'range'           => [
					'px' => [
						'min' => - 500,
						'max' => 500,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 13,
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
					'{{WRAPPER}} .rh_wrapper__testimonial_elementor.rhea_quote_left .quotes-marks.mark-left'  => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rh_wrapper__testimonial_elementor.rhea_quote_left .quotes-marks.mark-right' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'ere_testimonials_quotes_horizontal_position_rtl',
			[
				'label'           => esc_html__( 'Quote Marks Horizontal Position (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'condition'       => [
					'ere_show_testimonials_quotes' => 'yes',
					'ere_quote_position' => 'rhea_quote_right',
				],
				'range'           => [
					'px' => [
						'min' => - 500,
						'max' => 500,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 13,
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
					'{{WRAPPER}} .rh_wrapper__testimonial_elementor.rhea_quote_right .quotes-marks.mark-left'  => 'right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rh_wrapper__testimonial_elementor.rhea_quote_right .quotes-marks.mark-right' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();


	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		if ( isset( $settings['testimonial_text'] ) && ! empty( $settings['testimonial_text'] ) ) {
			?>
            <div class="rh_elementor_widget rh_wrapper__testimonial_elementor elementor_controls <?php echo esc_attr($settings['ere_quote_position']);?>">
                <div class="wrapper-section-contents">
                    <div class="rhea_testimonial">
						<?php
						if ( $settings['ere_show_testimonials_quotes'] == 'yes' ) {
							?>

                            <div class="quotes-marks mark-left"><?php include RHEA_ASSETS_DIR . '/icons/quotes.svg'; ?></div>
                            <div class="quotes-marks mark-right"><?php include RHEA_ASSETS_DIR . '/icons/quotes.svg'; ?></div>
						<?php } ?>
                        <blockquote class="rh_testimonial__quote_ele"><?php echo wp_kses( $settings['testimonial_text'], rhea_allowed_tags() ); ?></blockquote>

                        <div class="rh_testimonial__author">
							<?php
							if ( $settings['testimonial_name'] ) {
								?>
                                <p class="rh_testimonial__author_name">
									<?php echo esc_html( $settings['testimonial_name'] ); ?>
                                </p>
								<?php
							}

							if ( $settings['testimonial_url']['url'] ) {
								$target   = $settings['testimonial_url']['is_external'] ? ' target="_blank"' : '';
								$nofollow = $settings['testimonial_url']['nofollow'] ? ' rel="nofollow"' : '';
								?>
                                <p class="rh_testimonial__author__link">
                                    <a href="<?php echo esc_url( $settings['testimonial_url']['url'] ); ?>"<?php echo $target . $nofollow; ?>>
										<?php echo esc_html( $settings['testimonial_url']['url'] ); ?>
                                    </a>
                                </p>
								<?php
							}
							?>
                        </div>
                    </div>
                </div>
            </div>
			<?php
		}

	}

}