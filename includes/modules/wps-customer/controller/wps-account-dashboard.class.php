<?php
/**
 * Gestion de la page mon compte du client dans le frontend / Manage frontend account page for customer
 *
 * @package WPShop Customers
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion du tableau de bord des clients dans le site / Customer dashboard in website
 */
class WPS_Account_Dashboard_Class {

	/**
	 * Instanciation du tableau de bord des clients / Instanciate customer dashboard
	 */
	function __construct() {
		if ( empty( $_COOKIE ) || empty( $_COOKIE['wps_current_connected_customer'] ) ) {
			setcookie( 'wps_current_connected_customer', wps_customer_ctr::get_customer_id_by_author_id( get_current_user_id() ), strtotime( '+30 days' ), SITECOOKIEPATH, COOKIE_DOMAIN, is_ssl() );
		}

		add_shortcode( 'wps_account_dashboard', array( $this, 'display_account_dashboard' ) );
		add_shortcode( 'wps_account_last_actions_resume', array( $this, 'display_account_last_actions' ) );
	}

	/**
	 * Shortcode Callback - Affichage du tableau de bord du compte client / Display customer account dashboard
	 */
	function display_account_dashboard() {
		$current_connected_user_id = get_current_user_id();

		// Inclusion du tableau de bord uniquement si l'utilisateur est connecté / Include dashboard only if user is logged in.
		if ( 0 === $current_connected_user_id ) {
			$output = do_shortcode( '[wpshop_authentification]' );
		} else {
			$part = ( ! empty( $_GET['account_dashboard_part'] ) ) ? sanitize_title( $_GET['account_dashboard_part'] ) : 'account';
			$permalink_option = get_option( 'permalink_structure' );
			$account_page_id = wpshop_tools::get_page_id( get_option( 'wpshop_myaccount_page_id' ) );

			$default_dashboard_part_list = array(
				'account' => array(
					'title'	=> __( 'Account', 'wpshop' ),
					'icon'	=> 'wps-icon-user',
				),
				'address' => array(
					'title'	=> __( 'Addresses', 'wpshop' ),
					'icon'	=> 'wps-icon-user',
				),
				'order' => array(
					'title'	=> __( 'Orders', 'wpshop' ),
					'icon'	=> 'wps-icon-truck',
				),
				'coupon' => array(
					'title'	=> __( 'Coupons', 'wpshop' ),
					'icon'	=> 'wps-icon-promo',
				),
				'messages' => array(
					'title'	=> __( 'Messages', 'wpshop' ),
					'icon'	=> 'wps-icon-email',
				),
			);

			$dashboard_part_list = apply_filters( 'wps_filter_account_dashboard_part_list', $default_dashboard_part_list );

			ob_start();
			require_once( wpshop_tools::get_template_part( WPS_ACCOUNT_DIR, WPS_ACCOUNT_TPL, 'frontend', 'account/account-dashboard' ) );
			$output = ob_get_contents();
			ob_end_clean();
		}

		echo $output; // WPCS: XSS ok.
	}

	/**
	 * Affichage du contenu du tableau de bord du client selon l'onglet choisi / Display customer dashboard content according to chosen tab
	 *
	 * @param  string $part L'identifiant de l'onglet choisi / Chosen tab identifier.
	 *
	 * @return string       Le contenu HTML a afficher pour l'onglet sélectionné / The HTML ouput to display for chosen tab
	 */
	function display_dashboard_content( $part ) {
		$output = '';
		$current_customer_id = ! empty( $_COOKIE ) && ! empty( $_COOKIE['wps_current_connected_customer'] ) ? (int) $_COOKIE['wps_current_connected_customer'] : wps_customer_ctr::get_customer_id_by_author_id( get_current_user_id() );

		switch ( $part ) {
			case 'account':
				$output  = '<div id="wps_account_informations_container" data-nonce="' . esc_attr( wp_create_nonce( 'wps_account_reload_informations' ) ) . '" >';
				$output .= do_shortcode( '[wps_account_informations cid="' . $current_customer_id . '" ]' );
				$output .= '</div>';
				$output .= do_shortcode( '[wps_orders_in_customer_account cid="' . $current_customer_id . '" ]' );
			break;
			case 'address':
				$output .= do_shortcode( '[wps_addresses cid="' . $current_customer_id . '" ]' );
			break;
			case 'order':
				$output = do_shortcode( '[wps_orders_in_customer_account cid="' . $current_customer_id . '" ]' );
			break;
			case 'coupon':
				$output = do_shortcode( '[wps_coupon cid="' . $current_customer_id . '" ]' );
			break;
			case 'messages':
				$output = do_shortcode( '[wps_message_histo cid="' . $current_customer_id . '" ]' );
			break;

			default :
				$output = do_shortcode( '[wps_account_informations cid="' . $current_customer_id . '" ]' );
			break;
		}

		$output = apply_filters( 'wps_my_account_extra_panel_content', $output, $part, $current_customer_id );

		return $output;
	}

	/**
	 * Affichage de l'historique des commandes effectuées par l'utilisateur connecté / Display order history for connected user
	 *
	 * @return string L'affichage HTML de l'historique / HTML output for history
	 */
	function display_account_last_actions() {
		$output = '';

		$user_id = get_current_user_id();
		if ( ! empty( $user_id ) ) {
			$query = $GLOBALS['wpdb']->prepare( "SELECT * FROM {$GLOBALS['wpdb']->posts} WHERE post_type = %s AND post_author = %d", WPSHOP_NEWTYPE_IDENTIFIER_ORDER, $user_id );
			$orders = $GLOBALS['wpdb']->get_results( $query );
			if ( ! empty( $orders ) ) {
				$orders_list = '';
				foreach ( $orders as $order ) {
					$order_meta = get_post_meta( $order->ID, '_order_postmeta', true );
					$order_number = ( ! empty( $order_meta ) && ! empty( $order_meta['order_key'] ) ) ? $order_meta['order_key'] : '';
					$order_date = ( ! empty( $order_meta ) && ! empty( $order_meta['order_date'] ) ) ? mysql2date( get_option( 'date_format' ), $order_meta['order_date'], true ) : '';
					$order_amount = ( ! empty( $order_meta ) && ! empty( $order_meta['order_key'] ) ) ? wpshop_tools::formate_number( $order_meta['order_grand_total'] ) . ' ' . wpshop_tools::wpshop_get_currency( false ) : '';
					$order_available_status = unserialize( WPSHOP_ORDER_STATUS );
					$order_status = ( ! empty( $order_meta ) && ! empty( $order_meta['order_status'] ) ) ? __( $order_available_status[ $order_meta['order_status'] ], 'wpshop' ) : '';
					ob_start();
					require( wpshop_tools::get_template_part( WPS_ACCOUNT_DIR, WPS_ACCOUNT_TPL, 'frontend', 'account/account-dashboard-resume-element' ) );
					$orders_list .= ob_get_contents();
					ob_end_clean();
				}

				ob_start();
				require_once( wpshop_tools::get_template_part( WPS_ACCOUNT_DIR, WPS_ACCOUNT_TPL, 'frontend', 'account/account-dashboard-resume' ) );
				$output = ob_get_contents();
				ob_end_clean();
			}
		}

		return $output;
	}

}
