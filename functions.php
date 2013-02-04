<?php
/**
 * Typical functions and definitions (based on Starkers theme)
 *
 * @package WordPress
 * @subpackage Typical
 */
/** Tell WordPress to run typical_setup() when the 'after_setup_theme' hook is run. */

add_action( 'after_setup_theme', 'typical_setup' );

if ( !function_exists( 'typical_setup' ) ):

/**
* Sets up theme defaults and registers support for various WordPress features
*/

	function typical_setup() {
	
		// Add background and header image support
		add_theme_support( 'custom-header' );
		add_theme_support( 'custom-background' );
	
		// Editor stylesheet support
		add_editor_style('wysiwyg.css');
		
		// This theme uses post thumbnails
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'Typical Thumbnail', 600, 600, true );

		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );

		// Make theme available for translation
		// Translations can be filed in the /languages/ directory
		load_theme_textdomain( 'typical', get_template_directory(). '/languages' );

		$locale = get_locale();
		$locale_file = get_template_directory(). "/languages/$locale.php";
		if ( is_readable( $locale_file ) )
			require_once( $locale_file );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array( 'primary' => __( 'Primary Navigation', 'typical' ),) );
}
endif;

if ( !function_exists( 'typical_menu' ) ):

/**
* Combines pages and categories into a singular menu
*/

	function typical_menu() {
		$typical_pages = get_pages();
		$typical_cats = get_categories();
		echo '<nav role="navigation"><h1>Pages and Blog Categories Navigation</h1><ul>';
		foreach ( $typical_pages as $typical_page ) {
			$page = '<li><a href="' . get_page_link( $typical_page->ID ) . '">';
			$page .= $typical_page->post_title;
			$page .= '</a></li>';
			echo $page;
		}
		echo '</ul><ul>';
		foreach ( $typical_cats as $typical_cat ) {
			$cat = '<li><a href="' . get_category_link( $typical_cat->term_id ) . '"><span aria-hidden="true">&#x270E;</span> ';
			$cat .= $typical_cat->cat_name;
			$cat .= '<sup>'. $typical_cat->category_count .'</sup>';
			$cat .= '</a></li>';
			echo $cat;
		}
		echo '</ul></nav>';
	}
endif;

if ( !function_exists( 'typical_comment' ) ) :

/**
* Template for comments and pingbacks
*/
 
	function typical_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case '' :
		?>
		<article itemprop="comment" <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
			<figure>
				<?php echo get_avatar( $comment, 200 ); ?>
			</figure>
		<div itemprop="commentText">
				<h4>
					<?php printf( __( '%s', 'typical' ), sprintf( '%s', get_comment_author_link() ) );
					/* translators: 1: date, 2: time */
					?> 
					<time itemprop="commentTime" datetime="<?php comment_date( 'Y-m-d' ); ?>"><span aria-hidden="true">&#x274F;</span> 
							<?php printf( __( '%1$s', 'typical' ), get_comment_date( 'd M Y' )) ?>
					</time>
				</h4>
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<?php _e( '<p>Your comment is in the process of moderation.</p>', 'typical' ); ?>
			<?php endif; ?>
			<?php comment_text(); ?>
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div>
		<?php
			break;
			case 'pingback'  :
			case 'trackback' :
		?>
		<article <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
			<p itemprop="commentText"><?php _e( 'Pingback:', 'typical' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'typical' ), ' ' ); ?></p>
		<?php
			break;
		endswitch;
	}
endif;

/**
* Closes comments and pingbacks with </article> instead of </li>
*/

function typical_comment_close() {
	echo '</article>';
}

/**
* Adjusts the comment_form() input types for HTML5
*/

function typical_fields($fields) {
$commenter = wp_get_current_commenter();
$req = get_option( 'require_name_email' );
$aria_req = ( $req ? " aria-required='true'" : '' );
$fields =  array(
	'author' => '<p><label for="author">' . __( 'Name', 'typical' ) . '</label> ' . ( $req ? '<span>*</span>' : '' ) .
	'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
	'email'  => '<p><label for="email">' . __( 'Email', 'typical' ) . '</label> ' . ( $req ? '<span>*</span>' : '' ) .
	'<input id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
	'url'    => '<p><label for="url">' . __( 'Website', 'typical' ) . '</label>' .
	'<input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
);
return $fields;
}

