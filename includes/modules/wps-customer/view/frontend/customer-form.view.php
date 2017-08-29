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
	<span class="wps-h5"><?php esc_html_e( 'My society informations', 'wpshop' ); ?></span>
	<form action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" method="post" id="wps_customer_infos_form" >
		<input type="hidden" name="action" value="wps_customer_form_save" />
		<?php wp_nonce_field( 'wps_customer_form_save' ); ?>

		<input type="hidden" name="wps_customer_infos[user_id]" value="<?php echo esc_attr( $customer->id ); ?>" />

		<?php echo apply_filters( 'wps_filter_customer_form_top', '', $args ); // WPCS: XSS ok. ?>

		<div class="wps-form-group">
			<label for="wps_customer_infos_name"><?php esc_html_e( 'Society name', 'wpshop' );?></label>
			<div class="wps-form"><input type="text" name="wps_customer_infos[title]" id="wps_customer_infos_name" placeholder="<?php esc_html_e( 'Your society name...', 'wpshop' );?>" value="<?php echo esc_attr( $customer->title ); ?>" /></div>
		</div>
		<div class="wps-form-group">
			<label for="wps_customer_infos_siret"><?php esc_html_e( 'SIRET code', 'wpshop' );?></label>
			<div class="wps-form"><input type="text" name="wps_customer_infos[siret]" id="wps_customer_infos_siret" placeholder="<?php esc_html_e( 'Your siret code...', 'wpshop' );?>" value="<?php echo esc_attr( $customer->siret ); ?>" /></div>
		</div>
		<div class="wps-form-group">
			<label for="wps_customer_infos_phone"><?php esc_html_e( 'Phone number', 'wpshop' );?></label>
			<div class="wps-form"><input type="text" name="wps_customer_infos[phone]" id="wps_customer_infos_phone" placeholder="<?php esc_html_e( 'Your society phone number...', 'wpshop' );?>" value="<?php echo esc_attr( $customer->phone ); ?>" /></div>
		</div>

		<?php echo apply_filters( 'wps_filter_customer_form_bottom', '', $args ); // WPCS: XSS ok. ?>

		<div class="wps-form-group"></div>
		<div class="wps-form-group">
			<button class="wps-bton-first-alignRight-rounded" ><?php esc_html_e( 'Save', 'wpshop' ); ?></button>
		</div>
	</form>
</div>
