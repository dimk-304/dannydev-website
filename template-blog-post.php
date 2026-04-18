<?php
/**
 * Template Name: Blog Post Futuristic
 * Template Post Type: post
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Manrope:wght@200;300;400;500;600;700;800&display=swap">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap">
<style>
	.blogpost-template .material-symbols-outlined {
		font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24;
	}
	.blogpost-template .glass-panel {
		background: rgba(38, 37, 40, 0.4);
		backdrop-filter: blur(20px);
		-webkit-backdrop-filter: blur(20px);
	}
	.blogpost-template .mesh-gradient {
		background: radial-gradient(at 0% 0%, rgba(143, 245, 255, 0.15) 0px, transparent 50%),
			radial-gradient(at 100% 0%, rgba(172, 137, 255, 0.15) 0px, transparent 50%),
			radial-gradient(at 100% 100%, rgba(255, 89, 227, 0.15) 0px, transparent 50%),
			radial-gradient(at 0% 100%, rgba(0, 238, 252, 0.1) 0px, transparent 50%);
	}
</style>

<main class="blogpost-template mesh-gradient bg-surface text-on-surface font-body selection:bg-primary/30 selection:text-primary">
	<?php
	while ( have_posts() ) :
		the_post();

		$categories     = get_the_category();
		$category_label = ! empty( $categories ) ? $categories[0]->name : __( 'Blog', 'kinetic' );
		$author_name    = get_the_author();
		$author_bio     = get_the_author_meta( 'description' );
		$reading_time   = function_exists( 'kinetic_reading_time' ) ? kinetic_reading_time() : '';
		$tags           = get_the_tags();
		?>

		<header class="max-w-5xl mx-auto px-6 text-center mb-16 pt-24">
			<div class="flex items-center justify-center gap-3 mb-6">
				<span class="text-secondary font-headline tracking-[0.2em] text-xs font-bold uppercase py-1 px-3 rounded-full border border-secondary/20 bg-secondary/5"><?php echo esc_html( $category_label ); ?></span>
				<span class="w-1 h-1 rounded-full bg-outline-variant"></span>
				<?php if ( $reading_time ) : ?>
					<span class="text-on-surface-variant font-label text-xs tracking-widest uppercase"><?php echo esc_html( $reading_time ); ?></span>
				<?php endif; ?>
			</div>

			<h1 class="text-5xl md:text-7xl font-headline font-bold tracking-tight leading-[1.1] mb-10 text-on-surface">
				<?php the_title(); ?>
			</h1>

			<div class="flex flex-col md:flex-row items-center justify-center gap-6 py-8 border-y border-white/5">
				<div class="flex items-center gap-3">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 40, '', esc_attr__( 'Author', 'kinetic' ), array( 'class' => 'w-10 h-10 rounded-full border border-primary/30' ) ); ?>
					<div class="text-left">
						<p class="text-sm font-bold text-on-surface uppercase tracking-wide"><?php echo esc_html( $author_name ); ?></p>
						<p class="text-xs text-on-surface-variant uppercase">
							<?php echo esc_html( $author_bio ? $author_bio : __( 'Author', 'kinetic' ) ); ?>
						</p>
					</div>
				</div>
				<div class="h-8 w-px bg-white/10 hidden md:block"></div>
				<div class="text-xs text-on-surface-variant font-label uppercase tracking-tighter">
					<?php
					printf(
						/* translators: %s: publish date */
						esc_html__( 'Published %s', 'kinetic' ),
						esc_html( get_the_date() )
					);
					?>
				</div>
			</div>
		</header>

		<section class="max-w-3xl mx-auto px-6 pb-20">
			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="my-10 rounded-xl overflow-hidden border border-white/5 relative group">
					<?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-auto object-cover group-hover:scale-105 transition-transform duration-700' ) ); ?>
				</figure>
			<?php endif; ?>

			<article class="prose prose-invert max-w-none space-y-10">
				<div class="text-on-surface/90 leading-relaxed">
					<?php the_content(); ?>
				</div>
			</article>

			<?php if ( $tags ) : ?>
				<div class="glass-panel border border-primary/20 rounded-xl p-6 mt-12">
					<h3 class="font-headline font-bold text-primary tracking-widest uppercase text-sm mb-4"><?php esc_html_e( 'Topics', 'kinetic' ); ?></h3>
					<div class="flex flex-wrap gap-2">
						<?php foreach ( $tags as $tag ) : ?>
							<a class="text-[10px] px-2 py-0.5 rounded-sm bg-primary/10 border border-primary/20 text-primary uppercase tracking-widest" href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>">
								<?php echo esc_html( $tag->name ); ?>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		</section>
	<?php endwhile; ?>
</main>

<?php
get_footer();
