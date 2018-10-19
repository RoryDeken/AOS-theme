<?php
/**
 * aos customizer functionality.
 *
 * @package aos
 */

/**
 * Register customizer
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function aos_customizer( $wp_customize ) {

	/* Frontpage */

	$wp_customize->add_section( 'aos_top_post', array( 'title' => esc_html__( 'Frontpage', 'aos' ), 'priority' => 80, 'description' => esc_html__( 'Settings for front page', 'aos' ) ) );

	$wp_customize->add_setting( 'top_post_sortby', array( 'default' => 'random', 'sanitize_callback' => 'aos_sanitize_top_post_sortby' ) );
	$wp_customize->add_control( 'top_post_sortby', array( 'label' => esc_html__( 'Frontpage upper grid articles:', 'aos' ), 'section' => 'aos_top_post', 'settings' => 'top_post_sortby', 'type' => 'select', 'choices' => array( 'random' => esc_html__( 'random', 'aos' ), 'sticky' => esc_html__( 'sticky posts', 'aos' ), 'none' => esc_html__( 'none', 'aos' ) ) ) );

	/* Footer Copyright */

	$wp_customize->add_section( 'aos_footer_copyright', array( 'title' => esc_html__( 'Copyright', 'aos' ), 'priority' => 80, 'description' => esc_html__( 'Setting for footer copyright.', 'aos' ) ) );

	$wp_customize->add_setting( 'footer_copyright', array( 'default' => sprintf( esc_html__( 'Copyright 2016 %s, Powered by WordPress, Theme by gadgetone.', 'aos' ), esc_html( get_bloginfo( 'name' ) ) ), 'sanitize_callback' => 'aos_sanitize_footer_copyright' ) );
	$wp_customize->add_control( 'footer_copyright', array( 'section' => 'aos_footer_copyright', 'settings' => 'footer_copyright', 'label' => esc_html__( 'Footer copyright:', 'aos' ), 'type' => 'text', 'priority' => 10 ) );

	/* Colors */

	$wp_customize->add_setting( 'header_background', array( 'default' => '#fff', 'sanitize_callback' => 'sanitize_hex_color' ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_background', array( 'label' => esc_html__( 'Header Color', 'aos' ), 'section' => 'colors' ) ) );

	$wp_customize->add_setting( 'main_background', array( 'default' => '#fefefe', 'sanitize_callback' => 'sanitize_hex_color' ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'main_background', array( 'label' => esc_html__( 'Main Area Color', 'aos' ), 'section' => 'colors' ) ) );

	$wp_customize->add_setting( 'accent_color', array( 'default' => '#eba0c1', 'sanitize_callback' => 'sanitize_hex_color' ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_color', array( 'label' => esc_html__( 'Accent Color', 'aos' ), 'section' => 'colors' ) ) );
}
add_action( 'customize_register', 'aos_customizer' );

/**
 * Return footer copyright.
 *
 * @return string Footer copyright.
 */
function aos_get_footer_copyright() {
	$copyright_blogtitle = get_bloginfo( 'name' );
	return get_theme_mod( 'footer_copyright', sprintf( esc_html__( 'Copyright 2016 %s, Powered by WordPress, Theme by gadgetone.', 'aos' ), esc_html( $copyright_blogtitle ) ) );
}

/**
 * Sanitize top_post_sortby.
 *
 * @return string Sanitized data.
 */
function aos_sanitize_top_post_sortby( $value ) {
	$sortby_choices = array( 'random' => esc_html__( 'random', 'aos' ), 'sticky' => esc_html__( 'sticky posts', 'aos' ), 'none' => esc_html__( 'none', 'aos' ) );
	if ( ! array_key_exists( $value, $sortby_choices ) ) {
		return 'default';
	}
	return $value;
}

/**
 * Sanitize footer copyright.
 *
 * @return string Sanitized text.
 */
function aos_sanitize_footer_copyright( $string ) {
	return wp_kses( $string, array( 'a' => array( 'href' => array(), 'title' => array(), 'rel' => array(), 'target' => array() ), 'em' => array(), 'strong' => array(), 'i' => array() ) );
}

/**
 * Enqueue header background color style.
 */
function aos_header_background_css() {
	$header_background_color = get_theme_mod( 'header_background', '#fff' );

	if ( '#fff' === $header_background_color ) {
		return;
	}

	$css = '.site-header__inner, .primary-menu > .menu-item > a {
		background: %1$s;
	}';

	wp_add_inline_style( 'aos', sprintf( $css, esc_attr( $header_background_color ) ) );
}
add_action( 'wp_enqueue_scripts', 'aos_header_background_css', 11 );

/**
 * Enqueue main area background color style.
 */
function aos_main_background_css() {
	$main_background_color = get_theme_mod( 'main_background', '#fefefe' );

	if ( '#fefefe' === $main_background_color ) {
		return;
	}

	$css = '.site-main {
		background: %1$s;
	}';

	wp_add_inline_style( 'aos', sprintf( $css, esc_attr( $main_background_color ) ) );
}
add_action( 'wp_enqueue_scripts', 'aos_main_background_css', 11 );

/**
 * Enqueue themes primary color style.
 */
function aos_accent_color_css() {
	$accent_color = get_theme_mod( 'accent_color', '#eba0c1' );

	if ( '#eba0c1' === $accent_color ) {
		return;
	}

	$css = 'a, .button.hollow, .breadcrumbs a, .color-reverse:hover, .posts__item h2 a:hover, .widget-recent-post li:hover .widget-recent-post__meta {
		color: %1$s;
	}
	.button, .button.primary, .button.hollow.primary, .badge, .button-group.primary .button, .label, input[type="submit"], .main-content__pagination a, .main-content__pagination > span, .page-numbers {
		background: %1$s;
	}
	.button.hollow, .button.hollow.primary {
		border: 1px solid %1$s;
	}
	.primary-menu > .menu-item:hover::after {
		border-bottom-color: %1$s;
	}
	.site-footer {
		border-bottom: 6px %1$s solid;
	}';

	wp_add_inline_style( 'aos', sprintf( $css, esc_attr( $accent_color ) ) );
}
add_action( 'wp_enqueue_scripts', 'aos_accent_color_css', 11 );
