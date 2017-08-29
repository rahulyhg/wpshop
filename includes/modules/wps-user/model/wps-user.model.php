<?php
/**
 * Gestion des modèle pour les utilisateurs / Manage user models
 *
 * @author Eoxia dev team <dev@eoxia.com>
 * @since 1.0.0.0
 * @version 1.3.0.0
 * @copyright 2015-2017
 * @package WPShop Users
 * @subpackage Models
 */

namespace wpshop;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * [WPS_User_Model description]
 */
class WPS_User_Model extends \eoxia\User_Model {

	/**
	 * Extension du modèle par défaut des utilisateurs / Extend users' default model
	 *
	 * @param Mixed $object L'objet courant / Current object.
	 */
	public function __construct( $object ) {
		$this->model['cellphone'] = array(
			'type'			=> 'string',
			'meta_type' => 'single',
			'field'			=> 'wps_phone',
			'bydefault'	=> '',
		);

		parent::__construct( $object );
	}

}