add_filter( 'comment_form_default_fields','typical_fields' );

function typical_widgets_init() {

/**
* Register widgetized areas
*/

	register_sidebar( array(
		'name' => __( 'Primary Widget Area', 'typical' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The primary widget area', 'typical' ),
		'before_widget' => '<li>',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
}

// Register sidebars by running typical_widgets_init() on the widgets_init hook
add_action( 'widgets_init', 'typical_widgets_init' );
 
/**
* Removes the default styles that are packaged with the Recent Comments widget
*/

function typical_remove_recent_comments_style() {
	add_filter( 'show_recent_comments_widget_style', '__return_false' );
}
add_action( 'widgets_init', 'typical_remove_recent_comments_style' );

if ( ! function_exists( 'typical_posted_on' ) ) :

/**
* Prints HTML with meta information for the current post—date/time and author
*/

	function typical_posted_on() {
		printf( __( '<div>%2$s by %3$s', 'typical' ),
			'meta-prep meta-prep-author',
			sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time itemprop="datePublished" datetime="%3$s" pubdate><span aria-hidden="true">&#x274F;</span> %4$s</time></a>',
				get_permalink(),
				esc_attr( get_the_time() ),
				get_the_date('Y-m-d'),
				get_the_date()
			),
			sprintf( '<a href="%1$s" title="%2$s" rel="author" itemprop="author">%3$s</a>',
				get_author_posts_url( get_the_author_meta( 'ID' ) ),
				sprintf( esc_attr__( 'View all posts by %s', 'typical' ), get_the_author() ),
				get_the_author()
			)
		);
		
		/**
		* Adds Twitter and Instapaper links
		*/
		
		if ( is_single() ) {
		?>
			<div>
			<a rel="external" target="_blank" title="Post this article on Twitter" href="http://twitter.com/share?text=<?php the_title() ?>"><span aria-hidden="true">&#x275E;</span> <strong>Tweet this!</strong></a>
			
			<?php
			$theURL = get_permalink();
			$theTitle = get_the_title();
			$theTitle = urlencode($theTitle);
			?>
			<a rel="external" target="_blank" title="Save to read later with Instapaper.com" href="http://www.instapaper.com/hello2?url=<?php echo $theURL; ?>&title=<?php echo $theTitle; ?>"><span aria-hidden="true">&#x21B4;</span> <strong>Read later</strong></a>
			</div>
		<?php } ?>
		<div aria-hidden="true">&#x2014;</div>
		</div>
	<?php }
endif;

if ( ! function_exists( 'typical_author_posted_on' ) ) :

/**
* Prints basic author and published date info
*/

function typical_author_posted_on() {
	printf( __( '<div>Posted on %2$s', 'typical' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time itemprop="datePublished" datetime="%3$s" pubdate><span aria-hidden="true">&#x274F;</span> %4$s</time></a> <div aria-hidden="true">&#x2014;</div>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date( 'Y-m-d' ),
			get_the_date()
		)
	);
}
endif;

if ( ! function_exists( 'typical_posted_in' ) ) :

/**
* Prints HTML with meta information for the current post (category, tags and permalink)
*/

	function typical_posted_in() {
		// Retrieves tag list of current post, separated by commas.
		$tag_list = get_the_tag_list( '<span itemprop="keywords">', '<sup aria-hidden="true">&#x25C6;</sup></span><span itemprop="keywords">','<sup aria-hidden="true">&#x25C6;</sup></span>' );
		if ( $tag_list ) {
			$posted_in = __( 'This entry was posted in %1$s <span>%2$s</span>', 'typical' );
		} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
			$posted_in = __( 'This entry was posted in %1$s', 'typical' );
		} else {
			$posted_in = __( '', 'typical' );
		}
		// Prints the string, replacing the placeholders.
		printf(
			$posted_in,
			get_the_category_list( ', ' ),
			$tag_list,
			get_permalink(),
			the_title_attribute( 'echo=0' )
		);
	}
endif;

/**
* Place the itemprop="image" attribute on author images (belonging to Person schema)
*/

function change_avatar_css( $class ) {
$class = str_replace( 'class', 'itemprop="image" class', $class ) ;
return $class;
}

add_filter( 'get_avatar','change_avatar_css' );
 
/**
* Author info boxes using ARIA role="note"
*/

if ( ! function_exists( 'typical_author_info' ) ) : 
	function typical_author_info() { ?>
	<section role="note" itemscope itemtype="http://schema.org/Person">
		<h1>The author, <em>
							<a href="<?php the_author_meta( 'user_url' ); ?>" rel="author">
								<span itemprop="name"><?php the_author(); ?></span>
							</a>
						</em>
		</h1>
			<div>
				<figure>
					<?php 
					$authorAvatar = get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'typical_author_bio_avatar_size', 200 ) );
					echo $authorAvatar;  
					?>					
				</figure>
			</div>
			<div>
				<p itemprop="description"><?php the_author_meta( 'description' ); ?></p>
			</div>
			<footer>
				<p>
					<small>
						<a itemprop="url" href="<?php the_author_meta( 'user_url' ); ?>"><span aria-hidden="true">S</span> <i>The author's website</i></a> 
						<a href="<?php the_author_meta( 'twitter' ); ?>"><span aria-hidden="true">T</span> <i>The author's Twitter</i></a> 
						<a href="<?php the_author_meta( 'google' ); ?>" rel="me"><span aria-hidden="true">G</span> <i>The author's Google<sup>+</sup></i></a>
					</small>
				</p>
			</footer>
	</section>
	<?php 
	}
