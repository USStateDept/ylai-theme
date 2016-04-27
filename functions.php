<?php

/**
  * Script and style enqueue
  */
function ylai_enqueue_scripts() {
    wp_enqueue_script( 'corona-js', get_template_directory_uri() . '/js/dist/script.js', array(), '', true );
    wp_enqueue_script( 'ylai-js', get_stylesheet_directory_uri() . '/js/dist/script.js', array(), '', true );
    wp_enqueue_script( 'addthis', 'https://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-571e80b3848f4add', array(), '', true );
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'parent-rtl-style', get_template_directory_uri() . '/rtl.css' );
    wp_enqueue_style( 'ylai-style', get_stylesheet_directory_uri() . '/style.css' );
    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Oxygen' );
}
add_action( 'wp_enqueue_scripts', 'ylai_enqueue_scripts' );


/**
  * Child theme custom image sizes
  */
set_post_thumbnail_size( 720, 540, TRUE);


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
add_action( 'google_tag_manager', 'ylai_google_tag_manager' );


/**
  * Remove publication date and author from posts
  */
function unhook_corona_posted_on() {
  remove_action( 'corona_posted_on', 'corona_posted_date_author' );
}
add_action( 'init', 'unhook_corona_posted_on' );
