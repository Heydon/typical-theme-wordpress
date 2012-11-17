<?php
/**
 * The template for displaying the footer.
 *
 * @package WordPress
 * @subpackage Typical
 */
?>
	<footer>

<?php
	get_sidebar( 'footer' );
?>
	
		<div role="contentinfo">
		
		<?php
		// Custom footer text set in Theme Options or fallback
		$customText = get_option('footer-text');
		if ($customText != null) { 
			echo $customText;
		} else { ?>
			<p>You have been reading 
				<em>
					<a href="<?php echo home_url( '/' ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
						<?php bloginfo( 'name' ); ?>
					</a>
				</em>
			</p>
		<?php } ?>
		
		<?php
			$hide = get_option('hide-icons');
			if ($hide != null) {
				$hideClass = ' class="hide"';
			}
		?>
			<p>
				<span <?php echo $hideClass; ?>>
					<small><a title="Powered by Wordpress" href="http://www.wordpress.org"><span aria-hidden="true">W</span></a> <i>Powered by Wordpress</i></small> 
					<small><a title="Theme by Heydon Pickering" href="http://www.heydonworks.com"><span aria-hidden="true">&#x2622;</span> <i>Theme by Heydon Pickering</i></a></small> 
				</span>
					<small><a title="RSS Subscription" href="<?php bloginfo('rss2_url'); ?>"><span aria-hidden="true">R</span> <i>RSS Subscription</i></a></small>
			</p>
			
		</div>

	</footer>

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>