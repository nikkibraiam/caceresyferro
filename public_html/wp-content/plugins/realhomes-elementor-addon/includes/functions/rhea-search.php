<?php

if ( ! function_exists( 'rhea_get_search_page_url' ) ) :
	/**
	 * Get search page URL
	 */
	function rhea_get_search_page_url($page) {
		/* Check search page*/

		if(!empty($page)){
			$inspiry_search_page = $page;
		}else{
			$inspiry_search_page = get_option( 'inspiry_search_page' );
		}
		if ( ! empty( $inspiry_search_page ) ) {

			/* WPML filter to get translated page id if translation exists otherwise default id */
			$inspiry_search_page = apply_filters( 'wpml_object_id', $inspiry_search_page, 'page', true );

			return get_permalink( $inspiry_search_page );
		}

		/* Check search url which is deprecated and this code is to provide backward compatibility */
		$theme_search_url = get_option( 'theme_search_url' );
		if ( ! empty( $theme_search_url ) ) {
			return $theme_search_url;
		}

		/* Return false if all fails */

		return false;
	}
endif;


if ( ! function_exists( 'rhea_agents_in_search' ) ) {
	function rhea_agents_in_search() {

		$args = array(
			'post_type'        => 'agent',
			'posts_per_page'   => - 1,
			'suppress_filters' => false,
			// set this argument to false so WPML can filter the posts according to the language.
		);

		$agents       = new WP_Query( $args );
		$agents_ids   = wp_list_pluck( $agents->posts, 'ID' );
		$agents_names = wp_list_pluck( $agents->posts, 'post_title' );
		$agents       = array_combine( $agents_ids, $agents_names );

		/* check and store searched value if there is any */
		$searched_value = '';
		if ( isset( $_GET['agents'] ) ) {
			$searched_value = $_GET['agents'];
		}


		/* loop through agent values and generate select options */
		if ( ! empty( $agents ) ) {
			foreach ( $agents as $agent_id => $agent_name ) {
				if ( $searched_value == $agent_id ) {
					echo '<option value="' . esc_attr( $agent_id ) . '" selected="selected">' . esc_html( $agent_name ) . '</option>';
				} else {
					echo '<option value="' . esc_attr( $agent_id ) . '">' . esc_html( $agent_name ) . '</option>';
				}
			}
		}
	}
}

if ( ! function_exists( 'rhea_any_value' ) ) :
	/**
	 * Return
	 * @return string|void
	 */
	function rhea_any_value() {
		return 'any';   // NOTE: do not try to translate this as it has back-end use only and it never appears on front-end
	}
endif;

if ( ! function_exists( 'rhea_min_baths' ) ) {
	/**
	 * Generate values for minimum baths select box
	 */
	function rhea_min_baths( $placeholder, $values ) {
		$min_baths_values = array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 );

		// Get values from database and convert them to an integer array
		$inspiry_min_baths = $values;
		if ( ! empty( $inspiry_min_baths ) ) {
			$inspiry_min_baths_array = explode( ',', $inspiry_min_baths );
			if ( is_array( $inspiry_min_baths_array ) && ! empty( $inspiry_min_baths_array ) ) {
				$new_min_baths_array = array();
				foreach ( $inspiry_min_baths_array as $baths_value ) {
					$integer_baths_value = doubleval( $baths_value );
					if ( $integer_baths_value >= 0 ) {
						$new_min_baths_array[] = $integer_baths_value;
					}
				}
				if ( ! empty( $new_min_baths_array ) ) {
					$min_baths_values = $new_min_baths_array;
				}
			}
		}

		// check and store searched value if there is any */
		$searched_value = '';
		if ( isset( $_GET['bathrooms'] ) ) {
			$searched_value = $_GET['bathrooms'];
		}


		// Add any to select box */
		if ( ! empty( $placeholder ) ) {
			echo '<option value="' . rhea_any_value() . '" selected="selected">' . esc_html( $placeholder ) . '</option>';
		} else {
			echo '<option value="' . rhea_any_value() . '">' . esc_html__( 'All Baths', 'realhomes-elementor-addon' ) . '</option>';
		}

		// loop through min baths values and generate select options
		if ( ! empty( $min_baths_values ) ) {
			foreach ( $min_baths_values as $baths_value ) {
				if ( ! empty( $searched_value ) && ( $searched_value == $baths_value ) ) {
					echo '<option value="' . $baths_value . '" selected="selected">' . $baths_value . '</option>';
				} else {
					echo '<option value="' . $baths_value . '">' . $baths_value . '</option>';
				}
			}
		}

	}
}


