<?php
/**
 * Grupo ACF «Portfolio — detalle (Kinetic)»: campos alineados con template-project-detail.php.
 *
 * Si ya creaste el mismo grupo en el plugin, desactívalo o bórralo para no duplicar metaboxes.
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;

/**
 * Valor de campo ACF o valor por defecto.
 *
 * @param string $name    Field Name en ACF.
 * @param string $default Valor si el campo está vacío.
 * @return string
 */
function kinetic_pf_field( $name, $default = '' ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $default;
	}
	$v = get_field( $name );
	if ( null === $v || false === $v || '' === $v ) {
		return $default;
	}
	if ( is_string( $v ) ) {
		return $v;
	}
	return (string) $v;
}

/**
 * Contenido WYSIWYG ACF o HTML por defecto.
 *
 * @param string $name          Field Name.
 * @param string $default_html  HTML por defecto (ya seguro para el diseño).
 * @return string
 */
function kinetic_pf_wysiwyg( $name, $default_html = '' ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $default_html;
	}
	$v = get_field( $name );
	if ( null === $v || false === $v || '' === trim( (string) $v ) ) {
		return $default_html;
	}
	return (string) $v;
}

/**
 * URL de imagen ACF (tipo Image, return format URL o Array).
 *
 * @param string $name    Field Name.
 * @param string $default URL por defecto.
 * @return string
 */
function kinetic_pf_img_url( $name, $default = '' ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $default;
	}
	$v = get_field( $name );
	if ( null === $v || false === $v || '' === $v ) {
		return $default;
	}
	if ( is_string( $v ) ) {
		return $v;
	}
	if ( is_array( $v ) && ! empty( $v['url'] ) ) {
		return (string) $v['url'];
	}
	if ( is_numeric( $v ) ) {
		$url = wp_get_attachment_image_url( (int) $v, 'large' );
		return $url ? $url : $default;
	}
	return $default;
}

/**
 * Reglas de ubicación: entradas en categoría portfolio (si existe el término).
 *
 * @return array<int, array<int, array<string, string>>>
 */
function kinetic_portfolio_detail_acf_location() {
	$term = get_term_by( 'slug', 'portfolio', 'category' );
	if ( $term && ! is_wp_error( $term ) ) {
		return array(
			array(
				array(
					'param'    => 'post_taxonomy',
					'operator' => '==',
					'value'    => 'category:' . (int) $term->term_id,
				),
			),
		);
	}

	return array(
		array(
			array(
				'param'    => 'post_type',
				'operator' => '==',
				'value'    => 'post',
			),
		),
	);
}

/**
 * Registra el grupo local de campos (acf_add_local_field_group).
 */
