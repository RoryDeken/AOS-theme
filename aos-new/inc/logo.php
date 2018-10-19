<?php
/**
 * The template part of displaying logo.
 *
 * @package aos
 */

if ( is_front_page() && is_home() ) {
	$elem = 'h1';
} else {
	$elem = 'p';
}

?>
<<?php echo esc_html( $elem ); ?> class="site-header__logo" itemscope itemtype="http://schema.org/Organization" itemprop="publisher" id="data-site" role="banner">
	<?php if ( ! has_custom_logo() || ! function_exists( 'the_custom_logo' ) ) { ?>
		<a class="site-header__alt-title" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="name"><?php bloginfo( 'name' ); ?></a>
	<?php } else { ?>
	<?php the_custom_logo(); ?>
	<meta itemprop="name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
	<?php } ?>
	<meta itemprop="description" content="<?php esc_attr( get_bloginfo( 'description' ) ); ?>">
</<?php echo esc_html( $elem ); ?>>