endif; 


/**
* HTML5 (<figure>) post thumbnails with caption support
*/
	
if ( ! function_exists( 'typical_post_thumb_figure' ) ) : 
	function typical_post_thumb_figure() { ?>	
	<figure>
		<?php the_post_thumbnail( 'Typical Thumbnail' ); ?>
		<figcaption>
			<?php echo get_post( get_post_thumbnail_id() )->post_excerpt ?>
		</figcaption>
	</figure>
	<?php 
	}
endif; 

if ( !function_exists( 'typical_pagination' ) ) : 

/**
* Posts pagination <nav> with inactive links faded out
*/

	function typical_pagination() {	?>
			<nav>
				<?php 
				if( get_previous_posts_link() ) {
					previous_posts_link( __( '<span aria-hidden="true">&#x2190;</span> Newer posts', 'typical' ) );
				} else { ?>
					<a rel="prev" href="#no"><span aria-hidden="true">&#x2190;</span> Newer posts</a>
				<?php } 
				if( get_next_posts_link() ) {
					next_posts_link( __( 'Older posts <span aria-hidden="true">&#x2192;</span>', 'typical' ) );
				} else { ?>
					<a rel="next" href="#no">Older posts <span aria-hidden="true">&#x2192;</span></a>
		  <?php } ?>
			</nav> 
		<?php 
	}
endif;

/**
* Add rel attributes to post links
*/ 

function previous_posts_link_css( $content ) {
	return 'rel="prev"';
}
add_filter( 'previous_posts_link_attributes', 'previous_posts_link_css' );

function next_posts_link_css( $content ) {
	return 'rel="next"';
}
add_filter( 'next_posts_link_attributes', 'next_posts_link_css' );

/**
* Load CDN jquery
*/

function load_external_jQuery() {  
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js' );
	wp_enqueue_script( 'jquery' );
}  
add_action( 'wp_enqueue_scripts', 'load_external_jQuery' );

/**
* Add required comment-reply script
*/

function theme_queue_js(){
if ( (!is_admin()) && is_singular() && comments_open() && get_option('thread_comments') )
  wp_enqueue_script( 'comment-reply' );
}
add_action( 'wp_print_scripts', 'theme_queue_js' );

/**
* Custom arrow glyphs in 'read more' links
*/

