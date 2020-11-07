<?php
/**
 * Copyright (c) 2020.
 * Jesus Nuñez <Jesus.nunez2050@gmail.com>
 */
function incluyeme_applications_adminPage() {
	$incluyemeApplications = 'incluyemeApplicantsURL';
	if ( isset( $_POST['incluyemeApplications'] ) ) {
		$value = $_POST['incluyemeApplications'];
		update_option( $incluyemeApplications, sanitize_text_field( $value ) );
	}
	?>
	<div class="container">
		<div class="card">
			<div class="card-title">
				<h5>Configuración</h5>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col">
						<form method="POST">
							<div class="row">
								<div class="col-12">
									<label for="incluyemeApplications"><b><?php _e( "Ingrese la url al perfil de los usuarios", "wpjobboard" ); ?></b></label>
									<input type="text"
									       class="form-control"
									       id="incluyemeApplications"
									       name="incluyemeApplications"
									       value="<?php echo get_option( $incluyemeApplications ) ? get_option( $incluyemeApplications ) : ''; ?>"
									       placeholder="<?php _e( "http://incluyeme.com/candidato/perfil", "wpjobboard" ); ?>">
								</div>
							</div>
							<div class="text-right mt-2">
								<button type="submit"
								        class="btn btn-info"><?php _e( "Guardar", "wpjobboard" ); ?></button>
							</div>
						</form>
					</div>
				</div>
			</div>
		
		</div>
	</div>
	<?php
}

function incluyeme_stylesApplicants( $hook ) {
	$current_screen = get_current_screen();
	if ( ! strpos( $current_screen->base, 'incluyemeApplicants' ) ) {
		return;
	} else {
		$css = plugins_url() . '/incluyeme/include/assets/css/';
		wp_register_style( 'bootstrap-admin', $css . 'bootstrap.min.css', [], '1.0.0', false );
		wp_enqueue_style( 'bootstrap-admin' );
	}
}

function incluyemeSave_Options_Applicants() {
	$incluyemeApplications = 'incluyemeApplicantsURL';
	if ( isset( $_POST['incluyemeApplications'] ) ) {
		$value = $_POST['incluyemeApplications'];
		update_option( $incluyemeApplications, sanitize_text_field( $value ) );
	}
	
	wp_redirect( get_current_screen() );
	exit;
}

add_action( 'admin_post_my_test_sub_save', 'incluyemeSave_Options_Applicants' );

