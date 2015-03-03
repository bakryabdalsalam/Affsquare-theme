<?php
/**
 * @package WordPress
 * @subpackage customtheme
 */
?><!DOCTYPE html>
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html <?php language_attributes(); ?> class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>
	<?php wp_title( '|', true, 'right' ); ?>
</title>

	<link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); echo '?' . filemtime( get_stylesheet_directory() . '/style.css'); ?>" type="text/css" media="screen, projection" />

	<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	
	<?php wp_head(); ?>
	</head>
	
	<body <?php body_class(); ?>>
		
	<div id="page" class="hfeed">
		<header id="branding" role="banner">
				<a href="<?php echo home_url();?>"><img id="logo" src="<?php echo get_template_directory_uri(); ?>/images/yourlogo.jpg"/></a>
				<nav id="access" role="article">
					<div class="skip-link visuallyhidden">
						<a href="#content" title="<?php esc_attr_e( 'Skip to content', 'themename' ); ?>"><?php _e( 'Skip to content', 'themename' ); ?></a>
					</div>
					<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
				</nav><!-- #access -->
		</header><!-- #branding -->
		<div id="main">
