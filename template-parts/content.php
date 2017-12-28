<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package corona
 */
?>

<?php tha_entry_before(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry'); ?>>

	<?php tha_entry_top(); ?>

	<header class="entry-header">
		<?php
			if ( is_single() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}
		?>
	</header><!-- .entry-header -->

	<?php tha_entry_content_before(); ?>

	<div class="entry-content">
    <?php
      if ( has_post_thumbnail() && is_page_template('single-no-image.php') === false) {
        $html = '<figure>';
          $role = empty( $instance['show_title'] ) ? '' : 'aria-hidden="true"';
          $image = get_the_post_thumbnail( $post, 'medium_large' );
          $html .= $image;

          $html .= '<figcaption>';
            $html .= get_post( get_post_thumbnail_id() ) -> post_excerpt;
          $html .= '</figcaption>';
        $html .= '</figure>';

        echo $html;
      }
    ?>
		<?php
		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php corona_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>

		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'corona' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'corona' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php tha_entry_content_after(); ?>

	<footer class="entry-footer">
		<?php corona_entry_footer(); ?>
	</footer><!-- .entry-footer -->

	<?php tha_entry_bottom(); ?>

</article><!-- #post-## -->

<?php tha_entry_after(); ?>
