<?php
/**
 * Conmutador EN / ES (cookie + parámetro ?kinetic_lang=)
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;

/**
 * ¿Aplicar traducciones del tema en esta petición?
 *
 * @return bool
 */
function kinetic_lang_switch_applies_to_request() {
	if ( wp_doing_ajax() ) {
		return false;
	}
	if ( is_admin() && ( ! function_exists( 'is_customize_preview' ) || ! is_customize_preview() ) ) {
		return false;
	}
	return true;
}

/**
 * Idioma activo: en | es
 *
 * @return string
 */
function kinetic_get_lang() {
	static $resolved = null;

	if ( null !== $resolved ) {
		return $resolved;
	}

	if ( isset( $_GET['kinetic_lang'] ) ) {
		$try = sanitize_text_field( wp_unslash( $_GET['kinetic_lang'] ) );
		if ( in_array( $try, array( 'en', 'es' ), true ) ) {
			$resolved = $try;
			return $resolved;
		}
	}

	if ( isset( $_COOKIE['kinetic_lang'] ) ) {
		$try = sanitize_text_field( wp_unslash( $_COOKIE['kinetic_lang'] ) );
		if ( in_array( $try, array( 'en', 'es' ), true ) ) {
			$resolved = $try;
			return $resolved;
		}
	}

	$resolved = 'en';
	return $resolved;
}

/**
 * Guarda cookie y redirige sin query string
 */
function kinetic_handle_lang_query_param() {
	if ( ! isset( $_GET['kinetic_lang'] ) ) {
		return;
	}

	$lang = sanitize_text_field( wp_unslash( $_GET['kinetic_lang'] ) );
	if ( ! in_array( $lang, array( 'en', 'es' ), true ) ) {
		return;
	}

	$exp = time() + YEAR_IN_SECONDS;
	if ( PHP_VERSION_ID >= 70300 ) {
		setcookie(
			'kinetic_lang',
			$lang,
			array(
				'expires'  => $exp,
				'path'     => '/',
				'secure'   => is_ssl(),
				'httponly' => true,
				'samesite' => 'Lax',
			)
		);
	} else {
		setcookie( 'kinetic_lang', $lang, $exp, '/', '', is_ssl(), true );
	}

	/* En el personalizador, evitar redirección que rompe el iframe */
	if ( function_exists( 'is_customize_preview' ) && is_customize_preview() ) {
		return;
	}

	wp_safe_redirect( remove_query_arg( 'kinetic_lang' ) );
	exit;
}
add_action( 'template_redirect', 'kinetic_handle_lang_query_param', 0 );

/**
 * Locale de WordPress (núcleo) según idioma del tema
 *
 * @param string $locale Locale.
 * @return string
 */
function kinetic_filter_locale( $locale ) {
	if ( ! kinetic_lang_switch_applies_to_request() ) {
		return $locale;
	}
	return 'es' === kinetic_get_lang() ? 'es_ES' : 'en_US';
}
add_filter( 'locale', 'kinetic_filter_locale', 20 );

/**
 * Atributo lang en <html>
 *
 * @param string $output Atributos.
 * @return string
 */
function kinetic_filter_language_attributes( $output ) {
	if ( ! kinetic_lang_switch_applies_to_request() ) {
		return $output;
	}
	$lang = 'es' === kinetic_get_lang() ? 'es' : 'en';
	return preg_replace( '/\blang="[^"]*"/', 'lang="' . esc_attr( $lang ) . '"', $output );
}
add_filter( 'language_attributes', 'kinetic_filter_language_attributes', 20 );

/**
 * Clase en body
 *
 * @param array $classes Clases.
 * @return array
 */
function kinetic_body_class_lang( $classes ) {
	if ( kinetic_lang_switch_applies_to_request() ) {
		$classes[] = 'kinetic-lang-' . sanitize_html_class( kinetic_get_lang() );
	}
	return $classes;
}
add_filter( 'body_class', 'kinetic_body_class_lang' );

/**
 * Mapa EN → ES para el text domain kinetic
 *
 * @return array<string, string>
 */
