<?php
/**
 * Plantilla índice (respaldo)
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main class="kinetic-main kinetic-main--inner kinetic-container">
	<?php get_template_part( 'template-parts/loops/archive', 'loop' ); ?>
</main>

<?php
get_footer();
