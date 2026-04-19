<?php
/**
 * Metadatos del detalle de portfolio (sin ACF): register_post_meta + meta box en entradas.
 * Las claves coinciden con las que usaba el template (tag-project, reading-time, etc.).
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;

/**
 * Resuelve ID de entrada para leer meta (plantilla en el loop o consulta principal).
 *
 * @param int|null $post_id ID explícito o null.
 * @return int
 */
function kinetic_pf_meta_post_id( $post_id = null ) {
	if ( $post_id ) {
		return (int) $post_id;
	}
	$tid = (int) get_the_ID();
	if ( $tid ) {
		return $tid;
	}
	$qid = get_queried_object_id();
	return $qid && 'post' === get_post_type( $qid ) ? (int) $qid : 0;
}

/**
 * Valor de meta de entrada o por defecto.
 *
 * @param string   $name                 Clave post_meta.
 * @param string   $default              Valor si no está definido.
 * @param bool     $empty_string_default Si es false, cadena vacía guardada se respeta.
 * @param int|null $post_id              ID de entrada (opcional).
 * @return string
 */
function kinetic_pf_field( $name, $default = '', $empty_string_default = true, $post_id = null ) {
	$pid = kinetic_pf_meta_post_id( $post_id );
	if ( ! $pid ) {
		return $default;
	}
	if ( ! metadata_exists( 'post', $pid, $name ) ) {
		return $default;
	}
	$v = get_post_meta( $pid, $name, true );
	if ( false === $v || null === $v ) {
		return $default;
	}
	$v = is_string( $v ) ? $v : (string) $v;
	if ( ! $empty_string_default ) {
		return $v;
	}
	return '' === trim( $v ) ? $default : $v;
}

/**
 * HTML guardado (párrafo bajo H2) o HTML por defecto.
 *
 * @param string   $name           Clave post_meta.
 * @param string   $default_html   HTML por defecto.
 * @param int|null $post_id        ID de entrada (opcional).
 * @return string
 */
function kinetic_pf_wysiwyg( $name, $default_html = '', $post_id = null ) {
	$pid = kinetic_pf_meta_post_id( $post_id );
	if ( ! $pid ) {
		return $default_html;
	}
	if ( ! metadata_exists( 'post', $pid, $name ) ) {
		return $default_html;
	}
	$v = get_post_meta( $pid, $name, true );
	if ( false === $v || null === $v || '' === trim( (string) $v ) ) {
		return $default_html;
	}
	return (string) $v;
}

/**
 * URL de imagen: meta como URL, o ID de adjunto.
 *
 * @param string   $name    Clave post_meta.
 * @param string   $default URL por defecto.
 * @param int|null $post_id ID de entrada (opcional).
 * @return string
 */
function kinetic_pf_img_url( $name, $default = '', $post_id = null ) {
	$pid = kinetic_pf_meta_post_id( $post_id );
	if ( ! $pid ) {
		return $default;
	}
	if ( ! metadata_exists( 'post', $pid, $name ) ) {
		return $default;
	}
	$v = get_post_meta( $pid, $name, true );
	if ( '' === $v || null === $v || false === $v ) {
		return $default;
	}
	if ( is_numeric( $v ) ) {
		$url = wp_get_attachment_image_url( (int) $v, 'large' );
		return $url ? $url : $default;
	}
	if ( is_string( $v ) ) {
		$v = trim( $v );
		if ( is_numeric( $v ) ) {
			$url = wp_get_attachment_image_url( (int) $v, 'large' );
			return $url ? $url : $default;
		}
		return esc_url_raw( $v ) ? $v : $default;
	}
	if ( is_array( $v ) && ! empty( $v['url'] ) ) {
		return esc_url_raw( (string) $v['url'] ) ? (string) $v['url'] : $default;
	}
	return $default;
}

/**
 * Lista de claves registradas (post meta).
 *
 * @return array<string, string> slug => tipo: text|textarea|html|code|url
 */
