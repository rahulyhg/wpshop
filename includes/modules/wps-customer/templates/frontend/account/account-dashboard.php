<?php
/**
 * Fichier d'affichage du tableau de bord du compte client / Customer dashboard display tamplate
 *
 * @package WPShop Customers
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php if ( 0 !== $current_connected_user_id ) :
	$account_user = get_userdata( $current_connected_user_id ); ?>
<div class="wps-user-dashboard" >
	<?php do_action( 'wps_user_dashboard_header', $current_connected_user_id, $account_user ); ?>

	<div class="wps-user-info has-sub-menu" >
		<span class="wps-user-name">
			<?php echo get_avatar( $current_connected_user_id, 40 ); ?>
			<strong><?php echo esc_html( $account_user->data->user_login ); ?></strong>
		</span>
		<ul class="sub-menu" >
		<?php
		if ( function_exists( 'current_user_switched' ) ) :
			$old_user = current_user_switched();
			if ( $old_user && $url = user_switching::maybe_switch_url( $old_user ) ) :
				printf( '<li><a href="%s">' . esc_html( __( 'Switch back', 'wpshop' ) ) . '</a></li>', esc_url( $url ) );
			endif;
		endif;
		?>
			<li><a href="<?php echo esc_url( wp_logout_url( site_url() ) ); ?>"><i class="wps-icon-power"></i>&nbsp;<?php esc_html_e( 'Logout' ); ?></a></li>
		</ul>
	</div>
</div>
<?php endif; ?>

<section class="wps-section-account">
	<div class="wps-section-taskbar">
	<?php if ( ! empty( $dashboard_part_list ) && is_array( $dashboard_part_list ) ) : ?>
		<ul>
		<?php $i = 0; ?>
		<?php foreach ( $dashboard_part_list as $slug => $dashboard_part ) : ?>
			<li class="<?php echo ( empty( $part ) && ( 1 === $i ) || ( ! empty( $part ) && ( $slug === $part ) ) ? 'wps-activ' : '' ); ?>">
				<a data-target="menu<?php echo esc_attr( $i ); ?>" href="<?php echo esc_url( get_permalink( $account_page_id ) . ( ( ! empty( $permalink_option ) ? '?' : '&' ) . 'account_dashboard_part=' . $slug ) ); ?>" title="" class="" >
					<i class="<?php echo esc_attr( $dashboard_part['icon'] ); ?>"></i>
					<span><?php echo esc_html( $dashboard_part['title'] ); ?></span>
				</a>
			</li>
			<?php $i++; ?>
		<?php endforeach; ?>
			<?php echo apply_filters( 'wps_my_account_extra_part_menu', '' ); // WPCS: XSS ok. ?>
		</ul>
	<?php endif; ?>
	</div>
	<div class="wps-section-content">
		<div class="wps-activ" id="wps_dashboard_content" data-nonce="<?php echo esc_attr( wp_create_nonce( 'wps_refresh_add_opinion_list' ) ); ?>">
			<?php echo $this->display_dashboard_content( $part ); // WPCS: XSS ok. ?>
		</div>
	</div>
</section>
