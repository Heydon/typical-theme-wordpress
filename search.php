<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Typical
 */

get_header(); ?>

<?php if ( have_posts() ) : ?>
		<h1><?php printf( __( 'Search Results for: <em>&#x201c;%s&#x201d;</em>', 'typical' ), '' . get_search_query() . '' ); ?></h1>
			<?php get_template_part( 'loop', 'search' ); ?>
<?php else : ?>
		<h1><?php _e( 'Nothing Found', 'typical' ); ?></h1>
			<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'typical' ); ?></p>
			<?php get_search_form(); ?>
<?php endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>