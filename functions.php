<?php
/**
 * Funciones del tema Kinetic
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;

define( 'KINETIC_VERSION', '1.0.24' );

/**
 * Field Name del campo ACF “Title Hero - Landing CV” (WYSIWYG) — debe coincidir con el Name en ACF (mayúsculas/minúsculas).
 */
if ( ! defined( 'KINETIC_ACF_HERO_TITLE_FIELD' ) ) {
	define( 'KINETIC_ACF_HERO_TITLE_FIELD', 'Title_Hero_Landing_CV' );
}

require_once get_template_directory() . '/inc/language-switch.php';
require_once get_template_directory() . '/inc/seed-yiikaan-post.php';

/**
 * Página desde la que leer los campos ACF del hero (misma donde editaste el grupo Home-Landing).
 *
 * @return int Post ID o 0.
 */
function kinetic_get_landing_hero_post_id() {
	$post_id = (int) get_queried_object_id();
	if ( $post_id && 'page' === get_post_type( $post_id ) ) {
		return (int) apply_filters( 'kinetic_landing_acf_post_id', $post_id );
	}
	if ( is_front_page() ) {
		$front = (int) get_option( 'page_on_front' );
		if ( $front ) {
			return (int) apply_filters( 'kinetic_landing_acf_post_id', $front );
		}
	}
	global $post;
	if ( $post && isset( $post->ID ) && 'page' === get_post_type( $post ) ) {
		return (int) apply_filters( 'kinetic_landing_acf_post_id', (int) $post->ID );
	}
	return (int) apply_filters( 'kinetic_landing_acf_post_id', 0 );
}

/**
 * HTML del título hero desde ACF (prueba varios Field Name típicos de ACF para la misma etiqueta).
 *
 * @param int $post_id ID de la página.
 * @return string Cadena vacía si no hay valor.
 */
function kinetic_get_acf_hero_title_raw( $post_id ) {
	if ( ! function_exists( 'get_field' ) || ! $post_id ) {
		return '';
	}
	$default_names = array(
		KINETIC_ACF_HERO_TITLE_FIELD,
		'title_hero_landing_cv',
		'title_hero___landing_cv',
		'title_hero__landing_cv',
		'title_hero_-_landing_cv',
	);
	$names = apply_filters( 'kinetic_acf_hero_title_field_names', $default_names );
	$names = array_unique( array_filter( array_map( 'strval', (array) $names ) ) );
	foreach ( $names as $name ) {
		$raw = get_field( $name, $post_id, false );
		if ( is_string( $raw ) ) {
			$raw = trim( $raw );
			if ( '' !== $raw ) {
				return $raw;
			}
		}
	}
	return '';
}

/**
 * Normaliza HTML del título hero guardado en ACF (entidades tipo &lt;span, slashes de WordPress).
 * Sin esto el navegador muestra las etiquetas como texto plano.
 *
 * @param string $html Contenido desde Text, Textarea o WYSIWYG.
 * @return string
 */
function kinetic_prepare_hero_title_markup( $html ) {
	if ( ! is_string( $html ) ) {
		return '';
	}
	$html = trim( $html );
	if ( '' === $html ) {
		return '';
	}
	$html = stripslashes( $html );
	if ( preg_match( '/&(lt|gt|quot|#\d+);|&amp;(?:lt|gt|quot);/i', $html ) ) {
		$html = html_entity_decode( $html, ENT_QUOTES | ENT_HTML5, 'UTF-8' );
		if ( strpos( $html, '&lt;' ) !== false || strpos( $html, '&amp;lt;' ) !== false ) {
			$html = html_entity_decode( $html, ENT_QUOTES | ENT_HTML5, 'UTF-8' );
		}
	}
	return apply_filters( 'kinetic_prepare_hero_title_markup', $html );
}

/**
 * Configuración del tema
 */
