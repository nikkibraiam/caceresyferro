<?php
/**
 * Field: Agent
 *
 * @since    3.0.0
 * @package RH/modern
 */

$default_selection = 'profile_info';

if ( realhomes_dashboard_edit_property() ) {
	global $post_meta_data;
	if ( isset( $post_meta_data['REAL_HOMES_agent_display_option'] ) && ( 'none' == $post_meta_data['REAL_HOMES_agent_display_option'][0] ) ) {
		$default_selection = 'none';
	}

	if ( isset( $post_meta_data['REAL_HOMES_agent_display_option'] ) && ( 'agent_info' == $post_meta_data['REAL_HOMES_agent_display_option'][0] ) ) {
		$default_selection =  'agent_info';
	}
}
?>
<div class="property-agent-information">
    <label><?php esc_html_e( 'What to display in agent information box?', 'framework' ); ?></label>
    <ul class="list-unstyled agent-options-list">
        <li class="radio-field">
            <input id="agent_option_none" type="radio" name="agent_display_option" value="none"<?php checked( 'none', $default_selection ); ?> />
            <label for="agent_option_none"><?php esc_html_e( 'None ( Agent information box will not be displayed )', 'framework' ); ?></label>
        </li>
		<?php if ( is_user_logged_in() ) : ?>
            <li class="radio-field">
                <input id="agent_option_profile" type="radio" name="agent_display_option" value="my_profile_info"<?php checked( 'profile_info', $default_selection ); ?> />
                <label for="agent_option_profile">
					<?php esc_html_e( 'My profile information.', 'framework' ); ?>
					<?php
					$profile_url = realhomes_get_dashboard_page_url( 'profile' );
					if ( ! empty( $profile_url ) ) : ?>
                        <a href="<?php echo esc_url( $profile_url ); ?>" target="_blank"><?php esc_html_e( '( Edit Profile Information )', 'framework' ); ?></a>
					<?php else : ?>
                        <a href="<?php echo esc_url( network_admin_url( 'profile.php' ) ); ?>" target="_blank"><?php esc_html_e( '( Edit Profile Information )', 'framework' ); ?></a>
					<?php
					endif;
					?>
                </label>
            </li>
		<?php endif; ?>
        <li class="radio-field">
            <input id="agent_option_agent" type="radio" name="agent_display_option" value="agent_info"<?php checked( 'agent_info', $default_selection ); ?> />
            <label for="agent_option_agent"><?php esc_html_e( 'Display agent(s) information.', 'framework' ); ?></label>
            <div class="agent-options-wrap">
                <span class="note"><?php esc_html_e( 'Select agent(s)', 'framework' ); ?></span>
                <select name="agent_id[]"
                        id="agent-selectbox"
                        class="inspiry_select_picker_trigger show-tick"
                        multiple
                        data-selected-text-format="count > 2"
                        data-actions-box="true"
                        data-size="5"
                        data-actions-box="true"
                        title="<?php esc_attr_e( 'No Agent Selected', 'framework' ) ?>"
                        data-count-selected-text="{0} <?php esc_attr_e( 'Agents Selected', 'framework' ); ?>">
					<?php
					if ( realhomes_dashboard_edit_property() ) {
						global $post_meta_data;
						if ( isset( $post_meta_data['REAL_HOMES_agents'] ) ) {
							generate_posts_list( 'agent', $post_meta_data['REAL_HOMES_agents'] );
						} else {
							generate_posts_list( 'agent' );
						}
					} else {
						generate_posts_list( 'agent' );
					}
					?>
                </select>
            </div>
        </li>
    </ul>
</div>