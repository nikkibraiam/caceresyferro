<?php
/**
 * Grid Property Card
 *
 */

$property_size      = get_post_meta( get_the_ID(), 'REAL_HOMES_property_size', true );
$size_postfix       = get_post_meta( get_the_ID(), 'REAL_HOMES_property_size_postfix', true );
$property_bedrooms  = get_post_meta( get_the_ID(), 'REAL_HOMES_property_bedrooms', true );
$property_bathrooms = get_post_meta( get_the_ID(), 'REAL_HOMES_property_bathrooms', true );
$property_address   = get_post_meta( get_the_ID(), 'REAL_HOMES_property_address', true );
$is_featured        = get_post_meta( get_the_ID(), 'REAL_HOMES_featured', true );


global $settings;

$bedroom_label           = $settings['ere_property_bedrooms_label'];
$bathroom_label          = $settings['ere_property_bathrooms_label'];
$area_label              = $settings['ere_property_area_label'];
$show_fav_button         = $settings['ere_enable_fav_properties'];
$fav_label               = $settings['ere_property_fav_label'];
$fav_added_label         = $settings['ere_property_fav_added_label'];
$view_property_label     = $settings['ere_property_view_prop_label'];
$ere_property_grid_image = $settings['ere_property_grid_thumb_sizes'];
$prop_excerpt_length     = $settings['prop_excerpt_length'];

?>

<article <?php post_class( ' rh_prop_card_elementor' ); ?>>

    <div class="rh_prop_card__wrap">

		<?php if ( $is_featured ) : ?>
            <div class="rh_label_elementor rh_label__property_elementor">
                <div class="rh_label__wrap">
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
		<?php endif; ?>

        <figure class="rh_prop_card__thumbnail">
            <div class="rhea_figure_property_one">
                <a href="<?php the_permalink(); ?>">
					<?php
					if ( has_post_thumbnail( get_the_ID() ) ) {
						the_post_thumbnail( $ere_property_grid_image );
					} else {
						inspiry_image_placeholder( $ere_property_grid_image );
					}
					?>
                </a>

                <div class="rh_overlay"></div>
                <div class="rh_overlay__contents rh_overlay__fadeIn-bottom">
                    <a href="<?php the_permalink(); ?>"><?php
						if ( ! empty( $view_property_label ) ) {
							echo esc_html( $view_property_label );
						} else {
							echo esc_attr__( 'View Property', 'realhomes-elementor-addon' );
						};
						?>
                    </a>
                </div>
				<?php rhea_display_property_label( get_the_ID() ); ?>

            </div>

            <div class="rh_prop_card__btns">
				<?php
				if ( 'yes' === $show_fav_button ) {
					if ( function_exists( 'inspiry_favorite_button' ) ) {
						inspiry_favorite_button( get_the_ID(), null, $fav_label, $fav_added_label );
					}
				}

				if ( 'yes' == $settings['ere_enable_compare_properties'] && function_exists( 'inspiry_add_to_compare_button' ) ) {
					inspiry_add_to_compare_button(); // Display add to compare button.
				}
				?>
            </div>
        </figure>

        <div class="rh_prop_card__details_elementor">

            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

            <p class="rh_prop_card__excerpt"><?php rhea_framework_excerpt( esc_html( $prop_excerpt_length ) ); ?></p>

            <div class="rh_prop_card__meta_wrap_elementor">

				<?php if ( ! empty( $property_bedrooms ) ) : ?>

                    <div class="rh_prop_card__meta">
                        <span class="rhea_meta_titles">
                            <?php

                            if ( $bedroom_label ) {
	                            echo esc_html( $bedroom_label );
                            } else {
	                            esc_html_e( 'Bedrooms', 'realhomes-elementor-addon' );
                            }
                            ?></span>
                        <div class="rhea_meta_icon_wrapper">
							<?php include RHEA_ASSETS_DIR . '/icons/bed.svg'; ?>
                            <span class="figure"><?php echo esc_html( $property_bedrooms ); ?></span>
                        </div>
                    </div>
				<?php endif; ?>



				<?php if ( ! empty( $property_bathrooms ) ) : ?>
                    <div class="rh_prop_card__meta">
                        <span class="rhea_meta_titles"><?php
	                        if ( $bathroom_label ) {
		                        echo esc_html( $bathroom_label );
	                        } else {
		                        esc_html_e( 'Bathrooms', 'realhomes-elementor-addon' );
	                        }
	                        ?></span>
                        <div class="rhea_meta_icon_wrapper">
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
                            <div class="rhea_meta_icon_wrapper">
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
	                        if ( $area_label ) {
		                        echo esc_html( $area_label );
	                        } else {
		                        esc_html_e( 'Area', 'realhomes-elementor-addon' );
	                        }
	                        ?></span>
                        <div class="rhea_meta_icon_wrapper">
							<?php include RHEA_ASSETS_DIR . '/icons/area.svg'; ?>
                            <span class="figure"><?php echo esc_html( $property_size ); ?></span>
							<?php if ( ! empty( $size_postfix ) ) : ?>
                                <span class="label"><?php echo esc_html( $size_postfix ); ?></span>
							<?php endif; ?>
                        </div>
                    </div>
				<?php endif; ?>

            </div>

            <div class="rh_prop_card__priceLabel <?php if ( inspiry_is_rvr_enabled() ) {
				echo esc_attr( 'rhea_rvr_ratings_wrapper' );
			} ?>">
                <div class="rhea_property_price_box">
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
				<?php if ( inspiry_is_rvr_enabled() && 'yes' == $settings['rhea_rating_enable'] ) { ?>
                    <div class="rhea_rvr_ratings rvr_rating_right">
						<?php rhea_rvr_rating_average(); ?>
                    </div>
				<?php } ?>
            </div>

        </div>

    </div>

</article>
<!-- /.rh_prop_card -->
