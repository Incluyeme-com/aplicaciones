<?php
/**
 * Copyright (c) 2020.
 * Jesus Nuñez <Jesus.nunez2050@gmail.com>
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

global $wpdb;
$route = get_template_directory();
$route = $route . '/wpjobboard/job-board/single.php';
deleteDirectory( $route );

function deleteDirectory( $dir ) {
    if ( ! file_exists( $dir ) ) {
        return true;
    }
    
    if ( ! is_dir( $dir ) ) {
        return unlink( $dir );
    }
    
    return true;
}
