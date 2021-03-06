<?php
/**
 * Field: Virtual Tour Video URL
 *
 * @since 	3.0.0
 * @package RH/modern
 */

?>
<p>
	<label for="video-url"><?php esc_html_e( 'Virtual Tour Video URL', 'framework' ); ?></label>
	<input id="video-url" name="video-url" type="text" value="<?php
	if ( realhomes_dashboard_edit_property() ) {
	    global $post_meta_data;
	    if ( isset( $post_meta_data['REAL_HOMES_tour_video_url'] ) ) {
	        echo esc_attr( $post_meta_data['REAL_HOMES_tour_video_url'][0] );
	    }
	} ?>" title="<?php esc_attr_e( 'Virtual Tour Video URL', 'framework' ); ?>"/>
</p>
