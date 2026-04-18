<?php
/**
 * Contacto (bento)
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;

$email    = kinetic_cv_meta( 'contact_email', get_theme_mod( 'kinetic_contact_email', 'dannycen.dev@gmail.com' ) );
$linkedin = kinetic_cv_meta( 'contact_linkedin', get_theme_mod( 'kinetic_linkedin_url', 'https://www.linkedin.com/in/dannyscen/' ) );
$phone    = kinetic_cv_meta( 'contact_phone', get_theme_mod( 'kinetic_phone', '+52 999 648 8429' ) );

$digits = preg_replace( '/\D/', '', $phone );
$wa     = $digits ? 'https://wa.me/' . $digits : 'https://wa.me/529996488429';

$gmail          = 'mailto:' . sanitize_email( $email );
$contact_title  = kinetic_cv_meta( 'contact_title', __( 'Connect', 'kinetic' ) );
$contact_sub    = kinetic_cv_meta( 'contact_subtitle', __( 'Remote · Mexico · Open to travel', 'kinetic' ) );
?>

<section class="kinetic-section kinetic-container" id="contact">
	<div class="kinetic-contact-grid">
		<div class="kinetic-contact-intro kinetic-glass">
			<h2 class="kinetic-contact-intro__title"><?php echo esc_html( $contact_title ); ?></h2>
			<p class="kinetic-contact-intro__ver"><?php echo esc_html( $contact_sub ); ?></p>
		</div>

		<div class="kinetic-contact-email kinetic-glass">
			<div class="kinetic-contact-email__row">
				<div class="kinetic-contact-email__icon" aria-hidden="true">
					<span class="material-symbols-outlined">alternate_email</span>
				</div>
				<div>
					<span class="kinetic-micro"><?php esc_html_e( 'Email', 'kinetic' ); ?></span>
					<span class="kinetic-contact-email__addr" id="kinetic-email-display"><?php echo esc_html( $email ); ?></span>
				</div>
			</div>
			<div class="kinetic-contact-email__row">
				<div class="kinetic-contact-email__icon" aria-hidden="true">
					<svg class="kinetic-brand-icon kinetic-brand-icon--whatsapp" viewBox="0 0 16 16" role="img" focusable="false">
						<path d="M13.601 2.326A7.854 7.854 0 0 0 8.004 0C3.58 0 0 3.582 0 8.004a7.97 7.97 0 0 0 1.07 3.983L0 16l4.117-1.077a7.974 7.974 0 0 0 3.887 1.015h.003c4.423 0 8.003-3.582 8.003-8.004A7.95 7.95 0 0 0 13.6 2.326zM8.007 14.59h-.002a6.63 6.63 0 0 1-3.372-.922l-.242-.145-2.444.639.652-2.382-.157-.245a6.62 6.62 0 0 1-1.015-3.53c0-3.66 2.979-6.64 6.642-6.64a6.6 6.6 0 0 1 4.693 1.948 6.6 6.6 0 0 1 1.949 4.693c-.001 3.66-2.98 6.64-6.644 6.64zm3.642-4.943c-.199-.1-1.173-.579-1.355-.644-.18-.067-.312-.1-.444.1-.132.2-.51.644-.626.778-.115.132-.232.15-.431.05-.199-.1-.84-.31-1.599-.99-.59-.526-.987-1.177-1.103-1.376-.116-.2-.013-.308.087-.408.09-.09.2-.232.298-.347.1-.116.133-.2.2-.332.066-.133.033-.25-.017-.35-.05-.1-.445-1.075-.61-1.472-.16-.387-.325-.334-.445-.34a7.2 7.2 0 0 0-.38-.007.73.73 0 0 0-.53.248c-.182.2-.695.679-.695 1.655 0 .976.712 1.92.811 2.053.099.132 1.4 2.137 3.393 2.995.474.205.843.327 1.13.419.475.151.907.13 1.248.079.38-.057 1.173-.479 1.339-.942.166-.464.166-.861.116-.943-.05-.083-.182-.133-.381-.232z"></path>
					</svg>
				</div>
				<div>
					<span class="kinetic-micro"><?php esc_html_e( 'WhatsApp', 'kinetic' ); ?></span>
					<a class="kinetic-contact-email__addr" href="<?php echo esc_url( $wa ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $phone ); ?></a>
				</div>
			</div>
			<button type="button" class="kinetic-btn kinetic-btn--copy" data-kinetic-copy="<?php echo esc_attr( $email ); ?>" data-copied-label="<?php esc_attr_e( 'Copied', 'kinetic' ); ?>">
				<?php esc_html_e( 'Copy Email', 'kinetic' ); ?>
			</button>
		</div>

		<div class="kinetic-contact-social kinetic-glass">
			<a class="kinetic-social-cell" href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'LinkedIn profile', 'kinetic' ); ?>">
				<svg class="kinetic-brand-icon kinetic-brand-icon--linkedin" viewBox="0 0 16 16" role="img" focusable="false" aria-hidden="true">
					<path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zM4.943 13.394V6.169H2.542v7.225zm-1.2-8.21c.837 0 1.358-.554 1.358-1.248-.016-.71-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.936c0 .694.505 1.248 1.326 1.248zm2.133 8.21h2.401V9.359c0-.216.016-.433.08-.588.173-.433.568-.882 1.23-.882.868 0 1.215.666 1.215 1.642v3.863h2.401V9.255c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.194h.016v-1.03h-2.4c.032.666 0 7.227 0 7.227z"></path>
				</svg>
			</a>
			<a class="kinetic-social-cell kinetic-social-cell--secondary" href="<?php echo esc_url( $gmail ); ?>" aria-label="<?php esc_attr_e( 'Send email via Gmail', 'kinetic' ); ?>">
				<svg class="kinetic-brand-icon kinetic-brand-icon--gmail" viewBox="0 0 24 24" role="img" focusable="false" aria-hidden="true">
					<path d="M2 6.6v10.8h4V9.8L12 14l6-4.2v7.6h4V6.6L12 13.3z"></path>
				</svg>
			</a>
		</div>
	</div>
</section>