function kinetic_get_spanish_strings() {
	return array(
		'Menú principal'                                                                 => 'Menú principal',
		'Menú pie'                                                                       => 'Menú pie',
		'Portada Kinetic'                                                                => 'Portada Kinetic',
		'Marca (logo texto)'                                                             => 'Marca (logo texto)',
		'Web Developer & AI Automation Specialist'                                       => 'Desarrollador web y especialista en automatización con IA',
		'Systems Architect & Developer'                                                => 'Arquitecto de sistemas y desarrollador',
		'Hero: línea superior'                                                           => 'Hero: línea superior',
		"Hello, I'm"                                                                     => 'Hola, soy',
		"Hi, I'm"                                                                        => 'Hola, soy',
		'Hero: saludo'                                                                   => 'Hero: saludo',
		'Hero: marca destacada'                                                          => 'Portada: marca destacada',
		'Crafting digital ecosystems where high-performance engineering meets cinematic aesthetics. Exploring the intersection of human intent and algorithmic precision.' => 'Creando ecosistemas digitales donde la ingeniería de alto rendimiento se encuentra con la estética cinematográfica. Explorando la intersección entre la intención humana y la precisión algorítmica.',
		'10+ years in technology: web development, intelligent automation, and AI agents integrated with CRMs, APIs, and business systems. From WordPress and PHP to OpenAI, n8n, Kommo, Odoo, and production-ready deployments.' => 'Más de 10 años en tecnología: desarrollo web, automatización inteligente y agentes de IA integrados con CRMs, APIs y sistemas empresariales. Desde WordPress y PHP hasta OpenAI, n8n, Kommo, Odoo y despliegues listos para producción.',
		'Hero: descripción'                                                              => 'Hero: descripción',
		'"To build software that doesn\'t just function, but breathes. My work prioritizes atmospheric depth and technical transparency."' => '"Construir software que no solo funcione, sino que respire. Mi trabajo prioriza la profundidad atmosférica y la transparencia técnica."',
		'"I turn complex operations into reliable systems: AI agents, chatbots, and automations that recover real hours every week—without sacrificing clarity or control."' => '"Convierto operaciones complejas en sistemas confiables: agentes de IA, chatbots y automatizaciones que recuperan horas reales cada semana—sin sacrificar claridad ni control."',
		'Bento: misión'                                                                  => 'Bento: misión',
		'Bento: base de operaciones'                                                     => 'Bento: base de operaciones',
		'Bento: foco'                                                                    => 'Bento: foco',
		'Contacto: email'                                                                => 'Contacto: email',
		'© 2024 OBSIDIAN KINETIC. ALL RIGHTS RESERVED.'                                  => '© 2024 OBSIDIAN KINETIC. TODOS LOS DERECHOS RESERVADOS.',
		'© 2026 Danny Cen · Mérida, Yucatán, Mexico'                                     => '© 2026 Danny Cen · Mérida, Yucatán, México',
		'Pie: texto legal'                                                               => 'Pie: texto legal',
		'Home'                                                                           => 'Inicio',
		'CV'                                                                             => 'CV',
		'Projects'                                                                       => 'Proyectos',
		'Blog'                                                                           => 'Blog',
		'Contact'                                                                        => 'Contacto',
		'Principal'                                                                      => 'Principal',
		'Abrir menú'                                                                     => 'Abrir menú',
		"Let's Talk"                                                                     => 'Hablemos',
		'View Projects'                                                                  => 'Ver proyectos',
		'View projects'                                                                  => 'Ver proyectos',
		'Read Journal'                                                                   => 'Leer diario',
		'Get in touch'                                                                   => 'Hablemos',
		'Scroll to explore'                                                              => 'Desplázate para explorar',
		'01 — Experience'                                                                => '01 — Experiencia',
		'The Blueprint'                                                                  => 'El plano',
		'RESUME_V4.0'                                                                    => 'RESUME_V4.0',
		'CV · 2026'                                                                      => 'CV · 2026',
		'Mission Statement'                                                              => 'Manifiesto',
		'Base of Operations'                                                             => 'Base de operaciones',
		'Core Focus'                                                                     => 'Enfoque central',
		'Ion Drive (Stack)'                                                              => 'Ion Drive (stack)',
		'Core stack'                                                                     => 'Stack principal',
		'Temporal Path (Experience)'                                                     => 'Trayectoria temporal (experiencia)',
		'Senior Creative Engineer'                                                       => 'Ingeniero creativo senior',
		'2022 — Present'                                                                 => '2022 — Actualidad',
		'NEON NEXUS LABS'                                                                => 'NEON NEXUS LABS',
		'Architecting high-fidelity UI systems for enterprise-grade data visualization. Leading a team of 8 in the transition to atmospheric, spatial design principles.' => 'Arquitectura de sistemas UI de alta fidelidad para visualización de datos enterprise. Liderando un equipo de 8 en la transición a principios de diseño atmosférico y espacial.',
		'AI Automation Developer'                                                        => 'Desarrollador de automatizaciones IA',
		'Aug 2025 — Present'                                                             => 'Ago 2025 — Actualidad',
		'Fiborti Analytics'                                                              => 'Fiborti Analytics',
		'Remote freelance: intelligent ecosystems with automation, AI, and CRM. Advanced flows with Kommo, WhatsApp API, n8n, and Make; intelligent chatbots with OpenAI, Claude, and Gemini; custom APIs and technical documentation for scalable commercial and operations processes.' => 'Freelance remoto: ecosistemas inteligentes con automatización, IA y CRM. Flujos avanzados con Kommo, WhatsApp API, n8n y Make; chatbots con OpenAI, Claude y Gemini; APIs a medida y documentación técnica para procesos comerciales y operativos escalables.',
		'Application Admin · PM · Continuous Improvement'                                => 'Admin. de aplicaciones · PM · Mejora continua',
		'Jul 2023 — Present'                                                             => 'Jul 2023 — Actualidad',
		'Grupo ALI'                                                                      => 'Grupo ALI',
		'Corporate technology: Kommo CRM, AI bots on WhatsApp Cloud API, official GAIA-Manivela trainer, automation with n8n/Make, Linux hosting and sites, BigQuery analytics, ClickUp PM, and continuous improvement in real estate operations.' => 'Tecnología corporativa: Kommo CRM, bots con IA en WhatsApp Cloud API, capacitador oficial GAIA-Manivela, automatización con n8n/Make, hosting Linux y sitios, analítica en BigQuery, gestión en ClickUp y mejora continua en operaciones inmobiliarias.',
		'QA Frontend / QA Analyst'                                                       => 'QA Frontend / analista QA',
		'Sep 2024 — Jan 2025'                                                            => 'Sep 2024 — Ene 2025',
		'31ROOMS'                                                                        => '31ROOMS',
		'Remote QA on the UNADM project: specialized testing, documentation, and digital product quality. Manual and automated testing with Playwright; UI/UX validation, functional flows, and cross-browser compatibility; user manuals and functional documentation; bug tracking with development; task management in ClickUp.' => 'QA remoto en el proyecto UNADM: pruebas especializadas, documentación y calidad del producto digital. Pruebas manuales y automatizadas con Playwright; validación de UI/UX, flujos funcionales y compatibilidad cross-browser; manuales de usuario y documentación funcional; seguimiento de bugs con desarrollo; gestión de tareas en ClickUp.',
		'Developer / Full Stack'                                                         => 'Desarrollador / Full Stack',
		'Aug 2020 — Jan 2024'                                                            => 'Ago 2020 — Ene 2024',
		'Idea2Form LLC'                                                                  => 'Idea2Form LLC',
		'Lead developer on international projects: robust, scalable web solutions for U.S. clients. Angular, Ruby on Rails, WordPress, PHP, and JavaScript; MySQL, PostgreSQL, and SQL Server; AWS (EC2, S3, RDS) and production deployments; ongoing maintenance and support for foreign clients; remote agile work with multidisciplinary teams.' => 'Desarrollador principal en proyectos internacionales: soluciones web robustas y escalables para clientes en EE. UU. Angular, Ruby on Rails, WordPress, PHP y JavaScript; MySQL, PostgreSQL y SQL Server; AWS (EC2, S3, RDS) y despliegues en producción; mantenimiento y soporte continuo a clientes extranjeros; trabajo remoto ágil con equipos multidisciplinarios.',
		'Frontend Architect'                                                             => 'Arquitecto frontend',
		'2019 — 2022'                                                                    => '2019 — 2022',
		'OBSIDIAN SYSTEMS'                                                               => 'OBSIDIAN SYSTEMS',
		'Developed core component libraries using React and Tailwind CSS. Reduced bundle size by 40% while implementing complex interaction models.' => 'Desarrollo de librerías de componentes con React y Tailwind CSS. Reducción del bundle un 40% implementando modelos de interacción complejos.',
		'02 — Portfolio'                                                                 => '02 — Portafolio',
		'Selected Artifacts'                                                             => 'Artefactos seleccionados',
		'Create the «portfolio» category and assign posts to replace this demo.'        => 'Crea la categoría «portfolio» y asigna entradas para reemplazar esta demo.',
		'03 — Journal'                                                                   => '03 — Diario',
		'The AI Lab'                                                                     => 'The AI Lab',
		'View Archive'                                                                   => 'Ver archivo',
		'New Release'                                                                    => 'Nuevo lanzamiento',
		'AI-Tl;dr'                                                                       => 'AI-TL;DR',
		'No posts yet. Publish to fill the lab.'                                          => 'Aún no hay entradas. Publica entradas para llenar el laboratorio.',
		'Research Lab Status'                                                            => 'Estado del laboratorio',
		'Live Data Streaming'                                                            => 'Transmisión en vivo',
		"I'm currently exploring the integration of multi-modal agents in creative workflows. Tracking 14 active experiments." => 'Exploro la integración de agentes multimodales en flujos creativos. 14 experimentos activos.',
		'CURRENT READ'                                                                   => 'LECTURA ACTUAL',
		'The Nature of Software Development'                                             => 'The Nature of Software Development',
		'PLAYING'                                                                        => 'SONANDO',
		'Carbon Based Lifeforms - Interloper'                                            => 'Carbon Based Lifeforms - Interloper',
		'Connect'                                                                        => 'Conectar',
		'Version 4.0.0-Stable'                                                           => 'Versión 4.0.0 estable',
		'Remote · Mexico · Open to travel'                                               => 'Remoto · México · Disponible para viajar',
		'Email'                                                                          => 'Correo',
		'Phone'                                                                          => 'Teléfono',
		'LinkedIn profile'                                                               => 'Perfil de LinkedIn',
		'WhatsApp'                                                                       => 'WhatsApp',
		'Contacto: URL LinkedIn'                                                         => 'Contacto: URL LinkedIn',
		'Contacto: teléfono (texto)'                                                     => 'Contacto: teléfono (texto)',
		'Direct Terminal'                                                                => 'Terminal directo',
		'Copied'                                                                         => 'Copiado',
		'Copy Email'                                                                     => 'Copiar email',
		'Terminal'                                                                       => 'Terminal',
		'Hub'                                                                            => 'Hub',
		'Privacy'                                                                        => 'Privacidad',
		'Terms'                                                                          => 'Términos',
		'Socials'                                                                        => 'Redes',
		'Nothing here'                                                                   => 'Nada por aquí',
		'No content found. Try another search or go back home.'                          => 'No se encontró contenido. Prueba con otra búsqueda o vuelve al inicio.',
		'Search results for: %s'                                                         => 'Resultados para: %s',
		'Previous'                                                                       => 'Anterior',
		'Next'                                                                           => 'Siguiente',
		'404 — Signal lost'                                                              => '404 — Señal perdida',
		'The page you are looking for does not exist or has been moved.'                 => 'La página que buscas no existe o se movió.',
		'Back to home'                                                                   => 'Volver al inicio',
		'System Design / Web3'                                                           => 'Diseño de sistemas / Web3',
		'Cipher Engine Dashboard'                                                        => 'Cipher Engine Dashboard',
		'AI Integration / Python'                                                        => 'IA integrada / Python',
		'Neural Stream Interface'                                                        => 'Neural Stream Interface',
		'Brand Identity / UI'                                                            => 'Identidad de marca / UI',
		'Aether Brand System'                                                            => 'Aether Brand System',
		'Archive'                                                                        => 'Archivo',
		'Notes'                                                                          => 'Notas',
		'Intelligence Log'                                                               => 'Registro de inteligencia',
		'Feed.'                                                                          => 'Feed.',
		"Exploring the intersection of neural networks, kinetic motion, and the deep obsidian aesthetics of tomorrow's digital workspace." => 'Explorando la intersección entre redes neuronales, movimiento cinético y la estética obsidiana del workspace digital del mañana.',
		'AI-TL;DR'                                                                       => 'AI-TL;DR',
		'Join the Obsidian Collective.'                                                  => 'Únete al colectivo Obsidian.',
		'Get raw logs, technical breakdowns, and design theory delivered to your terminal weekly.' => 'Recibe bitácoras crudas, desgloses técnicos y teoría de diseño en tu terminal cada semana.',
		'Active Nodes'                                                                   => 'Nodos activos',
		'Access Token (Email)'                                                           => 'Token de acceso (email)',
		'Initialize Sync'                                                                => 'Iniciar sincronización',
		'© 2024 Obsidian Kinetic. Built for the vacuum.'                                 => '© 2024 Obsidian Kinetic. Construido para el vacío.',
		'Github'                                                                         => 'Github',
		'Signal'                                                                         => 'Signal',
		'Search insights...'                                                             => 'Buscar ideas...',
		'Subscribe'                                                                      => 'Suscribirse',
		'Language'                                                                       => 'Idioma',
		'%d min read'                                                                    => '%d min de lectura',
	);
}

