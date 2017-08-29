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
class WPS_User_Action {

	/**
	 * Instanciate the user
	 */
	public function __construct() {
		// Demande de connexion d'un utilisateur / User ask login to its account.
		add_action( 'wp_ajax_nopriv_wps_login_request', array( $this, 'wps_login_request' ) );

		// Création d'un compte pour un utilisateur à partir de son email / Create user account from an email address.
		add_action( 'wp_ajax_nopriv_wps_quick_signup', array( $this, 'wps_quick_signup' ) );

		// Enregistrement des informations du compte client / Save user account informations.
		add_action( 'wp_ajax_wps_user_account_save', array( $this, 'wps_save_account' ) );

		// Appel des scripts pour le module / Enqueue scripts for module.
		add_action( 'wp_enqueue_scripts', array( $this, 'wps_user_assets' ) );
	}

	public function wps_user_assets() {
		$module_name = 'wps-user';
		wp_enqueue_script( 'wps-user-frontend', str_replace( plugin_dir_path( \eoxia\Config_Util::$init['wpshop']->path . '/wpshop.php' ), plugin_dir_url( \eoxia\Config_Util::$init['wpshop']->path . '/wpshop.php' ), \eoxia\Config_Util::$init['wpshop']->$module_name->path ) . '/asset/js/wps-user.frontend.js', array(), \eoxia\Config_Util::$init['wpshop']->$module_name->version, true );
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

	/**
	 * AJAX Callback - Connexion de l'utilisateur à son compte après vérification des informations fournies / Login the user to his account after checking given informations
	 */
	public function wps_login_request() {
		check_ajax_referer( 'control_login_form_request' );

		$result = '';
		$status = false;
		$origin = sanitize_text_field( $_POST['wps-checking-origin'] );
		$wps_login_user_login = ! empty( $_POST['wps_login_user_login'] ) ? sanitize_text_field( $_POST['wps_login_user_login'] ) : '';
		$wps_login_password = ! empty( $_POST['wps_login_password'] ) ? sanitize_text_field( $_POST['wps_login_password'] ) : '';

		if ( ! empty( $wps_login_user_login ) && ! empty( $wps_login_password ) ) {
			$creds = array();
			// Test if an user exist with this login.
			$user_checking = get_user_by( 'login', $wps_login_user_login );
			if ( ! empty( $user_checking ) ) {
				$creds['user_login'] = $wps_login_user_login;
			} else {
				if ( is_email( $wps_login_user_login ) ) {
					$user_checking = get_user_by( 'email', $wps_login_user_login );
					$creds['user_login'] = $user_checking->user_login;
				}
			}
			if ( ! empty( $creds['user_login'] ) ) {
				$creds['user_password'] = $wps_login_password;
				$creds['remember'] = false;
				$user = wp_signon( $creds, false );
				if ( is_wp_error( $user ) ) {
					$result = '<div class="wps-alert-error">';
					foreach ( $user->errors as $error_key => $error_details ) {
						$result .= '<ul>';
						foreach ( $error_details as $error_detail ) {
							$result .= '<li>' . strip_tags( $error_detail ) . '</li>';
						}
						$result .= '</ul>';
					}
					$result .= '</div>';
				} else {
					if ( wp_get_referer() ) {
						$result = wp_get_referer();
					}
					$status = true;
				}
			} else {
				$result = '<div class="wps-alert-error">' . __( 'We are unable to found your account with given login', 'wpshop' ) . '</div>';
			}
		} else {
			$result = '<div class="wps-alert-error">' . __( 'E-Mail and Password are required', 'wpshop' ) . '</div>';
		}

		wp_die( wp_json_encode( array( $status, $result ) ) );
	}

	/**
	 * AJAX Callback - Création d'un compte utilisateur / Create a new user account
	 */
	public function wps_quick_signup() {
		check_ajax_referer( 'wps_quick_signup' );
		$status = false;

		// Vérification de l'email envoyé par l'internaute / Check email sended by the websurfer.
		$posted_user_email = ! empty( $_POST ) && ! empty( $_POST['wps_user_email'] ) && is_email( $_POST['wps_user_email'] ) ? sanitize_email( $_POST['wps_user_email'] ) : null;
		if ( is_null( $posted_user_email ) ) {
			$message = __( 'Given email is not a valid one. Please double check it before retrying.', 'wpshop' );
		} else {
			// Vérification que l'email n'est pas déjà utilisé / Check if the email is not already used.
			$user_checking = get_user_by( 'email', $posted_user_email );
			if ( ! empty( $user_checking ) ) {
				$message = __( 'Hey dude, it seems you have already an account. Please login or ask a new password.', 'wpshop' );
			} else {
				$user_info = array(
					'email'			=> $posted_user_email,
					'login'			=> $posted_user_email,
					'password'	=> wp_generate_password( 12, false ),
				);
				$created_user = WPS_User_Class::g()->create( $user_info );
			}
		}

		wp_die( wp_json_encode( array( 'status' => $status, 'message' => $message, 'object' => $created_user ) ) );
	}

	/**
	 * AJAX Callback - Enregistrement des informations de l'utilisateur / Save user account informations
	 */
	public function wps_save_account() {
		check_ajax_referer( 'wps_user_account_save' );

		$user_id = ! empty( $_POST ) && ! empty( $_POST['wps_user_account'] ) && ! empty( $_POST['wps_user_account']['user_id'] ) ? sanitize_text_field( $_POST['wps_user_account']['user_id'] ) : null;
		$user_login = ! empty( $_POST ) && ! empty( $_POST['wps_user_account'] ) && ! empty( $_POST['wps_user_account']['user_login'] ) ? sanitize_text_field( $_POST['wps_user_account']['user_login'] ) : null;

		$user_firstname = ! empty( $_POST ) && ! empty( $_POST['wps_user_account'] ) && ! empty( $_POST['wps_user_account']['firstname'] ) ? sanitize_text_field( $_POST['wps_user_account']['firstname'] ) : null;
		$user_lastname = ! empty( $_POST ) && ! empty( $_POST['wps_user_account'] ) && ! empty( $_POST['wps_user_account']['lastname'] ) ? sanitize_text_field( $_POST['wps_user_account']['lastname'] ) : null;
		$user_email = ! empty( $_POST ) && ! empty( $_POST['wps_user_account'] ) && ! empty( $_POST['wps_user_account']['email'] ) ? sanitize_email( $_POST['wps_user_account']['email'] ) : null;
		$user_cellphone = ! empty( $_POST ) && ! empty( $_POST['wps_user_account'] ) && ! empty( $_POST['wps_user_account']['cellphone'] ) ? sanitize_text_field( $_POST['wps_user_account']['cellphone'] ) : null;

		$user_password = ! empty( $_POST ) && ! empty( $_POST['wps_user_account'] ) && ! empty( $_POST['wps_user_account']['password'] ) ? sanitize_text_field( $_POST['wps_user_account']['password'] ) : null;
		$user_password_confirmation = ! empty( $_POST ) && ! empty( $_POST['wps_user_account'] ) && ! empty( $_POST['wps_user_account']['password_confirmation'] ) ? sanitize_text_field( $_POST['wps_user_account']['password_confirmation'] ) : null;

		if ( ! is_email( $user_email ) ) {

		} else {
			$user_info = array(
				'id'					=> $user_id,
				'login'				=> ! is_null( $user_login ) ? $user_login : $user_email,
				'firstname'		=> $user_firstname,
				'lastname'		=> $user_lastname,
				'email'				=> $user_email,
				'cellphone'		=> $user_cellphone,
			);
			$user_update = WPS_User_Class::g()->update( $user_info );
		}

		wp_die( );
	}

}

new WPS_User_Action();
