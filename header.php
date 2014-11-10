<!doctype html>
<!--[if lt IE 7 ]> <html class="ie ie6 ie-lt10 ie-lt9 ie-lt8 ie-lt7 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 ie-lt10 ie-lt9 ie-lt8 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 ie-lt10 ie-lt9 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 ie-lt10 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
<!-- the "no-js" class is for Modernizr. --> 

<head id="<?php echo of_get_option('meta_headid'); ?>" data-template-set="xmtn-web-generated">
<?php
			
			$id = get_the_ID();
			$title = get_the_title($id);
			$url = get_permalink($id);
			$text = get_excerpt_by_id($id);
			if($text == '') {
				$text = get_bloginfo ( 'description' );
			}
			if(is_home() || is_front_page()) {
				echo '<meta property="og:title" content="'.get_bloginfo('name').' | ' . get_bloginfo('description')  . '" >';
				echo '<meta property="og:description" content="' .of_get_option("meta_app_fb_description").'" >';
				echo '<meta property="og:url" content="' .home_url(). '" >';				
			} else {
				echo '<meta property="og:title" content="'.get_bloginfo('name').' | ' . $title  . '" >';
				echo '<meta property="og:url" content="' . $url . '" >';
				if(is_attachment()){
					$konten = get_post( $id); 
					echo '<meta property="og:description" content="' .$konten->post_excerpt.'" >';
				} else {
					echo '<meta property="og:description" content="' . $text . '" >';
				}
			}
			echo '<meta property="og:type" content="article" />';		
			if(has_post_thumbnail($id)) {
				$image = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'full');
				echo '<meta property="og:image" content="' .$image[0] . '" >';	
			} else if(is_attachment()){
				$image = wp_get_attachment_image_src( $id, 'full');
				echo '<meta property="og:image" content="' .$image[0] . '" >';	
			} else {
				echo '<meta property="og:image" content="' . of_get_option("meta_app_fb_image") . '" >';
			}
			echo '<meta property="article:author" content="'.of_get_option("meta_app_fb_url") .'" />';
			echo '<meta property="article:publisher" content="'.home_url().'" />';
		
		// Windows 8
		if (true == of_get_option('meta_app_win_name')) {
			echo '<meta name="application-name" content="' . of_get_option("meta_app_win_name") . '" /> ';
			echo '<meta name="msapplication-TileColor" content="' . of_get_option("meta_app_win_color") . '" /> ';
			echo '<meta name="msapplication-TileImage" content="' . of_get_option("meta_app_win_image") . '" />';
		}
		// Twitter
		if(is_attachment()){
			echo '<meta name="twitter:card" content="photo" />';
			echo '<meta name="twitter:site" content="' . of_get_option("meta_app_twt_site") . '" />';
			echo '<meta name="twitter:title" content="' . $title . '">';
			echo '<meta name="twitter:description" content="' . $text. '" />';
			echo '<meta name="twitter:url" content="' . $url. '" />';
			echo '<meta name="twitter:image:src" content="'.$image[0].'">';
		} else {
			echo '<meta name="twitter:card" content="' . of_get_option("meta_app_twt_card") . '" />';
			echo '<meta name="twitter:site" content="' . of_get_option("meta_app_twt_site") . '" />';
			if(is_home() || is_front_page()) {
				echo '<meta name="twitter:title" content="' . of_get_option("meta_app_twt_title") . '">';
				echo '<meta name="twitter:description" content="' . of_get_option("meta_app_twt_description") . '" />';
				echo '<meta name="twitter:url" content="' .home_url(). '" />';
				echo '<meta name="twitter:image:src" content="'.of_get_option("meta_app_fb_image").'">';
			} else {
				echo '<meta name="twitter:title" content="' . $title . '">';
				echo '<meta name="twitter:description" content="' . $text. '" />';
				echo '<meta name="twitter:url" content="' . $url. '" />';
				echo '<meta name="twitter:image:src" content="'.$image[0].'">';
			}
		}
			
	?>
	<meta charset="<?php bloginfo('charset'); ?>">	
	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
	<!--[if IE ]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<![endif]-->
	<?php
		if (is_search())
			echo '<meta name="robots" content="noindex, nofollow" />';
	?>
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<meta name="title" content="<?php wp_title( '|', true, 'right' ); ?>">
	<meta name="description" content="<?php bloginfo('description'); ?>" />
	<?php
		if (true == of_get_option('meta_author'))
			echo '<meta name="author" content="' . of_get_option("meta_author") . '" />';

		if (true == of_get_option('meta_google'))
			echo '<meta name="google-site-verification" content="' . of_get_option("meta_google") . '" />';
	?>
	<meta name="Copyright" content="Copyright &copy; <?php bloginfo('name'); ?> <?php echo date('Y'); ?>. All Rights Reserved.">
	<?php
		if (true == of_get_option('meta_viewport'))
			echo '<meta name="viewport" content="' . of_get_option("meta_viewport") . '" />';
	
		if (true == of_get_option('head_favicon')) {
			echo '<meta name="mobile-web-app-capable" content="yes">';
			echo '<link rel="shortcut icon" sizes="1024x1024" href="' . of_get_option("head_favicon") . '" />';
		}

		if (true == of_get_option('head_apple_touch_icon'))
			echo '<link rel="apple-touch-icon" href="' . of_get_option("head_apple_touch_icon") . '">';
	?>
	<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" />
	<script src="<?php echo get_stylesheet_directory_uri(); ?>/_/js/prefixfree.min.js"></script>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_head(); ?>
	
</head>

<body <?php body_class(); ?>>
	<div id="wrapper">

		<header id="header" role="banner">
			<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<div class="description"><?php bloginfo( 'description' ); ?></div>
			<?php if (get_header_image() != '') {?>
				<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />			
			<?php }?>

		</header>
		
		<nav id="nav" role="navigation">
			<?php wp_nav_menu( array('menu' => 'primary') ); ?>
		</nav>