<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers HTML5 3.0
 */
 
get_header(); 
	
	$intro = get_option('introduction');

	if ($intro != null) { 
	$introTitle = get_option('introductory-title');
	?>
	<section role="note">
		<h1><?php echo $introTitle; ?></h1>
		<p><?php echo $intro; ?></p>
	</section>
	<?php } ?>
	
    <section role="main">
		<h1><span>&mdash;</span> Latest Articles <span>&mdash;</span></h1>
		<?php get_template_part( 'loop', 'index' ); ?>
	</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>