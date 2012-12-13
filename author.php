<?php
/**
 * The template for displaying Author Archive pages.
 *
 * @package WordPress
 * @subpackage Typical
 */
 
get_header(); ?>
 
<?php
    if ( have_posts() )
        the_post();
?>
 
<?php
// If a user has filled out their description, show a bio on their entries.
?>

		<?php
		if ( get_the_author_meta( 'description' ) ) :
			typical_author_info();
		endif; 

		rewind_posts(); ?>
		
		<section role="main">
			<h1><span>&mdash;</span> <?php the_author(); ?>'s Writing <span>&mdash;</span></h1>
			<?php get_template_part('loop', 'author'); ?>
		</section>
 
<?php get_sidebar(); ?>
<?php get_footer(); ?>