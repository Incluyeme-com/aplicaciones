<?php
function activeIncluyemeApplicants() {
	$template = plugin_dir_path( __FILE__ ) . '/templates/job-board/single.php';
	$route    = get_template_directory();
	if ( ! file_exists( $route . '/wpjobboard/job-board/single.php' ) ) {
		mkdir( $route . '/wpjobboard' );
		mkdir( $route . '/wpjobboard/job-board' );
		copy( $template, $route . '/wpjobboard/job-board/single.php' );
	} else {
		$templateSize  = filesize( plugin_dir_path( __FILE__ ) . '/templates/job-board/single.php' );
		$templateExist = filesize( $route . '/wpjobboard/job-board/single.php' );
		if ( $templateExist !== $templateSize ) {
			copy( $template, $route . '/wpjobboard/job-board/single.php' );
		}
	}
}