if ( ! function_exists( 'rhea_min_beds' ) ) {
	/**
	 * Generate values for minimum beds select box
	 */
	function rhea_min_beds( $placeholder, $value ) {
		$min_beds_values = array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 );

		// Get values from database and convert them to an integer array
		$inspiry_min_beds = $value;
		if ( ! empty( $inspiry_min_beds ) ) {
			$inspiry_min_beds_array = explode( ',', $inspiry_min_beds );
			if ( is_array( $inspiry_min_beds_array ) && ! empty( $inspiry_min_beds_array ) ) {
				$new_inspiry_min_beds_array = array();
				foreach ( $inspiry_min_beds_array as $option_beds_value ) {
					$individual_beds_value = doubleval( $option_beds_value );
					if ( $individual_beds_value >= 0 ) {
						$new_inspiry_min_beds_array[] = $individual_beds_value;
					}
				}
				if ( ! empty( $new_inspiry_min_beds_array ) ) {
					$min_beds_values = $new_inspiry_min_beds_array;
				}
			}
		}

		// check and store searched value if there is any
		$searched_value = '';
		if ( isset( $_GET['bedrooms'] ) ) {
			$searched_value = $_GET['bedrooms'];
		}

		// Add any to select box */
		if ( ! empty( $placeholder ) ) {
			echo '<option value="' . esc_attr( rhea_any_value() ) . '" selected="selected">' . esc_html( $placeholder ) . '</option>';
		} else {
			echo '<option value="' . esc_attr( rhea_any_value() ) . '">' . esc_html__( 'All Beds', 'realhomes-elementor-addon' ) . '</option>';
		}

		// loop through min beds values and generate select options
		if ( ! empty( $min_beds_values ) ) {
			foreach ( $min_beds_values as $option_beds_value ) {
				if ( ! empty( $searched_value ) && ( $searched_value == $option_beds_value ) ) {
					echo '<option value="' . $option_beds_value . '" selected="selected">' . $option_beds_value . '</option>';
				} else {
					echo '<option value="' . $option_beds_value . '">' . $option_beds_value . '</option>';
				}
			}
		}

	}
}

if ( ! function_exists( 'rhea_min_garages' ) ) {
	/**
	 * Generate values for minimum baths select box
	 */
	function rhea_min_garages( $placeholder, $values ) {
		$min_garages_values = array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 );

		/* Get values from database and convert them to an integer array */
		$inspiry_min_garages = $values;
		if ( ! empty( $inspiry_min_garages ) ) {
			$inspiry_min_garages_array = explode( ',', $inspiry_min_garages );
			if ( is_array( $inspiry_min_garages_array ) && ! empty( $inspiry_min_garages_array ) ) {
				$new_min_garages_array = array();
				foreach ( $inspiry_min_garages_array as $garages_value ) {
					$integer_garages_value = doubleval( $garages_value );
					if ( $integer_garages_value >= 0 ) {
						$new_min_garages_array[] = $integer_garages_value;
					}
				}
				if ( ! empty( $new_min_garages_array ) ) {
					$min_garages_values = $new_min_garages_array;
				}
			}
		}

		/* check and store searched value if there is any */
		$searched_value = '';
		$get_global     = $_GET;
		if ( isset( $get_global['garages'] ) ) {
			$searched_value = $get_global['garages'];
		}


		// Add any to select box */
		if ( ! empty( $placeholder ) ) {
			echo '<option value="' . esc_attr( rhea_any_value() ) . '" selected="selected">' . esc_html( $placeholder ) . '</option>';
		} else {
			echo '<option value="' . esc_attr( rhea_any_value() ) . '">' . esc_html__( 'All Garages', 'realhomes-elementor-addon' ) . '</option>';
		}

		/* loop through min baths values and generate select options */
		if ( ! empty( $min_garages_values ) ) {
			foreach ( $min_garages_values as $garages_value ) {
				if ( $searched_value == $garages_value ) {
					echo '<option value="' . esc_attr( $garages_value ) . '" selected="selected">' . esc_html( $garages_value ) . '</option>';
				} else {
					echo '<option value="' . esc_attr( $garages_value ) . '">' . esc_html( $garages_value ) . '</option>';
				}
			}
		}

	}
}

