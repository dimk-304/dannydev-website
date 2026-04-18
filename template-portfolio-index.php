<?php
/**
 * Template Name: Portfolio Index Futuristic
 * Template Post Type: page
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;

$paged           = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
$portfolio_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 9,
		'paged'               => $paged,
		'category_name'       => 'portfolio',
		'ignore_sticky_posts' => true,
	)
);

get_header();
?>

<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<style>
	.portfolio-index-template .mesh-gradient {
		background: radial-gradient(at 10% 20%, rgba(143, 245, 255, 0.15) 0px, transparent 50%),
			radial-gradient(at 90% 80%, rgba(172, 137, 255, 0.15) 0px, transparent 50%),
			radial-gradient(at 50% 50%, rgba(255, 89, 227, 0.1) 0px, transparent 50%);
	}
	.portfolio-index-template .glass-card {
		background: rgba(38, 37, 40, 0.4);
		backdrop-filter: blur(20px);
		border: 1px solid rgba(255, 255, 255, 0.1);
	}
	.portfolio-index-template .data-pulse {
		position: relative;
	}
	.portfolio-index-template .data-pulse::after {
		content: "";
		position: absolute;
		inset: -4px;
		border-radius: 9999px;
		border: 1px solid #8ff5ff;
		opacity: 0.2;
		animation: pulse-ring 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
	}
	@keyframes pulse-ring {
		0% {
			transform: scale(0.8);
			opacity: 0.5;
		}
		100% {
			transform: scale(2);
			opacity: 0;
		}
	}
</style>

<main class="portfolio-index-template relative pt-32 pb-20 px-6 md:px-12 max-w-7xl mx-auto mesh-gradient">
	<header class="mb-16 max-w-3xl">
		<div class="flex items-center gap-3 mb-4">
			<span class="w-2 h-2 rounded-full bg-primary data-pulse"></span>
			<span class="text-secondary font-headline tracking-[0.2em] text-xs uppercase font-bold">
				<?php esc_html_e( 'Project Archive', 'kinetic' ); ?>
			</span>
		</div>
		<h1 class="text-5xl md:text-7xl font-headline font-bold text-on-background tracking-tight mb-6">
			<?php the_title(); ?>
		</h1>
		<div class="text-on-surface-variant text-lg leading-relaxed max-w-xl">
			<?php
			while ( have_posts() ) :
				the_post();
				the_content();
			endwhile;
			rewind_posts();
			?>
		</div>
	</header>

	<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
		<?php if ( $portfolio_query->have_posts() ) : ?>
			<?php
			while ( $portfolio_query->have_posts() ) :
				$portfolio_query->the_post();
				$project_tags = get_the_tags();
				$role         = get_post_meta( get_the_ID(), 'project_role', true );
				?>
				<article <?php post_class( 'group relative flex flex-col rounded-xl overflow-hidden glass-card transition-all duration-500 hover:-translate-y-2' ); ?>>
					<a class="absolute inset-0 z-10" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>"></a>
					<div class="relative h-64 overflow-hidden">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 scale-105 group-hover:scale-100' ) ); ?>
						<?php else : ?>
							<div class="w-full h-full bg-surface-container-high"></div>
						<?php endif; ?>
						<div class="absolute inset-0 bg-gradient-to-t from-background via-transparent to-transparent opacity-60"></div>
						<div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
							<span class="bg-primary text-on-primary px-6 py-2.5 rounded-lg font-bold text-sm uppercase tracking-widest flex items-center gap-2">
								<?php esc_html_e( 'View Details', 'kinetic' ); ?>
								<span class="material-symbols-outlined text-sm">arrow_forward</span>
							</span>
						</div>
					</div>
					<div class="p-6">
						<div class="flex justify-between items-start mb-4">
							<div>
								<h2 class="text-xl font-headline font-bold text-on-background mb-1"><?php the_title(); ?></h2>
								<?php if ( $role ) : ?>
									<p class="text-xs text-secondary font-headline uppercase tracking-widest"><?php echo esc_html( $role ); ?></p>
								<?php endif; ?>
							</div>
							<span class="material-symbols-outlined text-primary text-xl" aria-hidden="true">blur_on</span>
						</div>
						<p class="text-on-surface-variant text-sm mb-6">
							<?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?>
						</p>
						<?php if ( $project_tags ) : ?>
							<div class="flex flex-wrap gap-2">
								<?php
								foreach ( array_slice( $project_tags, 0, 3 ) as $tag ) :
									?>
									<span class="px-2 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-primary/10 text-primary border border-primary/20">
										<?php echo esc_html( $tag->name ); ?>
									</span>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
				</article>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		<?php else : ?>
			<div class="lg:col-span-3 glass-card rounded-xl p-10 text-center">
				<p class="text-on-surface-variant"><?php esc_html_e( 'No portfolio projects yet. Add posts in category "portfolio".', 'kinetic' ); ?></p>
			</div>
		<?php endif; ?>
	</div>

	<?php if ( $portfolio_query->max_num_pages > 1 ) : ?>
		<div class="mt-16 flex justify-center">
			<?php
			echo wp_kses_post(
				paginate_links(
					array(
						'total'   => $portfolio_query->max_num_pages,
						'current' => $paged,
						'type'    => 'list',
					)
				)
			);
			?>
		</div>
	<?php endif; ?>
</main>

<?php
get_footer();
