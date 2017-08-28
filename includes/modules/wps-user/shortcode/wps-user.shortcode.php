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

		// Formulaire de connexion / Login form.
		add_shortcode( 'wps_login', array( $this, 'login_form' ) );
		add_shortcode( 'wpshop_login', array( $this, 'login_form' ) );

		// Formulaire de création de compte / Signup form.
		add_shortcode( 'wps_signup', array( $this, 'signup_form' ) );

		// Formulaire de création - édition de compte complet / Full account creation - edition.
		add_shortcode( 'wps_account_form', array( $this, 'account_form' ) );
	}

	/**
	 * Définition du shortcode permettant l'affichage de la page d'authentification (inscription ou connexion) / Define shortcode allowing to display athetification page ( signin or signup )
	 *
	 * @param array $shortcode_args Les arguments qui sont passés au shortcode / Parameters passed to shortcode.
	 */
	public function display_authentification_page( $shortcode_args ) {
		ob_start();
		\eoxia\View_Util::exec( 'wpshop', 'wps-user', 'frontend/authentification', array() );
		$content = ob_get_clean();

		return $content;
	}

	/**
	 * Définition du shortcode permettant l'affichage du formulaire de cpnnexion / Define sign in form shortcode
	 *
	 * @param array $shortcode_args Les arguments qui sont passés au shortcode / Parameters passed to shortcode.
	 */
	public function login_form( $shortcode_args ) {
		if ( get_current_user_id() !== 0 ) {
			return __( 'You are already logged', 'wpshop' );
		} else {
			$action = ! empty( $_GET['action'] ) ? sanitize_text_field( $_GET['action'] ) : '';
			$key = ! empty( $_GET['key'] ) ? sanitize_text_field( $_GET['key'] ) : '';
			$login = ! empty( $_GET['login'] ) ? sanitize_text_field( $_GET['login'] ) : 0;
			if ( ! empty( $action ) && ( 'retrieve_password' === $action ) && ! empty( $key ) && ! empty( $login ) && ! $force_login ) {
				$output = self::get_renew_password_form();
			} else {
				ob_start();
				\eoxia\View_Util::exec( 'wpshop', 'wps-user', 'frontend/login-form', array(
					'args' => $shortcode_args,
				) );
				$output = ob_get_clean();
			}
			return $output;
		}
	}

	/**
	 * Définition du shortcode permettant l'affichage du formulaire de création de compte / Define signup form shortcode
	 *
	 * @param array $shortcode_args Les arguments qui sont passés au shortcode / Parameters passed to shortcode.
	 */
	public function signup_form( $shortcode_args ) {
		$output = '';

		if ( 0 === get_current_user_id() ) {
			$form_type = ! empty( $shortcode_args ) && ! empty( $shortcode_args['type'] ) ? sanitize_text_field( $shortcode_args['type'] ) : 'quick';

			ob_start();
			\eoxia\View_Util::exec( 'wpshop', 'wps-user', 'frontend/signup-' . $form_type . '-form', array(
				'args' => $shortcode_args,
			) );
			$output = ob_get_clean();
		}

		return $output;
	}

	/**
	 * Définition du shortcode permettant l'affichage du formulaire de création - édition de compte / Define signup form shortcode
	 *
	 * @param array $shortcode_args Les arguments qui sont passés au shortcode / Parameters passed to shortcode.
	 */
	public function account_form( $shortcode_args ) {
		$output = '';

		$user = WPS_User_Class::g()->get( array(
			'id'	=> get_current_user_id(),
		), true);

		ob_start();
		\eoxia\View_Util::exec( 'wpshop', 'wps-user', 'common/account-form', array(
			'args' => $shortcode_args,
			'user' => $user,
		) );
		$output = ob_get_clean();

		return $output;
	}

}

new WPS_User_Shortcode();
