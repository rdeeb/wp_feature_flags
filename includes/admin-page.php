<?php
/**
 * This file handles the admin page code
 *
 * @package wp-feature-flags
 * @author Ramy Deeb
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( "admin_menu", "ff_admin_menu_handler" );
add_action( "wp_ajax_get_feature_flags", "ff_ajax_get_feature_flags" );

if ( ! function_exists( 'ff_admin_register_scripts' ) ) {
	function ff_admin_register_scripts() {
		wp_register_script( "ff-admin-vendor", FF_URL . "admin/js/vendor.bundle.js", [], FF_VERSION, true );
		wp_register_script( "ff-admin-dashboard", FF_URL . "admin/js/app.bundle.js", [ "ff-admin-vendor" ], FF_VERSION, true );
		wp_register_style( "ff-admin-dashboard", FF_URL . "admin/css/styles.css", [], FF_VERSION, "screen" );
	}
}

if ( ! function_exists( "ff_add_contextual_help" ) ) {
	function ff_add_contextual_help() {
		$screen = get_current_screen();

		$screen->add_help_tab( array(
			"id"       => "ff-dashboard-overview",
			"title"    => __( "Overview" ),
			"content"  => __( "<p>Feature flags are a way to enable or disable features of your website that might be still in development but may need real world testing or user validation. It is also a way to enable features for an specific set of users, do A/B testing or any other case you might find useful</p>" )
		));

		$screen->add_help_tab( array(
			"id"       => "ff-dashboard-add-feature",
			"title"    => __( "Adding a feature" ),
			"content"  => __( "<p>Features are handled purely in the code, this plugin is aimed at plugin/theme developers that are building complex websites. There is no point on creating a front end for adding feature flags, since their sole purpose is to allow developers the flexibility of handling what pieces of logic to execute based on whether a feature flag is on or not.</p><p>To add a new feature flag in code you can use the helper <code>ff_register_feature_flag( \"feature_name\" )</code> where <strong>feature_name</strong> is the name of your feature flag.</p>" )
		));

		$screen->set_help_sidebar(
			'<p><strong>' . __( 'For more information:' ) . '</strong></p>' .
			'<p><a href="http://www.ramydeeb.com" target="_blank">' . _( 'Plugin website' ) . '</a></p>'
		);
	}
}

if ( ! function_exists( "ff_admin_menu_handler" ) ) {
	function ff_admin_menu_handler()
	{
		ff_admin_register_scripts();
		$settingsPage = add_options_page( "Feature Flags Settings", "Feature Flags", "manage_options", "feature-flag-settings", "ff_admin_menu_page_handler" );

		add_action( "admin_enqueue_scripts", function( $hook ) use ($settingsPage) {
			if ( $hook !== $settingsPage ) return;

			wp_enqueue_script( "ff-admin-dashboard" );
			wp_enqueue_style( "ff-admin-dashboard" );

			wp_localize_script( "ff-admin-dashboard", "ff_admin_dashboard", [
				"ajax_url" => admin_url( "admin-ajax.php" ),
				"lang" => substr( get_bloginfo ( 'language' ), 0, 2 ) // Two letter language code
			] );
		} );

		add_action( "load-$settingsPage", "ff_add_contextual_help" );
	}
}

if ( ! function_exists( "ff_admin_menu_page_handler" ) ) {
	function ff_admin_menu_page_handler() {
		if (!current_user_can("manage_options")) {
			wp_die(__("You do not have sufficient permissions to access this page."));
		}

		echo "<div id=\"wp-feature-flags-dashboard\"></div>";
	}
}

if ( ! function_exists( 'ff_ajax_get_feature_flags' ) ) {
    function ff_ajax_get_feature_flags() {
    	$features = ff_FeatureFlags::getInstance()->getFeatures();
    	echo json_encode(array_map(function ($feature) {
    		/** @var FeatureFlag $feature */
    		return $feature->toObject();
	    }, $features));
        wp_die();
    }
}
