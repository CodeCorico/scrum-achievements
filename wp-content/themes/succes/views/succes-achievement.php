<?php

function succes_post_thumbnail_html( $html, $post_id ) {
  if (get_post_type( $post_id ) != 'succes') {
    return $html;
  }

  $image = '';
  $reward = '';

  if (badgeos_get_user_achievements( array( 'achievement_id' => absint( $post_id ) ) )) {
    $image = get_field('success_win_image');

    if (is_single()) {
      $reward = get_field('success_reward_file');
      $reward = '<a class="succes-reward" href="' . $reward['url'] . '" target="_blank"><i class="dashicons dashicons-download"></i></a>';
    }
  }
  else {
    $image = get_field('success_default_image');
  }

  $image = '<img class="badgeos-item-thumbnail" src="' . $image['url'] . '" alt="' . $image['alt'] . '" />';

  $html = $image . $reward;

  return $html;
}

add_action( 'post_thumbnail_html', 'succes_post_thumbnail_html', 10, 2 );

function succes_submissions( $content = '' ) {
	global $post;

	if ( !is_single() ) {
		return $content;
	}

	$post_type = get_post_type( $post );
	$achievement = get_page_by_title( $post_type, 'OBJECT', 'achievement-type' );
	if ( !$achievement ) {
		global $wp_post_types;

		$labels = array( 'name', 'singular_name' );
		// check for other variations
		foreach ( $labels as $label ) {
			$achievement = get_page_by_title( $wp_post_types[$post_type]->labels->$label, 'OBJECT', 'achievement-type' );
			if ( $achievement ) {
				break;
			}
		}
	}

	if ( !$achievement ) {
		return $content;
	}

	$content .= badgeos_display_submissions(array(
		'limit' => 10,
		'status' => 'pending',
		'show_filter' => 'false',
		'show_search' => 'false',
		'show_attachments' => 'true',
		'show_comments' => 'true',
	));

	return $content;
}

add_filter( 'the_content', 'succes_submissions' );
