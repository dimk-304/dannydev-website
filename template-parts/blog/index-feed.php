<?php
/**
 * Índice visual del blog (masonry neo-futurista)
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;

global $wp_query;
$posts = array_values( (array) $wp_query->posts );

if ( empty( $posts ) ) {
	get_template_part( 'template-parts/content', 'none' );
	return;
}

$featured      = $posts[0];
$card_b        = $posts[1] ?? null;
$card_c        = $posts[2] ?? null;
$card_d        = $posts[3] ?? null;
$card_e        = $posts[4] ?? null;
$newsletter_to = home_url( '/#contact' );
$featured_cats = get_the_category( (int) $featured->ID );
$featured_cat  = ! empty( $featured_cats ) ? $featured_cats[0]->name : __( 'Archive', 'kinetic' );
?>

<section class="kinetic-blog-index kinetic-container">
	<header class="kinetic-blog-hero">
		<div class="kinetic-blog-hero__kicker-row">
			<span class="kinetic-blog-hero__kicker"><?php esc_html_e( 'Intelligence Log', 'kinetic' ); ?></span>
			<span class="kinetic-blog-hero__line" aria-hidden="true"></span>
		</div>
		<h1 class="kinetic-blog-hero__title">
			<?php esc_html_e( 'The AI Lab', 'kinetic' ); ?>
			<span><?php esc_html_e( 'Feed.', 'kinetic' ); ?></span>
		</h1>
		<p class="kinetic-blog-hero__lead">
			<?php esc_html_e( "Exploring the intersection of neural networks, kinetic motion, and the deep obsidian aesthetics of tomorrow's digital workspace.", 'kinetic' ); ?>
		</p>
	</header>

	<div class="kinetic-blog-grid">
		<article class="kinetic-blog-card kinetic-blog-card--featured kinetic-glass">
			<a href="<?php echo esc_url( get_permalink( $featured ) ); ?>">
				<div class="kinetic-blog-card__media kinetic-blog-card__media--featured">
					<?php echo get_the_post_thumbnail( $featured, 'large', array( 'class' => 'kinetic-blog-card__img' ) ); ?>
				</div>
				<div class="kinetic-blog-card__body">
					<div class="kinetic-blog-card__meta">
						<span class="kinetic-blog-chip"><?php echo esc_html( $featured_cat ); ?></span>
						<span class="kinetic-read"><span class="material-symbols-outlined">schedule</span><?php echo esc_html( kinetic_reading_time_for_post( (int) $featured->ID ) ); ?></span>
					</div>
					<h2 class="kinetic-blog-card__title"><?php echo esc_html( get_the_title( $featured ) ); ?></h2>
					<details class="kinetic-blog-tldr">
						<summary>
							<span><?php esc_html_e( 'AI-TL;DR', 'kinetic' ); ?></span>
							<span class="material-symbols-outlined">expand_more</span>
						</summary>
						<p><?php echo esc_html( wp_trim_words( get_the_excerpt( $featured ), 34 ) ); ?></p>
					</details>
				</div>
			</a>
		</article>

		<?php foreach ( array( $card_b, $card_c, $card_d, $card_e ) as $idx => $post_obj ) : ?>
			<?php if ( ! $post_obj ) { continue; } ?>
			<article class="kinetic-blog-card kinetic-blog-card--slot-<?php echo esc_attr( $idx + 1 ); ?> kinetic-glass">
				<a href="<?php echo esc_url( get_permalink( $post_obj ) ); ?>">
					<div class="kinetic-blog-card__media">
						<?php echo get_the_post_thumbnail( $post_obj, 'medium_large', array( 'class' => 'kinetic-blog-card__img' ) ); ?>
					</div>
					<div class="kinetic-blog-card__body">
						<div class="kinetic-blog-card__meta">
							<span><?php echo esc_html( get_the_date( 'd.m.Y', $post_obj ) ); ?></span>
							<span>
								<?php
								$post_cats = get_the_category( (int) $post_obj->ID );
								echo esc_html( ! empty( $post_cats ) ? $post_cats[0]->name : __( 'Notes', 'kinetic' ) );
								?>
							</span>
						</div>
						<h3 class="kinetic-blog-card__title"><?php echo esc_html( get_the_title( $post_obj ) ); ?></h3>
						<p class="kinetic-blog-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt( $post_obj ), 18 ) ); ?></p>
					</div>
				</a>
			</article>
		<?php endforeach; ?>
	</div>

	<section class="kinetic-blog-newsletter kinetic-glass">
		<div class="kinetic-blog-newsletter__main">
			<h3><?php esc_html_e( 'Join the Obsidian Collective.', 'kinetic' ); ?></h3>
			<p><?php esc_html_e( 'Get raw logs, technical breakdowns, and design theory delivered to your terminal weekly.', 'kinetic' ); ?></p>
		</div>
		<div class="kinetic-blog-newsletter__stat">
			<span class="material-symbols-outlined">rocket_launch</span>
			<strong>12.4k</strong>
			<small><?php esc_html_e( 'Active Nodes', 'kinetic' ); ?></small>
		</div>
		<form class="kinetic-blog-newsletter__form" method="get" action="<?php echo esc_url( $newsletter_to ); ?>">
			<label for="kinetic-newsletter-email"><?php esc_html_e( 'Access Token (Email)', 'kinetic' ); ?></label>
			<input id="kinetic-newsletter-email" type="email" name="newsletter_email" placeholder="user@kinetic.io">
			<button type="submit"><?php esc_html_e( 'Initialize Sync', 'kinetic' ); ?></button>
		</form>
	</section>

	<div class="kinetic-blog-pagination">
		<?php the_posts_pagination( array( 'mid_size' => 2 ) ); ?>
	</div>
</section>
