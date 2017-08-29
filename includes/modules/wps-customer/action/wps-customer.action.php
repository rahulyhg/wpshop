<?php
/**
 * Fichier des actions pour la gestion des clients dans WPShop / Actions' file for customers' management in WPShop
 *
 * @author Eoxia dev team <dev@eoxia.com>
 * @version 1.0.0.0
 * @package WPShop Customers
 * @subpackage Action
 */

namespace wpshop;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classes des actions pour la gestion des clients dans WPShop / Actions' class for customers' management in WPShop
 */
class WPS_Customer_Action {

	/**
	 * Instanciate the user
	 */
	public function __construct() {
		add_action( 'add_meta_boxes_' . WPSHOP_NEWTYPE_IDENTIFIER_CUSTOMERS, array( $this, 'add_meta_box_customer' ) );
	}

	public function add_meta_box_customer() {
		add_meta_box( 'wps_customer_informations', __( 'Customer\'s account informations', 'wpshop' ), array( $this, 'wps_customer_account_informations' ), WPSHOP_NEWTYPE_IDENTIFIER_CUSTOMERS, 'normal', 'high' );
	}

	/**
	 * META-BOX CONTENT - Display Customer's account informations in administration panel
	 *
	 * @param WP_Post $post Current post (customer) we are editing.
	 */
	function wps_customer_account_informations( $post ) {
		$current_customer = WPS_Customer_Class::g()->get( array( 'id' => $post->ID ), true );

		\eoxia\View_Util::exec( 'wpshop', 'wps-customer', 'backend/customer-form', array(
			'customer'		=> $current_customer,
		) );
	}

}

new WPS_Customer_Action();
