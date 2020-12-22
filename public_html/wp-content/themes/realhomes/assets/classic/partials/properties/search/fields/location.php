<?php
/**
 * Location Fields
 */

$location_select_count  = inspiry_get_locations_number(); // number of locations chosen from theme options
$location_select_names  = inspiry_get_location_select_names(); // Variable that contains location select boxes names
$location_select_titles = inspiry_get_location_titles(); // Default location select boxes titles
$location_placeholder   = inspiry_location_placeholder(); // Placeholder text for the location fields
$select_class           = 'inspiry_select_picker_trigger'; // Default class for the location dropdown fields
$is_location_ajax       = get_option( 'inspiry_ajax_location_field', 'no' ); // Option to check if location field Ajax is enabled

$parent_class = '';
if ( 'yes' === $is_location_ajax ) {
	$parent_class = ' inspiry_ajax_location_wrapper ';
	$select_class = ' inspiry_ajax_location_field inspiry_select_picker_trigger';
}

// Generate required location select boxes
for ( $i = 0; $i < $location_select_count; $i ++ ) {
	?>
    <div class="<?php echo esc_attr( $parent_class ) ?>  option-bar rh_classic_location_field rh-search-field small rh_classic_search__select rh_location_prop_search_<?php echo esc_attr( $i ) ?>" data-get-location-placeholder="<?php echo esc_attr( $location_placeholder[ $i ] ); ?>">
        <label for="<?php echo esc_attr( $location_select_names[ $i ] ); ?>">
			<?php echo esc_html( $location_select_titles[ $i ] ); ?>
        </label>
        <span class="selectwrap">
            <select id="<?php echo esc_attr( $location_select_names[ $i ] ); ?>" class="<?php echo esc_attr( $select_class ); ?> show-tick"

	            <?php
	            if ( 'yes' === $is_location_ajax ) {
		            ?>
                    name="location[]"
                    data-selected-text-format="count > 2"
                    data-none-results-text="<?php esc_html_e( 'No results matched ', 'framework' ); ?> {0}"
                    data-live-search="true"
                    multiple

                    title="<?php
		            $loc_placeholder = get_option( 'inspiry_location_placeholder_1' );
		            if ( ! empty( $loc_placeholder ) ) {
			            echo esc_attr( $loc_placeholder );
		            } else {
			            esc_attr_e( 'All Locations', 'framework' );
		            } ?>"

                    data-count-selected-text="{0} <?php
		            $loc_counter_placeholder = get_option( 'inspiry_location_count_placeholder_1' );
		            if ( ! empty( $loc_counter_placeholder ) ) {
			            echo esc_attr( $loc_counter_placeholder );
		            } else {
			            esc_attr_e( ' Locations Selected ', 'framework' );
		            }
		            ?>"

		            <?php
	            } else {
		            ?>
                    name="<?php echo esc_attr( $location_select_names[ $i ] ); ?>"

		            <?php
	            }
	            ?>
            >
				<?php
				if ( 'yes' !== $is_location_ajax && inspiry_is_edit_property() ) {
					?>
                    <option selected="selected" value=""><?php esc_html_e( 'None', 'framework' ); ?></option>
					<?php
				}
				?>
            </select>
        </span>
    </div>
	<?php
}

// important action hook - related JS works based on it
do_action( 'after_location_fields' );