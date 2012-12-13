<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Typical
 */

get_header(); ?>
			<section role="main">
				<h1>
					<?php
					printf( __( '%s<sup><span aria-hidden="true">&#x270E;</span></sup>', 'typical' ), '' . single_cat_title( '', false ) . '' );
					?>
				</h1>
				<?php
				$category_description = category_description(); 
				if ( ! empty( $category_description ) )
					echo '<div role="note">' . $category_description . '</div>';

				get_template_part( 'loop', 'category' );
				?>
			</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>