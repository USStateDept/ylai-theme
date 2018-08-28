<?php
/**
 * The template for displaying archive pages.
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
		if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="entry-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php

				tha_content_while_before();

				corona_loop( 'template-parts/content', 'search_archive' );

				tha_content_while_after();

				tha_content_bottom();
			
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

			tha_content_bottom();

		endif; ?>

		</main><!-- #main -->
		<?php tha_content_after(); ?>

<?php
get_sidebar();
get_footer();