function kinetic_setup() {
	load_theme_textdomain( 'kinetic', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);

	register_nav_menus(
		array(
			'primary' => __( 'Menú principal', 'kinetic' ),
			'footer'  => __( 'Menú pie', 'kinetic' ),
		)
	);
}
add_action( 'after_setup_theme', 'kinetic_setup' );

/**
 * Anchos de contenido
 */
function kinetic_content_width() {
	$GLOBALS['content_width'] = 1280;
}
add_action( 'after_setup_theme', 'kinetic_content_width', 0 );

/**
 * Encolar estilos y scripts
 */
function kinetic_enqueue_assets() {
	$ver = KINETIC_VERSION;

	wp_enqueue_style(
		'kinetic-fonts',
		'https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Manrope:wght@200;300;400;500;600;700;800&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'kinetic-material-symbols',
		'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0',
		array(),
		null
	);

	wp_enqueue_style(
		'kinetic-theme',
		get_stylesheet_uri(),
		array( 'kinetic-fonts', 'kinetic-material-symbols' ),
		$ver
	);

	wp_enqueue_script(
		'kinetic-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		$ver,
		true
	);

	wp_localize_script(
		'kinetic-main',
		'kineticData',
		array(
			'homeUrl' => home_url( '/' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'kinetic_enqueue_assets' );

/**
 * Favicon SVG (assets/favicon.svg) si no hay icono del sitio en el personalizador.
 */
function kinetic_theme_favicon() {
	if ( function_exists( 'has_site_icon' ) && has_site_icon() ) {
		return;
	}
	$href = get_template_directory_uri() . '/assets/favicon.svg';
	printf(
		'<link rel="icon" href="%s" type="image/svg+xml" sizes="any">' . "\n",
		esc_url( $href )
	);
}
add_action( 'wp_head', 'kinetic_theme_favicon', 5 );

/**
 * Personalizador: textos clave de la portada
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 */
function kinetic_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'kinetic_front',
		array(
			'title'    => __( 'Portada Kinetic', 'kinetic' ),
			'priority' => 30,
		)
	);

	$settings = array(
		'kinetic_site_brand'          => array(
			'default'           => 'DANNY DEV',
			'label'             => __( 'Marca (logo texto)', 'kinetic' ),
			'sanitize_callback' => 'sanitize_text_field',
		),
		'kinetic_hero_kicker'         => array(
			'default'           => __( 'Web Developer & AI Automation Specialist', 'kinetic' ),
			'label'             => __( 'Hero: línea superior', 'kinetic' ),
			'sanitize_callback' => 'sanitize_text_field',
		),
		'kinetic_hero_title_prefix'   => array(
			'default'           => __( "Hi, I'm", 'kinetic' ),
			'label'             => __( 'Hero: saludo', 'kinetic' ),
			'sanitize_callback' => 'sanitize_text_field',
		),
		'kinetic_hero_title_highlight' => array(
			'default'           => 'Danny Dev',
			'label'             => __( 'Hero: marca destacada', 'kinetic' ),
			'sanitize_callback' => 'sanitize_text_field',
		),
		'kinetic_hero_description'    => array(
			'default'           => __( '10+ years in technology: web development, intelligent automation, and AI agents integrated with CRMs, APIs, and business systems. From WordPress and PHP to OpenAI, n8n, Kommo, Odoo, and production-ready deployments.', 'kinetic' ),
			'label'             => __( 'Hero: descripción', 'kinetic' ),
			'sanitize_callback' => 'sanitize_textarea_field',
		),
		'kinetic_mission_text'        => array(
			'default'           => __( '"I turn complex operations into reliable systems: AI agents, chatbots, and automations that recover real hours every week—without sacrificing clarity or control."', 'kinetic' ),
			'label'             => __( 'Bento: misión', 'kinetic' ),
			'sanitize_callback' => 'sanitize_textarea_field',
		),
		'kinetic_base_ops'            => array(
			'default'           => 'Mérida, Yucatán · Mexico · Remote',
			'label'             => __( 'Bento: base de operaciones', 'kinetic' ),
			'sanitize_callback' => 'sanitize_text_field',
		),
		'kinetic_core_focus'          => array(
			'default'           => 'AI agents · Web apps · CRM · Odoo',
			'label'             => __( 'Bento: foco', 'kinetic' ),
			'sanitize_callback' => 'sanitize_text_field',
		),
		'kinetic_contact_email'       => array(
			'default'           => 'dannycen.dev@gmail.com',
			'label'             => __( 'Contacto: email', 'kinetic' ),
			'sanitize_callback' => 'sanitize_email',
		),
		'kinetic_linkedin_url'        => array(
			'default'           => 'https://www.linkedin.com/in/dannyscen/',
			'label'             => __( 'Contacto: URL LinkedIn', 'kinetic' ),
			'sanitize_callback' => 'esc_url_raw',
		),
		'kinetic_phone'               => array(
			'default'           => '+52 999 648 8429',
			'label'             => __( 'Contacto: teléfono (texto)', 'kinetic' ),
			'sanitize_callback' => 'sanitize_text_field',
		),
		'kinetic_footer_legal'        => array(
			'default'           => __( '© 2026 Danny Cen · Mérida, Yucatán, Mexico', 'kinetic' ),
			'label'             => __( 'Pie: texto legal', 'kinetic' ),
			'sanitize_callback' => 'sanitize_text_field',
		),
	);

	$textarea_fields = array( 'kinetic_hero_description', 'kinetic_mission_text' );

	foreach ( $settings as $id => $args ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $args['default'],
				'sanitize_callback' => $args['sanitize_callback'],
				'transport'         => 'refresh',
			)
		);

		$control_args = array(
			'label'    => $args['label'],
			'section'  => 'kinetic_front',
			'settings' => $id,
		);

		if ( in_array( $id, $textarea_fields, true ) ) {
			$control_args['type'] = 'textarea';
		}

		$wp_customize->add_control( $id, $control_args );
	}
}
add_action( 'customize_register', 'kinetic_customize_register' );