if ( ! function_exists( 'rhea_min_prices_list' ) ) {
	/**
	 * Minimum Prices
	 */
	function rhea_min_prices_list($placeholder,$values) {

		$min_price_array = array(
			1000,
			5000,
			10000,
			50000,
			100000,
			200000,
			300000,
			400000,
			500000,
			600000,
			700000,
			800000,
			900000,
			1000000,
			1500000,
			2000000,
			2500000,
			5000000
		);

		/* Get values from theme options and convert them to an integer array */
		$minimum_price_values = $values;
		if ( ! empty( $minimum_price_values ) ) {
			$min_prices_string_array = explode( ',', $minimum_price_values );
			if ( is_array( $min_prices_string_array ) && ! empty( $min_prices_string_array ) ) {
				$new_min_prices_array = array();
				foreach ( $min_prices_string_array as $string_price ) {
					$integer_price = doubleval( $string_price );
					if ( $integer_price > 1 ) {
						$new_min_prices_array[] = $integer_price;
					}
				}
				if ( ! empty( $new_min_prices_array ) ) {
					$min_price_array = $new_min_prices_array;
				}
			}
		}

		$minimum_price = '';
		if ( isset( $_GET['min-price'] ) ) {
			$minimum_price = doubleval( $_GET['min-price'] );
		}


		if ( ! empty( $placeholder ) ) {
			echo '<option value="' . esc_attr( rhea_any_value() ) . '" selected="selected">' . esc_html( $placeholder ) . '</option>';
		} else {
			echo '<option value="' . esc_attr( rhea_any_value() ) . '">' . esc_html__( 'Min Price', 'realhomes-elementor-addon' ) . '</option>';
		}

		if ( ! empty( $min_price_array ) && function_exists( 'rhea_get_custom_price' ) ) {
			foreach ( $min_price_array as $price ) {
				if ( $minimum_price == $price ) {
					echo '<option value="' . $price . '" selected="selected">' . rhea_get_custom_price( $price ) . '</option>';
				} else {
					echo '<option value="' . $price . '">' . rhea_get_custom_price( $price ) . '</option>';
				}
			}
		}

	}
}

if ( ! function_exists( 'rhea_get_custom_price' ) ) {
	/**
	 * Return custom price in configured format
	 *
	 * @param $amount
	 *
	 * @return bool|string
	 */
	function rhea_get_custom_price( $amount ) {
		// Return if amount is empty or not a number.
		if ( empty( $amount ) || is_nan( $amount ) ) {
			return '';
		}

		// If RealHomes Currency Switcher plugin is installed and current currency cookie is set.
		if ( function_exists( 'realhomes_currency_switcher_enabled' ) && realhomes_currency_switcher_enabled() ) {
			$formatted_converted_price = realhomes_switch_currency( $amount );
			return apply_filters( 'inspiry_property_converted_price', $formatted_converted_price, $amount );
		} else {
			$currency_sign       = ere_get_currency_sign();
			$decimals            = intval( get_option( 'theme_decimals', '0' ) );
			$decimal_point       = get_option( 'theme_dec_point', '.' );
			$thousands_separator = get_option( 'theme_thousands_sep', ',' );
			$currency_position   = get_option( 'theme_currency_position', 'after' );
			$formatted_price     = number_format( $amount, $decimals, $decimal_point, $thousands_separator );
			$formatted_price     = apply_filters( 'inspiry_property_price', $formatted_price, $amount );
			return ( 'after' == $currency_position ) ? $formatted_price . $currency_sign : $currency_sign . $formatted_price ;
		}
	}
}



