<?php

function succes_enqueue_styles() {
  wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
  wp_enqueue_style( 'succes-font', 'https://fonts.googleapis.com/css?family=Lato:300,400,700' );
  wp_enqueue_style( 'succes-style', get_stylesheet_directory_uri() . '/assets/succes-style.css' );
}

add_action( 'wp_enqueue_scripts', 'succes_enqueue_styles' );
