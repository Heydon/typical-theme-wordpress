<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage typical
 * @since typical HTML5 3.0
 */

get_header(); ?>

				<h1><?php
					printf( __( '%s<sup><span aria-hidden="true">&#x270E;</span></sup>', 'typical' ), '' . single_cat_title( '', false ) . '' );
				?></h1>
				<?php
					$category_description = category_description(); ?>
					<?php
						if ( ! empty( $category_description ) )
							echo '<div role="note">' . $category_description . '</div>';
					?>
				<?php
				get_template_part( 'loop', 'category' );
				?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>