<?php
/**
 * Sección CV / experiencia (bento)
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;

$mission = kinetic_cv_meta( 'mission_text', get_theme_mod( 'kinetic_mission_text', __( '"I turn complex operations into reliable systems: AI agents, chatbots, and automations that recover real hours every week—without sacrificing clarity or control."', 'kinetic' ) ) );
$base    = kinetic_cv_meta( 'base_ops', get_theme_mod( 'kinetic_base_ops', 'Mérida, Yucatán · Mexico · Remote' ) );
$focus   = kinetic_cv_meta( 'core_focus', get_theme_mod( 'kinetic_core_focus', 'AI agents · Web apps · CRM · Odoo' ) );

$exp_eyebrow = kinetic_cv_meta( 'exp_eyebrow', __( '01 — Experience', 'kinetic' ) );
$exp_title   = kinetic_cv_meta( 'exp_title', __( 'The Blueprint', 'kinetic' ) );
$exp_meta    = kinetic_cv_meta( 'exp_meta', __( 'CV · 2026', 'kinetic' ) );

$tl[1]['role']   = kinetic_cv_meta( 'tl1_role', __( 'AI Automation Developer', 'kinetic' ) );
$tl[1]['period'] = kinetic_cv_meta( 'tl1_period', __( 'Aug 2025 — Present', 'kinetic' ) );
$tl[1]['org']    = kinetic_cv_meta( 'tl1_org', __( 'Fiborti Analytics', 'kinetic' ) );
$tl[1]['desc']   = kinetic_cv_meta( 'tl1_desc', __( 'Remote freelance: intelligent ecosystems with automation, AI, and CRM. Advanced flows with Kommo, WhatsApp API, n8n, and Make; intelligent chatbots with OpenAI, Claude, and Gemini; custom APIs and technical documentation for scalable commercial and operations processes.', 'kinetic' ) );

$tl[2]['role']   = kinetic_cv_meta( 'tl2_role', __( 'QA Frontend / QA Analyst', 'kinetic' ) );
$tl[2]['period'] = kinetic_cv_meta( 'tl2_period', __( 'Sep 2024 — Jan 2025', 'kinetic' ) );
$tl[2]['org']    = kinetic_cv_meta( 'tl2_org', __( '31ROOMS', 'kinetic' ) );
$tl[2]['desc']   = kinetic_cv_meta( 'tl2_desc', __( 'Remote QA on the UNADM project: specialized testing, documentation, and digital product quality. Manual and automated testing with Playwright; UI/UX validation, functional flows, and cross-browser compatibility; user manuals and functional documentation; bug tracking with development; task management in ClickUp.', 'kinetic' ) );

$tl[3]['role']   = kinetic_cv_meta( 'tl3_role', __( 'Application Admin · PM · Continuous Improvement', 'kinetic' ) );
$tl[3]['period'] = kinetic_cv_meta( 'tl3_period', __( 'Jul 2023 — Present', 'kinetic' ) );
$tl[3]['org']    = kinetic_cv_meta( 'tl3_org', __( 'Grupo ALI', 'kinetic' ) );
$tl[3]['desc']   = kinetic_cv_meta( 'tl3_desc', __( 'Corporate technology: Kommo CRM, AI bots on WhatsApp Cloud API, official GAIA-Manivela trainer, automation with n8n/Make, Linux hosting and sites, BigQuery analytics, ClickUp PM, and continuous improvement in real estate operations.', 'kinetic' ) );

$tl[4]['role']   = kinetic_cv_meta( 'tl4_role', __( 'Developer / Full Stack', 'kinetic' ) );
$tl[4]['period'] = kinetic_cv_meta( 'tl4_period', __( 'Aug 2020 — Jan 2024', 'kinetic' ) );
$tl[4]['org']    = kinetic_cv_meta( 'tl4_org', __( 'Idea2Form LLC', 'kinetic' ) );
$tl[4]['desc']   = kinetic_cv_meta( 'tl4_desc', __( 'Lead developer on international projects: robust, scalable web solutions for U.S. clients. Angular, Ruby on Rails, WordPress, PHP, and JavaScript; MySQL, PostgreSQL, and SQL Server; AWS (EC2, S3, RDS) and production deployments; ongoing maintenance and support for foreign clients; remote agile work with multidisciplinary teams.', 'kinetic' ) );

$stack_icons = array( 'terminal', 'code_blocks', 'database', 'cloud', 'token', 'view_in_ar' );
?>

<section class="kinetic-section kinetic-container" id="experience">
	<div class="kinetic-section__head">
		<div>
			<span class="kinetic-eyebrow kinetic-eyebrow--secondary"><?php echo esc_html( $exp_eyebrow ); ?></span>
			<h2 class="kinetic-section__title"><?php echo esc_html( $exp_title ); ?></h2>
		</div>
		<span class="kinetic-section__meta"><?php echo esc_html( $exp_meta ); ?></span>
	</div>

	<div class="kinetic-bento">
		<div class="kinetic-bento__bio kinetic-glass">
			<div class="kinetic-bento__bio-inner">
				<div class="kinetic-pulse-row">
					<span class="kinetic-pulse" aria-hidden="true"></span>
					<span class="kinetic-label kinetic-label--primary"><?php esc_html_e( 'Mission Statement', 'kinetic' ); ?></span>
				</div>
				<p class="kinetic-bento__quote"><?php echo esc_html( $mission ); ?></p>
			</div>
			<div class="kinetic-bento__meta">
				<div>
					<span class="kinetic-micro"><?php esc_html_e( 'Base of Operations', 'kinetic' ); ?></span>
					<span class="kinetic-bento__meta-value"><?php echo esc_html( $base ); ?></span>
				</div>
				<div>
					<span class="kinetic-micro"><?php esc_html_e( 'Core Focus', 'kinetic' ); ?></span>
					<span class="kinetic-bento__meta-value"><?php echo esc_html( $focus ); ?></span>
				</div>
			</div>
			<div class="kinetic-bento__watermark" aria-hidden="true">BIO</div>
		</div>

		<div class="kinetic-bento__stack kinetic-glass">
			<span class="kinetic-label kinetic-label--secondary"><?php esc_html_e( 'Core stack', 'kinetic' ); ?></span>
			<div class="kinetic-stack-grid">
				<?php foreach ( $stack_icons as $icon ) : ?>
					<div class="kinetic-stack-cell">
						<span class="material-symbols-outlined kinetic-stack-icon" aria-hidden="true"><?php echo esc_html( $icon ); ?></span>
						<span class="screen-reader-text"><?php echo esc_html( $icon ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="kinetic-bento__timeline kinetic-glass">
			<span class="kinetic-label kinetic-label--tertiary"><?php esc_html_e( 'Temporal Path (Experience)', 'kinetic' ); ?></span>
			<div class="kinetic-timeline" data-kinetic-timeline>
				<div class="kinetic-timeline__line-wrap" aria-hidden="true">
					<span class="kinetic-timeline__line kinetic-timeline__line--bg"></span>
					<span class="kinetic-timeline__line kinetic-timeline__line--fill"></span>
				</div>

				<div class="kinetic-timeline__entry" data-kinetic-timeline-entry>
					<span class="kinetic-timeline__dot" aria-hidden="true"></span>
					<div class="kinetic-timeline__head">
						<h3 class="kinetic-timeline__role"><?php echo esc_html( $tl[1]['role'] ); ?></h3>
						<span class="kinetic-pill"><?php echo esc_html( $tl[1]['period'] ); ?></span>
					</div>
					<span class="kinetic-timeline__org"><?php echo esc_html( $tl[1]['org'] ); ?></span>
					<p class="kinetic-timeline__desc">
						<?php echo esc_html( $tl[1]['desc'] ); ?>
					</p>
				</div>

				<div class="kinetic-timeline__entry kinetic-timeline__entry--muted" data-kinetic-timeline-entry>
					<span class="kinetic-timeline__dot kinetic-timeline__dot--muted" aria-hidden="true"></span>
					<div class="kinetic-timeline__head">
						<h3 class="kinetic-timeline__role"><?php echo esc_html( $tl[2]['role'] ); ?></h3>
						<span class="kinetic-pill"><?php echo esc_html( $tl[2]['period'] ); ?></span>
					</div>
					<span class="kinetic-timeline__org kinetic-timeline__org--muted"><?php echo esc_html( $tl[2]['org'] ); ?></span>
					<p class="kinetic-timeline__desc">
						<?php echo esc_html( $tl[2]['desc'] ); ?>
					</p>
				</div>

				<div class="kinetic-timeline__entry" data-kinetic-timeline-entry>
					<span class="kinetic-timeline__dot" aria-hidden="true"></span>
					<div class="kinetic-timeline__head">
						<h3 class="kinetic-timeline__role"><?php echo esc_html( $tl[3]['role'] ); ?></h3>
						<span class="kinetic-pill"><?php echo esc_html( $tl[3]['period'] ); ?></span>
					</div>
					<span class="kinetic-timeline__org"><?php echo esc_html( $tl[3]['org'] ); ?></span>
					<p class="kinetic-timeline__desc">
						<?php echo esc_html( $tl[3]['desc'] ); ?>
					</p>
				</div>

				<div class="kinetic-timeline__entry kinetic-timeline__entry--muted" data-kinetic-timeline-entry>
					<span class="kinetic-timeline__dot kinetic-timeline__dot--muted" aria-hidden="true"></span>
					<div class="kinetic-timeline__head">
						<h3 class="kinetic-timeline__role"><?php echo esc_html( $tl[4]['role'] ); ?></h3>
						<span class="kinetic-pill"><?php echo esc_html( $tl[4]['period'] ); ?></span>
					</div>
					<span class="kinetic-timeline__org kinetic-timeline__org--muted"><?php echo esc_html( $tl[4]['org'] ); ?></span>
					<p class="kinetic-timeline__desc">
						<?php echo esc_html( $tl[4]['desc'] ); ?>
					</p>
				</div>
			</div>
		</div>
	</div>
</section>
