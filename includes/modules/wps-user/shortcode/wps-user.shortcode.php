<?php
/**
 * Actions pour la gestion des utilisateurs dans WPShop / Actions for users' manager in WPShop
 *
 * @author Eoxia dev team <dev@eoxia.com>
 * @version 1.0.0.0
 * @package WPShop Users
 * @subpackage Action
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Initialise les scripts JS et CSS du Plugin
 * Ainsi que le fichier MO
 */
class WPS_User_Shortcode {

	/**
	 * Instanciate the user
	 */
	public function __construct() {
		// Définition du shortcode permettant d'afficher la page d'authentification ou de création de compte / Define shortcode allowing to display sign in or sign up.
		add_shortcode( 'wpshop_authentification', array( $this, 'display_authentification_page' ) );
	}

	/**
	 * Filtre la liste des méthodes de contact de WordPress pour ajouter le numéro de téléphone / Filter WordPress default contact method list in order to add phone numbre.
	 *
	 * @param array $shortcode_args Les arguments qui sont passés au shortcode / Parameters passed to shortcode.
	 */
	public function display_authentification_page( $shortcode_args ) {
		ob_start();
		\eoxia\View_Util::exec( 'wpshop', 'wps-user', 'frontend/authentification', array() );
		$content = ob_get_clean();

		return $content;
	}

}

new WPS_User_Shortcode();
