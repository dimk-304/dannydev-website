<?php
/**
 * Cabecera del tema
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="kinetic-html dark">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'kinetic-body' ); ?>>
<?php wp_body_open(); ?>

<div class="kinetic-mesh" aria-hidden="true"></div>

<header class="kinetic-header">
	<div class="kinetic-nav__backdrop" aria-hidden="true"></div>
	<nav class="kinetic-nav" aria-label="<?php esc_attr_e( 'Principal', 'kinetic' ); ?>">
		<button type="button" class="kinetic-nav__toggle" aria-expanded="false" aria-controls="kinetic-nav-menu">
			<span class="screen-reader-text"><?php esc_html_e( 'Abrir menú', 'kinetic' ); ?></span>
			<span class="kinetic-nav__toggle-bar" aria-hidden="true"></span>
			<span class="kinetic-nav__toggle-bar" aria-hidden="true"></span>
		</button>

		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_id'        => 'kinetic-nav-menu',
				'menu_class'     => 'kinetic-nav__list',
				'fallback_cb'    => 'kinetic_fallback_menu',
			)
		);
		?>

		<?php kinetic_render_language_switcher(); ?>

		<a class="kinetic-btn kinetic-btn--primary kinetic-btn--nav" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>">
			<?php esc_html_e( "Let's Talk", 'kinetic' ); ?>
		</a>
	</nav>
</header>