/**
 * Traducción gettext para kinetic
 *
 * @param string $translation Traducción actual.
 * @param string $text        Texto original.
 * @param string $domain      Dominio.
 * @return string
 */
function kinetic_gettext_kinetic( $translation, $text, $domain ) {
	if ( 'kinetic' !== $domain || ! kinetic_lang_switch_applies_to_request() ) {
		return $translation;
	}
	if ( 'es' !== kinetic_get_lang() ) {
		return $translation;
	}
	$map = kinetic_get_spanish_strings();
	return isset( $map[ $text ] ) ? $map[ $text ] : $translation;
}
add_filter( 'gettext', 'kinetic_gettext_kinetic', 10, 3 );

/**
 * Plurales (tiempo de lectura)
 *
 * @param string $translation Traducción.
 * @param string $single      Singular.
 * @param string $plural      Plural.
 * @param int    $number      Número.
 * @param string $domain      Dominio.
 * @return string
 */
function kinetic_ngettext_kinetic( $translation, $single, $plural, $number, $domain ) {
	if ( 'kinetic' !== $domain || ! kinetic_lang_switch_applies_to_request() ) {
		return $translation;
	}
	if ( 'es' !== kinetic_get_lang() ) {
		return $translation;
	}
	if ( '%d min read' === $single && '%d min read' === $plural ) {
		return '%d min de lectura';
	}
	return $translation;
}
add_filter( 'ngettext', 'kinetic_ngettext_kinetic', 10, 5 );

/**
 * URL para cambiar idioma (misma página)
 *
 * @param string $lang en|es.
 * @return string
 */
function kinetic_lang_switch_url( $lang ) {
	return esc_url( add_query_arg( 'kinetic_lang', $lang ) );
}

/**
 * Imprime el conmutador EN | ES
 */
function kinetic_render_language_switcher() {
	if ( ! kinetic_lang_switch_applies_to_request() ) {
		return;
	}
	$current = kinetic_get_lang();
	?>
	<div class="kinetic-lang-switch" role="group" aria-label="<?php echo esc_attr( __( 'Language', 'kinetic' ) ); ?>">
		<a class="kinetic-lang-switch__btn <?php echo 'en' === $current ? 'is-active' : ''; ?>" href="<?php echo kinetic_lang_switch_url( 'en' ); ?>">EN</a>
		<span class="kinetic-lang-switch__sep" aria-hidden="true">/</span>
		<a class="kinetic-lang-switch__btn <?php echo 'es' === $current ? 'is-active' : ''; ?>" href="<?php echo kinetic_lang_switch_url( 'es' ); ?>">ES</a>
	</div>
	<?php
}
