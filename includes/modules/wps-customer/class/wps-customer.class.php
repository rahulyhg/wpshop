<?php
/**
 * FIchier de la classe pour la gestion des clients dans WPShop / Class file for customers' manager in WPShop
 *
 * @author Eoxia dev team <dev@eoxia.com>
 * @version 1.0.0.0
 * @package WPShop Customers
 * @subpackage Classes
 */

namespace wpshop;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classes pour la gestion des clients dans WPShop / Classes for customers' manager in WPShop
 *
 * @author Eoxia dev team <dev@eoxia.com>
 * @version 1.0.0.0
 * @package WPShop Customers
 * @subpackage Classes
 */
class WPS_Customer_Class extends \eoxia\Post_Class {

	/**
	 * Le nom du modèle / Model name
	 *
	 * @var string
	 */
	protected $model_name 	= '\wpshop\WPS_Customer_Model';

	/**
	 * SLug de base pour l'api rest
	 *
	 * @var string
	 */
	protected $base = 'wpshop-customers';

	/**
	 * Instanciation des clients / Instanciate customers' management
	 */
	protected function construct() {
		parent::construct();
	}

}

WPS_Customer_Class::g();
