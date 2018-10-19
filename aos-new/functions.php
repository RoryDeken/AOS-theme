<?php
/**
 * aos functions and definitions
 *
 * @package aos
 */

require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/widgets/recent-post-widget.php';


if ( ! function_exists( 'aos_setup' ) ) {
	/**
	 * Theme sets up.
	 */
	function aos_setup() {
		load_theme_textdomain( 'aos', get_template_directory() . '/languages' );

		add_theme_support( 'automatic-feed-links' );

		// Adds suport for audio files.
		add_theme_support( 'post-formats', array( 'audio' ) );

		register_nav_menus( array(
			'primary-menu' => esc_html__( 'Header navigation menu', 'aos' ),
			'social-links' => esc_html__( 'Header social links', 'aos' ),
		) );

		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );

		$header_picture = array( 'flex-width' => true, 'uploads' => true, 'header-text' => false );
		add_theme_support( 'custom-header', $header_picture );

		add_theme_support( 'custom-logo' );

		$html5support = array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		);
		add_theme_support( 'html5', $html5support );

		add_editor_style( 'asset/css/editor-style.css' );
	}
}
add_action( 'after_setup_theme', 'aos_setup' );

/**
 * Set up $content_width.
 */
function aos_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'aos_content_width', 820 );
}
add_action( 'after_setup_theme', 'aos_content_width', 0 );

/**
 * Loading styles and scripts.
 */
function aos_styles_load() {
	wp_enqueue_style( 'aos', get_stylesheet_directory_uri() . '/asset/css/style.min.css', array(), null, 'all' );
	

	wp_register_style( 'aos-new', get_template_directory_uri().'/style.css', array(), filemtime( 	get_template_directory().'/style.css' ) );
wp_enqueue_style( 'aos-new' );
	
	
	wp_enqueue_script( 'foundation', get_template_directory_uri() . '/asset/js/foundation.min.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'moment', get_template_directory_uri() . '/asset/js/moment-with-locales.min.js', array( 'jquery' ), null, true );

	wp_enqueue_script( 'aos-script', get_template_directory_uri() . '/asset/js/script.js', array( 'jquery' ), null, true );
	wp_localize_script( 'aos-script', 'wplocale', array( 'momentlocale' => esc_html__( 'en', 'aos' ) ) );

	if ( is_singular() ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'aos_styles_load' );

/**
 * Register sidebar.
 */
function aos_sidebar_init() {
	register_sidebar( array(
		'name' => esc_html__( 'sidebar', 'aos' ),
		'id' => 'sidebar-1',
		'description' => esc_html__( 'Sidebar widget area', 'aos' ),
		'before_widget' => '<div id="%1$s" class="sidebar-widgetarea widget %2$s">',
		'after_widget' => '</div>',
	) );

	register_sidebar( array(
		'name' => esc_html__( 'footer', 'aos' ),
		'id' => 'sidebar-footer-1',
		'description' => esc_html__( 'Footer widget area', 'aos' ),
		'before_widget' => '<div id="%1$s" class="sidebar-widgetarea widget %2$s">',
		'after_widget' => '</div>',
	) );
}
add_action( 'widgets_init', 'aos_sidebar_init' );

/**
 * Register widgets.
 */
function aos_widget_register() {
	register_widget( 'aos_Recent_Posts' );
}
add_action( 'widgets_init', 'aos_widget_register' );

/**
 * If user sets showing sticky posts at top-post area, main loop ignore sticky posts.
 */
function aos_home_query_pre( $query ) {
	if ( get_theme_mod( 'top_post_sortby' ) ) {
		if ( 'sticky' === get_theme_mod( 'top_post_sortby' ) ) {
			if ( $query->is_home() && $query->is_main_query() ) {
				$query->set( 'ignore_sticky_posts', 1 );
			}
		}
	}
}
add_action( 'pre_get_posts', 'aos_home_query_pre' );

if ( ! function_exists( 'aos_comment_format' ) ) {
	/**
	 * Comment callback.
	 */
	function aos_comment_format( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;

		switch ( $comment->comment_type ) {
			case 'pingback' :
			case 'trackback' : ?>
				<li class="post pingback">
				<p class="pingback__content"><i class="fa fa-thumb-tack pingback__icon" aria-hidden="true"></i><?php comment_author_link(); ?><?php edit_comment_link( esc_html__( 'Edit', 'aos' ) ); ?></p><?php
				break;
			default : ?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<div id="comment-<?php comment_ID(); ?>" class="comment comment-container">
					<div class="comment__avatar">
						<?php echo get_avatar( $comment, 60 ); ?>
					</div>
					<div class="comment__content">
						<div class="comment__meta">
							<?php printf( wp_kses( __( '<cite class="fn">%s</cite>', 'aos' ), array( 'cite' => array( 'class' => array() ) ) ), get_comment_author_link() ); ?>
							<?php echo '<time datetime="' . esc_attr( get_comment_date( 'Y-m-d' ) ) . '">' . esc_html( get_comment_date() ) . '</time>'; ?>
							<?php if ( get_queried_object()->post_author === $comment->user_id ) { ?>
								<span class="label"><?php esc_html_e( 'Author', 'aos' ); ?></span>
							<?php } ?>
							<div class="comment__reply">
								<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
								<?php edit_comment_link( esc_html__( 'Edit', 'aos' ) ); ?>
							</div>
						</div>
						<?php if ( '0' === $comment->comment_approved ) : ?>
							<div class="comment__moderation">
								<em><?php esc_html_e( 'Your comment is awaiting moderation.', 'aos' ); ?></em>
							</div>
						<?php endif; ?>
						<div class="comment__text"><?php comment_text(); ?></div>
					</div>
				</div>
				<?php
				break;
		}
	}
}
