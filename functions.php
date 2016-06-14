<?php
/**
  * Add the CHILD_THEME_VERSION as a constant
  */

function ylai_add_constants( $constants ) {
  $ylai_constants = array(
    'CHILD_THEME_VERSION' => corona_get_theme_version( get_stylesheet_directory() . '/version.json' ),
  );

  $constants = array_merge( $ylai_constants, $constants );

  return $constants;
}

add_filter( 'corona_add_constants', 'ylai_add_constants' );




/**
  * Child theme custom image sizes
  */

function ylai_custom_image_sizes() {
  set_post_thumbnail_size( 720, 520, true);
  add_image_size( 'medium_large', 720, 520, true );
  add_image_size( 'medium_large_632', 632, 457, true );
  add_image_size( 'medium_large_300', 300, 217, true );
  add_image_size( 'home_thumb', 359, 269, true );
}

add_action( 'corona_init', 'ylai_custom_image_sizes' );




/**
  * Set appropriate srcset sizes
  *
  * @since 3.0.0
  */

function ylai_responsive_img_sizes( $attr, $attachment, $size ) {
  // For archive.php, home.php, search.php, etc
  if ( $size === 'medium_large' && ! is_single() ) {
    $attr['sizes'] = '(min-width: 48em) 300px, (min-width: 25em) 720px, 300px';
  }

  // For posts and pages
  if ( $size === 'medium_large' && is_single() ) {
    $attr['sizes'] = '(min-width: 75em) 720px , (min-width: 64em) 632px, (min-width: 25em) 720px, 300px';
  }

  return $attr;
}

add_filter( 'wp_get_attachment_image_attributes', 'ylai_responsive_img_sizes', 10, 3 );




/**
  * Add theme support for the `link` post format
  */

function ylai_link_post_format() {
  add_theme_support( 'post-formats',
    array(
      'image',
      'link',
      'video',
    )
  );
}

add_action( 'after_setup_theme', 'ylai_link_post_format' );




/**
  * Script and style enqueue
  */

function ylai_enqueue_scripts() {
    wp_enqueue_script( 'corona-js', get_template_directory_uri() . '/js/dist/script.js', array(), CORONA_THEME_VERSION, true );
    wp_enqueue_script( 'ylai-js', get_stylesheet_directory_uri() . '/js/dist/script.js', array(), CHILD_THEME_VERSION, true );
    wp_enqueue_script( 'addthis', 'https://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-571e80b3848f4add', array(), null, true );
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', array(), CORONA_THEME_VERSION, 'all' );
    wp_enqueue_style( 'parent-rtl-style', get_template_directory_uri() . '/rtl.css', array(), CORONA_THEME_VERSION, 'all' );
    wp_enqueue_style( 'ylai-style', get_stylesheet_directory_uri() . '/style.css', array(), CHILD_THEME_VERSION, 'all' );
    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Oxygen', array(), null, 'all' );
}

add_action( 'wp_enqueue_scripts', 'ylai_enqueue_scripts' );




/**
  * Add Google Tag Manager
  */

function ylai_google_tag_manager() {
  $gtm = "<!-- Google Tag Manager -->
<noscript><iframe src='//www.googletagmanager.com/ns.html?id=GTM-P4JRP8'
height='0' width='0' style='display:none;visibility:hidden'></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-P4JRP8');</script>
<!-- End Google Tag Manager -->";
  echo($gtm);
}

add_action( 'tha_body_top', 'ylai_google_tag_manager' );




/**
  * Remove publication date and author from posts
  */

function unhook_corona_posted_on() {
  remove_action( 'corona_posted_on', 'corona_posted_date_author' );
}

add_action( 'init', 'unhook_corona_posted_on' );




/**
  * Unhook Corona's default entry footer output
  */

function unhook_corona_entry_footer() {
  remove_action( 'corona_entry_footer', 'corona_entry_footer_output' );
}

add_action( 'init', 'unhook_corona_entry_footer' );




/**
  * Customize the output of `corona_entry_footer` for archive pages
  */

function ylai_archive_entry_footer() {
  if ( 'post' === get_post_type() && is_single() === false ) {
    $categories_list = get_the_category_list( esc_html__( ', ', 'corona' ) );
    $post_format = get_post_format();

		if ( $categories_list ) {
			printf( '<span class="cat-links">' . esc_html__( '%1$s', 'corona' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

    if ( $post_format ) {
      $url = trailingslashit( sprintf( '%s/type/%s', get_site_url(), $post_format ) );

      if ( $post_format === 'link' ) {
        printf( '<div class="format-links"><a href="%s">%s</a></div>', $url, __( 'External Resources', 'ylai' ) );
      } else {
        printf( '<div class="format-links"><a href="%s">%s</a></div>', $url, ucfirst( $post_format ) );
      }
    }
  }
}

add_action( 'corona_entry_footer', 'ylai_archive_entry_footer' );




/**
  * Customize the output of `corona_entry_footer` for posts
  */

function ylai_post_entry_footer() {
  if ( 'post' === get_post_type() && is_single() ) {
    $tags_list = get_the_tag_list( '', esc_html__( ', ', 'corona' ) );

    if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tags: %1$s', 'corona' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
  }
}

add_action( 'corona_entry_footer', 'ylai_post_entry_footer' );




/**
  * Remove 'Category: ', 'Tag: ', etc. from the title of pages that use `archive.php`
  */

function ylai_remove_archive_type( $title ) {
  if ( is_category() ) {
    $title = single_cat_title( '', false );
  } else if ( is_tag() ) {
    $title = single_tag_title( '', false );
  } else if ( is_author() ) {
    $title = get_the_author();
  } else if ( is_tax( 'post_format' ) ) {
    if ( is_tax( 'post_format', 'post-format-link' ) ) {
      $title = _x( 'External Resources' );
    }
  } else if ( is_post_type_archive() ) {
    $title = post_type_archive_title( '', false );
  }

  return $title;
}

add_filter( 'get_the_archive_title', 'ylai_remove_archive_type' );
