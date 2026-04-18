<?php
/**
 * Pie específico para índice del blog
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;

$brand       = get_theme_mod( 'kinetic_site_brand', 'DANNY DEV' );
$footer_text = get_theme_mod( 'kinetic_footer_legal', __( '© 2026 Danny Cen · Mérida, Yucatán, Mexico', 'kinetic' ) );
?>
<footer class="kinetic-footer kinetic-blog-footer">
	<div class="kinetic-container kinetic-footer__inner">
		<div class="kinetic-footer__brand">
			<span class="kinetic-footer__logo"><?php echo esc_html( $brand ); ?></span>
			<span class="kinetic-footer__copy"><?php echo esc_html( $footer_text ); ?></span>
		</div>

		<div class="kinetic-footer__links">
			<a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy', 'kinetic' ); ?></a>
			<a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>"><?php esc_html_e( 'Terms', 'kinetic' ); ?></a>
			<a href="https://github.com" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Github', 'kinetic' ); ?></a>
			<a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><?php esc_html_e( 'Signal', 'kinetic' ); ?></a>
		</div>

		<div class="kinetic-blog-footer__icons" aria-hidden="true">
			<span class="kinetic-blog-footer__icon material-symbols-outlined">share</span>
			<span class="kinetic-blog-footer__icon material-symbols-outlined">notifications</span>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
