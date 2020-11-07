<?php

/**
 * Copyright (c) 2020.
 * Jesus Nuñez <Jesus.nunez2050@gmail.com>
 */
require_once plugin_dir_path( __FILE__ ) . 'admins/incluyeme_applicants_adminPage.php';
add_action( 'admin_menu', 'incluyeme_applicants_menus' );
add_action( 'admin_enqueue_scripts', 'incluyeme_stylesApplicants' );
function incluyeme_applicants_menus() {
	add_menu_page(
		'Incluyeme - Aplicantes',
		'Incluyeme - Aplicantes',
		'manage_options',
		'incluyemeApplicants',
		'incluyeme_applications_adminPage'
	);
}