if ( ! function_exists( 'rhea_max_prices_list' ) ) {
	/**
	 * Maximum Prices
	 */
	function rhea_max_prices_list($placeholder,$values) {

		$max_price_array = array(
			5000,
			10000,
			50000,
			100000,
			200000,
			300000,
			400000,
			500000,
			600000,
			700000,
			800000,
			900000,
			1000000,
			1500000,
			2000000,
			2500000,
			5000000,
			10000000
		);

		/* Get values from theme options and convert them to an integer array */
		$maximum_price_values = $values;
		if ( ! empty( $maximum_price_values ) ) {
			$max_prices_string_array = explode( ',', $maximum_price_values );
			if ( is_array( $max_prices_string_array ) && ! empty( $max_prices_string_array ) ) {
				$new_max_prices_array = array();
				foreach ( $max_prices_string_array as $string_price ) {
					$integer_price = doubleval( $string_price );
					if ( $integer_price > 1 ) {
						$new_max_prices_array[] = $integer_price;
					}
				}
				if ( ! empty( $new_max_prices_array ) ) {
					$max_price_array = $new_max_prices_array;
				}
			}
		}

		$maximum_price = '';
		if ( isset( $_GET['max-price'] ) ) {
			$maximum_price = doubleval( $_GET['max-price'] );
		}



		if ( ! empty( $placeholder ) ) {
			echo '<option value="' . esc_attr( rhea_any_value() ) . '" selected="selected">' . esc_html( $placeholder ) . '</option>';
		} else {
			echo '<option value="' . esc_attr( rhea_any_value() ) . '">' . esc_html__( 'Max Price', 'realhomes-elementor-addon' ) . '</option>';
		}

		if ( ! empty( $max_price_array ) && function_exists( 'rhea_get_custom_price' ) ) {
			foreach ( $max_price_array as $price ) {
				if ( $maximum_price == $price ) {
					echo '<option value="' . $price . '" selected="selected">' . rhea_get_custom_price( $price ) . '</option>';
				} else {
					echo '<option value="' . $price . '">' . rhea_get_custom_price( $price ) . '</option>';
				}
			}
		}
	}
}

if ( ! function_exists( 'rhea_min_prices_for_rent_list' ) ) {
	/**
	 * Minimum Prices For Rent Only
	 */
	function rhea_min_prices_for_rent_list($placeholder,$values) {

		$min_price_for_rent_array = array(
			500,
			1000,
			2000,
			3000,
			4000,
			5000,
			7500,
			10000,
			15000,
			20000,
			25000,
			30000,
			40000,
			50000,
			75000,
			100000
		);

		/* Get values from theme options and convert them to an integer array */
		$minimum_price_values_for_rent = $values;
		if ( ! empty( $minimum_price_values_for_rent ) ) {
			$min_prices_string_array = explode( ',', $minimum_price_values_for_rent );
			if ( is_array( $min_prices_string_array ) && ! empty( $min_prices_string_array ) ) {
				$new_min_prices_array = array();
				foreach ( $min_prices_string_array as $string_price ) {
					$integer_price = doubleval( $string_price );
					if ( $integer_price > 1 ) {
						$new_min_prices_array[] = $integer_price;
					}
				}
				if ( ! empty( $new_min_prices_array ) ) {
					$min_price_for_rent_array = $new_min_prices_array;
				}
			}
		}

		$minimum_price = '';
		if ( isset( $_GET['min-price'] ) ) {
			$minimum_price = doubleval( $_GET['min-price'] );
		}

		if ( ! empty( $placeholder ) ) {
			echo '<option value="' . esc_attr( rhea_any_value() ) . '" selected="selected">' . esc_html( $placeholder ) . '</option>';
		} else {
			echo '<option value="' . esc_attr( rhea_any_value() ) . '">' . esc_html__( 'Min Price', 'realhomes-elementor-addon' ) . '</option>';
		}


		if ( ! empty( $min_price_for_rent_array ) && function_exists( 'rhea_get_custom_price' ) ) {
			foreach ( $min_price_for_rent_array as $price ) {
				if ( $minimum_price == $price ) {
					echo '<option value="' . $price . '" selected="selected">' . rhea_get_custom_price( $price ) . '</option>';
				} else {
					echo '<option value="' . $price . '">' . rhea_get_custom_price( $price ) . '</option>';
				}
			}
		}

	}
}

