<?php
/**
 * Carrusel / listado de proyectos
 *
 * Usa entradas en la categoría "portfolio". Si no hay, muestra placeholders del wireframe.
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;

$portfolio_eyebrow = kinetic_cv_meta( 'portfolio_eyebrow', __( '02 — Portfolio', 'kinetic' ) );
$portfolio_title   = kinetic_cv_meta( 'portfolio_title', __( 'Selected Artifacts', 'kinetic' ) );

$portfolio_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => 8,
		'post_status'         => 'publish',
		'category_name'       => 'portfolio',
		'ignore_sticky_posts' => true,
	)
);

$placeholders = array(
	array(
		'img'   => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD2N81BlOevU3U54Hce6NWQB5USJKcSri93O_o8ltR3-LiKTfFRZLbeM-cgdlC8b8leCJKngjzxxwlynSx3zBWYCdRWRGLf-Wy1JvjGuj8MCcwzcTErAWagEua83VFFnWl_xmpS19khzWdXBlIALP2PvIR3-bG3e6VIVlTyScbPvo6jS9ZPVdFdyjACylAjMhVrd3zn0QA5_QdXeoqkLoecnQGpkQu-Xp8b936hjwrVR6IWIYFISdnyBMaTSRIralXigotoY5wcB3og',
		'cat'   => __( 'System Design / Web3', 'kinetic' ),
		'title' => __( 'Cipher Engine Dashboard', 'kinetic' ),
		'url'   => get_template_directory_uri() . '/prototypes/proyect.html',
		'tags'  => array( 'React', 'WebGL' ),
	),
	array(
		'img'   => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBXWjNds_rZclxtzpurrajvfcJsz4AMS1dJQc-BObpSOdJuWyNiJLMuVL-fyaZ_S4BT4z_pljJTG47om9o2-RuHPGUGkSSvzbWUzR_QhygV5nASCaZQoC1WkYCcX2BqRWibYFSoXXJ4F9e1ntWrkdWBeJT-D2xVTrxPrVdl7AHD2zmo-wTDvCqqsARywqYeIG_iVExRItotHeb6fQUJCGoBU0W_lOy4FMlv21Quu-bC_D13VVSxbEsGqXxccVbfYxdWUJEU7gMBwKG0',
		'cat'   => __( 'AI Integration / Python', 'kinetic' ),
		'title' => __( 'Neural Stream Interface', 'kinetic' ),
		'url'   => get_template_directory_uri() . '/prototypes/proyect.html',
		'tags'  => array( 'PyTorch', 'Next.js' ),
	),
	array(
		'img'   => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD4BGeWpY9AMwm7E_XrGkFbJlhCkXDNQzrZKXs8RAe4Pu5g87IG_hdIooISKs4Zuzj8DEuWjGCrLrPDLVIQlyl8aCC7wQ-J7JEW2Qob7V59SnRETKYVCqcH9s3GnjNLIm_CpbEDgzsHA_PKq6RDmxs5MMb5-YbRIxoMGBX6cFp4eVp5rCcR5wIlSvfhSx-sfVtjOy7ORkfAriSB72v97bqTm1ZeoCwIzcBBFwVIPJThdKKol2xmYN-W1L5RU-1HFVxgCOTO7Wk4Eunh',
		'cat'   => __( 'Brand Identity / UI', 'kinetic' ),
		'title' => __( 'Aether Brand System', 'kinetic' ),
		'url'   => get_template_directory_uri() . '/prototypes/proyect.html',
		'tags'  => array( 'Tailwind', 'Framer' ),
	),
);
?>

<section class="kinetic-section kinetic-container" id="portfolio">
	<div class="kinetic-portfolio__head">
		<div>
			<span class="kinetic-eyebrow kinetic-eyebrow--primary"><?php echo esc_html( $portfolio_eyebrow ); ?></span>
			<h2 class="kinetic-section__title"><?php echo esc_html( $portfolio_title ); ?></h2>
		</div>
		<div class="kinetic-portfolio__nav" data-kinetic-carousel-nav>
			<button type="button" class="kinetic-icon-btn" data-kinetic-carousel-prev aria-label="<?php esc_attr_e( 'Previous', 'kinetic' ); ?>">
				<span class="material-symbols-outlined" aria-hidden="true">chevron_left</span>
			</button>
			<button type="button" class="kinetic-icon-btn" data-kinetic-carousel-next aria-label="<?php esc_attr_e( 'Next', 'kinetic' ); ?>">
				<span class="material-symbols-outlined" aria-hidden="true">chevron_right</span>
			</button>
		</div>
	</div>

	<div class="kinetic-portfolio__track" data-kinetic-carousel>
		<?php if ( $portfolio_query->have_posts() ) : ?>
			<?php
			while ( $portfolio_query->have_posts() ) :
				$portfolio_query->the_post();
				$cats = get_the_category();
				$cat  = ! empty( $cats ) ? $cats[0]->name : '';
				?>
				<article <?php post_class( 'kinetic-project' ); ?>>
					<a class="kinetic-project__link" href="<?php the_permalink(); ?>">
						<div class="kinetic-project__media kinetic-glass">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'large', array( 'class' => 'kinetic-project__img' ) ); ?>
							<?php else : ?>
								<div class="kinetic-project__placeholder" aria-hidden="true"></div>
							<?php endif; ?>
							<span class="kinetic-project__shade" aria-hidden="true"></span>
							<span class="kinetic-project__shine" aria-hidden="true"></span>
						</div>
						<?php if ( $cat ) : ?>
							<span class="kinetic-project__cat"><?php echo esc_html( $cat ); ?></span>
						<?php endif; ?>
						<h3 class="kinetic-project__title"><?php the_title(); ?></h3>
					</a>
					<div class="kinetic-project__tags">
						<?php
						$tags = get_the_tags();
						if ( $tags ) {
							$tags = array_slice( $tags, 0, 4 );
							foreach ( $tags as $tag ) {
								echo '<span class="kinetic-tag">' . esc_html( $tag->name ) . '</span>';
							}
						}
						?>
					</div>
				</article>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		<?php else : ?>
			<?php foreach ( $placeholders as $item ) : ?>
				<article class="kinetic-project">
					<a class="kinetic-project__link" href="<?php echo esc_url( $item['url'] ); ?>">
						<div class="kinetic-project__media kinetic-glass">
							<img class="kinetic-project__img" src="<?php echo esc_url( $item['img'] ); ?>" alt="" loading="lazy" width="450" height="253">
							<span class="kinetic-project__shade" aria-hidden="true"></span>
							<span class="kinetic-project__shine" aria-hidden="true"></span>
						</div>
						<span class="kinetic-project__cat"><?php echo esc_html( $item['cat'] ); ?></span>
						<h3 class="kinetic-project__title"><?php echo esc_html( $item['title'] ); ?></h3>
					</a>
					<div class="kinetic-project__tags">
						<?php foreach ( $item['tags'] as $t ) : ?>
							<span class="kinetic-tag"><?php echo esc_html( $t ); ?></span>
						<?php endforeach; ?>
					</div>
				</article>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
	<?php if ( ! $portfolio_query->post_count ) : ?>
		<p class="kinetic-portfolio__hint">
			<?php esc_html_e( 'Create the «portfolio» category and assign posts to replace this demo.', 'kinetic' ); ?>
		</p>
	<?php endif; ?>
</section>
