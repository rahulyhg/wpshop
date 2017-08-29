<?php
/**
 * Actions pour la gestion des utilisateurs dans WPShop / Actions for users' manager in WPShop
 *
 * @author Eoxia dev team <dev@eoxia.com>
 * @version 1.0.0.0
 * @package WPShop Users
 * @subpackage Action
 */

namespace wpshop;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Initialise les scripts JS et CSS du Plugin
 * Ainsi que le fichier MO
 */
class WPS_User_Filter {

	/**
	 * Instanciate the user
	 */
	public function __construct() {
		// Appel du filtre permettant d'ajouter des informations dans la liste des méthodes de contacts dans les profil utilisateur.
		add_filter( 'user_contactmethods', array( $this, 'add_contact_method_to_user' ), 20, 2 );

		add_filter( 'wps_filter_account_form_bottom', array( $this, 'display_commercial_newsletter_form' ), 10, 2 );
	}

	/**
	 * Filtre la liste des méthodes de contact de WordPress pour ajouter le numéro de téléphone / Filter WordPress default contact method list in order to add phone numbre.
	 *
	 * @param array   $contact_methods La liste actuelle des méthodes permettant de contacter l'utilisateur / The current method list to contact a user.
	 * @param WP_user $user          L'utilisateur en court d'édition / The current edited user.
	 */
	public function add_contact_method_to_user( $contact_methods, $user ) {
		$wps_contact_method = array(
			'wps_phone'	=> __( 'Phone number', 'wpshop' ),
		);

		return array_merge( $wps_contact_method, $contact_methods );
	}

	/**
	 * Affichage des champs de souscription aux newsletter du site et de ses partenaires / Display newsletter subscription fields for website and partners
	 *
	 * @param  string $output Le contenu actuel défini par l'utilisationdu filtre / Current content defined by filter call.
	 * @param  array  $args   Des paramètres supplémentaires passés au filtre / Extras parameters passed to filter.
	 *
	 * @return string         Le code HTML permettant l'affichage des champs de souscription / HTML code allowing to display subscription fields.
	 */
	function display_commercial_newsletter_form( $output = '', $args = array() ) {
		$user_preferences = get_user_meta( get_current_user_id(), 'user_preferences', true );
		$wpshop_cart_option = get_option( 'wpshop_cart_option' );

		ob_start();
		\eoxia\View_Util::exec( 'wpshop', 'wps-user', 'frontend/newsletter-subscription', array(
			'user_preferences'		=> $user_preferences,
			'wpshop_cart_option'	=> $wpshop_cart_option,
		) );
		$output = ob_get_clean();

		return $output;
	}

}

new WPS_User_Filter();
