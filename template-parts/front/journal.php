<?php
/**
 * Blog destacado (The AI Lab)
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;

$journal_eyebrow       = kinetic_cv_meta( 'journal_eyebrow', __( '03 — Journal', 'kinetic' ) );
$journal_title         = kinetic_cv_meta( 'journal_title', __( 'The AI Lab', 'kinetic' ) );
$journal_archive_label = kinetic_cv_meta( 'journal_archive_label', __( 'View Archive', 'kinetic' ) );
$journal_badge         = kinetic_cv_meta( 'journal_badge', __( 'New Release', 'kinetic' ) );
$lab_title             = kinetic_cv_meta( 'lab_title', __( 'Research Lab Status', 'kinetic' ) );
$lab_status_label      = kinetic_cv_meta( 'lab_status_label', __( 'Live Data Streaming', 'kinetic' ) );
$lab_text              = kinetic_cv_meta( 'lab_text', __( "I'm currently exploring the integration of multi-modal agents in creative workflows. Tracking 14 active experiments.", 'kinetic' ) );
$lab_read_label        = kinetic_cv_meta( 'lab_read_label', __( 'CURRENT READ', 'kinetic' ) );
$lab_read_title        = kinetic_cv_meta( 'lab_read_title', __( 'The Nature of Software Development', 'kinetic' ) );
$lab_playing_label     = kinetic_cv_meta( 'lab_playing_label', __( 'PLAYING', 'kinetic' ) );
$lab_playing_title     = kinetic_cv_meta( 'lab_playing_title', __( 'Carbon Based Lifeforms - Interloper', 'kinetic' ) );

$blog_url = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/' );

$journal_args = array(
	'post_type'           => 'post',
	'posts_per_page'      => 3,
	'post_status'         => 'publish',
	'ignore_sticky_posts' => true,
);

$portfolio_cat = get_category_by_slug( 'portfolio' );
if ( $portfolio_cat ) {
	$journal_args['category__not_in'] = array( (int) $portfolio_cat->term_id );
}

$journal = new WP_Query( $journal_args );
?>

<section class="kinetic-section kinetic-container" id="journal">
	<div class="kinetic-section__head">
		<div>
			<span class="kinetic-eyebrow kinetic-eyebrow--tertiary"><?php echo esc_html( $journal_eyebrow ); ?></span>
			<h2 class="kinetic-section__title"><?php echo esc_html( $journal_title ); ?></h2>
		</div>
		<a class="kinetic-text-link" href="<?php echo esc_url( $blog_url ); ?>">
			<?php echo esc_html( $journal_archive_label ); ?>
			<span class="material-symbols-outlined kinetic-text-link__icon" aria-hidden="true">north_east</span>
		</a>
	</div>

	<div class="kinetic-journal">
		<div class="kinetic-journal__main">
			<?php
			if ( $journal->have_posts() ) :
				$i = 0;
				while ( $journal->have_posts() ) :
					$journal->the_post();
					$i++;
					$is_featured = ( 1 === $i );
					$tags        = get_the_tags();
					?>
					<article <?php post_class( 'kinetic-article kinetic-glass' ); ?>>
						<a class="kinetic-article__link" href="<?php the_permalink(); ?>">
							<?php if ( $is_featured ) : ?>
								<div class="kinetic-article__top">
									<span class="kinetic-badge"><?php echo esc_html( $journal_badge ); ?></span>
									<span class="kinetic-read">
										<span class="material-symbols-outlined kinetic-read__icon" aria-hidden="true">schedule</span>
										<?php echo esc_html( kinetic_reading_time() ); ?>
									</span>
								</div>
							<?php else : ?>
								<div class="kinetic-article__top">
									<span class="kinetic-read">
										<span class="material-symbols-outlined kinetic-read__icon" aria-hidden="true">schedule</span>
										<?php echo esc_html( kinetic_reading_time() ); ?>
									</span>
								</div>
							<?php endif; ?>

							<?php
							$title_tag = $is_featured ? 'h3' : 'h3';
							echo '<' . esc_attr( $title_tag ) . ' class="kinetic-article__title' . ( $is_featured ? ' kinetic-article__title--xl' : '' ) . '">';
							the_title();
							echo '</' . esc_attr( $title_tag ) . '>';
							?>

							<?php if ( $is_featured ) : ?>
								<p class="kinetic-article__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
								<div class="kinetic-article__foot">
									<div class="kinetic-article__tags">
										<?php
										if ( $tags ) {
											foreach ( array_slice( $tags, 0, 2 ) as $tag ) {
												echo '<span class="kinetic-hash">#' . esc_html( $tag->name ) . '</span>';
											}
										}
										?>
									</div>
									<div class="kinetic-article__cta">
										<span class="kinetic-article__cta-label"><?php esc_html_e( 'AI-Tl;dr', 'kinetic' ); ?></span>
										<span class="kinetic-article__cta-icon" aria-hidden="true">
											<span class="material-symbols-outlined">add</span>
										</span>
									</div>
								</div>
							<?php else : ?>
								<div class="kinetic-article__foot kinetic-article__foot--simple">
									<div class="kinetic-article__tags">
										<?php
										if ( $tags ) {
											foreach ( array_slice( $tags, 0, 2 ) as $tag ) {
												echo '<span class="kinetic-hash">#' . esc_html( $tag->name ) . '</span>';
											}
										}
										?>
									</div>
								</div>
							<?php endif; ?>
						</a>
					</article>
					<?php
				endwhile;
				wp_reset_postdata();
			else :
				?>
				<p class="kinetic-empty"><?php esc_html_e( 'No posts yet. Publish to fill the lab.', 'kinetic' ); ?></p>
			<?php endif; ?>
		</div>

		<aside class="kinetic-journal__aside kinetic-glass kinetic-lab">
			<span class="kinetic-lab__icon material-symbols-outlined" aria-hidden="true" style="font-variation-settings: 'FILL' 1;">psychology</span>
			<h4 class="kinetic-lab__title"><?php echo esc_html( $lab_title ); ?></h4>
			<div class="kinetic-lab__status">
				<span class="kinetic-pulse kinetic-pulse--lg" aria-hidden="true"></span>
				<span class="kinetic-label kinetic-label--primary"><?php echo esc_html( $lab_status_label ); ?></span>
			</div>
			<p class="kinetic-lab__text">
				<?php echo esc_html( $lab_text ); ?>
			</p>
			<div class="kinetic-lab__cards">
				<div class="kinetic-lab-card">
					<span class="kinetic-micro"><?php echo esc_html( $lab_read_label ); ?></span>
					<span class="kinetic-lab-card__title"><?php echo esc_html( $lab_read_title ); ?></span>
				</div>
				<div class="kinetic-lab-card">
					<span class="kinetic-micro"><?php echo esc_html( $lab_playing_label ); ?></span>
					<span class="kinetic-lab-card__title"><?php echo esc_html( $lab_playing_title ); ?></span>
				</div>
			</div>
		</aside>
	</div>
</section>
