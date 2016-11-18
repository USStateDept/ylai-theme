<?php

/**
 * Require badge generation class
 */
include( get_stylesheet_directory() . '/badge/class-america-badge-generation.php');

/**
  * Add the CHILD_THEME_VERSION as a constant
  *
  * @param $constants Array - An array of constants from Corona
  *
  * @since 2.0.0
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
  *
  * @since 2.0.0
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
  * Add theme support for the following post formats
  *
  * @since 2.1.0
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
  * Custom post_format custom slugs. Primarily used by `link`
  *
  * @since 3.0.0
  */

function ylai_post_format_slugs() {
  $slugs = array(
    'image' => 'image',
    'link' =>  'external-resources',
    'video' => 'video',
  );

  return $slugs;
}




/**
  * A rewrite of `_post_format_link` that rewrites the post_format slug using `ylai_post_format_slugs`
  *
  * @param $termlink String - The term url
  * @param $term Object - The term object
  * @param $taxonomy string - The taxonomy slug
  *
  * @see https://developer.wordpress.org/reference/functions/_post_format_link/
  * @see http://justintadlock.com/archives/2012/09/11/custom-post-format-urls
  */

function ylai_post_format_link( $termlink, $term, $taxonomy ) {
  global $wp_rewrite;

  if ( 'post_format' !== $taxonomy ) {
    return $termlink;
  }

  $slugs = ylai_post_format_slugs();

  // Get the last part of the slug, e.g. `link` or `video`
  $slug = str_replace( 'post-format-', '', $term->slug );

  if ( $wp_rewrite->get_extra_permastruct( $taxonomy ) ) {
    $termlink = str_replace( "/{$term->slug}", '/' . $slugs[$slug], $termlink );
  } else {
    $termlink = add_query_arg( 'post_format', str_replace( 'post_format', '', $slugs[$slug] ), remove_query_arg( 'post_format', $termlink ) );
  }

  return $termlink;
}

remove_filter( 'term_link', '_post_format_link', 10 );
add_filter( 'term_link', 'ylai_post_format_link', 10, 3 );




/**
  * Matches the queried post_format slug, e.g. `external-resources` that that which is in the DB,
  * i.e. `link` in the `external-resources` example.
  *
  * @param $qvs Array
  *
  * @see https://developer.wordpress.org/reference/functions/_post_format_request/
  * @see http://justintadlock.com/archives/2012/09/11/custom-post-format-urls
  */

function ylai_post_format_request( $qvs ) {
  if ( ! isset( $qvs['post_format'] ) ) {
    return $qvs;
  }

  // We have to flip the array, so that `external-resources` becomes the key instead of `link`
  $slugs = array_flip( ylai_post_format_slugs() );

  if ( isset( $slugs[ $qvs['post_format'] ] ) ) {
    $qvs['post_format'] = 'post-format-' . $slugs[ $qvs['post_format'] ];
  }

  $tax = get_taxonomy( 'post_format' );

  if ( ! is_admin() ) {
    $qvs['post_type'] = $tax->object_type;
  }

  return $qvs;
}

remove_filter( 'request', '_post_format_request' );
add_filter( 'request', 'ylai_post_format_request' );




/**
  * Script and style enqueue
  *
  * @since 1.0.0
  */

function ylai_enqueue_scripts() {
    wp_enqueue_script( 'corona-js', get_template_directory_uri() . '/js/dist/script.js', array(), CORONA_THEME_VERSION, true );
    wp_enqueue_script( 'ylai-js', get_stylesheet_directory_uri() . '/js/dist/script.js', array(), CHILD_THEME_VERSION, true );
    wp_enqueue_script( 'addthis', 'https://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-571e80b3848f4add', array(), null, true );
    wp_enqueue_script( 'screendoor', '//d3q1ytufopwvkq.cloudfront.net/0/formrenderer.js', array(), null, false );
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', array(), CORONA_THEME_VERSION, 'all' );
    wp_enqueue_style( 'parent-rtl-style', get_template_directory_uri() . '/rtl.css', array(), CORONA_THEME_VERSION, 'all' );
    wp_enqueue_style( 'ylai-style', get_stylesheet_directory_uri() . '/style.css', array(), CHILD_THEME_VERSION, 'all' );
    wp_enqueue_style( 'screendoor-style', '//d3q1ytufopwvkq.cloudfront.net/0/formrenderer.css', array(), null, 'all' );
    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Oxygen', array(), null, 'all' );
}

add_action( 'wp_enqueue_scripts', 'ylai_enqueue_scripts' );