/**
 * Estimación de lectura (minutos)
 *
 * @return string
 */
function kinetic_reading_time() {
	$id           = get_the_ID();
	$content      = get_post_field( 'post_content', $id );
	$word_count   = str_word_count( wp_strip_all_tags( (string) $content ) );
	$minutes      = max( 1, (int) ceil( $word_count / 200 ) );

	return sprintf(
		/* translators: %d: estimated minutes */
		_n( '%d min read', '%d min read', $minutes, 'kinetic' ),
		$minutes
	);
}

/**
 * Estimación de lectura para un post específico.
 *
 * @param int $post_id Post ID.
 * @return string
 */
function kinetic_reading_time_for_post( $post_id ) {
	$content    = get_post_field( 'post_content', $post_id );
	$word_count = str_word_count( wp_strip_all_tags( (string) $content ) );
	$minutes    = max( 1, (int) ceil( $word_count / 200 ) );

	return sprintf(
		/* translators: %d: estimated minutes */
		_n( '%d min read', '%d min read', $minutes, 'kinetic' ),
		$minutes
	);
}

/**
 * Clases del menú principal (estilo wireframe)
 *
 * @param array    $classes Clases del ítem.
 * @param WP_Post  $item    Ítem de menú.
 * @param stdClass $args    Argumentos wp_nav_menu.
 * @return array
 */
