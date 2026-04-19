<?php
/**
 * Rellena una sola vez el post del portafolio «Yiikaan» (slug yiikaan) con el copy de Yikkan.
 * Tras la primera carga del sitio con este archivo incluido, puedes quitar el require en functions.php.
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;

/**
 * Inserta contenido, extracto y metadatos del caso Yikkan.
 */
function kinetic_seed_yiikaan_post_once() {
	if ( get_option( 'kinetic_yiikaan_seeded_v1' ) ) {
		return;
	}

	$posts = get_posts(
		array(
			'name'           => 'yiikaan',
			'post_type'      => 'post',
			'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);

	if ( empty( $posts ) ) {
		global $wpdb;
		$by_title = (int) $wpdb->get_var(
			$wpdb->prepare(
				"SELECT ID FROM {$wpdb->posts} WHERE post_type = 'post' AND post_status IN ('publish','draft','pending','private') AND post_title = %s LIMIT 1",
				'Yiikaan'
			)
		);
		if ( $by_title ) {
			$posts = array( $by_title );
		}
	}

	if ( empty( $posts ) ) {
		return;
	}

	$post_id = (int) $posts[0];

	$excerpt = 'Yikkan — Sistema de control de asistencia con reconocimiento facial, API REST en Django, jerarquía organizacional y despliegue con Docker.';

	$content = <<<'HTML'
<h2>Qué es Yikkan</h2>
<p>Yikkan es un sistema web de control de asistencia laboral que usa reconocimiento facial para identificar al empleado y registrar automáticamente entrada y salida (alterna entre CHECK_IN y CHECK_OUT según el último registro). Los empleados se dan de alta con una foto; el backend genera un encoding facial (con face-recognition / dlib) y lo guarda para compararlo con la foto capturada al fichar.</p>
<p>No es solo «fichar»: el modelo incluye organización jerárquica (roles como CEO, director, gerente, etc., supervisor, departamento, puesto), horarios de trabajo e incidencias (faltas, retardos, etc.). Hay también un módulo tipo red interna (networking) donde los empleados pueden publicar posts con texto e imagen.</p>
<p>Técnicamente es un backend en Django 5 con Django REST Framework, PostgreSQL, interfaz con plantillas HTML/JS (por ejemplo captura desde la cámara web y envío a <code>/api/check/</code>). El proyecto está pensado para Docker (desarrollo y producción), con opciones de despliegue en Fly.io o VPS con Nginx y Certbot (HTTPS).</p>
<p>Desarrollé Yikkan, una aplicación de asistencia con reconocimiento facial para empresas: el empleado se registra con una foto, el sistema extrae un vector facial y, al fichar, compara la nueva captura con los perfiles activos para registrar entrada o salida. La solución incluye roles y supervisión, gestión de horarios, incidencias y un feed social interno. El stack es Django + DRF + PostgreSQL, con contenedores Docker y documentación para producción en Fly.io o servidor propio con SSL.</p>
HTML;

	$updated = wp_update_post(
		array(
			'ID'           => $post_id,
			'post_content' => $content,
			'post_excerpt' => $excerpt,
		),
		true
	);

	if ( is_wp_error( $updated ) ) {
		return;
	}

	update_post_meta(
		$post_id,
		'tech_stack',
		'Django 5, Django REST Framework, PostgreSQL, plantillas HTML/JS, face-recognition (dlib), Docker, Nginx, Certbot, Fly.io / VPS'
	);
	update_post_meta(
		$post_id,
		'project_role',
		'Desarrollo full-stack: backend, API REST, integración de reconocimiento facial y despliegue documentado'
	);
	update_post_meta(
		$post_id,
		'project_timeline',
		'Desarrollo y documentación para entornos Docker; despliegue orientado a Fly.io o servidor propio con HTTPS'
	);

	update_option( 'kinetic_yiikaan_seeded_v1', '1', false );
}

add_action( 'init', 'kinetic_seed_yiikaan_post_once', 5 );
