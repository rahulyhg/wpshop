<?php
/**
 * Fichier d'affichage pour le formulaire d'un utilisateur / Tempalte file for user account creation
 *
 * @package WPShop Users
 */

namespace wpshop;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><div class="wps-boxed">
	<span class="wps-h5"><?php esc_html_e( 'My user account informations', 'wpshop' ); ?></span>
	<form action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" method="post" id="wps_user_account_form" >
		<input type="hidden" name="action" value="wps_user_account_save" />
		<?php wp_nonce_field( 'wps_user_account_save' ); ?>

		<input type="hidden" name="wps_user_account[user_id]" value="<?php echo esc_attr( $user->id ); ?>" />
		<input type="hidden" name="wps_user_account[user_login]" value="<?php echo esc_attr( $user->login ); ?>" />

		<?php echo apply_filters( 'wps_filter_account_form_top', '', $args ); // WPCS: XSS ok. ?>

		<div class="wps-form-group">
			<label for="wps_user_account_firstname"><?php esc_html_e( 'Firstname', 'wpshop' );?></label>
			<div class="wps-form"><input type="text" name="wps_user_account[firstname]" id="wps_user_account_firstname" placeholder="<?php esc_html_e( 'Your firstname...', 'wpshop' );?>" value="<?php echo esc_attr( $user->firstname ); ?>" /></div>
		</div>
		<div class="wps-form-group">
			<label for="wps_user_account_lastname"><?php esc_html_e( 'Lastname', 'wpshop' );?></label>
			<div class="wps-form"><input type="text" name="wps_user_account[lastname]" id="wps_user_account_lastname" placeholder="<?php esc_html_e( 'Your lastname...', 'wpshop' );?>" value="<?php echo esc_attr( $user->lastname ); ?>" /></div>
		</div>

		<div class="wps-form-group">
			<label for="wps_user_account_email"><?php esc_html_e( 'Email address', 'wpshop' );?></label>
			<div class="wps-form"><input type="text" name="wps_user_account[email]" id="wps_user_account_email" placeholder="<?php esc_html_e( 'Your email address...', 'wpshop' );?>" value="<?php echo esc_attr( $user->email ); ?>" /></div>
		</div>
		<div class="wps-form-group">
			<label for="wps_user_account_cellphone"><?php esc_html_e( 'Cellphone number', 'wpshop' );?></label>
			<div class="wps-form"><input type="text" name="wps_user_account[cellphone]" id="wps_user_account_cellphone" placeholder="<?php esc_html_e( 'Your cellphone number', 'wpshop' );?>" value="<?php echo esc_attr( $user->cellphone ); ?>" /></div>
		</div>

		<div class="wps-form-group">
			<label for="wps_user_account_password"><?php esc_html_e( 'Password', 'wpshop' );?></label>
			<div class="wps-form"><input type="password" name="wps_user_account[password]" id="wps_user_account_password" /></div>
		</div>

		<div class="wps-form-group">
			<label for="wps_user_account_password_confirmation"><?php esc_html_e( 'Confirm password', 'wpshop' );?></label>
			<div class="wps-form"><input type="password" name="wps_user_account[password_confirmation]" id="wps_user_account_password_confirmation" /></div>
		</div>

		<?php echo apply_filters( 'wps_filter_account_form_bottom', '', $args ); // WPCS: XSS ok. ?>

		<div class="wps-form-group"></div>
		<div class="wps-form-group">
			<button class="wps-bton-first-alignRight-rounded" ><?php esc_html_e( 'Save', 'wpshop' ); ?></button>
		</div>
	</form>
</div>
