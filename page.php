<?php
/**
 * The template for displaying all pages.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers HTML5 3.0
 */

get_header(); ?>

	<?php get_template_part( 'loop', 'page' ); ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