function kinetic_portfolio_detail_meta_keys() {
	return array(
		'tag-project'             => 'text',
		'reading-time'            => 'text',
		'title-project'           => 'text',
		'title-project-accent'    => 'text',
		'editor-avatar'           => 'url',
		'editor-name'             => 'text',
		'position'                => 'text',
		'publication_date'        => 'text',
		'summary-title'           => 'text',
		'summary-icon'            => 'text',
		'summary-body'            => 'textarea',
		'summary-tag-1'           => 'text',
		'summary-tag-2'           => 'text',
		'lead-paragraph'          => 'textarea',
		'article-h2'              => 'text',
		'article-p1'              => 'html',
		'article-figure'          => 'url',
		'article-figure-caption'  => 'text',
		'article-p2'              => 'textarea',
		'article-code'            => 'code',
		'article-h3'              => 'text',
		'article-p3'              => 'textarea',
		'newsletter-title'        => 'text',
		'newsletter-text'         => 'textarea',
		'newsletter-placeholder'  => 'text',
		'newsletter-button'       => 'text',
		'newsletter-footnote'     => 'text',
		'live-pill-text'          => 'text',
	);
}

/**
 * @param mixed  $value Valor crudo.
 * @param string $type  text|textarea|html|code|url
 * @return string
 */
function kinetic_portfolio_detail_sanitize_meta( $value, $type ) {
	if ( null === $value || false === $value ) {
		return '';
	}
	$value = is_array( $value ) ? '' : (string) wp_unslash( $value );
	switch ( $type ) {
		case 'textarea':
			return sanitize_textarea_field( $value );
		case 'html':
			return wp_kses_post( $value );
		case 'code':
			return sanitize_textarea_field( $value );
		case 'url':
			if ( preg_match( '/^\d+$/', trim( $value ) ) ) {
				return (string) (int) $value;
			}
			return esc_url_raw( $value );
		case 'text':
		default:
			return sanitize_text_field( $value );
	}
}

/**
 * register_post_meta para REST / documentación (la UI principal es el meta box).
 */
function kinetic_portfolio_detail_register_post_meta() {
	$auth = static function () {
		return current_user_can( 'edit_posts' );
	};

	foreach ( kinetic_portfolio_detail_meta_keys() as $key => $type ) {
		register_post_meta(
			'post',
			$key,
			array(
				'type'              => 'string',
				'single'            => true,
				'show_in_rest'      => true,
				'auth_callback'     => $auth,
				'sanitize_callback' => static function ( $meta_value ) use ( $type ) {
					return kinetic_portfolio_detail_sanitize_meta( $meta_value, $type );
				},
			)
		);
	}
}
add_action( 'init', 'kinetic_portfolio_detail_register_post_meta' );

/**
 * Meta box en editor de entradas.
 */
