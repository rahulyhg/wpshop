<?php
/**
 * CLasses pour la gestion des utilisateurs dans WPShop / Classes for users' manager in WPShop
 *
 * @author Eoxia dev team <dev@eoxia.com>
 * @version 1.0.0.0
 * @package WPShop Users
 * @subpackage Classes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Initialise les scripts JS et CSS du Plugin
 * Ainsi que le fichier MO
 */
class WPS_User_Class extends \eoxia\User_Class {

	/**
	 * Instanciate the user
	 */
	protected function construct() { }

}

WPS_User_Class::g();
