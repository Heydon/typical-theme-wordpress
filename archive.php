<?php
/**
 * The template for displaying Archive pages.
 *
 * @package WordPress
 * @subpackage Typical
 */

get_header(); ?>

<?php
	if ( have_posts() )
		the_post();
?>
		<section role="main">
			<h1>
<?php if ( is_day() ) : ?>
				<?php printf( __( '<span aria-hidden="true">&#x274F;</span> %s', 'typical' ), get_the_date() ); ?>
<?php elseif ( is_month() ) : ?>
				<?php printf( __( '<span aria-hidden="true">&#x274F;</span> %s', 'typical' ), get_the_date('F Y') ); ?>
<?php elseif ( is_year() ) : ?>
				<?php printf( __( '<span aria-hidden="true">&#x274F;</span> %s', 'typical' ), get_the_date('Y') ); ?>
<?php else : ?>
				<?php _e( 'Archives', 'typical' ); ?>
<?php endif; ?>
			</h1>
<?php
	rewind_posts();

	get_template_part( 'loop', 'archive' );
?>
		</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>