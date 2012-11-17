<?php
/**
 * The loop that displays category posts.
 *
 * @package WordPress
 * @subpackage typical
 */
?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	 
		<header>
			<h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'typical' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

			<?php typical_author_posted_on(); ?>
		</header>

			<?php the_excerpt(); ?>

		<footer>
			<p>
				<?php if ( count( get_the_category() ) ) : ?>
						<?php printf( __( 'Posted in %2$s', 'typical' ), 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list( ', ' ) ); ?> <span aria-hidden="true">&#x2767;</span>
				<?php endif; ?>
				<?php
					$tags_list = get_the_tag_list( '', ', ' );
					if ( $tags_list ):
				?>
						<?php printf( __( 'Tagged %2$s', 'typical' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list ); ?> <span aria-hidden="true">&#x2767;</span>
				<?php endif; ?>
				<?php comments_popup_link( __( 'Leave a comment', 'typical' ), __( '1 Comment', 'typical' ), __( '% Comments', 'typical' ) ); ?>
				<?php edit_post_link( __( 'Edit', 'typical' ), '<span aria-hidden="true">&#x2767;</span> ', '' ); ?>
			</p>
		</footer>
	</article>
	
<?php endwhile; // end of the loop. ?>