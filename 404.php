<?php
/**
 * 404
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main class="kinetic-main kinetic-main--inner kinetic-container">
	<div class="kinetic-empty kinetic-glass">
		<h1 class="kinetic-empty__title"><?php esc_html_e( '404 — Signal lost', 'kinetic' ); ?></h1>
		<p class="kinetic-empty__text"><?php esc_html_e( 'The page you are looking for does not exist or has been moved.', 'kinetic' ); ?></p>
		<a class="kinetic-btn kinetic-btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'kinetic' ); ?></a>
	</div>
</main>

<?php
get_footer();
