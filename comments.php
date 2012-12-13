<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.  The actual display of comments is
 * handled by a callback to typical_comment which is
 * located in the functions.php file.
 *
 * @package WordPress
 * @subpackage Typical
 */
?>

<?php if ( post_password_required() ) : ?>
	<p><?php _e( 'This post is password protected. Enter the password to view any comments.', 'typical' ); ?></p>
<?php
	return;
endif;
?>

<?php
	// You can start editing here -- including this comment!
?>

<?php if ( have_comments() ) : ?>
			<?php /* typical NOTE: The following h3 id is left intact so that comments can be referenced on the page */ ?>
			<h3 id="comments-title">
			<?php
			printf( _n( 'Commentary on <em>&#x201c;%2$s&#x201d;</em>', 'Commentary on <em>&#x201c;%2$s&#x201d;</em>', get_comments_number(), 'typical' ),
			number_format_i18n( get_comments_number() ), '' . get_the_title() . '' );
			?></h3>

				<?php
					wp_list_comments( array( 'style' => 'div', 'callback' => 'typical_comment', 'end-callback' => 'typical_comment_close' ) );
				?>
				
				<?php if(get_comments_number() > get_option('comments_per_page')) : ?>
					<nav class="comment-pagination">
						<h2>More comments &hellip;</h2>
						<?php paginate_comments_links(); ?>
					</nav>
				<?php endif; ?>

<?php else : // or, if we don't have comments:

	if ( ! comments_open() ) :
?>
	<p><?php _e( '<p>Comments are closed.</p>', 'typical' ); ?></p>
<?php endif; // end ! comments_open() ?>

<?php endif; // end have_comments() ?>

<?php comment_form(); ?>