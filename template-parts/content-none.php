<?php
/**
 * Sin resultados
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="kinetic-empty kinetic-glass kinetic-container">
	<h1 class="kinetic-empty__title"><?php esc_html_e( 'Nothing here', 'kinetic' ); ?></h1>
	<p class="kinetic-empty__text"><?php esc_html_e( 'No content found. Try another search or go back home.', 'kinetic' ); ?></p>
	<a class="kinetic-btn kinetic-btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'kinetic' ); ?></a>
</div>