if ( ! function_exists( 'rhea_max_prices_for_rent_list' ) ) {
	/**
	 * Maximum Price For Rent Only
	 */
	function rhea_max_prices_for_rent_list($placeholder,$values) {

		$max_price_for_rent_array = array(
			1000,
			2000,
			3000,
			4000,
			5000,
			7500,
			10000,
			15000,
			20000,
			25000,
			30000,
			40000,
			50000,
			75000,
			100000,
			150000
		);

		/* Get values from theme options and convert them to an integer array */
		$maximum_price_for_rent_values = $values;
		if ( ! empty( $maximum_price_for_rent_values ) ) {
			$max_prices_string_array = explode( ',', $maximum_price_for_rent_values );
			if ( is_array( $max_prices_string_array ) && ! empty( $max_prices_string_array ) ) {
				$new_max_prices_array = array();
				foreach ( $max_prices_string_array as $string_price ) {
					$integer_price = doubleval( $string_price );
					if ( $integer_price > 1 ) {
						$new_max_prices_array[] = $integer_price;
					}
				}
				if ( ! empty( $new_max_prices_array ) ) {
					$max_price_for_rent_array = $new_max_prices_array;
				}
			}
		}

		$maximum_price = '';
		if ( isset( $_GET['max-price'] ) ) {
			$maximum_price = doubleval( $_GET['max-price'] );
		}

		if ( ! empty( $placeholder ) ) {
			echo '<option value="' . esc_attr( rhea_any_value() ) . '" selected="selected">' . esc_html( $placeholder ) . '</option>';
		} else {
			echo '<option value="' . esc_attr( rhea_any_value() ) . '">' . esc_html__( 'Max Price', 'realhomes-elementor-addon' ) . '</option>';
		}


		if ( ! empty( $max_price_for_rent_array ) && function_exists( 'rhea_get_custom_price' ) ) {
			foreach ( $max_price_for_rent_array as $price ) {
				if ( $maximum_price == $price ) {
					echo '<option value="' . $price . '" selected="selected">' . rhea_get_custom_price( $price ) . '</option>';
				} else {
					echo '<option value="' . $price . '">' . rhea_get_custom_price( $price ) . '</option>';
				}
			}
		}

	}
}

if ( ! function_exists( 'rhea_advance_search_options' ) ) {
	/**
	 * Advance search options (List boxes listing in advance-search.php)
	 *
	 * @param $taxonomy_name
	 * @param array $args
	 *
	 * @return bool
	 */
	function rhea_advance_search_options( $default,$placeholder,$taxonomy_name, $args = array() ) {

		$defaults = array(
			'taxonomy' => $taxonomy_name
		);

		$args           = wp_parse_args( $args, $defaults );
		$taxonomy_terms = get_terms( $args );

		if ( empty( $taxonomy_terms ) || is_wp_error( $taxonomy_terms ) ) {
			return false;
		}

		$searched_term = '';

		if ( $taxonomy_name == 'property-city' ) {
			if ( ! empty( $_GET['location'] ) ) {
				$searched_term = $_GET['location'];
			}
		}

		if ( $taxonomy_name == 'property-type' ) {
			if ( ! empty( $_GET['type'] ) ) {
				$searched_term = $_GET['type'];
			}
		}

		if ( $taxonomy_name == 'property-status' ) {
			if ( ! empty( $_GET['status'] ) ) {
				$searched_term = $_GET['status'];
			}
		}

		if ( ! empty( $placeholder ) ) {
			echo '<option value="' . rhea_any_value() . '">' . esc_html( $placeholder ) . '</option>';
		} else {
			echo '<option value="' . rhea_any_value() . '">' . esc_html__( 'All Statuses', 'realhomes-elementor-addon' ) . '</option>';
		}

		if ( ! empty( $taxonomy_terms ) ) {
			foreach ( $taxonomy_terms as $term ) {
				if ( $searched_term == $term->slug ) {
					echo '<option value="' . $term->slug . '" selected="selected">' . $term->name . '</option>';
				} else {
					if($default == $term->slug){
						$selected = ' selected="selected" ';
					}else{
						$selected = '';
					}
					echo '<option value="' . $term->slug . '" '.$selected.'>' . $term->name . '</option>';
				}
			}
		}

	}
}

