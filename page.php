<?php
/**
 * Página estática
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main class="kinetic-main kinetic-main--inner kinetic-container kinetic-page">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article <?php post_class( 'kinetic-page-article' ); ?>>
			<h1 class="kinetic-page-title"><?php the_title(); ?></h1>
			<div class="kinetic-page-content entry-content">
				<?php the_content(); ?>
			</div>
		</article>
	<?php endwhile; ?>
</main>

<?php
get_footer();
