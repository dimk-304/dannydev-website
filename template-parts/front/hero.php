<?php
/**
 * Sección Hero (portada)
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;

$kicker    = kinetic_cv_meta( 'hero_kicker', get_theme_mod( 'kinetic_hero_kicker', __( 'Web Developer & AI Automation Specialist', 'kinetic' ) ) );
$prefix    = kinetic_cv_meta( 'hero_title_prefix', get_theme_mod( 'kinetic_hero_title_prefix', __( "Hi, I'm", 'kinetic' ) ) );
$highlight = kinetic_cv_meta( 'hero_title_highlight', get_theme_mod( 'kinetic_hero_title_highlight', 'Danny Dev' ) );
$desc      = kinetic_cv_meta( 'hero_description', get_theme_mod( 'kinetic_hero_description', __( '10+ years in technology: web development, intelligent automation, and AI agents integrated with CRMs, APIs, and business systems. From WordPress and PHP to OpenAI, n8n, Kommo, Odoo, and production-ready deployments.', 'kinetic' ) ) );

$hero_post_id    = kinetic_get_landing_hero_post_id();
$hero_title_html = kinetic_prepare_hero_title_markup( kinetic_get_acf_hero_title_raw( $hero_post_id ) );
if ( '' !== $hero_title_html && preg_match( '#^<p[^>]*>(.+)</p>$#is', $hero_title_html, $m ) ) {
	$hero_title_html = trim( $m[1] );
}
$legal     = kinetic_cv_meta( 'hero_legal_name', __( 'Danny Cen', 'kinetic' ) );
$btn_proj  = kinetic_cv_meta( 'hero_btn_projects', __( 'View projects', 'kinetic' ) );
$btn_cont  = kinetic_cv_meta( 'hero_btn_contact', __( 'Get in touch', 'kinetic' ) );
$scroll    = kinetic_cv_meta( 'hero_scroll_hint', __( 'Scroll to explore', 'kinetic' ) );

$projects_url = home_url( '/#portfolio' );
$contact_url  = home_url( '/#contact' );
?>

<section class="kinetic-hero kinetic-container">
	<div class="kinetic-glass kinetic-hero__panel">
		<div class="kinetic-hero__tech-bg" aria-hidden="true">
			<span class="kinetic-hero__tech-grid"></span>
			<span class="kinetic-hero__tech-scan"></span>
			<span class="kinetic-hero__tech-orbit"></span>
		</div>
		<div class="kinetic-hero__glow kinetic-hero__glow--tl" aria-hidden="true"></div>
		<div class="kinetic-hero__glow kinetic-hero__glow--br" aria-hidden="true"></div>

		<p class="kinetic-eyebrow kinetic-eyebrow--secondary"><?php echo esc_html( $kicker ); ?></p>
		<h1 class="kinetic-hero__title">
			<?php if ( '' !== $hero_title_html ) : ?>
				<?php echo wp_kses_post( $hero_title_html ); ?>
			<?php else : ?>
				<?php echo esc_html( $prefix ); ?>
				<span class="kinetic-text-glow"><?php echo esc_html( $highlight ); ?></span>
			<?php endif; ?>
		</h1>
		<p class="kinetic-hero__legal-name"><?php echo esc_html( $legal ); ?></p>
		<p class="kinetic-hero__lead"><?php echo esc_html( $desc ); ?></p>

		<div class="kinetic-hero__actions">
			<a class="kinetic-btn kinetic-btn--primary kinetic-btn--lg kinetic-ion-glow" href="<?php echo esc_url( $projects_url ); ?>">
				<?php echo esc_html( $btn_proj ); ?>
			</a>
			<a class="kinetic-btn kinetic-btn--glass kinetic-btn--lg" href="<?php echo esc_url( $contact_url ); ?>">
				<?php echo esc_html( $btn_cont ); ?>
			</a>
		</div>
	</div>

	<div class="kinetic-scroll-hint" aria-hidden="true">
		<span class="kinetic-scroll-hint__label"><?php echo esc_html( $scroll ); ?></span>
		<span class="kinetic-scroll-hint__line"></span>
	</div>
</section>
