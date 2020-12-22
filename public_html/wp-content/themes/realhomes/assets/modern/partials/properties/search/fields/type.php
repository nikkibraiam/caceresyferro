<?php
/**
 * Field: Property Type
 *
 * Property type field for advance search.
 *
 * @since    3.0.0
 * @package RH/modern
 */

?>

<div class="rh_prop_search__option rh_prop_search__select rh_type_field_wrapper inspiry_select_picker_field">
    <label for="select-property-type">
		<?php
		$inspiry_property_type_label = get_option( 'inspiry_property_type_label' );
		if ( !empty( $inspiry_property_type_label ) ) {
			echo esc_html( $inspiry_property_type_label );
		} else {
			esc_html_e( 'Property Type', 'framework' );
		}
		?>
    </label>
    <span class="rh_prop_search__selectwrap">
		<select name="type[]"
                id="select-property-type"
                class="inspiry_select_picker_trigger show-tick"
                data-selected-text-format="count > 2"
                data-actions-box="true"
                data-size="5"
                data-actions-box="true"
                multiple
                title="<?php
                if ( ! empty( get_option( 'inspiry_property_type_placeholder' ) ) ) {
	                echo esc_attr( get_option( 'inspiry_property_type_placeholder' ) );
                } else {
	                esc_attr_e( 'All Types', 'framework' );
                } ?>"
                data-count-selected-text="{0} <?php
                $types_counter_placeholder = get_option('inspiry_property_types_counter_placeholder');
                if(!empty($types_counter_placeholder)){
	               echo esc_html($types_counter_placeholder);
                }else{
	                esc_attr_e( ' Types Selected ', 'framework' );
                }
                ?>"
        >

			<?php advance_hierarchical_options( 'property-type' ); ?>
		</select>
	</span>
</div>
