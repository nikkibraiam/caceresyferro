<?php
/**
 * Contains Basic Functions for RealHomes Elementor Addon plugin.
 */

/**
 * Get template part for RHEA plugin.
 *
 * @access public
 *
 * @param mixed $slug Template slug.
 * @param string $name Template name (default: '').
 */
function rhea_get_template_part( $slug, $name = '' ) {
	$template = '';

	// Get slug-name.php.
	if ( ! $template && $name && file_exists( RHEA_PLUGIN_DIR . "/{$slug}-{$name}.php" ) ) {
		$template = RHEA_PLUGIN_DIR . "/{$slug}-{$name}.php";
	}

	// Get slug.php.
	if ( ! $template && file_exists( RHEA_PLUGIN_DIR . "/{$slug}.php" ) ) {
		$template = RHEA_PLUGIN_DIR . "/{$slug}.php";
	}

	// Allow 3rd party plugins to filter template file from their plugin.
	$template = apply_filters( 'rhea_get_template_part', $template, $slug, $name );

	if ( $template ) {
		load_template( $template, false );
	}
}


if ( ! function_exists( 'rhea_allowed_tags' ) ) :
	/**
	 * Returns array of allowed tags to be used in wp_kses function.
	 *
	 * @return array
	 */
	function rhea_allowed_tags() {

		return array(
			'a'      => array(
				'href'  => array(),
				'title' => array(),
				'alt'   => array(),
			),
			'b'      => array(),
			'br'     => array(),
			'div'    => array(
				'class' => array(),
				'id'    => array(),
			),
			'em'     => array(),
			'strong' => array(),
		);

	}
endif;


if ( ! function_exists( 'rhea_list_gallery_images' ) ) {
	/**
	 * Get list of Gallery Images - use in gallery post format
	 *
	 * @param string $size
	 */
	function rhea_list_gallery_images( $size = 'post-featured-image' ) {

		$gallery_images = rwmb_meta( 'REAL_HOMES_gallery', 'type=plupload_image&size=' . $size, get_the_ID() );

		if ( ! empty( $gallery_images ) ) {
			foreach ( $gallery_images as $gallery_image ) {
				$caption = ( ! empty( $gallery_image['caption'] ) ) ? $gallery_image['caption'] : $gallery_image['alt'];
				echo '<li><a href="' . esc_url( $gallery_image['full_url'] ) . '" title="' . esc_attr( $caption ) . '" class="' . esc_attr( rhea_get_lightbox_plugin_class() ) . '">';
				echo '<img src="' . esc_url( $gallery_image['url'] ) . '" alt="' . esc_attr( $gallery_image['title'] ) . '" />';
				echo '</a></li>';
			}
		} else if ( has_post_thumbnail( get_the_ID() ) ) {
			echo '<li><a href="' . get_permalink() . '" title="' . get_the_title() . '" >';
			the_post_thumbnail( $size );
			echo '</a></li>';
		}
	}
}


if ( ! function_exists( 'rhea_get_lightbox_plugin_class' ) ) {
	/**
	 * Get Lightbox Plugin Class
	 *
	 * @return string
	 */
	function rhea_get_lightbox_plugin_class() {
		return get_option( 'theme_lightbox_plugin', 'swipebox' );
	}
}


if ( ! function_exists( 'rhea_framework_excerpt' ) ) {
	/**
	 * Output custom excerpt of required length
	 *
	 * @param int $len number of words
	 * @param string $trim string to appear after excerpt
	 */
	function rhea_framework_excerpt( $len = 15, $trim = "&hellip;" ) {
		echo rhea_get_framework_excerpt( $len, $trim );
	}
}


if ( ! function_exists( 'rhea_get_framework_excerpt' ) ) {
	/**
	 * Returns custom excerpt of required length
	 *
	 * @param int $len number of words
	 * @param string $trim string after excerpt
	 *
	 * @return string
	 */
	function rhea_get_framework_excerpt( $len = 15, $trim = "&hellip;" ) {
		$limit     = $len + 1;
		$excerpt   = explode( ' ', get_the_excerpt(), $limit );
		$num_words = count( $excerpt );
		if ( $num_words >= $len ) {
			array_pop( $excerpt );
		} else {
			$trim = "";
		}
		$excerpt = implode( " ", $excerpt ) . "$trim";

		return $excerpt;
	}
}

