<?php

function thinkup_panels_setup() {

	// Get theme data
	$theme_data = wp_get_theme();

	// Get theme name is exists
	try {

		// Get name of parent theme
		if ( is_child_theme() ) {
			$theme_name    = trim( strtolower( str_replace( ' (Lite)', '', $theme_data->parent()->get( 'Name' ) ) ) );
			$theme_slug    = trim( strtolower( str_replace( ' (Lite)', '-lite', $theme_data->parent()->get( 'Name' ) ) ) );
			$theme_version = $theme_data->parent()->get( 'Version' );
		} else {
			$theme_name    = trim( strtolower( str_replace( ' (Lite)', '', $theme_data->get( 'Name' ) ) ) );
			$theme_slug    = trim( strtolower( str_replace( ' (Lite)', '-lite', $theme_data->get( 'Name' ) ) ) );
			$theme_version = $theme_data->get( 'Version' );
		}

	} catch (\Throwable $th) {

		// Exit early on error
		return;
	}

    // Enqueue CSS for the editor shell
    wp_enqueue_style(
        'thinkup-panels-upsell',
        get_template_directory_uri() . '/admin/main-panels/assets/css/panels-upsell.css',
        array(),
        $theme_version
    );

    // Enqueue JS for the editor shell
    wp_enqueue_script(
        'thinkup-panels-upsell',
        get_template_directory_uri() . '/admin/main-panels/assets/js/panels-upsell.js',
        array( 'wp-plugins', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-data' ),
        $theme_version,
        true
    );

    // Localized data for your JS file
    wp_localize_script(
        'thinkup-panels-upsell',
        'thinkupData',
        array(
            'themeName' => $theme_name
        )
    );
}
add_action( 'enqueue_block_editor_assets', 'thinkup_panels_setup' );
