<?php
/**
 * Field: Property Type
 *
 * @since 	3.0.0
 */
?>
<p>
	<label for="type"><?php esc_html_e( 'Type', 'framework' ); ?></label>
    <select name="type[]" id="type" class="inspiry_select_picker_trigger show-tick"
            data-selected-text-format="count > 2"
            data-size="5"
            data-actions-box="true"
            multiple
            title="<?php esc_attr_e( 'None', 'framework' ); ?>"
            data-count-selected-text="{0} <?php esc_attr_e( ' Types Selected ', 'framework' ); ?>">
        <?php
        if ( realhomes_dashboard_edit_property() ) {
            global $target_property;
            edit_form_hierarchical_options( $target_property->ID, 'property-type' );
        } else {
            /**
             * Property Type Terms
             */
            $property_types_terms = get_terms(array(
                    'taxonomy'   => 'property-type',
                    'orderby'    => 'name',
                    'order'      => 'ASC',
                    'hide_empty' => false,
                    'parent'     => 0,
                )
            );
            generate_id_based_hirarchical_options( 'property-type', $property_types_terms, - 1 );
        }
        ?>
    </select>
</p>