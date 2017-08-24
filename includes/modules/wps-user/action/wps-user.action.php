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
class WPS_User_Action {

	/**
	 * Instanciate the user
	 */
	public function __construct() {
		// Appel du filtre permettant d'ajouter des informations dans la liste des méthodes de contacts dans les profil utilisateur.
		add_filter( 'user_contactmethods', array( $this, 'add_contact_method_to_user' ), 20, 2 );
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

}

new WPS_User_Action();
