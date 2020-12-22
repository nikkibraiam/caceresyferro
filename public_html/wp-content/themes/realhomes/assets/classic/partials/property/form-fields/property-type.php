<div class="form-option property-type-field-wrapper">
	<label for="type"><?php esc_html_e('Type', 'framework'); ?></label>
    <span class="selectwrap">
        <select name="type[]" id="type" class="inspiry_select_picker_trigger show-tick">
	        <?php
            if (inspiry_is_edit_property()) {
                global $target_property;
                edit_form_hierarchical_options($target_property->ID, 'property-type');
            } else {
                ?>
		        <option selected="selected" value="-1"><?php esc_html_e('None', 'framework'); ?></option>
		        <?php
                /*
                 * Property Type Terms
                 */
                $property_types_terms = get_terms(array(
                        'taxonomy'   => "property-type",
                        'orderby'    => 'name',
                        'order'      => 'ASC',
                        'hide_empty' => false,
                        'parent'     => 0
                    )
                );
                generate_id_based_hirarchical_options("property-type", $property_types_terms, - 1);
            }
            ?>
        </select>
    </span>
</div>
