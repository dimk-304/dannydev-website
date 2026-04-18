<?php
/**
 * Cabecera específica para índice del blog
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;

$blog_url   = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/' );
$categories = get_categories(
	array(
		'hide_empty' => true,
		'number'     => 3,
	)
);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="kinetic-html dark">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'kinetic-body kinetic-body--blog-index' ); ?>>
<?php wp_body_open(); ?>

<div class="kinetic-mesh" aria-hidden="true"></div>

<header class="kinetic-blog-header">
	<nav class="kinetic-blog-nav">
		<div class="kinetic-blog-nav__inner kinetic-container">
			<div class="kinetic-blog-nav__links">
				<a class="kinetic-blog-nav__link current-menu-item" href="<?php echo esc_url( $blog_url ); ?>"><?php esc_html_e( 'Archive', 'kinetic' ); ?></a>
				<?php foreach ( $categories as $cat ) : ?>
					<a class="kinetic-blog-nav__link" href="<?php echo esc_url( get_category_link( $cat ) ); ?>"><?php echo esc_html( $cat->name ); ?></a>
				<?php endforeach; ?>
			</div>

			<div class="kinetic-blog-nav__actions">
				<?php kinetic_render_language_switcher(); ?>
				<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="kinetic-blog-search">
					<span class="material-symbols-outlined" aria-hidden="true">search</span>
					<input type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search insights...', 'kinetic' ); ?>">
				</form>
				<a class="kinetic-btn kinetic-btn--primary kinetic-btn--nav" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>">
					<?php esc_html_e( 'Subscribe', 'kinetic' ); ?>
				</a>
			</div>
		</div>
		<div class="kinetic-blog-progress-wrap">
			<span class="kinetic-blog-progress" data-blog-progress></span>
		</div>
	</nav>
</header>
