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
  set_post_thumbnail_size( 720, 540, TRUE);
  add_image_size( 'medium_large', 720, 540, TRUE );
}

add_action( 'corona_init', 'ylai_custom_image_sizes' );




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
      
      printf( '<div class="format-links"><a href="%s">%s</a></div>', $url, ucfirst( $post_format ) );
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
