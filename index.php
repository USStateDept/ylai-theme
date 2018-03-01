<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package corona
 */

get_header(); ?>

	<div class="content-sidebar-wrap">

		<?php tha_content_before(); ?>
		<main id="main" class="content" role="main"><!-- post loop -->
		<?php tha_content_top(); ?>

		<?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) : ?>
				<header class="page-header">
					<h1 class="entry-title"><?php echo get_the_title( get_option( 'page_for_posts' ) ); ?></h1>
				</header>

			<?php
			endif;

			tha_content_while_before();

			corona_loop( 'template-parts/content', 'search_archive' );

			tha_content_while_after();

			?>

			<div class="posts-pagination">
				<?php
				previous_posts_link();
				next_posts_link();
				?>
			</div>
			
		<?php
		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		<?php tha_content_bottom(); ?>
		</main><!-- #main -->
		<?php tha_content_after(); ?>

<?php
get_sidebar();
get_footer();