function kinetic_portfolio_detail_register_acf() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_kpf_portfolio_detail',
			'title'                 => 'Portfolio — detalle (Kinetic)',
			'fields'                => array(
				array(
					'key'               => 'field_kpf_tab_hero',
					'label'             => 'Hero',
					'name'              => '',
					'type'              => 'tab',
					'placement'         => 'top',
					'endpoint'          => 0,
				),
				array(
					'key'               => 'field_kpf_tag_project',
					'label'             => 'Tag proyecto',
					'name'              => 'tag-project',
					'type'              => 'text',
					'instructions'      => 'Pastilla pequeña (ej. QUANTUM COMPUTING). Vacío = título de la entrada.',
					'default_value'     => '',
					'placeholder'       => 'BACKEND',
				),
				array(
					'key'               => 'field_kpf_reading_time',
					'label'             => 'Tiempo de lectura',
					'name'              => 'reading-time',
					'type'              => 'text',
					'default_value'     => '',
					'placeholder'       => '12 MIN READ',
				),
				array(
					'key'               => 'field_kpf_title_project',
					'label'             => 'Título (parte principal)',
					'name'              => 'title-project',
					'type'              => 'text',
					'instructions'      => 'Texto antes del tramo en gradiente.',
					'placeholder'       => 'Entanglement & The',
				),
				array(
					'key'               => 'field_kpf_title_project_accent',
					'label'             => 'Título (gradiente)',
					'name'              => 'title-project-accent',
					'type'              => 'text',
					'instructions'      => 'Tramo con color degradado. Si lo dejas vacío solo se muestra la parte principal.',
					'placeholder'       => 'Future of Neural Architecture',
				),
				array(
					'key'               => 'field_kpf_editor_avatar',
					'label'             => 'Foto autor',
					'name'              => 'editor-avatar',
					'type'              => 'image',
					'return_format'     => 'url',
					'preview_size'      => 'thumbnail',
					'library'           => 'all',
				),
				array(
					'key'               => 'field_kpf_editor_name',
					'label'             => 'Nombre autor',
					'name'              => 'editor-name',
					'type'              => 'text',
				),
				array(
					'key'               => 'field_kpf_position',
					'label'             => 'Cargo / posición',
					'name'              => 'position',
					'type'              => 'text',
				),
				array(
					'key'               => 'field_kpf_publication_date',
					'label'             => 'Fecha de publicación (texto)',
					'name'              => 'publication_date',
					'type'              => 'text',
					'instructions'      => 'Texto libre (ej. Published Oct 24, 2024).',
				),
				array(
					'key'               => 'field_kpf_tab_summary',
					'label'             => 'Resumen TL;DR',
					'name'              => '',
					'type'              => 'tab',
					'placement'         => 'top',
					'endpoint'          => 0,
				),
				array(
					'key'               => 'field_kpf_summary_title',
					'label'             => 'Título del bloque',
					'name'              => 'summary-title',
					'type'              => 'text',
					'default_value'     => 'AI-TL;DR Summary',
				),
				array(
					'key'               => 'field_kpf_summary_icon',
					'label'             => 'Icono Material (nombre)',
					'name'              => 'summary-icon',
					'type'              => 'text',
					'instructions'      => 'Nombre del glifo, ej. smart_toy',
					'default_value'     => 'smart_toy',
				),
				array(
					'key'               => 'field_kpf_summary_body',
					'label'             => 'Texto resumen',
					'name'              => 'summary-body',
					'type'              => 'textarea',
					'rows'              => 4,
					'new_lines'         => 'br',
				),
				array(
					'key'               => 'field_kpf_summary_tag_1',
					'label'             => 'Etiqueta chip 1',
					'name'              => 'summary-tag-1',
					'type'              => 'text',
				),
				array(
					'key'               => 'field_kpf_summary_tag_2',
					'label'             => 'Etiqueta chip 2',
					'name'              => 'summary-tag-2',
					'type'              => 'text',
				),
				array(
					'key'               => 'field_kpf_tab_article',
					'label'             => 'Artículo',
					'name'              => '',
					'type'              => 'tab',
					'placement'         => 'top',
					'endpoint'          => 0,
				),
				array(
					'key'               => 'field_kpf_lead_paragraph',
					'label'             => 'Párrafo inicial (drop cap)',
					'name'              => 'lead-paragraph',
					'type'              => 'textarea',
					'rows'              => 5,
					'new_lines'         => 'br',
				),
				array(
					'key'               => 'field_kpf_article_h2',
					'label'             => 'Subtítulo (H2)',
					'name'              => 'article-h2',
					'type'              => 'text',
				),
				array(
					'key'               => 'field_kpf_article_p1',
					'label'             => 'Párrafo bajo H2',
					'name'              => 'article-p1',
					'type'              => 'wysiwyg',
					'tabs'              => 'all',
					'toolbar'           => 'basic',
					'media_upload'      => 0,
					'delay'             => 1,
				),
				array(
					'key'               => 'field_kpf_article_figure',
					'label'             => 'Imagen principal',
					'name'              => 'article-figure',
					'type'              => 'image',
					'return_format'     => 'url',
					'preview_size'      => 'medium',
				),
				array(
					'key'               => 'field_kpf_article_figure_caption',
					'label'             => 'Leyenda de la imagen',
					'name'              => 'article-figure-caption',
					'type'              => 'text',
				),
				array(
					'key'               => 'field_kpf_article_p2',
					'label'             => 'Párrafo (tras imagen)',
					'name'              => 'article-p2',
					'type'              => 'textarea',
					'rows'              => 4,
					'new_lines'         => 'br',
				),
				array(
					'key'               => 'field_kpf_article_code',
					'label'             => 'Bloque de código (texto plano)',
					'name'              => 'article-code',
					'type'              => 'textarea',
					'rows'              => 14,
					'new_lines'         => '',
				),
				array(
					'key'               => 'field_kpf_article_h3',
					'label'             => 'Subtítulo (H3)',
					'name'              => 'article-h3',
					'type'              => 'text',
				),
				array(
					'key'               => 'field_kpf_article_p3',
					'label'             => 'Párrafo final',
					'name'              => 'article-p3',
					'type'              => 'textarea',
					'rows'              => 4,
					'new_lines'         => 'br',
				),
				array(
					'key'               => 'field_kpf_tab_cta',
					'label'             => 'Bloque CTA / newsletter',
					'name'              => '',
					'type'              => 'tab',
					'placement'         => 'top',
					'endpoint'          => 0,
				),
				array(
					'key'               => 'field_kpf_newsletter_title',
					'label'             => 'Título CTA',
					'name'              => 'newsletter-title',
					'type'              => 'text',
				),
				array(
					'key'               => 'field_kpf_newsletter_text',
					'label'             => 'Descripción',
					'name'              => 'newsletter-text',
					'type'              => 'textarea',
					'rows'              => 3,
					'new_lines'         => 'br',
				),
				array(
					'key'               => 'field_kpf_newsletter_placeholder',
					'label'             => 'Placeholder del email',
					'name'              => 'newsletter-placeholder',
					'type'              => 'text',
				),
				array(
					'key'               => 'field_kpf_newsletter_button',
					'label'             => 'Texto del botón',
					'name'              => 'newsletter-button',
					'type'              => 'text',
				),
				array(
					'key'               => 'field_kpf_newsletter_footnote',
					'label'             => 'Nota pie',
					'name'              => 'newsletter-footnote',
					'type'              => 'text',
				),
				array(
					'key'               => 'field_kpf_tab_widget',
					'label'             => 'Widget fijo',
					'name'              => '',
					'type'              => 'tab',
					'placement'         => 'top',
					'endpoint'          => 0,
				),
				array(
					'key'               => 'field_kpf_live_pill',
					'label'             => 'Texto pill inferior',
					'name'              => 'live-pill-text',
					'type'              => 'text',
					'instructions'      => 'Esquina inferior derecha (demo).',
				),
			),
			'location'              => kinetic_portfolio_detail_acf_location(),
			'menu_order'            => 2,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
		)
	);
}
add_action( 'acf/init', 'kinetic_portfolio_detail_register_acf' );
