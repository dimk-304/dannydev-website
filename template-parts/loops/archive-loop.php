<?php
/**
 * Listado de entradas (blog, búsqueda, archivo genérico desde index)
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;
?>

<?php if ( have_posts() ) : ?>
	<header class="kinetic-page-header">
		<h1 class="kinetic-page-title">
			<?php
			if ( is_home() && ! is_front_page() ) {
				single_post_title();
			} elseif ( is_search() ) {
				/* translators: %s: search query */
				printf( esc_html__( 'Search results for: %s', 'kinetic' ), '<span>' . esc_html( get_search_query() ) . '</span>' );
			} else {
				the_archive_title();
			}
			?>
		</h1>
	</header>

	<div class="kinetic-loop">
		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', 'excerpt' );
		endwhile;
		?>

		<?php the_posts_pagination( array( 'mid_size' => 2 ) ); ?>
	</div>
<?php else : ?>
	<?php get_template_part( 'template-parts/content', 'none' ); ?>
<?php endif; ?>
