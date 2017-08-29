<?php
/**
 * Fichier d'affichage pour la connexion d'un utilisateur / Tempalte file for user login
 *
 * @package WPShop Users
 */

namespace wpshop;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><div class="wps-boxed" id="wps_login_form_container" >
	<span class="wps-h5"><?php esc_html_e( 'login' ); ?></span>
	<div id="wps_login_error_container" ></div>
	<form action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" method="post" id="wps_login_form">

		<?php echo apply_filters( 'login_form_top', '', $args ); // WPCS: XSS ok. ?>

		<input type="hidden" name="action" value="wps_login_request" />
		<?php wp_nonce_field( 'control_login_form_request' ); ?>

		<div class="wps-form-group">
			<label for="wps_login_email_address"><?php esc_html_e( 'Email address', 'wpshop' );?></label>
			<span class="wps-help-inline wps-help-inline-title"></span>
			<div id="wps_login_email_address" class="wps-form"><input type="text" name="wps_login_user_login" id="wps_login_email" placeholder="<?php esc_html_e( 'Your email address', 'wpshop' );?>" /></div>
		</div>

		<div class="wps-form-group">
			<label for="wps_login_password"><?php esc_html_e( 'Password', 'wpshop' );?></label>
			<div id="wps_login_password" class="wps-form"><input type="password" name="wps_login_password" id="wps_login_password" placeholder="<?php esc_html_e( 'Your password', 'wpshop' );?>" /></div>
		</div>

		<div class="wps-form-group">
			<?php echo apply_filters( 'login_form_middle', '', $args ); // WPCS: XSS ok. ?>
			<?php do_action( 'login_form' ); ?>
		</div>

		<div class="wps-form-group wps-password-reminder">
			<a href="#" data-nonce="<?php echo esc_attr( wp_create_nonce( 'wps_fill_forgot_password_modal' ) ); ?>" class="wps-modal-forgot-password-opener wps-password-reminder-link" ><?php esc_html_e( 'Forgotten password', 'wpshop' ); ?> ?</a>
			<button class="wps-bton-first-alignRight-rounded" id="wps_login_button" ><?php esc_html_e( 'login', 'wpshop' ); ?></button>
		</div>

		<?php echo apply_filters( 'login_form_bottom', '', $args ); // WPCS: XSS ok. ?>

	</form>
</div>
