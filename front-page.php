<?php
/**
 * Plantilla de la página de inicio
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main" class="kinetic-main">
	<?php get_template_part( 'template-parts/home', 'landing' ); ?>
</main>

<?php
get_footer();
