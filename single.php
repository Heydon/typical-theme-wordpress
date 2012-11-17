<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers HTML5 3.0
 */

get_header(); ?>

	<?php get_template_part( 'loop', 'single' ); ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>