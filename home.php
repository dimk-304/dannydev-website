<?php
/**
 * Blog: portada con últimas entradas, o listado si el blog está en subpágina
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;

if ( is_front_page() ) :
	get_header();
	?>
	<main id="main" class="kinetic-main">
		<?php get_template_part( 'template-parts/home', 'landing' ); ?>
	</main>
	<?php
	get_footer();
else :
	get_header( 'blog' );
	?>
	<main id="main" class="kinetic-blog-main">
		<?php get_template_part( 'template-parts/blog/index', 'feed' ); ?>
	</main>
	<?php
	get_footer( 'blog' );
endif;