if ( ! function_exists( 'rhea_advance_hierarchical_options' ) ) {
	/**
	 * Advance hierarchical options
	 *
	 * @param $taxonomy_name
	 */
	function rhea_advance_hierarchical_options( $taxonomy_name ) {
		$taxonomy_terms = get_terms( array(
			'taxonomy'   => $taxonomy_name,
			'hide_empty' => false,
			'parent'     => 0
		) );
		$searched_term  = '';

		if ( $taxonomy_name == 'property-city' ) {
			if ( ! empty( $_GET['location'] ) ) {
				$searched_term = $_GET['location'];
			}
		}

		if ( $taxonomy_name == 'property-type' ) {
			if ( ! empty( $_GET['type'] ) ) {
				$searched_term = $_GET['type'];
			}
		}

//		$get_select_placeholder = get_option( 'inspiry_property_type_placeholder' );
//		if ( ! empty( $get_select_placeholder ) ) {
//			$default_slelect = $get_select_placeholder;
//		} else {
//			$default_slelect = rhea_any_text();
//		}
//
//		if ( $searched_term == rhea_any_value() || empty( $searched_term ) ) {
//			echo '<option value="' . rhea_any_value() . '" selected="selected">' . esc_html( $default_slelect ) . '</option>';
//		} else {
//			echo '<option value="' . rhea_any_value() . '">' . esc_html( $default_slelect ) . '</option>';
//		}

		// Generate options
		rhea_generate_hirarchical_options( $taxonomy_name, $taxonomy_terms, $searched_term );
	}
}

if ( ! function_exists( 'rhea_generate_hirarchical_options' ) ) {
	/**
	 * Generate Hierarchical Options
	 *
	 * @param $taxonomy_name
	 * @param $taxonomy_terms
	 * @param $searched_term
	 * @param string $prefix
	 */
	function rhea_generate_hirarchical_options( $taxonomy_name, $taxonomy_terms, $searched_term, $prefix = " " ) {
		if ( ! empty( $taxonomy_terms ) ) {
			foreach ( $taxonomy_terms as $term ) {
				if ( $searched_term == $term->slug ) {
					echo '<option value="' . $term->slug . '" selected="selected">' . $prefix . $term->name . '</option>';
				} else {
					echo '<option value="' . $term->slug . '">' . $prefix . $term->name . '</option>';
				}
				$child_terms = get_terms( array(
					'taxonomy'   => $taxonomy_name,
					'hide_empty' => false,
					'parent'     => $term->term_id
				) );

				if ( is_wp_error( $child_terms ) ) {
					error_log( $child_terms->get_error_message() );

					return;
				}

				if ( ! empty( $child_terms ) ) {
					// recursive call
					rhea_generate_hirarchical_options( $taxonomy_name, $child_terms, $searched_term, "- " . $prefix );
				}
			}
		}
	}
}

if ( ! function_exists( 'rhea_get_location_select_names' ) ) :
	/**
	 * Return location select names
	 *
	 * @return mixed|void
	 */
	function rhea_get_location_select_names() {
		$location_select_names = array(
			'location',
			'child-location',
			'grandchild-location',
			'great-grandchild-location'
		);

		return apply_filters( 'rhea_location_select_names', $location_select_names );
	}
endif;

if ( ! function_exists( 'rhea_get_location_select_ids' ) ) :
	/**
	 * Return location select names
	 *
	 * @return mixed|void
	 */
	function rhea_get_location_select_ids( $prefix = '' ) {
		$location_select_ids = array(
			$prefix . 'location',
			$prefix . 'child-location',
			$prefix . 'grandchild-location',
			$prefix . 'great-grandchild-location'
		);

		return apply_filters( 'rhea_location_select_ids', $location_select_ids );
	}
endif;

if ( ! function_exists( 'rhea_get_location_titles' ) ) :
	/**
	 * Get location titles
	 *
	 * @return array Location titles
	 */
	function rhea_get_location_titles( $l1, $l2, $l3, $l4 ) {

		$location_select_titles = array();

		if ( ! empty( $l1 ) ) {
			$location_select_titles[] = esc_html( $l1 );
		} else {
			$location_select_titles[] = esc_html__( 'Main Location', 'framework' );
		}

		if ( ! empty( $l2 ) ) {
			$location_select_titles[] = esc_html( $l2 );
		} else {
			$location_select_titles[] = esc_html__( 'Child Location', 'framework' );
		}

		if ( ! empty( $l3 ) ) {
			$location_select_titles[] = esc_html( $l3 );
		} else {
			$location_select_titles[] = esc_html__( 'Grand Child Location', 'framework' );
		}

		if ( ! empty( $l4 ) ) {
			$location_select_titles[] = esc_html( $l4 );
		} else {
			$location_select_titles[] = esc_html__( 'Great Grand Child Location', 'framework' );
		}



		return $location_select_titles;
	}
