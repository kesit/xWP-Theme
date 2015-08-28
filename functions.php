<?php
if ( ! isset( $content_width ) ) {
	$content_width = 600;
}
		
	// Options Framework (https://github.com/devinsays/options-framework-plugin)
	if ( !function_exists( 'optionsframework_init' ) ) {
		define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/_/inc/' );
		require_once dirname( __FILE__ ) . '/_/inc/options-framework.php';
	}

	// Theme Setup (based on twentythirteen: http://make.wordpress.org/core/tag/twentythirteen/)
	function xWP_setup() {
		load_theme_textdomain( 'html5reset', get_template_directory() . '/languages' );
		add_theme_support( 'automatic-feed-links' );	
		register_nav_menu( 'primary', __( 'Navigation Menu', 'html5reset' ) );
		add_theme_support('post-thumbnails');
		add_theme_support('custom-background');
		add_theme_support('custom-header');
		add_editor_style( 'custom-editor-style.css' );
	}
	add_action( 'after_setup_theme', 'xWP_setup' );
	

	function print_webfont() {
		if ( wp_script_is( 'jquery', 'done' ) ) {
			?>
			<script type="text/javascript">
				WebFontConfig={google:{families:['Roboto:400,400italic,300,700,700italic,300italic:latin']}};(function(){var wf=document.createElement('script');wf.src=('https:'==document.location.protocol?'https':'http')+'://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';wf.type='text/javascript';wf.async='true';var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(wf,s);})();
			</script>
		<?php
		}
	}
	add_action( 'wp_footer', 'print_webfont' );

	
/* -------- WP Header Stuff

xWP_wp_title: Title of Pages setup
removeHeadLinks: Clean head section from rsd link and wlwmanifest link
xWP_scripts_styles: Header scripts and style queue

-------------------------------------------------*/
	function xWP_wp_title( $title, $sep ) {
		global $paged, $page;
	
		if ( is_feed() )
			return $title;
	
		$site_description = get_bloginfo( 'description', 'display' );
		$title .= get_bloginfo( 'name' ).': '.$site_description;		
	
		if ( $paged >= 2 || $page >= 2 )
			$title = "$title $sep " . sprintf( __( 'Page %s', 'html5reset' ), max( $paged, $page ) );
		
		return $title;
	}
	add_filter( 'wp_title', 'xWP_wp_title', 10, 2 );

	function removeHeadLinks() {
		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'wlwmanifest_link');
        	remove_action('wp_head', 'wp_generator');
        	remove_action('wp_head', 'feed_links', 2);
        	remove_action('wp_head', 'index_rel_link');
        	remove_action('wp_head', 'feed_links_extra', 3);
        	remove_action('wp_head', 'start_post_rel_link', 10, 0);
        	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
        	remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
        	add_filter( 'script_loader_src', 'remove_src_version' );
        	add_filter( 'style_loader_src', 'remove_src_version' );
        	add_filter('wp_headers', 'remove_x_pingback');
	}
	add_action('init', 'removeHeadLinks');
	
	function remove_src_version ( $src ) {
		global $wp_version;

      		$version_str = '?ver='.$wp_version;
      		$version_str_offset = strlen( $src ) - strlen( $version_str );

      		if( substr( $src, $version_str_offset ) == $version_str )
        		return substr( $src, 0, $version_str_offset );
      		else
        		return $src;
	}

    	function remove_x_pingback($headers) {
        	unset($headers['X-Pingback']);
        	return $headers;
    	}

	function xWP_scripts_styles() {
		global $wp_styles;
	
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );

		// You should generate a custom build that only has the detects you need.
		wp_enqueue_script( 'xWP-modernizr', get_template_directory_uri() . '/_/js/modernizr-2.7.0.dev.js' );
	}
	add_action( 'wp_enqueue_scripts', 'xWP_scripts_styles' );


	// Load jQuery
	if ( !function_exists( 'core_mods' ) ) {
		function core_mods() {
			if ( !is_admin() ) {
				wp_deregister_script( 'jquery' );
				wp_register_script( 'jquery', ( "//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" ), false);
				wp_enqueue_script( 'jquery' );
			}
		}
		add_action( 'wp_enqueue_scripts', 'core_mods' );
	}



	// Custom Menu
	register_nav_menu( 'primary', __( 'Navigation Menu', 'html5reset' ) );

	// Widgets
	if ( function_exists('register_sidebar' )) {
		function xWP_widgets_init() {
			register_sidebar( array(
				'name'          => __( 'Sidebar Widgets', 'html5reset' ),
				'id'            => 'sidebar-primary',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );
		}
		add_action( 'widgets_init', 'xWP_widgets_init' );
	}

	// Navigation - update coming from twentythirteen
	function post_navigation() {
		echo '<div class="navigation">';
		echo '	<div class="next-posts">'.get_next_posts_link('&laquo; Older Entries', 'html5reset').'</div>';
		echo '	<div class="prev-posts">'.get_previous_posts_link('Newer Entries &raquo;', 'html5reset').'</div>';
		echo '</div>';
	}

	// Posted On
	function posted_on() {
		printf( __( '<span class="sep">Posted </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a> by <span class="byline author vcard">%5$s</span>', '' ),
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_author() )
		);
	}
	
function get_excerpt_by_id($post_id){
    $the_post = get_post($post_id); //Gets post ID
    if($the_post->post_excerpt =='') {
	    $the_excerpt = $the_post->post_content; //Gets post_content to be used as a basis for the excerpt	    
    } else {
	    $the_excerpt = $the_post->post_excerpt;
    }
    $excerpt_length = 35; //Sets excerpt length by word count
    $the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
    $words = explode(' ', $the_excerpt, $excerpt_length + 1);

    if(count($words) > $excerpt_length) :
        array_pop($words);
        array_push($words, '...');
        $the_excerpt = implode(' ', $words);
    endif;
    return $the_excerpt;
}

?>
