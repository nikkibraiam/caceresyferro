<?php
/**
 * This file has the configuration of available demos to import and
 * settings after a demo import.
 *
 * @since      1.0.0
 * @package    realhomes-demo-import
 * @subpackage realhomes-demo-import/demos
 */

if ( ! function_exists( 'inspiry_demo_import_files' ) ) {
	/**
	 * Availalble Demos configuration for import.
	 *
	 * @since  1.0.0
	 * @return array
	 */
	function inspiry_demo_import_files() {
		$configured_demos = array(
			array(
				'import_file_name'             => 'Modern - Elementor',
				'local_import_file'            => trailingslashit( plugin_dir_path( __FILE__ ) ) . 'elementor-modern/contents.xml',
				'local_import_widget_file'     => trailingslashit( plugin_dir_path( __FILE__ ) ) . 'elementor-modern/widgets.wie',
				'local_import_customizer_file' => trailingslashit( plugin_dir_path( __FILE__ ) ) . 'elementor-modern/customizer.dat',
				'import_preview_image_url'     => plugin_dir_url( __FILE__ ) . 'elementor-modern/demo.jpg',
				'preview_url'                  => 'https://di.realhomes.io/modern-elementor/',
			),
			array(
				'import_file_name'             => 'Classic - Elementor',
				'local_import_file'            => trailingslashit( plugin_dir_path( __FILE__ ) ) . 'elementor-classic/contents.xml',
				'local_import_widget_file'     => trailingslashit( plugin_dir_path( __FILE__ ) ) . 'elementor-classic/widgets.wie',
				'local_import_customizer_file' => trailingslashit( plugin_dir_path( __FILE__ ) ) . 'elementor-classic/customizer.dat',
				'import_preview_image_url'     => plugin_dir_url( __FILE__ ) . 'elementor-classic/demo.jpg',
				'preview_url'                  => 'https://di.realhomes.io/classic-elementor/',
			),
			array(
				'import_file_name'             => 'Modern',
				'local_import_file'            => trailingslashit( plugin_dir_path( __FILE__ ) ) . 'modern/contents.xml',
				'local_import_widget_file'     => trailingslashit( plugin_dir_path( __FILE__ ) ) . 'modern/widgets.wie',
				'local_import_customizer_file' => trailingslashit( plugin_dir_path( __FILE__ ) ) . 'modern/customizer.dat',
				'import_preview_image_url'     => plugin_dir_url( __FILE__ ) . 'modern/demo.jpg',
				'preview_url'                  => 'https://di.realhomes.io/modern/',
			),
			array(
				'import_file_name'             => 'Classic',
				'local_import_file'            => trailingslashit( plugin_dir_path( __FILE__ ) ) . 'classic/contents.xml',
				'local_import_widget_file'     => trailingslashit( plugin_dir_path( __FILE__ ) ) . 'classic/widgets.wie',
				'local_import_customizer_file' => trailingslashit( plugin_dir_path( __FILE__ ) ) . 'classic/customizer.dat',
				'import_preview_image_url'     => plugin_dir_url( __FILE__ ) . 'classic/demo.jpg',
				'preview_url'                  => 'https://di.realhomes.io/classic/',
			),
		);

		// Add Vacation Rentals Demo if related plugin is active
		if ( class_exists( 'Realhomes_Vacation_Rentals' ) ) {
			$configured_demos[] = array(
				'import_file_name'             => 'Vacation Rentals - Elementor',
				'local_import_file'            => trailingslashit( plugin_dir_path( __FILE__ ) ) . 'vacation-rentals/contents.xml',
				'local_import_widget_file'     => trailingslashit( plugin_dir_path( __FILE__ ) ) . 'vacation-rentals/widgets.wie',
				'local_import_customizer_file' => trailingslashit( plugin_dir_path( __FILE__ ) ) . 'vacation-rentals/customizer.dat',
				'import_preview_image_url'     => plugin_dir_url( __FILE__ ) . 'vacation-rentals/demo.jpg',
				'preview_url'                  => 'https://di.realhomes.io/vacation-rentals/',
			);
		}

		// Spanish Demo Import
		$configured_demos[] = array(
			'import_file_name'             => 'Español Modern - Elementor',
			'local_import_file'            => trailingslashit( plugin_dir_path( __FILE__ ) ) . 'spanish-elementor-modern/contents.xml',
			'local_import_widget_file'     => trailingslashit( plugin_dir_path( __FILE__ ) ) . 'spanish-elementor-modern/widgets.wie',
			'local_import_customizer_file' => trailingslashit( plugin_dir_path( __FILE__ ) ) . 'spanish-elementor-modern/customizer.dat',
			'import_preview_image_url'     => plugin_dir_url( __FILE__ ) . 'spanish-elementor-modern/demo.jpg',
			'preview_url'                  => 'http://demo.realhomes.io/spanish/',
		);

		return $configured_demos;
	}
	add_filter( 'rhdi/import_files', 'inspiry_demo_import_files' );
}