endif;

if ( ! function_exists( 'rhea_location_placeholder' ) ) {
	function rhea_location_placeholder($l1, $l2, $l3, $l4) {
		$location_placeholder_array = array();

		if ( ! empty( $l1 ) ) {
			$location_placeholder_array[] = esc_html( $l1 );
		} else {
			$location_placeholder_array[] = esc_html__( 'All Main Location', 'framework' );
		}

		if ( ! empty( $l2 ) ) {
			$location_placeholder_array[] = esc_html( $l2 );
		} else {
			$location_placeholder_array[] = esc_html__( 'All Child Location', 'framework' );
		}

		if ( ! empty( $l3 ) ) {
			$location_placeholder_array[] = esc_html( $l3 );
		} else {
			$location_placeholder_array[] = esc_html__( 'All Grand Child Location', 'framework' );
		}

		if ( ! empty( $l4 ) ) {
			$location_placeholder_array[] = esc_html( $l4 );
		} else {
			$location_placeholder_array[] = esc_html__( 'All Great Grand Child Location', 'framework' );
		}


		return $location_placeholder_array;
	}
}

if ( ! function_exists( 'rhea_get_locations_number' ) ) :
	/**
	 * Return number of location boxes required in search form
	 *
	 * @return int number of locations
	 */
	function rhea_get_locations_number($number,$is_ajax) {

		$is_location_ajax = $is_ajax; // Option to check if location field Ajax is enabled

		if ( 'yes' !== $is_location_ajax ) {
			$location_select_count = intval( $number );
			if ( ! ( $location_select_count > 0 && $location_select_count < 5 ) ) {
				$location_select_count = 1;
			}

			return $location_select_count;
		}

		return 1;
	}
endif;

if ( ! function_exists( 'rhea_get_min_max_price' ) ) {

	/**
	 * Returns Min/Max values of property post type.
	 *
	 * @param $range
	 *
	 * @return mixed
	 */

	function rhea_get_min_max_price( $range = 'min' ) {

		$value           = 0;
		$rhea_price_args = array(
			'posts_per_page' => - 1,
			'post_type'      => 'property',
			'orderby'        => 'meta_value_num',
			'order'          => 'ASC',
			'meta_query'     => array(
				array(
					'key' => 'REAL_HOMES_property_price',
					'value' => '^[0-9]*$', // must be only numbers
					'compare' => 'REGEXP'
				)
			)
		);

		$loop = new WP_Query( $rhea_price_args );

		$last = ( end( $loop->posts ) );


		if ( 'min' == $range ) {
			if(is_numeric(get_post_meta( $loop->posts[0]->ID, 'REAL_HOMES_property_price', true ))){
			$value = get_post_meta( $loop->posts[0]->ID, 'REAL_HOMES_property_price', true );
			}else{
				$value = '1';
			}

		}
		if ( 'max' == $range ) {
			$value = get_post_meta( $last->ID, 'REAL_HOMES_property_price', true );
		}

		return $value;

	}
}

if ( ! function_exists( 'rhea_get_plain_property_price' ) ) {
	/**
	 * Returns property price in configured format
	 *
	 * @return mixed|string
	 */
	function rhea_get_plain_property_price($amount) {

		if ( empty( $amount ) || is_nan( $amount ) ) {
			return '';
		}

		// If RealHomes Currency Switcher plugin is installed and current currency cookie is set.
		if ( function_exists( 'realhomes_currency_switcher_enabled' ) && realhomes_currency_switcher_enabled() ) {
			$formatted_converted_price = rhea_switch_currency_plain( $amount );
			return apply_filters( 'inspiry_property_converted_price', $formatted_converted_price, $amount );
		} else {
			return $amount;
		}

	}
}