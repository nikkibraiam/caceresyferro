<?php
$property_size      = get_post_meta( get_the_ID(), 'REAL_HOMES_property_size', true );
$size_postfix       = get_post_meta( get_the_ID(), 'REAL_HOMES_property_size_postfix', true );
$property_bedrooms  = get_post_meta( get_the_ID(), 'REAL_HOMES_property_bedrooms', true );
$property_bathrooms = get_post_meta( get_the_ID(), 'REAL_HOMES_property_bathrooms', true );
$property_address   = get_post_meta( get_the_ID(), 'REAL_HOMES_property_address', true );

global $settings;

$bedroom_label           = $settings['ere_property_bedrooms_label'];
$bathroom_label          = $settings['ere_property_bathrooms_label'];
$area_label              = $settings['ere_property_area_label'];
?>
<div class="rh_prop_card_meta_wrap_stylish">

	<?php if ( ! empty( $property_bedrooms ) ) : ?>

		<div class="rh_prop_card__meta">
			<span class="rhea_meta_titles"><?php

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
                                if(!empty($settings['ere_property_guests_label'])){
	                                echo esc_html($settings['ere_property_guests_label']);
                                }else{
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