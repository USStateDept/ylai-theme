<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package corona
 */

get_header(); ?>

	<div class="content-sidebar-wrap">

		<?php tha_content_before(); ?>
		<main id="main" class="content" role="main"><!-- post loop -->
		<?php tha_content_top(); ?>

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( esc_html__( 'Search results for: "%s"', 'corona' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .page-header -->

			<?php
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
