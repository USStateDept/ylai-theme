<?php
/*
 * Template Name: No Featured Image
 * Template Post Type: post
 */

get_header(); ?>

	<div class="content-sidebar-wrap">

		<?php tha_content_before(); ?>
		<main id="main" class="content" role="main"><!-- post loop -->
		<?php tha_content_top(); ?>

    <?php if ( is_active_sidebar( 'before-entry' ) ) : ?>
      <div class="before-entry">
		    <?php dynamic_sidebar( 'before-entry' ); ?>
      </div>
    <?php endif; ?>

			<?php
			tha_content_while_before();

			corona_loop( 'template-parts/content', get_post_format(), $comments = true );

			tha_content_while_after();
			?>

    <?php if ( is_active_sidebar( 'after-entry' ) ) : ?>
      <div class="after-entry">
		    <?php dynamic_sidebar( 'after-entry' ); ?>
      </div>
    <?php endif; ?>

		<?php tha_content_bottom(); ?>
		</main><!-- #main -->
		<?php tha_content_after(); ?>

<?php
get_sidebar();
get_footer();
