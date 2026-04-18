<?php
/**
 * Resumen de entrada (listados)
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class( 'kinetic-loop-card kinetic-glass' ); ?>>
	<a class="kinetic-loop-card__link" href="<?php the_permalink(); ?>">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="kinetic-loop-card__thumb">
				<?php the_post_thumbnail( 'medium_large' ); ?>
			</div>
		<?php endif; ?>
		<time class="kinetic-loop-card__date" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
			<?php echo esc_html( get_the_date() ); ?>
		</time>
		<h2 class="kinetic-loop-card__title"><?php the_title(); ?></h2>
		<p class="kinetic-loop-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
	</a>
</article>