/**
  * Add Google Tag Manager
  *
  * @since 1.0.0
  */

function ylai_google_tag_manager() {
  if ( function_exists( 'gtm4wp_the_gtm_tag' ) ) {
    gtm4wp_the_gtm_tag();
  }
}

add_action( 'tha_body_top', 'ylai_google_tag_manager' );




/**
  * Add Twitter widget js to template
  */

function ylai_add_twitter_widget() {
  echo '<script>window.twttr = (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0],
      t = window.twttr || {};
    if (d.getElementById(id)) return t;
    js = d.createElement(s);
    js.id = id;
    js.src = "https://platform.twitter.com/widgets.js";
    fjs.parentNode.insertBefore(js, fjs);

    t._e = [];
    t.ready = function(f) {
      t._e.push(f);
    };

    return t;
  } (document, "script", "twitter-wjs"));</script>';
}

add_action( 'wp_head', 'ylai_add_twitter_widget' );



/**
  * Remove publication date and author from posts
  *
  * @since 1.1.0
  */

function unhook_corona_posted_on() {
  remove_action( 'corona_posted_on', 'corona_posted_date_author' );
}

add_action( 'init', 'unhook_corona_posted_on' );




/**
  * Unhook Corona's default entry footer output
  *
  * @since 3.0.0
  */

function unhook_corona_entry_footer() {
  remove_action( 'corona_entry_footer', 'corona_entry_footer_output' );
}

add_action( 'init', 'unhook_corona_entry_footer' );




/**
  * Customize the output of `corona_entry_footer` for archive pages
  *
  * @since 3.0.0
  */

function ylai_archive_entry_footer() {
  if ( 'post' === get_post_type() && is_single() === false ) {
    $categories_list = get_the_category_list( esc_html__( ', ', 'corona' ) );
    $post_format = get_post_format();

		if ( $categories_list ) {
			printf( '<span class="cat-links">' . esc_html__( '%1$s', 'corona' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

    if ( $post_format ) {
      $slugs = ylai_post_format_slugs();

      $url = trailingslashit( sprintf( '%s/type/%s', get_site_url(), $slugs[$post_format]) );

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
  *
  * @since 3.0.0
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
  *
  * @since 3.0.0
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
      $title = _x( 'External Resources', 'ylai' );
    }
  } else if ( is_post_type_archive() ) {
    $title = post_type_archive_title( '', false );
  }

  return $title;
}

add_filter( 'get_the_archive_title', 'ylai_remove_archive_type' );


/**
  * Screendoor form shortcode
  */

function ylai_screendoor_form( $args ) {
  $a = shortcode_atts( array(
    'id' => '',
    'button_class' => 'button'
  ), $args );

  $html = '<form data-formrenderer>This form requires JavaScript to complete.</form>';
  $html .= '<script>FormRenderer.BUTTON_CLASS = "' . $a['button_class'] . '";new FormRenderer({"project_id":"' . $a['id'] . '"});</script>';

  return $html;
}

add_shortcode( 'screendoor', 'ylai_screendoor_form' );


/**
  * Send token data for Course
  */

function create_nonce() {
  $requiredplugin = 'wp-simple-nonce/wp-simple-nonce.php';
  if ( is_plugin_active($requiredplugin) ) {
    global $post;

    if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'course' ) ) {
      $myNonce = WPSimpleNonce::createNonce('certificate', 2592000);
      wp_localize_script( 'ylai-js', 'token', $myNonce );
    }
  }
}

add_action('wp_enqueue_scripts', 'create_nonce');

/**
 * Add attachment using the Formidable 'frm_notification_attachment' hook
 *
 * @since 2.5.0
 */
function ylai_add_attachment( $attachments, $form, $args ) {
	if ( $form->form_key == 'get_certificate2' ) {

		$params = array (
			'key'				=>  $form->form_key,				// form identifier (i.e. project id used to find config)
			'metas'			=>  $args['entry']->metas		// formidable metas passed in via $args that hold field values
		);

		$generator = new America_Badge_Generation ();
    $attachments[] =  $generator->create_image( $params );
 }
  return $attachments;
}

// Formidable email hooks that enables adding attachments
add_filter( 'frm_notification_attachment', 'ylai_add_attachment', 10, 3 );

/*
  Allow multiple consecutive submissions during image testing
  add_filter( 'frm_time_to_check_duplicates', '__return_false' );
 */

add_filter( 'frm_time_to_check_duplicates', '__return_false' );
