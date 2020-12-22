<?php
$get_prop_images = count( get_post_meta( get_the_ID(), 'REAL_HOMES_property_images' ) );
$REAL_HOMES_tour_video_url   = get_post_meta( get_the_ID(), 'REAL_HOMES_tour_video_url', true );
$REAL_HOMES_tour_video_image = get_post_meta( get_the_ID(), 'REAL_HOMES_tour_video_image', true );

$inspiry_video_group = get_post_meta( get_the_ID(), 'inspiry_video_group', true );

?>

<div class="rhea_media_count">

	<?php if ( $get_prop_images > 0 ) { ?>
		<div class="rhea_media">
			<?php include RHEA_ASSETS_DIR . 'icons/photos.svg'; ?>
			<span>
											<?php echo esc_html( $get_prop_images ); ?>
                                                </span>
		</div>
		<?php
	}

	$count_videos = '';
	if ( isset( $REAL_HOMES_tour_video_url ) && ( ! empty( $REAL_HOMES_tour_video_url ) ) ) {
		$count_videos = count(get_post_meta( get_the_ID(), 'REAL_HOMES_tour_video_url', false ));
	}elseif ( isset($inspiry_video_group) &&! empty($inspiry_video_group)){
		$count_videos = count(get_post_meta( get_the_ID(), 'inspiry_video_group', true ));
    }
 if ( $count_videos > 0 ) {
	 ?>
     <div class="rhea_media">
		 <?php include RHEA_ASSETS_DIR . 'icons/video.svg'; ?>
         <span>
											<?php echo esc_html( $count_videos ); ?>
                                                </span>
     </div>
	 <?php
 }
	?>
</div>