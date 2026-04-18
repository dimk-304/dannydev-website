<?php
/**
 * Template Name: Project Detail
 * Template Post Type: page, post
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
		$tech_stack = get_post_meta( get_the_ID(), 'tech_stack', true );
		$role       = get_post_meta( get_the_ID(), 'project_role', true );
		$timeline   = get_post_meta( get_the_ID(), 'project_timeline', true );
		?>
		<article <?php post_class( 'kinetic-single__article kinetic-glass' ); ?>>
			<header class="kinetic-single__header">
				<span class="kinetic-eyebrow kinetic-eyebrow--primary"><?php esc_html_e( 'Project Case Study', 'kinetic' ); ?></span>
				<h1 class="kinetic-single__title"><?php the_title(); ?></h1>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="kinetic-single__media kinetic-glass">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
			<?php endif; ?>

			<div class="kinetic-page-content entry-content">
				<?php the_content(); ?>
			</div>

			<div class="kinetic-meta-grid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1rem;margin-top:2rem;">
				<?php if ( $tech_stack ) : ?>
					<section class="kinetic-glass" style="padding:1rem;">
						<h3 class="kinetic-eyebrow"><?php esc_html_e( 'Tech Stack', 'kinetic' ); ?></h3>
						<p><?php echo esc_html( $tech_stack ); ?></p>
					</section>
				<?php endif; ?>

				<?php if ( $role ) : ?>
					<section class="kinetic-glass" style="padding:1rem;">
						<h3 class="kinetic-eyebrow"><?php esc_html_e( 'Role', 'kinetic' ); ?></h3>
						<p><?php echo esc_html( $role ); ?></p>
					</section>
				<?php endif; ?>

				<?php if ( $timeline ) : ?>
					<section class="kinetic-glass" style="padding:1rem;">
						<h3 class="kinetic-eyebrow"><?php esc_html_e( 'Timeline', 'kinetic' ); ?></h3>
						<p><?php echo esc_html( $timeline ); ?></p>
					</section>
				<?php endif; ?>
			</div>
		</article>
	<?php endwhile; ?>
</main>

<?php
get_footer();
