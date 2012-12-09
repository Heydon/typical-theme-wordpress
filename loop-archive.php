<?php
/**
 * The loop that displays category posts.
 *
 * @package WordPress
 * @subpackage typical
 */
?>

<div itemscope itemtype="http://schema.org/ItemList">
	<ul>

<?php 

	if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

		<li itemprop="itemListElement" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<h2>
				<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'typical' ), the_title_attribute( 'echo=0' ) ); ?>" itemprop="url" rel="bookmark">
					<span itemprop="name"><?php the_title(); ?></span> <span aria-hidden="true">&#x2192;</span>
				</a>
			</h2>
			<p>
				 <time itemprop="datePublished" datetime="<?php the_date('Y-m-d'); ?>" pubdate><span aria-hidden="true">&#x274F;</span> <?php print get_the_date('d/m/Y'); ?></time> (by <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php the_author_meta('display_name'); ?></a>)
			</p>
			<div></div>
		</li>
	
<?php endwhile; // end of the loop. ?>
	</ul>
</div>
<?php if ( $wp_query->max_num_pages > 1 ) : ?>
	<nav>
        <?php 
		if(get_previous_posts_link()) {
			previous_posts_link( __( '<span aria-hidden="true">&#x2190;</span> Newer posts', 'typical' ) );
		} else { ?>
			<a rel="prev" href="#no"><span aria-hidden="true">&#x2190;</span> Newer posts</a>
		<?php } 
		if(get_next_posts_link()) {
			next_posts_link( __( 'Older posts <span aria-hidden="true">&#x2192;</span>', 'typical' ) );
		} else { ?>
			<a rel="next" href="#no">Older posts <span aria-hidden="true">&#x2192;</span></a>
		<?php } 
		?>
	</nav>
<?php endif; ?>