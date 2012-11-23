<?php
/**
 * The template for displaying Tag Archive pages.
 *
 * @package WordPress
 * @subpackage typical
 */

get_header(); ?>

		<h1><?php
			printf( __( '%s <sup aria-hidden="true">&#x25C6;</sup>', 'typical' ), '' . single_tag_title( '', false ) . '' );
		?></h1>
		
		<?php
			$tag_description = tag_description();
			if ( ! empty( $tag_description ) )
				echo apply_filters( 'tag_archive_meta', '<div role="note"><p>' . $tag_description . '</p></div>' );
		?>

<?php
 get_template_part( 'loop', 'archive' );
?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>