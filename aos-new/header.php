<?php
/**
 * The template for displaying header.
 *
 * @package aos
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) { ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php } ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
	<script async src="//pagead2.googlesyndication.com/
pagead/js/adsbygoogle.js"></script>
	<?php if(is_single()) { ?>
	<script>
	(adsbygoogle = window.adsbygoogle || []).push({
	google_ad_client: "ca-pub-7713730536405303",
	enable_page_level_ads: true
	});
</script> 
	<?php } ?>
	</head>

<body <?php ( 'lang="ja"' === get_language_attributes() ) ? body_class() : body_class( 'no-ja' ); ?> itemscope <?php echo ( ! is_page() ) ? 'itemtype="http://schema.org/Blog"' : 'itemtype="http://schema.org/WebPage"'; ?>>
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'aos' ); ?></a>
	<header class="site-header" id="header">
	<div class="site-header__inner<?php if ( ! has_nav_menu( 'primary-menu' ) ) { echo ' nomenu'; } ?>" itemscope itemtype="http://schema.org/WPHeader">
		<div class="site-header__col-left">
			
			<?php if ( has_nav_menu( 'primary-menu' ) ) { ?>
			<nav class="site-header__menu" itemscope itemtype="http://schema.org/SiteNavigationElement" role="navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => false, 'container_class' => '', 'menu_class' => 'primary-menu', 'fallback_cb' => 'wp_page_menu' ) ); ?>
			</nav>
			<?php } ?>

		</div>
		<div class="site-header__col-right">
			<?php get_template_part( 'inc/logo' ); ?>
			<?php if ( has_nav_menu( 'social-links' ) ) { ?>
				<div class="site-header__social">
					<?php wp_nav_menu( array( 'theme_location' => 'social-links', 'container' => false, 'container_class' => '', 'menu_class' => 'site-header__social-button', 'menu_id' => 'socialBtn', 'fallback_cb' => 'wp_page_menu', 'link_before' => '<span class="screen-reader-text">', 'link_after' => '</span>', 'depth' => 1 ) ); ?>
					<div class="site-header__social-call" id="socialCall"><i class="fa fa-share-alt"></i></div>
				</div>
			<?php } ?>
			
			
		</div>
	</div>
	<?php if ( get_header_image() ) { ?>
	<div class="site-header__image">
		<div class="header-image" style="background-image: url(<?php header_image(); ?>)"></div>
	</div>
	<?php } ?>
	</header>
