<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Strapped
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'strapped' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<nav id="navbar-main" role="navigation">
			<div class="navbar navbar-inverse navbar-static-top">
				<div class="container">
				<!-- .navbar-toggle is used as the toggle for collapse navbar content -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<?php strapped_the_custom_logo(); ?>						
					</div>
					<div class="navbar-collapse collapse navbar-responsive-collapse">

						<?php 
							$args = array(
								'theme_location'=> 'primary',
								'depth' 		=> 2,
								'container'		=> false,
								'menu_class'	=> 'nav navbar-nav navbar-right',
								'walker'		=> new Bootstrap_Walker_Nav_Menu()
							);
							if ( has_nav_menu('primary')) {
								wp_nav_menu($args);
							}
						?>

					</div>
				</div>
			</div>
		</nav>
	</header><!-- #masthead -->
	<div class="container">
	<div id="content" class="site-content">
