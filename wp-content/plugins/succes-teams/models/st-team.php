<?php

function st_custom_post() {
	$labels = array(
		'name' => _x( 'Équipes', 'Post Type General Name'),
		'singular_name' => _x( 'Équipe', 'Post Type Singular Name'),
		'menu_name' => __( 'Équipes'),
		'all_items' => __( 'Toutes les équipes'),
		'view_item' => __( 'Voir les équipes'),
		'add_new_item' => __( 'Ajouter une nouvelle équipe'),
		'add_new' => __( 'Ajouter'),
		'edit_item' => __( 'Editer l\'équipe'),
		'update_item' => __( 'Modifier l\'équipe'),
		'search_items' => __( 'Rechercher l\'équipe'),
		'not_found' => __( 'Non trouvée'),
		'not_found_in_trash' => __( 'Non trouvée dans la corbeille'),
	);

	$args = array(
		'label' => __( 'Équipes'),
		'description' => __( 'Tous sur les équipes'),
		'labels' => $labels,
		'supports' => array( 'thumbnail', 'title', 'editor', 'author', 'revisions' ),
		'hierarchical' => false,
		'public' => true,
		'has_archive' => false,
    'rewrite' => array( 'slug' => 'teams' ),
    'menu_icon' => 'dashicons-groups',
	);

	register_post_type( 'team', $args );
}

add_action( 'init', 'st_custom_post', 0 );