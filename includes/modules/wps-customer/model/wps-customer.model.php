<?php
/**
 * Gestion des modèles pour les clients / Manage customers' models
 *
 * @author Eoxia dev team <dev@eoxia.com>
 * @since 1.0.0.0
 * @version 1.3.0.0
 * @copyright 2015-2017
 * @package WPShop Customers
 * @subpackage Models
 */

namespace wpshop;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * [WPS_User_Model description]
 */
class WPS_Customer_Model extends \eoxia\Post_Model {

	/**
	 * Extension du modèle par défaut des utilisateurs / Extend users' default model
	 *
	 * @param Mixed $object L'objet courant / Current object.
	 */
	public function __construct( $object ) {
		$this->model['siret'] = array(
			'type'			=> 'string',
			'field'			=> 'siret',
			'bydefault'	=> '',
		);
		$this->model['phone'] = array(
			'type'			=> 'string',
			'field'			=> 'phone',
			'bydefault'	=> '',
		);

		parent::__construct( $object );
	}

}
