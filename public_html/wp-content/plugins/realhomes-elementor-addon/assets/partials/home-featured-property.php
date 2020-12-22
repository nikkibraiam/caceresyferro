<?php
/**
 * Featured Property Card
 *
 * Featured property card to be displayed on homepage.
 *
 */
global $settings;
$property_size      = get_post_meta( get_the_ID(), 'REAL_HOMES_property_size', true );
$size_postfix       = get_post_meta( get_the_ID(), 'REAL_HOMES_property_size_postfix', true );
$property_bedrooms  = get_post_meta( get_the_ID(), 'REAL_HOMES_property_bedrooms', true );
$property_bathrooms = get_post_meta( get_the_ID(), 'REAL_HOMES_property_bathrooms', true );
$property_address   = get_post_meta( get_the_ID(), 'REAL_HOMES_property_address', true );

?>

<li <?php post_class( 'rh_prop_card' ); ?>>

    <figure class="rh_prop_card__thumbnail_elementor">
        <a href="<?php the_permalink(); ?>">
			<?php
			if ( has_post_thumbnail( get_the_ID() ) ) {
				the_post_thumbnail( 'property-detail-video-image' );
			} else {
				inspiry_image_placeholder( 'property-detail-video-image' );
			}
			?>
        </a>
    </figure>

    <div class="rh_prop_card__details_elementor rh_prop_card__featured">

        <div class="rh_label_elementor rhea_label__property">
            <div class="rh_label__wrap_elementor">

				<?php
				if ( ! empty( $settings['ere_property_featured_label'] ) ) {
					echo esc_html( $settings['ere_property_featured_label'] );
				} else {
					esc_html_e( 'Featured', 'realhomes-elementor-addon' );
				}
				?>
                <span></span>
            </div>
        </div>

        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>


        <p class="rh_prop_card__excerpt"><?php rhea_framework_excerpt( esc_html( $settings['featured_excerpt_length'] ) ); ?></p>

        <div class="rh_prop_card__meta_wrap_elementor">

			<?php if ( ! empty( $property_bedrooms ) ) : ?>

                <div class="rh_prop_card__meta">
                    <span class="rhea_meta_titles"><?php
	                    if ( $settings['ere_property_bedrooms_label'] ) {
		                    echo esc_html( $settings['ere_property_bedrooms_label'] );
	                    } else {
		                    esc_html_e( 'Bedrooms', 'realhomes-elementor-addon' );
	                    }
	                    ?></span>
                    <div>
						<?php include RHEA_ASSETS_DIR . '/icons/bed.svg'; ?>
                        <span class="figure"><?php echo esc_html( $property_bedrooms ); ?></span>
                    </div>
                </div>
			<?php endif; ?>

			<?php if ( ! empty( $property_bathrooms ) ) : ?>
                <div class="rh_prop_card__meta">
                    <span class="rhea_meta_titles"><?php
	                    if ( $settings['ere_property_bathrooms_label'] ) {
		                    echo esc_html( $settings['ere_property_bathrooms_label'] );
	                    } else {
		                    esc_html_e( 'Bathrooms', 'realhomes-elementor-addon' );
	                    }
	                    ?></span>
                    <div>
						<?php include RHEA_ASSETS_DIR . '/icons/shower.svg'; ?>
                        <span class="figure"><?php echo esc_html( $property_bathrooms ); ?></span>
                    </div>
                </div>
			<?php endif; ?>


			<?php
			if ( inspiry_is_rvr_enabled() ) {
				$post_meta_data = get_post_custom( get_the_ID() );
				if ( ! empty( $post_meta_data['rvr_guests_capacity'][0] ) ) : ?>
                    <div class="rh_prop_card__meta">
                            <span class="rhea_meta_titles">
                                <?php
                                if ( ! empty( $settings['ere_property_guests_label'] ) ) {
	                                echo esc_html( $settings['ere_property_guests_label'] );
                                } else {
	                                esc_html_e( 'Guests', 'realhomes-elementor-addon' );
                                }
                                ?>
                            </span>
                        <div>
							<?php include RHEA_ASSETS_DIR . '/icons/guests-icons.svg'; ?>
                            <span class="figure"><?php echo esc_html( $post_meta_data['rvr_guests_capacity'][0] ); ?></span>
                        </div>
                    </div>
                    <!-- /.rh_property__meta -->
				<?php endif;
			}
			?>

			<?php if ( ! empty( $property_size ) ) : ?>
                <div class="rh_prop_card__meta">
                    <span class="rhea_meta_titles"><?php
	                    if ( $settings['ere_property_area_label'] ) {
		                    echo esc_html( $settings['ere_property_area_label'] );
	                    } else {
		                    esc_html_e( 'Area', 'realhomes-elementor-addon' );
	                    }
	                    ?></span>
                    <div>
						<?php include RHEA_ASSETS_DIR . '/icons/area.svg'; ?>
                        <span class="figure"><?php echo esc_html( $property_size ); ?></span>
						<?php if ( ! empty( $size_postfix ) ) : ?>
                            <span class="label"><?php echo esc_html( $size_postfix ); ?></span>
						<?php endif; ?>
                    </div>
                </div>
			<?php endif; ?>

        </div>

		<?php
		if ( inspiry_is_rvr_enabled() ) {
			?>
            <div class="rh_rvr_price_rating_wrapper">
                <div class="rh_prop_card__priceLabel">
            <span class="rh_prop_card__status">
                          <?php
                          if ( function_exists( 'ere_get_property_statuses' ) ) {
	                          echo esc_html( ere_get_property_statuses( get_the_ID() ) );
                          }
                          ?>
            </span>
                    <p class="rh_prop_card__price">
						<?php
						if ( function_exists( 'ere_property_price' ) ) {
							ere_property_price();
						}
						?>
                    </p>
                </div>
                <div class="rvr_rating_right">
				<?php rhea_rvr_rating_average(); ?>
                </div>
            </div>
			<?php
		} else {
			?>
            <div class="rh_prop_card__priceLabel">
            <span class="rh_prop_card__status">
                          <?php
                          if ( function_exists( 'ere_get_property_statuses' ) ) {
	                          echo esc_html( ere_get_property_statuses( get_the_ID() ) );
                          }
                          ?>
            </span>
                <p class="rh_prop_card__price">
					<?php
					if ( function_exists( 'ere_property_price' ) ) {
						ere_property_price();
					}
					?>
                </p>
            </div>

			<?php
		}
		?>

    </div>

</li>