if ( ! function_exists( 'RHEA_ajax_pagination' ) ) {
	/**
	 * Function for Widgets AJAX pagination
	 *
	 * @param string $pages
	 */
	function RHEA_ajax_pagination( $pages = '' ) {

		global $wp_query;

		$paged = 1;
		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) { // if is static front page
			$paged = get_query_var( 'page' );
		}

		$prev          = $paged - 1;
		$next          = $paged + 1;
		$range         = 3;                             // change it to show more links
		$pages_to_show = ( $range * 2 ) + 1;

		if ( $pages == '' ) {
			$pages = $wp_query->max_num_pages;
			if ( ! $pages ) {
				$pages = 1;
			}
		}

		if ( 1 != $pages ) {
			echo "<div class='rhea_pagination_wrapper'>";
			echo "<div class='pagination rhea-pagination-clean'>";

			if ( ( $paged > 2 ) && ( $paged > $range + 1 ) && ( $pages_to_show < $pages ) ) {
				echo "<a href='" . get_pagenum_link( 1 ) . "' class='real-btn'> " . esc_html__( 'First', 'realhomes-elementor-addon' ) . "</a> "; // First Page
			}

			if ( ( $paged > 1 ) && ( $pages_to_show < $pages ) ) {
				echo "<a href='" . get_pagenum_link( $prev ) . "' class='real-btn'> " . esc_html__( 'Prev', 'realhomes-elementor-addon' ) . "</a> "; // Previous Page
			}

			$min_page_number = $paged - $range - 1;
			$max_page_number = $paged + $range + 1;

			for ( $i = 1; $i <= $pages; $i ++ ) {
				if ( ( ( $i > $min_page_number ) && ( $i < $max_page_number ) ) || ( $pages <= $pages_to_show ) ) {
					$current_class = 'real-btn';
					$current_class .= ( $paged == $i ) ? ' current' : '';
					echo "<a href='" . get_pagenum_link( $i ) . "' class='" . $current_class . "' >" . $i . "</a> ";
				}
			}

			if ( ( $paged < $pages ) && ( $pages_to_show < $pages ) ) {
				echo "<a href='" . get_pagenum_link( $next ) . "' class='real-btn'>" . esc_html__( 'Next', 'realhomes-elementor-addon' ) . " </a> "; // Next Page
			}

			if ( ( $paged < $pages - 1 ) && ( $paged + $range - 1 < $pages ) && ( $pages_to_show < $pages ) ) {
				echo "<a href='" . get_pagenum_link( $pages ) . "' class='real-btn'>" . esc_html__( 'Last', 'realhomes-elementor-addon' ) . " </a> "; // Last Page
			}

			echo "</div>";
			echo "</div>";
		}
	}
}

if ( ! function_exists( 'rhea_property_price' ) ) {
	/**
	 * Output property price
	 */
	function rhea_property_price() {
		echo rhea_get_property_price();
	}
}

if ( ! function_exists( 'rhea_get_property_price' ) ) {
	/**
	 * Returns property price in configured format
	 *
	 * @return mixed|string
	 */
	function rhea_get_property_price() {

		// get property price
		$price_digits = doubleval( get_post_meta( get_the_ID(), 'REAL_HOMES_property_price', true ) );

		if ( $price_digits ) {
			// get price prefix and postfix
			$price_pre_fix  = get_post_meta( get_the_ID(), 'REAL_HOMES_property_price_prefix', true );
			$price_post_fix = get_post_meta( get_the_ID(), 'REAL_HOMES_property_price_postfix', true );

			// if wp-currencies plugin installed and current currency cookie is set
			if ( class_exists( 'WP_Currencies' ) && isset( $_COOKIE["current_currency"] ) ) {
				$current_currency = $_COOKIE["current_currency"];
				if ( currency_exists( $current_currency ) ) {    // validate current currency
					$base_currency             = ere_get_base_currency();
					$converted_price           = convert_currency( $price_digits, $base_currency, $current_currency );
					$formatted_converted_price = format_currency( $converted_price, $current_currency );
					$formatted_converted_price = apply_filters( 'inspiry_property_converted_price', $formatted_converted_price, $price_digits );

					return $price_pre_fix . ' ' . $formatted_converted_price . ' ' . $price_post_fix;
				}
			}

			// otherwise go with default approach.
			$currency            = ere_get_currency_sign();
			$decimals            = intval( get_option( 'theme_decimals', '0' ) );
			$decimal_point       = get_option( 'theme_dec_point', '.' );
			$thousands_separator = get_option( 'theme_thousands_sep', ',' );
			$currency_position   = get_option( 'theme_currency_position' );
			$formatted_price     = number_format( $price_digits, $decimals, $decimal_point, $thousands_separator );
			$formatted_price     = apply_filters( 'inspiry_property_price', $formatted_price, $price_digits );

			if ( 'after' === $currency_position ) {
				return $price_pre_fix . ' ' . $formatted_price . $currency . ' <span>' . $price_post_fix . '</span>';
			} else {
				return $price_pre_fix . ' ' . $currency . $formatted_price . ' <span>' . $price_post_fix . '</span>';
			}

		} else {
			return ere_no_price_text();
		}
	}
}

