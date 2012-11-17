<?php
/**
 * The loop that displays posts.
 *
 * @package WordPress
 * @subpackage typical
 */

query_posts('posts_per_page=-1'); ?>
 
<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if ( $wp_query->max_num_pages > 1 ) : ?>
    <nav>
        <?php next_posts_link( __( '&larr; Older posts', 'typical' ) ); ?>
        <?php previous_posts_link( __( 'Newer posts &rarr;', 'typical' ) ); ?>
    </nav>
<?php endif; ?>
 
<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
        <h1><?php _e( 'Not Found', 'typical' ); ?></h1>
            <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'typical' ); ?></p>
            <?php get_search_form(); ?>
<?php endif; ?>
 
<?php while ( have_posts() ) : the_post(); ?>
     
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
         
			<header>
                <h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'typical' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
 
                <?php typical_posted_on(); ?>
            </header>
 
    <?php if ( is_archive() || is_search() || is_category()) : // Only display excerpts for archives and search. ?>
                <?php the_excerpt(); ?>
    <?php else : ?>
                <?php the_content( __( 'Continue reading &rarr;', 'typical' ) ); ?>
                 
                <?php wp_link_pages( array( 'before' => '<nav>' . __( 'Pages:', 'typical' ), 'after' => '</nav>' ) ); ?>
    <?php endif; ?>
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
 
            <?php comments_template( '', true ); ?>
 
<?php endwhile; // End the loop. Whew. ?>