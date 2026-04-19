<?php
/**
 * Bloque principal one-page (hero + secciones)
 *
 * Usado en front-page.php y home.php.
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;

get_template_part( 'template-parts/front/hero' );
get_template_part( 'template-parts/front/experience' );
get_template_part( 'template-parts/front/tech-logos' );
get_template_part( 'template-parts/front/portfolio' );
if ( kinetic_show_landing_blog() ) {
	get_template_part( 'template-parts/front/journal' );
}
get_template_part( 'template-parts/front/contact' );