function kinetic_nav_menu_css_class( $classes, $item, $args ) {
	if ( isset( $args->theme_location ) && 'primary' === $args->theme_location ) {
		$classes[] = 'kinetic-nav__item';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'kinetic_nav_menu_css_class', 10, 3 );

/**
 * Añade clase al enlace del menú activo
 */
function kinetic_nav_menu_link_attributes( $atts, $item, $args ) {
	if ( isset( $args->theme_location ) && 'primary' === $args->theme_location ) {
		$atts['class'] = isset( $atts['class'] ) ? $atts['class'] . ' kinetic-nav__link' : 'kinetic-nav__link';
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'kinetic_nav_menu_link_attributes', 10, 3 );

/**
 * Menú por defecto (misma estructura que el wireframe)
 */
function kinetic_fallback_menu() {
	$blog_page_id = (int) get_option( 'page_for_posts' );
	$blog_url     = $blog_page_id ? get_permalink( $blog_page_id ) : home_url( '/' );

	$links = array(
		home_url( '/' )           => __( 'Home', 'kinetic' ),
		home_url( '/#experience' ) => __( 'CV', 'kinetic' ),
		home_url( '/#portfolio' )  => __( 'Projects', 'kinetic' ),
		$blog_url                 => __( 'Blog', 'kinetic' ),
		home_url( '/#contact' )    => __( 'Contact', 'kinetic' ),
	);

	echo '<ul id="kinetic-nav-menu" class="kinetic-nav__list">';

	foreach ( $links as $url => $label ) {
		printf(
			'<li class="menu-item kinetic-nav__item"><a class="kinetic-nav__link" href="%1$s">%2$s</a></li>',
			esc_url( $url ),
			esc_html( $label )
		);
	}

	echo '</ul>';
}

/**
 * Fuerza el editor clasico en todo el sitio.
 */
function kinetic_disable_block_editor() {
	return false;
}
add_filter( 'use_block_editor_for_post', 'kinetic_disable_block_editor', 10 );
add_filter( 'use_block_editor_for_post_type', 'kinetic_disable_block_editor', 10 );

/**
 * Fuerza widgets clasicos en apariencia.
 */
add_filter( 'use_widgets_block_editor', '__return_false' );

/**
 * Obtiene IDs de categorías por slug.
 *
 * @param string[] $slugs Slugs de categoría.
 * @return int[]
 */
function kinetic_get_category_ids_by_slug( $slugs ) {
	$ids = array();

	foreach ( $slugs as $slug ) {
		$term = get_category_by_slug( $slug );
		if ( $term instanceof WP_Term ) {
			$ids[] = (int) $term->term_id;
		}
	}

	return array_values( array_unique( array_filter( $ids ) ) );
}

/**
 * Excluye categorías de portfolio del feed principal del blog.
 *
 * @param WP_Query $query Query principal.
 */
function kinetic_filter_main_blog_query( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_home() ) {
		return;
	}

	$portfolio_ids = kinetic_get_category_ids_by_slug( array( 'portfolio' ) );
	if ( empty( $portfolio_ids ) ) {
		return;
	}

	$excluded = (array) $query->get( 'category__not_in', array() );
	$query->set( 'category__not_in', array_values( array_unique( array_merge( $excluded, $portfolio_ids ) ) ) );
}
add_action( 'pre_get_posts', 'kinetic_filter_main_blog_query' );

/**
 * Selecciona plantilla individual según categoría de la entrada.
 *
 * - portfolio => template-project-detail.php
 * - resto     => template-blog-post.php
 *
 * @param string $template Plantilla detectada.
 * @return string
 */
function kinetic_single_template_by_category( $template ) {
	if ( ! is_single() ) {
		return $template;
	}

	$post_id = get_queried_object_id();
	if ( ! $post_id ) {
		return $template;
	}

	$portfolio_template = get_template_directory() . '/template-project-detail.php';
	$blog_template      = get_template_directory() . '/template-blog-post.php';

	if ( has_category( 'portfolio', $post_id ) && file_exists( $portfolio_template ) ) {
		return $portfolio_template;
	}

	if ( file_exists( $blog_template ) ) {
		return $blog_template;
	}

	return $template;
}
add_filter( 'single_template', 'kinetic_single_template_by_category' );

/**
 * Texto del landing CV (Personalizador del tema y valores por defecto).
 *
 * @param string $meta_key Clave (compatibilidad con plantillas; no usada).
 * @param mixed  $fallback Valor desde theme_mod o default.
 * @return mixed
 */
function kinetic_cv_meta( $meta_key, $fallback ) {
	return $fallback;
}
