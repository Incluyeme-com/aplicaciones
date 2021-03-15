<?php

/*
Plugin Name: Incluyeme Applicants
Plugin URI: https://github.com/Cro22
Description: Activar este plugin impide que los aplicantes puedan solicitar puestos de trabajo sin completar la sección de disCapacidades.
Version: 1.0.8
Author: Jesus
Author URI: https://github.com/Cro22
Text Domain: incluyeme-applicants
Domain Path: /languages
License: A "Slug" license name e.g. GPL2
*/
require 'plugin-update-checker/plugin-update-checker.php';
require 'include/verifyApplicants.php';
require 'include/activeIncluyemeApplicants.php';
#require_once plugin_dir_path(__FILE__) . 'include/menu/incluyeme_applicants_admin_menu.php';

defined( 'ABSPATH' ) or exit;
add_action( 'admin_init', 'incluyemeApplicants_requirements' );

function incluyemeApplicants_i18n() {
	load_plugin_textdomain( 'incluyeme-applicants', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action( 'plugins_loaded', 'incluyemeApplicants_i18n' );

function incluyemeApplicants_requirements() {
	if ( is_admin() && current_user_can( 'activate_plugins' ) && ! is_plugin_active( 'wpjobboard/index.php' ) ) {
		add_action( 'admin_notices', 'incluyeme_notice' );
		deactivate_plugins( plugin_basename( __FILE__ ) );

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
	}
	if ( is_admin() && current_user_can( 'activate_plugins' ) && is_plugin_active( 'wpjobboard/index.php' ) ) {
		activeIncluyemeApplicants();
	}
}

function incluyemeApplicants_loaderCheck() {
	$version = '1.0.8';
	$check   = strcmp( get_option( 'incluyemeApplicantsVersion' ), $version );
	if ( $check === 0 ) {
		$template = plugin_dir_path( __FILE__ ) . '/include/templates/job-board/single.php';
		$route    = get_template_directory();
		if ( ! file_exists( $route . '/wpjobboard/job-board/single.php' ) ) {
			mkdir( $route . '/wpjobboard' );
			mkdir( $route . '/wpjobboard/job-board' );
			copy( $template, $route . '/wpjobboard/job-board/single.php' );
		} else {
			copy( $template, $route . '/wpjobboard/job-board/single.php' );
		}
		update_option( 'incluyemeApplicantsVersion', $version );
	}
}

function incluyemeApplicants_notice() {
	?>
	<div class="error"><p> <?php echo __( 'Sorry, but Incluyeme Applicants plugin requires the WPJob Board plugin to be installed and
	                      active.', 'incluyeme' ); ?> </p></div>
	<?php
}

$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/Incluyeme-com/aplicaciones',
	__FILE__,
	'incluyeme-applicants'
);


$myUpdateChecker->setBranch( 'master' );
