<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page" class="site">
	<header id="masthead" class="site-header" role="banner">
		<div class="menu-top-menu-container">
			<ul id="top-menu" class="menu">
				<li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item
					<?php echo (is_front_page() ? 'current_page_item' : ''); ?>
				">
					<a href="/">
						<i class="_mi dashicons dashicons-admin-home" aria-hidden="true"></i>
						<span class="visuallyhidden">Accueil</span>
					</a>
				</li>
				<li class="menu-item menu-item-type-post_type menu-item-object-page
					<?php echo (is_page('Équipes') ? 'current_page_item' : ''); ?>
				">
					<a href="/equipes">
						<i class="_mi dashicons dashicons-groups" aria-hidden="true"></i>
						<span class="visuallyhidden">Équipes</span></a>
					</li>
				<li class="menu-item menu-item-type-post_type menu-item-object-page
					<?php echo (is_page('Règles') ? 'current_page_item' : ''); ?>
				">
					<a href="/regles">
						<i class="_mi dashicons dashicons-format-aside" aria-hidden="true"></i>
						<span class="visuallyhidden">Règles</span>
					</a>
			</li>
			</ul>
		</div>
		<?php /*
			wp_nav_menu(array(
				'theme_location' => 'top',
				'menu_id' => 'top-menu',
			));
		*/ ?>

		<div class="header-border"></div>

		<h1>
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/logo.png" alt="Wynd" />
			<span>succès</span>
		</h1>

	</header><!-- #masthead -->

	<div class="site-content-contain">
		<div id="content" class="site-content">
