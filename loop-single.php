<?php
/**
 * The loop that displays a single post.
 *
 * @package WordPress
 * @subpackage typical
 */
?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

		<nav class="prev-and-next">
			<h1>Previous And Next Post Navigation</h1>
			<?php
				$prev_post = get_previous_post();
				if($prev_post) {
						$prev_title = strip_tags(str_replace('"', '', $prev_post->post_title));
						echo '<a rel="prev" href="' . get_permalink($prev_post->ID) . '" title="' . $prev_title. '"><span aria-hidden="true">&#x2190;</span> Previous Post</a> ';
					} else {
						echo '<a rel="prev" href="#no"><span aria-hidden="true">&#x2190;</span> Previous Post</a>';
					}

				$next_post = get_next_post();
				if($next_post) {
				   $next_title = strip_tags(str_replace('"', '', $next_post->post_title));
				   echo '<a rel="next" href="' . get_permalink($next_post->ID) . '" title="' . $next_title. '">Next Post <span aria-hidden="true">&#x2192;</span></a> ';
					} else {
						echo '<a rel="next" href="#no">Next Post <span aria-hidden="true">&#x2192;</span></a>';
					}
			?>
		
		</nav>
		<div itemscope itemtype="http://schema.org/Article">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				
				<header>
					<h1 itemprop="headline"><?php the_title(); ?></h1>
					<div>
						<?php typical_posted_on(); ?>
					</div>
				</header>
				<?php 
					if ( has_post_thumbnail() ) { 
						typical_post_thumb_figure();
					} 
				?>
				<div itemprop="articleBody">
					<?php the_content(); ?>
				</div>
						
				<?php wp_link_pages( array( 'before' => '<nav>' . __( 'Pages:', 'typical' ), 'after' => '</nav>' ) ); ?>
				
				<footer>
					<p>
						<?php typical_posted_in(); ?>
						<?php edit_post_link( __( 'Edit', 'typical' ), '', '' ); ?>
					</p>
				</footer>
				<div aria-hidden="true"></div>
				
				<?php
					if ( get_the_author_meta( 'description' ) ) :
						typical_author_info();
					endif;
				?>
					
			</article>
			<section id="comments" itemscope itemtype="http://schema.org/UserComments">
				<?php comments_template( '', true ); ?>
			</section>
		</div>

<?php endwhile; // end of the loop. ?>