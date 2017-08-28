<?php
/**
 * Fichier d'affichage des champs de souscription aux newsletter du site et de ses partenaires / File for displaying newsletter subscription fields
 *
 * @package WPShop Users
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php if ( ! empty( $wpshop_cart_option['display_newsletter']['site_subscription'][0] ) && ( 'yes' === $wpshop_cart_option['display_newsletter']['site_subscription'][0] ) ) : ?>
	<div class="wps-form-group field-newsletters_site">
		<div class="wps-form">
			<input id="newsletters_site" type="checkbox" name="newsletters_site" <?php echo ( ( ! empty( $user_preferences['newsletters_site'] ) && 1 === $user_preferences['newsletters_site'] ) ? ' checked="checked"' : null); ?>>
			<label 	for="newsletters_site"><?php esc_html_e( 'I want to receive promotional information from the site', 'wpshop' ); ?></label>
		</div>
	</div>
<?php endif; ?>

<?php if ( ! empty( $wpshop_cart_option['display_newsletter']['partner_subscription'][0] ) && ( 'yes' === $wpshop_cart_option['display_newsletter']['partner_subscription'][0] ) ) : ?>
	<div class="wps-form-group field-newsletters_site_partners">
		<div class="wps-form">
			<input id="newsletters_site_partners" type="checkbox" name="newsletters_site_partners" <?php echo ( ( ! empty( $user_preferences['newsletters_site_partners'] ) && 1 === $user_preferences['newsletters_site_partners'] ) ? ' checked="checked"' : null); ?>/>
			<label for="newsletters_site_partners"><?php esc_html_e( 'I want to receive promotional information from partner companies', 'wpshop' ); ?></label>
		</div>
	</div>
<?php endif; ?>
