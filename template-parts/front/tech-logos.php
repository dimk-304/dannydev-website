<?php
/**
 * Franja de stack: marquee infinito (izquierda → derecha), acorde al tema oscuro.
 *
 * Iconos Simple Icons (CDN). Kommo sin slug en el set → texto.
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;

$tech_eyebrow = kinetic_cv_meta( 'tech_eyebrow', __( 'Stack & integrations', 'kinetic' ) );

$kinetic_si    = 'https://cdn.simpleicons.org';
$kinetic_si_hex = '9eb8c8';

/**
 * Orden: herramientas que ya tenías + lenguajes / frameworks / runtime comunes.
 * slug = identificador Simple Icons (https://simpleicons.org/).
 */
$kinetic_tech_logos = array(
	array( 'label' => __( 'Claude', 'kinetic' ), 'slug' => 'anthropic' ),
	array( 'label' => __( 'Cursor', 'kinetic' ), 'slug' => 'cursor' ),
	array( 'label' => __( 'Kommo', 'kinetic' ), 'slug' => null ),
	array( 'label' => __( 'WhatsApp', 'kinetic' ), 'slug' => 'whatsapp' ),
	array( 'label' => __( 'Python', 'kinetic' ), 'slug' => 'python' ),
	array( 'label' => __( 'JavaScript', 'kinetic' ), 'slug' => 'javascript' ),
	array( 'label' => __( 'TypeScript', 'kinetic' ), 'slug' => 'typescript' ),
	array( 'label' => __( 'PHP', 'kinetic' ), 'slug' => 'php' ),
	array( 'label' => __( 'Go', 'kinetic' ), 'slug' => 'go' ),
	array( 'label' => __( 'Rust', 'kinetic' ), 'slug' => 'rust' ),
	array( 'label' => __( 'Swift', 'kinetic' ), 'slug' => 'swift' ),
	array( 'label' => __( 'Kotlin', 'kinetic' ), 'slug' => 'kotlin' ),
	array( 'label' => __( 'React', 'kinetic' ), 'slug' => 'react' ),
	array( 'label' => __( 'Vue', 'kinetic' ), 'slug' => 'vuedotjs' ),
	array( 'label' => __( 'Next.js', 'kinetic' ), 'slug' => 'nextdotjs' ),
	array( 'label' => __( 'Node.js', 'kinetic' ), 'slug' => 'nodedotjs' ),
	array( 'label' => __( 'Express', 'kinetic' ), 'slug' => 'express' ),
	array( 'label' => __( 'Tailwind CSS', 'kinetic' ), 'slug' => 'tailwindcss' ),
	array( 'label' => __( 'WordPress', 'kinetic' ), 'slug' => 'wordpress' ),
	array( 'label' => __( 'n8n', 'kinetic' ), 'slug' => 'n8n' ),
	array( 'label' => __( 'PostgreSQL', 'kinetic' ), 'slug' => 'postgresql' ),
	array( 'label' => __( 'MongoDB', 'kinetic' ), 'slug' => 'mongodb' ),
	array( 'label' => __( 'Redis', 'kinetic' ), 'slug' => 'redis' ),
	array( 'label' => __( 'GraphQL', 'kinetic' ), 'slug' => 'graphql' ),
	array( 'label' => __( 'Docker', 'kinetic' ), 'slug' => 'docker' ),
	array( 'label' => __( 'Kubernetes', 'kinetic' ), 'slug' => 'kubernetes' ),
	array( 'label' => __( 'Git', 'kinetic' ), 'slug' => 'git' ),
);

$kinetic_tech_sr = implode(
	', ',
	array_map(
		static function ( $item ) {
			return $item['label'];
		},
		$kinetic_tech_logos
	)
);
?>

<section
	class="kinetic-section kinetic-container kinetic-logo-rail-section"
	id="tooling"
	aria-label="<?php esc_attr_e( 'Tools and integrations', 'kinetic' ); ?>"
>
	<span class="kinetic-eyebrow kinetic-eyebrow--primary"><?php echo esc_html( $tech_eyebrow ); ?></span>

	<p class="screen-reader-text">
		<?php
		echo esc_html(
			sprintf(
				/* translators: lista de nombres de tecnologías separados por comas */
				__( 'Technologies: %s', 'kinetic' ),
				$kinetic_tech_sr
			)
		);
		?>
	</p>

	<div class="kinetic-logo-rail__surface">
		<div
			class="kinetic-logo-rail__marquee"
			aria-hidden="true"
		>
			<div class="kinetic-logo-rail__inner">
				<?php foreach ( array( 1, 2 ) as $kinetic_marquee_pass ) : ?>
					<ul class="kinetic-logo-rail__row" role="presentation">
						<?php foreach ( $kinetic_tech_logos as $item ) : ?>
							<li class="kinetic-logo-rail__item">
								<?php if ( ! empty( $item['slug'] ) ) : ?>
									<img
										class="kinetic-logo-rail__img"
										src="<?php echo esc_url( $kinetic_si . '/' . rawurlencode( $item['slug'] ) . '/' . $kinetic_si_hex ); ?>"
										alt=""
										loading="<?php echo 1 === (int) $kinetic_marquee_pass ? 'eager' : 'lazy'; ?>"
										decoding="async"
									/>
								<?php else : ?>
									<span class="kinetic-logo-rail__text"><?php echo esc_html( $item['label'] ); ?></span>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
