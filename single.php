<?php
/**
 * Entrada individual
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main class="kinetic-main kinetic-main--inner kinetic-container kinetic-single">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article <?php post_class( 'kinetic-single__article' ); ?>>
			<header class="kinetic-single__header">
				<time class="kinetic-single__date" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
					<?php echo esc_html( get_the_date() ); ?>
				</time>
				<h1 class="kinetic-single__title"><?php the_title(); ?></h1>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="kinetic-single__media kinetic-glass">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
			<?php endif; ?>

			<div class="kinetic-single__content entry-content">
				<?php the_content(); ?>
			</div>
		</article>

	<?php endwhile; ?>

	<?php
	the_post_navigation(
		array(
			'prev_text' => '<span class="kinetic-nav-label">' . esc_html__( 'Previous', 'kinetic' ) . '</span><span class="kinetic-nav-title">%title</span>',
			'next_text' => '<span class="kinetic-nav-label">' . esc_html__( 'Next', 'kinetic' ) . '</span><span class="kinetic-nav-title">%title</span>',
		)
	);
	?>
</main>

<?php
get_footer();