function typical_more($more) {
    global $post;
	return '&hellip; <a href="'. get_permalink($post->ID) . '" rel="bookmark" itemprop="url"> read more <span aria-hidden="true">&#x2192;</span></a>';
}
add_filter( 'excerpt_more', 'typical_more' );

/**
* Add Twitter and Google+ / remove others
*/

function my_new_contactmethods( $contactmethods ) {
	$contactmethods['twitter'] = 'Twitter';
	$contactmethods['google'] = 'Google+';
	unset($contactmethods['yim']);  
	unset($contactmethods['aim']);  
	unset($contactmethods['jabber']);
	return $contactmethods;
}
add_filter( 'user_contactmethods', 'my_new_contactmethods', 10, 1);

/**
* Add the Typical default avatar
*/

function typical_avatar( $avatar_defaults ) {
	$myavatar = get_stylesheet_directory_uri().'/images/avatar.png';
	$avatar_defaults[$myavatar] = 'Typical Resolution Independent Default';
	return $avatar_defaults;
}

add_filter( 'avatar_defaults', 'typical_avatar' );

/**
* Theme Options
* Don't edit beyond this point unless you're really confident
*/

add_action( 'admin_menu', 'setup_theme_admin_menus' );

function setup_theme_admin_menus() {  
   add_theme_page( 'Typical Theme Options', 'Theme Options', 'edit_theme_options', 'typical-theme-options', 'typical_theme_options_page' );
}

