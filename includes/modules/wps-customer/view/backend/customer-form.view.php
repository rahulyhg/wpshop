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
	<?php echo apply_filters( 'wps_filter_customer_form_top', '', $args ); // WPCS: XSS ok. ?>

	<div class="wps-form-group">
		<label for="wps_customer_infos_siret"><?php esc_html_e( 'SIRET code', 'wpshop' );?></label>
		<div class="wps-form"><input type="text" name="wps_customer_infos[lastname]" id="wps_customer_infos_siret" placeholder="<?php esc_html_e( 'Your siret code...', 'wpshop' );?>" value="<?php echo esc_attr( $customer->siret ); ?>" /></div>
	</div>
	<div class="wps-form-group">
		<label for="wps_customer_infos_phone"><?php esc_html_e( 'Phone number', 'wpshop' );?></label>
		<div class="wps-form"><input type="text" name="wps_customer_infos[phone]" id="wps_customer_infos_phone" placeholder="<?php esc_html_e( 'Your society phone number...', 'wpshop' );?>" value="<?php echo esc_attr( $customer->phone ); ?>" /></div>
	</div>

	<?php echo apply_filters( 'wps_filter_customer_form_bottom', '', $args ); // WPCS: XSS ok. ?>
</div>
