<?php
/**
 * The template for displaying Tag Archive pages.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers HTML5 3.0
 */

get_header(); ?>

		<h1><?php
			printf( __( '%s <sup aria-hidden="true">&#x25C6;</sup>', 'starkers' ), '' . single_tag_title( '', false ) . '' );
		?></h1>

<?php
 get_template_part( 'loop', 'archive' );
?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>