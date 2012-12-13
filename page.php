<?php
/**
 * The template for displaying all pages.
 *
 * @package WordPress
 * @subpackage Typical
 */

get_header(); ?>

	<?php get_template_part( 'loop', 'page' ); ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