function kinetic_portfolio_detail_add_meta_box() {
	add_meta_box(
		'kinetic_portfolio_detail',
		__( 'Portfolio — detalle (Kinetic)', 'kinetic' ),
		'kinetic_portfolio_detail_render_meta_box',
		'post',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 'kinetic_portfolio_detail_add_meta_box' );

/**
 * @param WP_Post $post Post.
 */
function kinetic_portfolio_detail_render_meta_box( $post ) {
	wp_nonce_field( 'kinetic_portfolio_detail_save', 'kinetic_portfolio_detail_nonce' );

	$keys = kinetic_portfolio_detail_meta_keys();
	$get  = static function ( $key ) use ( $post ) {
		return (string) get_post_meta( $post->ID, $key, true );
	};

	echo '<p class="description" style="margin-top:0;">' . esc_html__( 'Campos usados por la plantilla de detalle (categoría «portfolio»). Vacíos = textos demo del tema.', 'kinetic' ) . '</p>';

	echo '<h4 style="margin:1.25em 0 0.5em;">' . esc_html__( 'Hero', 'kinetic' ) . '</h4><table class="form-table"><tbody>';
	kinetic_portfolio_detail_field_row_text( 'tag-project', __( 'Tag proyecto', 'kinetic' ), $get( 'tag-project' ), __( 'Ej. BACKEND. Vacío en front = título de la entrada.', 'kinetic' ) );
	kinetic_portfolio_detail_field_row_text( 'reading-time', __( 'Tiempo de lectura', 'kinetic' ), $get( 'reading-time' ), '12 MIN READ' );
	kinetic_portfolio_detail_field_row_text( 'title-project', __( 'Título (parte principal)', 'kinetic' ), $get( 'title-project' ), '' );
	kinetic_portfolio_detail_field_row_text( 'title-project-accent', __( 'Título (gradiente)', 'kinetic' ), $get( 'title-project-accent' ), '' );
	kinetic_portfolio_detail_field_row_text( 'editor-avatar', __( 'Foto autor (URL o ID adjunto)', 'kinetic' ), $get( 'editor-avatar' ), '' );
	kinetic_portfolio_detail_field_row_text( 'editor-name', __( 'Nombre autor', 'kinetic' ), $get( 'editor-name' ), '' );
	kinetic_portfolio_detail_field_row_text( 'position', __( 'Cargo', 'kinetic' ), $get( 'position' ), '' );
	kinetic_portfolio_detail_field_row_text( 'publication_date', __( 'Fecha (texto)', 'kinetic' ), $get( 'publication_date' ), '' );
	echo '</tbody></table>';

	echo '<h4 style="margin:1.25em 0 0.5em;">' . esc_html__( 'Resumen TL;DR', 'kinetic' ) . '</h4><table class="form-table"><tbody>';
	kinetic_portfolio_detail_field_row_text( 'summary-title', __( 'Título del bloque', 'kinetic' ), $get( 'summary-title' ), 'AI-TL;DR Summary' );
	kinetic_portfolio_detail_field_row_text( 'summary-icon', __( 'Icono Material', 'kinetic' ), $get( 'summary-icon' ), 'smart_toy' );
	kinetic_portfolio_detail_field_row_textarea( 'summary-body', __( 'Texto resumen', 'kinetic' ), $get( 'summary-body' ), 4 );
	kinetic_portfolio_detail_field_row_text( 'summary-tag-1', __( 'Chip 1', 'kinetic' ), $get( 'summary-tag-1' ), '' );
	kinetic_portfolio_detail_field_row_text( 'summary-tag-2', __( 'Chip 2', 'kinetic' ), $get( 'summary-tag-2' ), '' );
	echo '</tbody></table>';

	echo '<h4 style="margin:1.25em 0 0.5em;">' . esc_html__( 'Artículo', 'kinetic' ) . '</h4><table class="form-table"><tbody>';
	kinetic_portfolio_detail_field_row_textarea( 'lead-paragraph', __( 'Párrafo inicial', 'kinetic' ), $get( 'lead-paragraph' ), 5 );
	kinetic_portfolio_detail_field_row_text( 'article-h2', __( 'Subtítulo H2', 'kinetic' ), $get( 'article-h2' ), '' );
	echo '<tr><th><label for="kinetic_article_p1">' . esc_html__( 'Párrafo bajo H2 (HTML)', 'kinetic' ) . '</label></th><td>';
	wp_editor(
		$get( 'article-p1' ),
		'kinetic_article_p1',
		array(
			'textarea_name' => 'kinetic_pf[article-p1]',
			'textarea_rows' => 8,
			'media_buttons' => false,
			'teeny'         => true,
			'quicktags'     => true,
		)
	);
	echo '</td></tr>';
	kinetic_portfolio_detail_field_row_text( 'article-figure', __( 'Imagen principal (URL o ID)', 'kinetic' ), $get( 'article-figure' ), '' );
	kinetic_portfolio_detail_field_row_text( 'article-figure-caption', __( 'Leyenda imagen', 'kinetic' ), $get( 'article-figure-caption' ), '' );
	kinetic_portfolio_detail_field_row_textarea( 'article-p2', __( 'Párrafo tras imagen', 'kinetic' ), $get( 'article-p2' ), 4 );
	kinetic_portfolio_detail_field_row_textarea( 'article-code', __( 'Bloque código (texto plano)', 'kinetic' ), $get( 'article-code' ), 14 );
	kinetic_portfolio_detail_field_row_text( 'article-h3', __( 'Subtítulo H3', 'kinetic' ), $get( 'article-h3' ), '' );
	kinetic_portfolio_detail_field_row_textarea( 'article-p3', __( 'Párrafo final', 'kinetic' ), $get( 'article-p3' ), 4 );
	echo '</tbody></table>';

	echo '<h4 style="margin:1.25em 0 0.5em;">' . esc_html__( 'CTA / newsletter', 'kinetic' ) . '</h4><table class="form-table"><tbody>';
	kinetic_portfolio_detail_field_row_text( 'newsletter-title', __( 'Título', 'kinetic' ), $get( 'newsletter-title' ), '' );
	kinetic_portfolio_detail_field_row_textarea( 'newsletter-text', __( 'Descripción', 'kinetic' ), $get( 'newsletter-text' ), 3 );
	kinetic_portfolio_detail_field_row_text( 'newsletter-placeholder', __( 'Placeholder email', 'kinetic' ), $get( 'newsletter-placeholder' ), '' );
	kinetic_portfolio_detail_field_row_text( 'newsletter-button', __( 'Texto botón', 'kinetic' ), $get( 'newsletter-button' ), '' );
	kinetic_portfolio_detail_field_row_text( 'newsletter-footnote', __( 'Nota pie', 'kinetic' ), $get( 'newsletter-footnote' ), '' );
	echo '</tbody></table>';

	echo '<h4 style="margin:1.25em 0 0.5em;">' . esc_html__( 'Widget fijo', 'kinetic' ) . '</h4><table class="form-table"><tbody>';
	kinetic_portfolio_detail_field_row_text( 'live-pill-text', __( 'Texto pill inferior', 'kinetic' ), $get( 'live-pill-text' ), '' );
	echo '</tbody></table>';
}

/**
 * @param string $key   Meta key.
 * @param string $label Etiqueta.
 * @param string $value Valor actual.
 * @param string $placeholder Placeholder (opcional).
 */
function kinetic_portfolio_detail_field_row_text( $key, $label, $value, $placeholder = '' ) {
	$id = 'kinetic_pf_' . str_replace( array( '-', '_' ), '_', $key );
	printf(
		'<tr><th scope="row"><label for="%1$s">%2$s</label></th><td><input class="large-text" type="text" id="%1$s" name="kinetic_pf[%3$s]" value="%4$s" placeholder="%5$s" /></td></tr>',
		esc_attr( $id ),
		esc_html( $label ),
		esc_attr( $key ),
		esc_attr( $value ),
		esc_attr( $placeholder )
	);
}

/**
 * @param string $key   Meta key.
 * @param string $label Etiqueta.
 * @param string $value Valor actual.
 * @param int    $rows  Filas.
 */
function kinetic_portfolio_detail_field_row_textarea( $key, $label, $value, $rows = 4 ) {
	$id = 'kinetic_pf_' . str_replace( array( '-', '_' ), '_', $key );
	printf(
		'<tr><th scope="row"><label for="%1$s">%2$s</label></th><td><textarea class="large-text" id="%1$s" name="kinetic_pf[%3$s]" rows="%5$d">%4$s</textarea></td></tr>',
		esc_attr( $id ),
		esc_html( $label ),
		esc_attr( $key ),
		esc_textarea( $value ),
		(int) $rows
	);
}

/**
 * Guardado del meta box.
 *
 * @param int $post_id ID de entrada.
 */
function kinetic_portfolio_detail_save_meta_box( $post_id ) {
	if ( ! isset( $_POST['kinetic_portfolio_detail_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['kinetic_portfolio_detail_nonce'] ) ), 'kinetic_portfolio_detail_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( 'post' !== get_post_type( $post_id ) ) {
		return;
	}

	$keys = kinetic_portfolio_detail_meta_keys();
	$raw  = isset( $_POST['kinetic_pf'] ) && is_array( $_POST['kinetic_pf'] ) ? wp_unslash( $_POST['kinetic_pf'] ) : array();

	foreach ( $keys as $key => $type ) {
		if ( ! array_key_exists( $key, $raw ) ) {
			continue;
		}
		$sanitized = kinetic_portfolio_detail_sanitize_meta( $raw[ $key ], $type );
		update_post_meta( $post_id, $key, $sanitized );
	}
}
add_action( 'save_post_post', 'kinetic_portfolio_detail_save_meta_box', 10, 1 );
