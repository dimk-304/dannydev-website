<?php
/**
 * Pie del tema
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;

$brand       = get_theme_mod( 'kinetic_site_brand', 'DANNY DEV' );
$footer_text = get_theme_mod( 'kinetic_footer_legal', __( '© 2026 Danny Cen · Mérida, Yucatán, Mexico', 'kinetic' ) );
?>
<footer class="kinetic-footer">
	<div class="kinetic-container kinetic-footer__inner">
		<div class="kinetic-footer__brand">
			<span class="kinetic-footer__logo"><?php echo esc_html( $brand ); ?></span>
			<span class="kinetic-footer__copy"><?php echo esc_html( $footer_text ); ?></span>
		</div>
		<?php if ( has_nav_menu( 'footer' ) ) : ?>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'kinetic-footer__menu',
					'depth'          => 1,
				)
			);
			?>
		<?php else : ?>
			<div class="kinetic-footer__links">
				<a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy', 'kinetic' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>"><?php esc_html_e( 'Terms', 'kinetic' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><?php esc_html_e( 'Socials', 'kinetic' ); ?></a>
			</div>
		<?php endif; ?>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