if ( ! function_exists( 'inspiry_settings_after_content_import' ) ) {
	/**
	 * After a demo import setup.
	 *
	 * @since 1.0.1
	 * @param string $selected_import Name of the demo that's imported.
	 */
	function inspiry_settings_after_content_import( $selected_import ) {

		// Update design setting.
		if ( 'Classic' === $selected_import['import_file_name'] || 'Classic - Elementor' === $selected_import['import_file_name'] ) {
			update_option( 'inspiry_design_variation', 'classic' );
		} elseif ( 'Modern' === $selected_import['import_file_name']
		           || 'Modern - Elementor' === $selected_import['import_file_name']
		           || 'Vacation Rentals - Elementor' === $selected_import['import_file_name']
		           || 'Español Modern - Elementor' === $selected_import['import_file_name'] ) {
			update_option( 'inspiry_design_variation', 'modern' );
		}

		// Assign menu to right location.
		$locations = get_theme_mod( 'nav_menu_locations' );
		if ( ! empty( $locations ) && is_array( $locations ) ) {
			foreach ( $locations as $location_id => $menu_value ) {
				$menu = null;
				switch ( $location_id ) {
					case 'main-menu':
						$menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
						break;

					case 'responsive-menu':
						$menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
						break;
				}
				if ( ! empty( $menu ) ) {
					$locations[ $location_id ] = $menu->term_id;
				}
			}
			set_theme_mod( 'nav_menu_locations', $locations );
		}

		// Set homepage as front page and blog page as posts page.
		if ( 'Español Modern - Elementor' === $selected_import['import_file_name'] ) {
			$home_page = get_page_by_title( 'Inicio' );
			$blog_page = get_page_by_title( 'Blog' );
		} elseif ( 'Vacation Rentals - Elementor' === $selected_import['import_file_name'] ) {
			$home_page = get_page_by_title( 'Home' );
			$blog_page = get_page_by_title( 'Blog' );

			// Enable RVR in its settings if it's not yet.
			$rvr_settings = get_option( 'rvr_settings' );
			$rvr_enabled  = isset( $rvr_settings['rvr_activation'] ) ? $rvr_settings['rvr_activation'] : false;

			if ( ! $rvr_enabled && class_exists( 'Realhomes_Vacation_Rentals' ) ) {
				$rvr_settings['rvr_activation'] = 1;
				update_option( 'rvr_settings', $rvr_settings );
			}
		} else {
			$home_page = get_page_by_title( 'Home' );
			$blog_page = get_page_by_title( 'News' );
		}

		if ( $home_page || $blog_page ) {
			update_option( 'show_on_front', 'page' );
		}

		if ( $home_page ) {
			update_option( 'page_on_front', $home_page->ID );
		}

		if ( $blog_page ) {
			update_option( 'page_for_posts', $blog_page->ID );
			update_option( 'posts_per_page', 4 );
		}

		// No need of migration after latest demo import.
		update_option( 'inspiry_home_settings_migration', 'true' );

		// Set fonts to Default.
		update_option( 'inspiry_heading_font', 'Default' );
		update_option( 'inspiry_secondary_font', 'Default' );
		update_option( 'inspiry_body_font', 'Default' );

		// Disable Elementor typography and color schemes.
		update_option( 'elementor_disable_typography_schemes', 'yes' );
		update_option( 'elementor_disable_color_schemes', 'yes' );

		// Update Elementor container width.
		$get_elementor_container_width = get_option( 'elementor_container_width' );
		if ( empty( $get_elementor_container_width ) ) {
			update_option( 'elementor_container_width', 1240 );
		}
	}

	add_action( 'rhdi/after_import', 'inspiry_settings_after_content_import' );

}
