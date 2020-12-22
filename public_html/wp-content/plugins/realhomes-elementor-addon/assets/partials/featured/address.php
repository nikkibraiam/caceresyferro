<?php
$REAL_HOMES_property_address = get_post_meta( get_the_ID(), 'REAL_HOMES_property_address', true );
if ( isset( $REAL_HOMES_property_address ) && ! empty( $REAL_HOMES_property_address ) ) { ?>
    <address class="rhea_fp_address">
        <a href="<?php the_permalink(); ?>">
            <span class="rhea_address_pin"><?php include RHEA_ASSETS_DIR . 'icons/pin.svg'; ?></span>
            <span class="rhea_address_text"><?php echo esc_html( $REAL_HOMES_property_address ); ?></span>
        </a>
    </address>
	<?php
}