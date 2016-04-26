<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package corona
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php
	if ( function_exists ( 'google_tag_manager' ) ) {
		 google_tag_manager();
	}?>

<div class="site-container">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'corona' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<?php if ( get_header_image() ) : ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<img src="https://ylai.state.gov/wp-content/uploads/sites/2/2016/04/cropped-YLAI_Logo_new_header-1.jpg" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
			</a>
		<?php endif; // End header image check. ?>
		<div class="title-area">
			<?php
			if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else :
				// this was a <p> for pages that are not either home or front pages.  Changed to be the same on all until we can decide what we want to do
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php
			endif;

			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
				<h2 class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></h2>
			<?php
			endif; ?>
		</div><!-- .title-area -->

		<?php
			// only show if widgets are assigned to it
			if( is_active_sidebar( 'header-right') ) {
				dynamic_sidebar( 'header-right' );
			}
		?><!-- .header right widget area -->

	</header><!-- #masthead -->

	<div class="menu-toggle" aria-controls="menu-primary" aria-expanded="false">
		<div class="hamburger">
      <span class="line"></span>
      <span class="line"></span>
      <span class="line"></span>
    </div>
	</div>
	<nav id="site-navigation" class="nav-primary" role="navigation">
		<?php
 			$args = array(
 				'theme_location'	=> 'primary',
 				'menu_id'			=> 'menu-primary',
 				'menu_class'		=> 'menu nav-menu menu-primary',
 				'container_class' 	=> 'wrap',
 				'fallback_cb'    	=> ''
 			);
			wp_nav_menu( $args );
		?>
    </nav><!-- .nav-primary-->

		<?php
			if ( has_nav_menu( 'secondary' ) ) {
		    $html = '<nav class="nav-secondary" role="navigation">';
		 			$args = array(
		 				'theme_location'	=> 'secondary',
		 				'menu_id'			=> 'menu-secondary',
		 				'menu_class'		=> 'menu nav-menu menu-secondary',
		 				'container_class' 	=> 'wrap',
		 				'fallback_cb'    	=> ''

		 			);
					wp_nav_menu( $args );
		  	$html .= '</nav><!-- .nav-secondary-->';
				return $html;
			}
		?>

	<div id="content" class="site-inner">
