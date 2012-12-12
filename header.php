<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section
 *
 * @package WordPress
 * @subpackage Typical
 */
?>
<!DOCTYPE html>
<!--[if IE 7]>     <html class="ie ie7 lt-ie8 lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>     <html class="ie ie8 lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]>     <html class="ie ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]>  <html <?php language_attributes(); ?>> <![endif]-->
<!--[if !IE]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
 
    global $page, $paged;
 
    wp_title( '|', true, 'right' );
 
    bloginfo( 'name' );
 
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
        echo " | $site_description";
?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<?php 

// Set up Google font family and call resources

$fontfamily = get_option( 'font-face' );
if ( $fontfamily != null ) { ?>
	<link href='http://fonts.googleapis.com/css?family=<?php echo $fontfamily ?>:400,700,400italic' rel='stylesheet' type='text/css'>
	<style type="text/css">
		body {
			font-family: '<?php echo str_replace( '+', ' ', $fontfamily ) ?>', serif !important;
		}
	</style>
<?php 
} else { 
?>
	<link href="http://fonts.googleapis.com/css?family=Averia+Serif+Libre:400,700,400italic" rel="stylesheet" type="text/css">
<?php 
} ?>

<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
 <!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/selectivizr-min.js"></script>
 <![endif]-->
<?php wp_head(); ?>
</head>
 
<body <?php body_class(); ?>>
	<header role="banner">
		<?php
			$logo = get_option('logo-image');
			
			if ( $logo != null ) { ?>
				<hgroup>
					<h1 class="with-image"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><span><?php bloginfo( 'name' ); ?></span><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/custom-logo.png" alt="" /></a></h1>
					<h2><?php bloginfo( 'description' ); ?></h2>
				</hgroup>
			<?php } else { ?>
				<hgroup>
					<h1><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<h2><?php bloginfo( 'description' ); ?></h2>
				</hgroup>			
			<?php } ?>
			<?php wp_nav_menu( array( 'container' => 'nav', 'fallback_cb' => 'typical_menu', 'theme_location' => 'primary' ) ); ?>
		<div></div>
	</header>
	<div>