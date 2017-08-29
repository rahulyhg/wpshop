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
class WPS_Customer_Filter {

	/**
	 * Instanciate the user
	 */
	public function __construct() {
		// Appel du filtre permettant d'ajouter des informations dans la liste des méthodes de contacts dans les profil utilisateur.
		add_filter( 'wps_my_account_extra_panel_content', array( $this, 'display_customer_form_in_account' ), 10, 3 );
	}

	/**
	 * Filtre la liste des méthodes de contact de WordPress pour ajouter le numéro de téléphone / Filter WordPress default contact method list in order to add phone numbre.
	 *
	 * @param array   $contact_methods La liste actuelle des méthodes permettant de contacter l'utilisateur / The current method list to contact a user.
	 * @param WP_user $user          L'utilisateur en court d'édition / The current edited user.
	 */
	public function display_customer_form_in_account( $output, $part, $current_customer_id ) {
		if ( 'account' === $part ) {
			$current_customer_id = ! empty( $_COOKIE ) && ! empty( $_COOKIE['wps_current_connected_customer'] ) ? (int) $_COOKIE['wps_current_connected_customer'] : wps_customer_ctr::get_customer_id_by_author_id( get_current_user_id() );

			$current_customer = WPS_Customer_Class::g()->get( array( 'id' => $current_customer_id ), true );

			ob_start();
			\eoxia\View_Util::exec( 'wpshop', 'wps-customer', 'frontend/customer-form', array(
				'customer'		=> $current_customer,
			) );
			$output .= ob_get_clean();
		}

		return $output;
	}

}

new WPS_Customer_Filter();