if ( ! function_exists( 'rhea_display_property_label' ) ) {
	/**
	 * Display property label
	 *
	 * @param $post_id
	 */
	function rhea_display_property_label( $post_id ) {

		$label_text = get_post_meta( $post_id, 'inspiry_property_label', true );
		$color      = get_post_meta( $post_id, 'inspiry_property_label_color', true );
		if ( ! empty ( $label_text ) ) {
			?>
            <span style="background: <?php echo esc_attr( $color ); ?>"
                  class='rhea-property-label'><?php echo esc_html( $label_text ); ?></span>
			<?php

		}
	}
}

if ( ! function_exists( 'rhea_get_maps_type' ) ) {
	/**
	 * Returns the type currently available for use.
	 */
	function rhea_get_maps_type() {
		$google_maps_api_key = get_option( 'inspiry_google_maps_api_key', false );

		if ( ! empty( $google_maps_api_key ) ) {
			return 'google-maps';    // For Google Maps
		}

		return 'open-street-map';    // For OpenStreetMap https://www.openstreetmap.org/
	}
}

if ( ! function_exists( 'rhea_switch_currency_plain' ) ) {
	/**
	 * Convert and format given amount from base currency to current currency.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $amount Amount in digits to change currency for.
	 *
	 * @return string
	 */
	function rhea_switch_currency_plain( $amount ) {

		if ( function_exists( 'realhomes_currency_switcher_enabled' ) && realhomes_currency_switcher_enabled() ) {
			$base_currency    = realhomes_get_base_currency();
			$current_currency = realhomes_get_current_currency();
			$converted_amount = realhomes_convert_currency( $amount, $base_currency, $current_currency );

			return apply_filters( 'realhomes_switch_currency', $converted_amount );
		}
	}
}


if ( ! function_exists( 'rhea_get_location_options' ) ) {

	/**
	 * Return Property Locations as Options List in Json format
	 */
	function rhea_get_location_options() {


		$options         = array(); // A list of location options will be passed to this array
		$number          = 30; // Number of locations that will be returned per Ajax request
		$locations_order = array(
			'orderby' => 'count',
			'order'   => 'desc',
		);


		if ( isset( $_GET['sortplpha'] ) && 'yes' == $_GET['sortplpha'] ) {
			$locations_order['orderby'] = 'name';
			$locations_order['order']   = 'asc';
		}


		if ( isset( $_GET['hideemptyfields'] ) && 'yes' == $_GET['hideemptyfields'] ) {
			$hide_empty_location = true;
		} else {
			$hide_empty_location = false;
		}


		// Prepare a query to fetch property locations from database
		$terms_query = array(
			'taxonomy'   => 'property-city',
			'number'     => $number,
			'hide_empty' => $hide_empty_location,
			'orderby'    => $locations_order['orderby'],
			'order'      => $locations_order['order'],
		);

		// If there is a search parameter
		if ( isset( $_GET['keyword'] ) ) {
			$terms_query['name__like'] = $_GET['keyword'];
		}

		$locations = get_terms( $terms_query );

		// Build an array of locations info form their objects
		if ( ! empty( $locations ) && ! is_wp_error( $locations ) ) {
			foreach ( $locations as $location ) {
				$options[] = array( $location->slug, $location->name );
			}
		}

		echo json_encode( $options ); // Return locations list in Json format
		die;
	}

	add_action( 'wp_ajax_rhea_get_location_options', 'rhea_get_location_options' );
	add_action( 'wp_ajax_nopriv_rhea_get_location_options', 'rhea_get_location_options' );

}