function typical_theme_options_page() {  
    if ( !current_user_can('manage_options') ) {  
		wp_die('<p>Sorry, my dear. You are not allowed to edit this particular page.</p>');  
	} ?>
	<div class="wrap">  
		<?php screen_icon( 'themes' ); ?> <h2>Theme Settings For Typical</h2>
		<p class="top-notice">Typical includes the following settings. To reconfigure the theme further, consult the functions.php file where the PHP form for setting these options is included.</p>
		<?php
		
		$fontface = get_option( 'font-face' );
		$introductoryTitle = get_option( 'introductory-title' );
		$introduction = get_option( 'introduction' );
		$logoImage = get_option( 'logo-image' );
		$footerText = get_option( 'footer-text' );
		$hideIcons = get_option( 'hide-icons' );
		$customFavicon = get_option( 'custom-favicon' );
		
		if ( isset($_POST["update_settings"]) ) {
			$fontface = $_POST["font-face"];
			$introductoryTitle = htmlspecialchars( $_POST["introductory-title"] );
			$introductoryTitle = trim( $introductoryTitle );
			$introduction = trim( $_POST["introduction"] );
			$logoImage = isset( $_POST["logo-image"]) ? $_POST["logo-image"] : null;
			$hideIcons = isset( $_POST["hide-icons"]) ? $_POST["hide-icons"] : null;
			$customFavicon = isset( $_POST["custom-favicon"]) ? $_POST["custom-favicon"] : null;
			
			$footerText = trim( $_POST["footer-text"] );
			$formErrors = array();
			
			$introduction = stripslashes( $introduction );
			$footerText = stripslashes( $footerText );
			
			if ( !empty($formErrors) ) {
				foreach($formErrors as $error) { ?>
					<div class="error below-h2">
						<p><?php echo $error; ?></p>
					</div>
			<?php
				}
			} else {
				if ( empty($introductoryTitle) ) {
					$introductoryTitle = 'Introduction';
				}
				
				update_option('font-face', $fontface);
				update_option('introductory-title', $introductoryTitle);
				update_option('introduction', $introduction);
				update_option('hide-icons', $hideIcons);
				update_option('custom-favicon', $customFavicon);
				update_option('footer-text', $footerText);
				update_option('logo-image', $logoImage);
			?>
				<div id="message" class="updated below-h2">
					<p>Typical Theme settings have been saved.</p>
				</div>				
			<?php
			}
		}		
		?>		
		<form method="POST" action="">  
			<table class="form-table">  
				<tr valign="top">  
					<th scope="row">  
						<label for="font-face">  
							Font family: 
						</label>   
					</th>  
					<td>  
						<select id="font-face" name="font-face">
							<option value="Averia+Serif+Libre" <?php if ( $fontface == 'Averia+Serif+Libre' ) {?>selected="selected"<?php } ?>>Averia Serif Libre</option>
							<option value="Vollkorn" <?php if ( $fontface == 'Vollkorn' ) {?>selected="selected"<?php } ?>>Vollkorn</option>
							<option value="Neuton" <?php if ( $fontface == 'Neuton' ) {?>selected="selected"<?php } ?>>Neuton</option>
							<option value="PT+Serif" <?php if ( $fontface == 'PT+Serif' ) {?>selected="selected"<?php } ?>>PT Serif</option>
							<option value="Cardo" <?php if ( $fontface == 'Cardo' ) {?>selected="selected"<?php } ?>>Cardo</option>
							<option value="Gentium+Book+Basic" <?php if ( $fontface == 'Gentium+Book+Basic' ) {?>selected="selected"<?php } ?>>Gentium Book Basic</option>
						</select>
						<span style="display:block" class="description">Each family includes 400, 400 italic and 700 faces and is served from Google Web Fonts.</span>
					</td>  
				</tr>
				<tr valign="top">  
					<th scope="row">  
						<label for="introductory-title">  
							Homepage introductory title: 
						</label>   
					</th>  
					<td>  
						<input type="text" maxlength="40" name="introductory-title" id="introductory-title" value="<?php echo $introductoryTitle; ?>" />
						<span style="display:block" class="description">Optional. Defaults to "Introduction" but does not display if "Homepage introduction" is not filled out below.</span>
					</td>  
				</tr>
				<tr valign="top">  
					<th scope="row">  
						<label for="introduction">  
							Homepage introduction: 
						</label>   
					</th>  
					<td>  
						<textarea id="introduction" name="introduction" style="width:300px"><?php echo $introduction; ?></textarea>
						<span style="display:block" class="description">Optional: Write some text to introduce your blog. HTML such as links permitted. Follows the introductory title set above.</span>
					</td>  
				</tr>
				<tr valign="top">  
					<th scope="row">  
						<label for="logo-image">  
							Use a logo image?
						</label>   
					</th>  
					<td>  
						<input type="checkbox" name="logo-image" id="logo-image" value="Yes" <?php if ( $logoImage != null ) { echo 'checked="checked"'; } ?> />
						<span style="display:block" class="description">Check if you wish to use an image / logo for your site title.<br/> The text version of the name will be accessibly hidden. <br/>You must place the image in the theme's <strong>images</strong> folder and name it <strong>custom-logo.png</strong>.</span>
					</td>
				</tr>
				<tr valign="top">  
					<th scope="row">  
						<label for="custom-favicon">  
							Use a custom favicon?
						</label>   
					</th>  
					<td>  
						<input type="checkbox" name="custom-favicon" id="custom-favicon" value="Yes" <?php if ( $customFavicon != null ) { echo 'checked="checked"'; } ?> />
						<span style="display:block" class="description">Should you wish to use a custom favicon, check this box and save the image as <strong>images/favicon.png</strong> in the theme folder, replacing the example file.</span>
					</td>
				</tr>
				<tr valign="top">  
					<th scope="row">  
						<label for="footer-text">  
							Custom footer text: 
						</label>   
					</th>  
					<td>  
						<textarea id="footer-text" name="footer-text" style="width:300px"><?php echo $footerText; ?></textarea>
						<span style="display:block" class="description">Optional: Replace the default "You have been reading [Sitename]" with some custom info. Links allowed.</span>
					</td>  
				</tr>
				<tr valign="top">  
					<th scope="row">  
						<label for="hide-icons">  
							Hide footer icons?
						</label>
					</th>  
					<td>  
						<input type="checkbox" name="hide-icons" id="hide-icons" value="Yes" <?php if ( $hideIcons != null ) { echo 'checked="checked"'; } ?> />
						<span style="display:block" class="description">Check to hide the Wordpress and Heydonworks (theme author) icons in your footer.</span>
					</td>  
				</tr>
				<tr>
					<td>
						<input type="hidden" name="update_settings" value="Y" />
					</td>
				</tr>
				<tr>
					<td>
						<input type="submit" value="Save settings" class="button-primary"/> 
					</td>
				</tr>
			</table>
		</form>
		<h2>Using Typical's shortcodes</h2>
		
		<p>Typical provides two shortcodes: One for making blockquotes and one for making HTML5 figures (for images only) in your posts. Below are two examples.</p>
		
		<p><strong>Blockquote</strong>:</p>
		
		<pre>
		
		&#x5b;blockquote quotation="Shortcodes are great!" author="Heydon Pickering" author_url="http://www.heydonworks.com"&#x5d;

		// Output:

		&lt;blockquote&gt;
		   &lt;p>Shortcodes are great!&lt;/p&gt;
		   &lt;footer&gt;
			  &lt;a href="http://www.heydonworks.com"&gt;Heydon Pickering&lt;/a&gt;
		   &lt;/footer&gt;
		&lt;/blockquote&gt;
		
		</pre>
		
		<p><strong>Figure</strong>:</p>
		
		<pre>
		
		&#x5b;image_figure image_url="http://www.heydonworks.com/images/portrait.jpg" alt="Portrait of The Theme Author" caption="The Theme Author, Heydon Pickering"&#x5d;

		// Output:

		&lt;figure&gt;
		   &lt;img src="http://www.heydonworks.com/images/portrait.jpg" alt="Portrait of The Theme Author"&gt;
		   &lt;figcaption&gt;The Theme Author, Heydon Pickering&lt;/figcaption&gt;
		&lt;/figure&gt;
		
		</pre>

		<h2>Credits</h2>
		
		<p>This theme was created by <a href="http://twitter.com/heydonworks">@heydonworks</a> (<a href="http://www.heydonworks.com">http://www.heydonworks.com</a>) for Wordpress.</p>
		
		<p>Some of the designs in Typical's icon font were adapted from Michelle Dixon's beautiful <a href="http://www.fontsquirrel.com/fonts/Printers-Ornaments-One">Printers Ornaments One</a> typeface.</p>
		
		<p>Typical incorporates <a href="http://profiles.wordpress.org/nacin/">Andrew Nacin</a>'s excellent <a href="http://wordpress.org/extend/plugins/simple-footnotes/">Simple Footnotes</a> plugin natively.</p>
		
	</div>
<?php } 
 
/**
* Footnotes support. Incorporates a modified version of nacin's Simple Footnotes plugin
* (http://wordpress.org/extend/plugins/simple-footnotes/)
*/

function load_footnote_support() {
	if ( !class_exists('nacin_footnotes') ) {
        /*
		 * Author: Andrew Nacin
		 * Author URI: http://andrewnacin.com/
		 */
		class nacin_footnotes {
				var $footnotes = array();
				var $option_name = 'simple_footnotes';
				var $db_version = 1;
				var $placement = 'content';
				function nacin_footnotes() {
						add_shortcode( 'ref', array( &$this, 'shortcode' ) );
						$this->options = get_option( 'simple_footnotes' );
						if ( ! empty( $this->options ) )
								$this->placement = $this->options['placement'];
						if ( 'page_links' == $this->placement )
								add_filter( 'wp_link_pages_args', array( &$this, 'wp_link_pages_args' ) );
						add_filter( 'the_content', array( &$this, 'the_content' ), 12 );
						if ( ! is_admin() )
								return;
						add_action( 'admin_init', array( &$this, 'admin_init' ) );
				}
				function admin_init() {
						if ( false === $this->options || ! isset( $this->options['db_version'] ) || $this->options['db_version'] < $this->db_version ) {
								if ( ! is_array( $this->options ) )
										$this->options = array();
								$current_db_version = isset( $this->options['db_version'] ) ? $this->options['db_version'] : 0;
								$this->upgrade( $current_db_version );
								$this->options['db_version'] = $this->db_version;
								update_option( $this->option_name, $this->options );
						}
						add_settings_field( 'simple_footnotes_placement', 'Footnotes placement', array( &$this, 'settings_field_cb' ), 'reading' );
						register_setting( 'reading', 'simple_footnotes', array( &$this, 'register_setting_cb' ) );
				}
				function register_setting_cb( $input ) {
						$output = array( 'db_version' => $this->db_version, 'placement' => 'content' );
						if ( ! empty( $input['placement'] ) && 'page_links' == $input['placement'] )
								$output['placement'] = 'page_links';
						return $output;
				}
				function settings_field_cb() {
						$fields = array(
								'content' => 'Below content',
								'page_links' => 'Below page links',
						);
						foreach ( $fields as $field => $label ) {
								echo '<label><input type="radio" name="simple_footnotes[placement]" value="' . $field . '"' . checked( $this->placement, $field, false ) . '> ' . $label . '</label><br/>';
						}
				}
				function upgrade( $current_db_version ) {
						if ( $current_db_version < 1 )
								$this->options['placement'] = 'content';
				}
				function shortcode( $atts, $content = null ) {
						global $id;
						if ( null === $content )
								return;
						if ( ! isset( $this->footnotes[$id] ) )
								$this->footnotes[$id] = array( 0 => false );
						$this->footnotes[$id][] = $content;
						$note = count( $this->footnotes[$id] ) - 1;
						return ' <sup><a class="simple-footnote" title="' . esc_attr( wp_strip_all_tags( $content ) ) . '" id="return-note-' . $id . '-' . $note . '" href="#note-' . $id . '-' . $note . '">' . $note . '</a></sup>';
				}
				function the_content( $content ) {
						if ( 'content' == $this->placement || ! $GLOBALS['multipage'] )
								return $this->footnotes( $content );
						return $content;
				}
				function wp_link_pages_args( $args ) {
						// if wp_link_pages appears both before and after the content,
						// $this->footnotes[$id] will be empty the first time through,
						// so it works, simple as that.
						$args['after'] = $this->footnotes( $args['after'] );
						return $args;
				}
				function footnotes( $content ) {
						global $id;
						if ( empty( $this->footnotes[$id] ) )
								return $content;
						$content .= '<div id="footnotes">';
						$content .= '<h4>Notes:</h4>';
						$content .= '<ol>';
						foreach ( array_filter( $this->footnotes[$id] ) as $num => $note )
								$content .= '<li id="note-' . $id . '-' . $num . '">' . do_shortcode( $note ) . ' <a href="#return-note-' . $id . '-' . $num . '">&#x2191;</a></li>';
						$content .= '</ol></div>';
						return $content;
				}
		}
		new nacin_footnotes();
			}
	}

add_action( 'after_setup_theme', 'load_footnote_support' );

/**
* Semantic shortcodes (figure and blockquote)
*/

// Example usage: [blockquote quotation="Shortcodes are great!" author="Heydon Pickering" author_url="http://www.heydonworks.com"]

function typical_blockquote( $atts ) {
	extract( shortcode_atts( array(
		'quotation' => 'I have nothing to say',
		'author' => 'John Doe',
		'quotation_url' => '#'
	), $atts ) );

	return '<blockquote><p>'.$quotation.'</p><footer><a href="'.$quotation_url.'">'.$author.'</a></footer></blockquote>';
}
add_shortcode( 'blockquote', 'typical_blockquote' );

// Example usage: [image_figure image_url="http://www.heydonworks.com/images/portrait.jpg" alt="Holding a black dog" caption="The Theme Designer pictured with their retired greyhound"]
function typical_image_figure( $atts ) {
	extract( shortcode_atts( array(
		'image_url' => '#',
		'alt' => 'The image',
		'caption' => 'An image (above)'
	), $atts ) );

	return '<figure><img src="'.$image_url.'" alt="'.$alt.'" /><figcaption>'.$caption.'</figcaption></figure>';
}

add_shortcode( 'image_figure', 'typical_image_figure' );

/**
* Required for theme validation (a default media width)
*/

if ( ! isset( $content_width ) ) $content_width = 900;