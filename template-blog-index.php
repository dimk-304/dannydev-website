<?php
/**
 * Template Name: Blog Index Futuristic
 * Template Post Type: page
 *
 * @package Kinetic
 */

defined( 'ABSPATH' ) || exit;

get_header( 'blog' );
?>

<main id="main" class="kinetic-blog-main">
	<?php get_template_part( 'template-parts/blog/index', 'feed' ); ?>
</main>

<?php
get_footer( 'blog' );