if ( ! function_exists( 'rhea_rvr_rating_average' ) ) {
	/**
	 * Display rating average based on approved comments with rating
	 */
	function rhea_rvr_rating_average() {

		$args = array(
			'post_id' => get_the_ID(),
			'status'  => 'approve',
		);

		$comments = get_comments( $args );
		$ratings  = array();
		$count    = 0;

		foreach ( $comments as $comment ) {

			$rating = get_comment_meta( $comment->comment_ID, 'inspiry_rating', true );

			if ( ! empty( $rating ) ) {
				$ratings[] = absint( $rating );
				$count ++;
			}
		}


		$allowed_html = array(
			'span' => array(
				'class' => array(),
			),
			'i'    => array(
				'class' => array(),
			),
		);

		if ( 0 !== count( $ratings ) ) {

			$values_count = ( array_count_values( $ratings ) );


			$avg = round( array_sum( $ratings ) / count( $ratings ), 2 );
			?>
            <div class="rhea_rvr_ratings">
                <div class="rhea_stars_avg_rating"
                     title="<?php echo esc_html( $avg ) . ' / ' . esc_html__( '5 based on', 'framework' ) . ' ' . esc_html( $count ) . ' ' . esc_html__( 'reviews', 'framework' );
				     ?>"
                >
					<?php
					echo wp_kses( rhea_rating_stars( $avg ), $allowed_html );
					?>

                    <div class="rhea_wrapper_rating_info">

                        <?php


                        $i = 5;
                        while($i>0) {
	                        ?>
                            <p class="rhea_rating_percentage">
                            <span class="rhea_rating_sorting_label">
                                <?php
                                 printf(_nx('%s Star','%s Stars', $i , 'Rating Stars' , 'realhomes-elementor-addon'), number_format_i18n( $i ));
                                ?>
                            </span>
		                        <?php
                                if (isset($values_count[$i]) && !empty($values_count[$i]) ){
                                $stars = round( ( $values_count[$i] / (count( $ratings )) ) * 100 );
                                }else{
	                                $stars = 0;
                                }
                                ?>

                                <span class="rhea_rating_line">
                                <span class="rhea_rating_line_inner" style="width: <?php echo esc_attr( $stars ); ?>%"></span>
                            </span>

                                <span class="rhea_rating_text">
                            <span class="rhea_rating_text_inner">

                                <?php echo esc_html( $stars ) . '%' ?>
                            </span>
                            </span>
                            </p>
                            <?php

	                        $i--;
                        }
                        ?>




                    </div>
                </div>
            </div>
			<?php

		}
	}
}

if ( ! function_exists( 'rhea_rating_stars' ) ) {
	/**
	 * Display rated stars based on given number of rating
	 *
	 * @param int $rating - Average rating.
	 *
	 * @return string
	 */
	function rhea_rating_stars( $rating ) {

		$output = '';

		if ( ! empty( $rating ) ) {

			$whole    = floor( $rating );
			$fraction = $rating - $whole;

			$round = round( $fraction, 2 );

			$output = '<span class="rating-stars">';

			for ( $count = 1; $count <= $whole; $count ++ ) {
				$output .= '<i class="fas fa-star rated"></i>'; //3
			}
			$half = 0;
			if ( $round <= .24 ) {
				$half = 0;
			} elseif ( $round >= .25 && $round <= .74 ) {
				$half   = 1;
				$output .= '<i class="fas fa-star-half-alt"></i>';
			} elseif ( $round >= .75 ) {
				$half   = 1;
				$output .= '<i class="fas fa-star rated"></i>';
			}

			$unrated = 5 - ( $whole + $half );
			for ( $count = 1; $count <= $unrated; $count ++ ) {
				$output .= '<i class="far fa-star"></i>';
			}

			$output .= '</span>';
		}

		return $output;
	}
}
