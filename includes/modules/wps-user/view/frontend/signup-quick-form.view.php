<?php
/**
 * Fichier d'affichage pour l'inscription d'un utilisateur / Tempalte file for user account creation
 *
 * @package WPShop Users
 */

namespace wpshop;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><div class="wps-boxed" id="wps_signup_form_container">
	<span class="wps-h5"><?php esc_html_e( 'Sign up', 'wpshop' ); ?></span>
	<form action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" method="post" id="wps_quick_signup_form" >
		<input type="hidden" name="action" value="wps_quick_signup" />
		<?php wp_nonce_field( 'wps_quick_signup' ); ?>

		<div class="wps-form-group">
			<div class="wps-form" ><input type="text" name="wps_user_email" placeholder="<?php esc_html_e( 'Your email address', 'wpshop' );?>" /></div>
		</div>

		<button class="wps-bton-first-alignRight-rounded" ><?php esc_html_e( 'Sign up', 'wpshop' ); ?></button>
	</form>
</div>
