<?php
/**
 * CLasses pour la gestion des utilisateurs dans WPShop / Classes for users' manager in WPShop
 *
 * @author Eoxia dev team <dev@eoxia.com>
 * @version 1.0.0.0
 * @package WPShop Users
 * @subpackage Classes
 */

namespace wpshop;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Initialise les scripts JS et CSS du Plugin
 * Ainsi que le fichier MO
 */
class WPS_User_Class extends \eoxia\User_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name 	= '\wpshop\WPS_User_Model';

	/**
	 * SLug de base pour l'api rest
	 *
	 * @var string
	 */
	protected $base = 'wpshop-user';

	/**
	 * Instanciate the user
	 */
	protected function construct() {
		parent::construct();
	}

}

WPS_User_Class::g();
