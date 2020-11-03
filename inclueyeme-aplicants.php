<?php

/*
Plugin Name: Inclueyeme Applicants
Plugin URI: https://github.com/Cro22
Description: A brief description of the Plugin.
Version: 1.0
Author: Jesus
Author URI: https://github.com/Cro22
Text Domain: incluyeme-applicants
Domain Path: /languages
License: A "Slug" license name e.g. GPL2
*/
require 'plugin-update-checker/plugin-update-checker.php';
require 'include/verifyApplicants.php';

use verifyApplicants\verifyApplicants;

defined( 'ABSPATH' ) or exit;
add_action( 'admin_init', 'incluyemeApplicants_requeriments' );

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
		incluyeme_load();
	}
}

function incluyemeApplicants_notice() {
	?>
	<div class="error"><p> <?php echo __( 'Sorry, but Incluyeme plugin requires the WPJob Board plugin to be installed and
	                      active.', 'incluyeme' ); ?> </p></div>
	<?php
}

add_filter( "wpjb_form_save_apply", function ( $form ) {
	$verifyApplicants = new verifyApplicants();
	error_log( print_r( $verifyApplicants->checkUsersCapacities(), true ) );
	
	$form_data = $form->toArray();
	
	return $form;
} );
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/Incluyeme-com/filtro-aplicantes',
	__FILE__,
	'incluyeme-applicants'
);


$myUpdateChecker->setBranch( 'master' );
