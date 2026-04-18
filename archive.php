<?php
/**
 * Archivos (categorías, etiquetas, fechas, autor)
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main class="kinetic-main kinetic-main--inner kinetic-container">
	<header class="kinetic-page-header">
		<h1 class="kinetic-page-title"><?php the_archive_title(); ?></h1>
		<?php the_archive_description( '<div class="kinetic-archive-desc">', '</div>' ); ?>
	</header>

	<?php if ( have_posts() ) : ?>
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
</main>

<?php
get_footer();
