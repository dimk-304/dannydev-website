<?php
/**
 * Template Name: Project Detail
 * Template Post Type: page, post
 *
 * Maquetación basada en prototypes/portfolio.html (Tailwind + tokens).
 * Contenido desde ACF (grupo «Portfolio — detalle (Kinetic)») con fallback al copy demo.
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	$default_avatar = 'https://lh3.googleusercontent.com/aida-public/AB6AXuCtVDEhOpS0YdI9rdN50-IQJIV4EXn8fdqi4N9xGfANNQ-FY_4xDJeKHFHCaaHde6ESBorQbAIIEzOyNnavNB7UYxoSKfZt4TfxXmjVcUdqJLF1aCgRh7D9DoFU6RRanjG5w5q6G461WPQDuDdao20Cc2b0oZgRo_YiUgPnoHkOKJGwGjBovk6vh1X0pZ-F1PGxoWEyb10BMwp52WXuT22C2aw7KmA2CVQYSNiYV2MvmVQq0mCzi7LbxVGLOYg3ecGwjHlcHi6Z-QZo';
	$default_figure = 'https://lh3.googleusercontent.com/aida-public/AB6AXuBNknHyZvfpsIMakUT1SQcmum-iFPnonOFjZbMZplpJfwsPDqPwx_RYY2FjJuk0ZmCT5cuM1MND7-zRa0cDAqcSMCt5g6yzTq2ypK5PRpm8aJQjiDsTdbxVV7x15yHSgcQLh4AW2NvEOPE2ubCHvKKTGiqZOLuN-GFkaZ4QyDMildSMrY3p6BuSJihv886yUIxvRCE-Vp1TQvCW9GrmH5owKoLqcuSQdRyHyMKTU5cAaWVH3T-MQjg9NLjFiWs7KgKUOyQVy5k55GMp';

	$tag_project   = kinetic_pf_field( 'tag-project', get_the_title() );
	$reading_time  = kinetic_pf_field( 'reading-time', '12 MIN READ' );
	$title_main   = kinetic_pf_field( 'title-project', 'Entanglement & The ' );
	$title_accent = kinetic_pf_field( 'title-project-accent', 'Future of Neural Architecture', false );
	$editor_avatar = kinetic_pf_img_url( 'editor-avatar', $default_avatar );
	$editor_name   = kinetic_pf_field( 'editor-name', 'Dr. Elias Thorne' );
	$position      = kinetic_pf_field( 'position', 'Lead Architect @ Obsidian Lab' );
	$pub_date      = kinetic_pf_field( 'publication_date', 'Published Oct 24, 2024' );

	$summary_title = kinetic_pf_field( 'summary-title', 'AI-TL;DR Summary' );
	$summary_icon  = kinetic_pf_field( 'summary-icon', 'smart_toy' );
	$summary_icon  = preg_replace( '/[^a-z0-9_]/i', '', $summary_icon );
	if ( '' === $summary_icon ) {
		$summary_icon = 'smart_toy';
	}
	$summary_body = kinetic_pf_field(
		'summary-body',
		'This article explores the synthesis of quantum entanglement principles within classical neural network weights. By treating attention mechanisms as probabilistic wave functions, we demonstrate a 40% reduction in training latency for large language models while increasing context sensitivity by orders of magnitude.'
	);
	$sum_tag1     = kinetic_pf_field( 'summary-tag-1', 'TRANSFORMER-Q' );
	$sum_tag2     = kinetic_pf_field( 'summary-tag-2', 'PROBABILISTIC WEIGHTS' );

	$lead = kinetic_pf_field(
		'lead-paragraph',
		'The intersection of quantum mechanics and artificial intelligence has long been relegated to theoretical whitepapers. However, the Obsidian Lab\'s recent experiments suggest that the biological brain\'s uncanny ability to map non-linear relationships might be fundamentally rooted in what Einstein famously called "spooky action at a distance."'
	);

	$article_h2 = kinetic_pf_field( 'article-h2', 'Defining Neural Superposition' );
	$article_p1 = kinetic_pf_wysiwyg(
		'article-p1',
		'Standard deep learning models rely on static tensors to represent knowledge. While effective, this architecture is inherently rigid. In our new <span class="text-primary font-mono bg-primary/5 px-1">Kinetic-Q</span> framework, weights exist in a state of superposition—defined by a probability cloud rather than a single floating-point value.'
	);
	$figure_src     = kinetic_pf_img_url( 'article-figure', $default_figure );
	$figure_caption = kinetic_pf_field(
		'article-figure-caption',
		'Fig 1.1: Visualizing 8-dimensional weight entanglement within a transformer block.'
	);
	$article_p2 = kinetic_pf_field(
		'article-p2',
		'When the model encounters an ambiguous prompt, the superposition "collapses" into the most contextually relevant configuration. This is not merely a metaphor; the mathematics involved mirrors the Schrödinger equation, adapted for information entropy.'
	);

	$code_default = <<<'CODE'
import obsidian_lab as lab

# Initialize the Quantum Entangler
engine = lab.KineticEngine(dims=512, mode='quantum')

@engine.entangle
def process_superposition(input_data):
    weights = engine.get_probability_cloud()
    return lab.collapse(input_data, weights)

# Observe the reduction in entropy
metrics = engine.measure()
print(f"Entanglement Score: {metrics.coherence}")
CODE;
	$article_code = kinetic_pf_field( 'article-code', $code_default );

	$article_h3 = kinetic_pf_field( 'article-h3', 'The Ethical Horizon' );
	$article_p3 = kinetic_pf_field(
		'article-p3',
		'As we approach models that mimic quantum logic, the transparency of decision-making becomes obscured. If a model arrives at a conclusion through multi-dimensional entanglement, can we truly map the path back to its source? This is the primary hurdle for Obsidian in 2025.'
	);

	$nl_title       = kinetic_pf_field( 'newsletter-title', 'Stay Synchronized' );
	$nl_text        = kinetic_pf_field(
		'newsletter-text',
		'Get the latest breakthroughs from the Obsidian Lab delivered to your inbox every Thursday. No noise, just neural architecture.'
	);
	$nl_placeholder = kinetic_pf_field( 'newsletter-placeholder', 'COMMUNICATIONS@MAIL.COM' );
	$nl_button      = kinetic_pf_field( 'newsletter-button', 'Initialize' );
	$nl_foot        = kinetic_pf_field( 'newsletter-footnote', 'Protected by Obsidian Encryption. Unsubscribe anytime.' );
	$live_pill      = kinetic_pf_field( 'live-pill-text', 'LAB CONNECTED' );
	?>

<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries,typography"></script>
<script id="kinetic-tailwind-project-detail">
		tailwind.config = {
			darkMode: 'class',
			theme: {
				extend: {
					colors: {
						'on-error': '#490006',
						'primary-fixed-dim': '#00deec',
						'on-surface': '#f9f5f8',
						'on-secondary-fixed': '#41009a',
						'on-secondary-container': '#f8f1ff',
						'inverse-surface': '#fcf8fb',
						surface: '#0e0e10',
						'on-primary': '#005d63',
						'surface-container-lowest': '#000000',
						'inverse-primary': '#006a71',
						tertiary: '#ff59e3',
						'tertiary-container': '#ff05e5',
						'tertiary-dim': '#ff59e3',
						'surface-container-highest': '#262528',
						'on-tertiary-fixed': '#33002d',
						'primary-container': '#00eefc',
						'surface-bright': '#2c2c2f',
						'primary-fixed': '#00eefc',
						'on-primary-fixed': '#003f43',
						'error-dim': '#d7383b',
						error: '#ff716c',
						'surface-container-low': '#131315',
						'primary-dim': '#00deec',
						'on-tertiary-fixed-variant': '#6d0061',
						'surface-dim': '#0e0e10',
						'secondary-fixed-dim': '#ceb9ff',
						'on-tertiary': '#42003a',
						'inverse-on-surface': '#565457',
						'secondary-dim': '#874cff',
						secondary: '#ac89ff',
						'outline-variant': '#48474a',
						'surface-container-high': '#1f1f22',
						'on-primary-fixed-variant': '#005e64',
						'surface-tint': '#8ff5ff',
						'secondary-container': '#7000ff',
						'secondary-fixed': '#dac9ff',
						outline: '#767577',
						'tertiary-fixed': '#ff85e4',
						'on-primary-container': '#005359',
						'error-container': '#9f0519',
						'on-surface-variant': '#adaaad',
						'on-secondary-fixed-variant': '#6300e2',
						'on-background': '#f9f5f8',
						background: '#0e0e10',
						'surface-variant': '#262528',
						'on-secondary': '#290067',
						'tertiary-fixed-dim': '#ff68e3',
						primary: '#8ff5ff',
						'surface-container': '#19191c',
						'on-error-container': '#ffa8a3',
						'on-tertiary-container': '#1b0017',
					},
					borderRadius: {
						DEFAULT: '0.125rem',
						lg: '0.25rem',
						xl: '0.5rem',
						full: '0.75rem',
					},
					fontFamily: {
						headline: [ 'Space Grotesk', 'sans-serif' ],
						body: [ 'Manrope', 'sans-serif' ],
						label: [ 'Manrope', 'sans-serif' ],
					},
				},
			},
		};
</script>
<style>
	.kinetic-project-detail-layout .material-symbols-outlined {
		font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
	}
	.kinetic-project-detail-layout .glass-panel {
		background: rgba(38, 37, 40, 0.4);
		backdrop-filter: blur(20px);
		-webkit-backdrop-filter: blur(20px);
	}
	.kinetic-project-detail-layout .mesh-gradient {
		background:
			radial-gradient(at 0% 0%, rgba(143, 245, 255, 0.15) 0px, transparent 50%),
			radial-gradient(at 100% 0%, rgba(172, 137, 255, 0.15) 0px, transparent 50%),
			radial-gradient(at 100% 100%, rgba(255, 89, 227, 0.15) 0px, transparent 50%),
			radial-gradient(at 0% 100%, rgba(0, 238, 252, 0.1) 0px, transparent 50%);
	}
	.kinetic-project-detail-layout .scroll-progress {
		width: 65%;
	}
</style>

<main class="kinetic-project-detail-layout bg-surface text-on-surface font-body selection:bg-primary/30 selection:text-primary pt-24 md:pt-32 pb-24 mesh-gradient">
	<header class="max-w-5xl mx-auto px-6 text-center mb-16">
		<div class="flex items-center justify-center gap-3 mb-6 flex-wrap">
			<span class="text-secondary font-headline tracking-[0.2em] text-xs font-bold uppercase py-1 px-3 rounded-full border border-secondary/20 bg-secondary/5"><?php echo esc_html( $tag_project ); ?></span>
			<span class="w-1 h-1 rounded-full bg-outline-variant" aria-hidden="true"></span>
			<span class="text-on-surface-variant font-label text-xs tracking-widest uppercase"><?php echo esc_html( $reading_time ); ?></span>
		</div>
		<h1 class="text-5xl md:text-7xl font-headline font-bold tracking-tight leading-[1.1] mb-10 text-on-surface">
			<?php echo esc_html( $title_main ); ?>
			<?php if ( '' !== trim( $title_accent ) ) : ?>
			<span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary"><?php echo esc_html( $title_accent ); ?></span>
			<?php endif; ?>
		</h1>
		<div class="flex flex-col md:flex-row items-center justify-center gap-6 py-8 border-y border-white/5">
			<div class="flex items-center gap-3">
				<img alt="" class="w-10 h-10 rounded-full border border-primary/30" width="40" height="40" loading="lazy" src="<?php echo esc_url( $editor_avatar ); ?>"/>
				<div class="text-left">
					<p class="text-sm font-bold text-on-surface uppercase tracking-wide"><?php echo esc_html( $editor_name ); ?></p>
					<p class="text-xs text-on-surface-variant uppercase"><?php echo esc_html( $position ); ?></p>
				</div>
			</div>
			<div class="h-8 w-px bg-white/10 hidden md:block" aria-hidden="true"></div>
			<div class="text-xs text-on-surface-variant font-label uppercase tracking-tighter">
				<?php echo esc_html( $pub_date ); ?>
			</div>
		</div>
	</header>

	<section class="max-w-3xl mx-auto px-6">
		<div class="glass-panel border border-primary/20 rounded-xl p-8 mb-16 relative overflow-hidden group">
			<div class="absolute -right-12 -top-12 w-32 h-32 bg-primary/10 blur-3xl group-hover:bg-primary/20 transition-all duration-500" aria-hidden="true"></div>
			<div class="flex items-start gap-4 mb-4">
				<span class="material-symbols-outlined text-primary text-2xl" aria-hidden="true"><?php echo esc_html( $summary_icon ); ?></span>
				<h2 class="font-headline font-bold text-primary tracking-widest uppercase text-sm mt-1"><?php echo esc_html( $summary_title ); ?></h2>
			</div>
			<div class="text-on-surface-variant leading-relaxed text-sm italic">
				<?php echo wp_kses_post( wpautop( esc_html( $summary_body ) ) ); ?>
			</div>
			<?php if ( '' !== trim( $sum_tag1 ) || '' !== trim( $sum_tag2 ) ) : ?>
			<div class="mt-4 flex gap-2 flex-wrap">
				<?php if ( '' !== trim( $sum_tag1 ) ) : ?>
				<span class="text-[10px] px-2 py-0.5 rounded-sm bg-primary/10 border border-primary/20 text-primary"><?php echo esc_html( $sum_tag1 ); ?></span>
				<?php endif; ?>
				<?php if ( '' !== trim( $sum_tag2 ) ) : ?>
				<span class="text-[10px] px-2 py-0.5 rounded-sm bg-secondary/10 border border-secondary/20 text-secondary"><?php echo esc_html( $sum_tag2 ); ?></span>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		</div>

		<article class="prose prose-invert max-w-none space-y-10">
			<p class="not-prose text-lg leading-[1.8] text-on-surface/90 font-light first-letter:text-5xl first-letter:font-bold first-letter:text-primary first-letter:mr-3 first-letter:float-left">
				<?php echo wp_kses_post( nl2br( esc_html( $lead ), false ) ); ?>
			</p>
			<h2 class="text-3xl font-headline font-bold text-on-surface mt-16 mb-6"><?php echo esc_html( $article_h2 ); ?></h2>
			<div class="text-on-surface/80 leading-relaxed not-prose">
				<?php echo wp_kses_post( $article_p1 ); ?>
			</div>
			<figure class="my-16 rounded-xl overflow-hidden border border-white/5 relative group not-prose">
				<div class="absolute inset-0 bg-gradient-to-t from-background via-transparent to-transparent opacity-60 pointer-events-none" aria-hidden="true"></div>
				<img class="w-full h-[450px] object-cover group-hover:scale-105 transition-transform duration-700" alt="" loading="lazy" width="1200" height="450" src="<?php echo esc_url( $figure_src ); ?>"/>
				<figcaption class="absolute bottom-6 left-6 right-6 text-xs text-on-surface-variant font-label italic uppercase tracking-wider">
					<?php echo esc_html( $figure_caption ); ?>
				</figcaption>
			</figure>
			<div class="text-on-surface/80 leading-relaxed">
				<?php echo wp_kses_post( wpautop( esc_html( $article_p2 ) ) ); ?>
			</div>
			<div class="relative group my-12 not-prose">
				<div class="absolute -inset-0.5 bg-gradient-to-r from-primary/50 to-secondary/50 rounded-xl blur opacity-20 group-hover:opacity-40 transition duration-1000" aria-hidden="true"></div>
				<div class="relative glass-panel rounded-xl overflow-hidden border border-white/10">
					<div class="flex items-center justify-between px-6 py-3 bg-white/5 border-b border-white/5">
						<div class="flex gap-1.5" aria-hidden="true">
							<div class="w-2.5 h-2.5 rounded-full bg-error/40"></div>
							<div class="w-2.5 h-2.5 rounded-full bg-primary/40"></div>
							<div class="w-2.5 h-2.5 rounded-full bg-secondary/40"></div>
						</div>
						<button type="button" class="flex items-center gap-2 text-[10px] uppercase font-bold text-on-surface-variant hover:text-primary transition-colors">
							<span class="material-symbols-outlined text-xs">content_copy</span>
							Copy Code
						</button>
					</div>
					<pre class="p-8 text-sm font-mono overflow-x-auto leading-relaxed text-left text-primary-fixed-dim whitespace-pre-wrap"><?php echo esc_html( $article_code ); ?></pre>
				</div>
			</div>
			<h3 class="text-2xl font-headline font-bold text-on-surface mt-16 mb-4"><?php echo esc_html( $article_h3 ); ?></h3>
			<div class="text-on-surface/80 leading-relaxed">
				<?php echo wp_kses_post( wpautop( esc_html( $article_p3 ) ) ); ?>
			</div>
		</article>

		<?php if ( get_the_content() ) : ?>
			<div class="kinetic-project-detail-wp-content prose prose-invert max-w-none mt-16 border-t border-white/10 pt-12">
				<h2 class="text-sm font-headline font-bold text-primary tracking-widest uppercase mb-6"><?php esc_html_e( 'Contenido del editor', 'kinetic' ); ?></h2>
				<div class="entry-content text-on-surface/90 leading-relaxed space-y-4">
					<?php the_content(); ?>
				</div>
			</div>
		<?php endif; ?>

		<section class="mt-32 relative not-prose" aria-labelledby="kinetic-project-detail-newsletter-heading">
			<h2 id="kinetic-project-detail-newsletter-heading" class="screen-reader-text"><?php esc_html_e( 'Newsletter', 'kinetic' ); ?></h2>
			<div class="absolute inset-0 bg-gradient-to-r from-primary/5 to-tertiary/5 rounded-2xl blur-xl" aria-hidden="true"></div>
			<div class="relative glass-panel border border-white/10 rounded-2xl p-12 text-center overflow-hidden">
				<div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-primary/50 to-transparent" aria-hidden="true"></div>
				<h3 class="text-3xl font-headline font-bold mb-4"><?php echo esc_html( $nl_title ); ?></h3>
				<div class="text-on-surface-variant text-sm mb-8 max-w-md mx-auto">
					<?php echo wp_kses_post( wpautop( esc_html( $nl_text ) ) ); ?>
				</div>
				<div class="flex flex-col md:flex-row gap-3 max-w-md mx-auto">
					<div class="relative flex-grow">
						<label class="screen-reader-text" for="kinetic-project-detail-email"><?php esc_html_e( 'Correo', 'kinetic' ); ?></label>
						<input id="kinetic-project-detail-email" class="w-full bg-surface-container-lowest border border-white/10 rounded-lg px-6 py-3 text-xs font-label focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/30 transition-all uppercase tracking-widest text-on-surface" placeholder="<?php echo esc_attr( $nl_placeholder ); ?>" type="email" autocomplete="email"/>
					</div>
					<button type="button" class="bg-primary text-on-primary px-8 py-3 rounded-lg font-headline font-bold text-xs uppercase tracking-widest hover:shadow-[0_0_20px_rgba(143,245,255,0.4)] transition-all">
						<?php echo esc_html( $nl_button ); ?>
					</button>
				</div>
				<p class="mt-6 text-[10px] text-on-surface-variant/50 uppercase tracking-tighter">
					<?php echo esc_html( $nl_foot ); ?>
				</p>
			</div>
		</section>
	</section>
</main>

<div class="fixed bottom-8 right-8 flex items-center gap-3 glass-panel border border-white/10 px-4 py-2 rounded-full z-40 kinetic-project-detail-layout" aria-hidden="true">
	<div class="relative w-2 h-2">
		<div class="absolute inset-0 bg-primary rounded-full animate-ping opacity-75"></div>
		<div class="relative w-2 h-2 bg-primary rounded-full"></div>
	</div>
	<span class="text-[10px] font-headline font-bold text-on-surface uppercase tracking-widest"><?php echo esc_html( $live_pill ); ?></span>
</div>

	<?php
endwhile;

get_footer();
