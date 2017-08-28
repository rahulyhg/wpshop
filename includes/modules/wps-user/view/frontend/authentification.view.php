<?php
/**
 * Fichier d'affichage pour l'authentification d'un utilisateur / Template for user authentification
 *
 * @package WPShop Users
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

echo do_shortcode( '[wps_login]' );
echo do_shortcode( '[wps_signup type="quick"]' );
