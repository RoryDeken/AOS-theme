<?php
/**
 * The template for displaying pages.
 *
 * @package aos
 */

get_header(); ?>
		<div class="site-main">
		<main class="content">
			<?php if ( have_posts() ) :
				while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<nav>
					<ul class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">
						<?php $breadcrumb_order = 1; ?>
						<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="item"><span itemprop="name"><?php esc_html_e( 'Home', 'aos' ); ?></span></a><meta itemprop="position" content="<?php echo esc_attr( intval( $breadcrumb_order++ ) ); ?>"></li>
						<?php if ( 0 !== $post -> post_parent ) {
							$ancestors = array_reverse( $post-> ancestors );
							foreach ( $ancestors as $ancestor ) { ?>
							<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="<?php echo esc_url( get_permalink( $ancestor ) ); ?>" itemprop="item"><span itemprop="name"><?php echo esc_html( get_the_title( $ancestor ) ); ?></span></a><meta itemprop="position" content="<?php echo esc_attr( intval( $breadcrumb_order++ ) ); ?>"></li>
							<?php }
							} ?>
						<li class="current" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="item name"><?php the_title(); ?></span><meta itemprop="position" content="<?php echo esc_attr( intval( $breadcrumb_order++ ) ); ?>"></li>
					</ul>
				</nav>
				<header class="post__header">
					<?php if ( has_post_thumbnail() ) { ?>
					<div class="post__thumb" itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
						<?php the_post_thumbnail( 'large', array( 'itemprop' => 'thumbnail' ) ); ?>
						<meta itemprop="name" content="<?php echo esc_attr( get_post_meta( get_post_thumbnail_id( $post->id ), '_wp_attachment_image_alt', true ) ); ?>">
						<meta itemprop="url" content="<?php echo esc_attr( wp_get_attachment_image_src( get_post_thumbnail_id( $post->id ), 'full' )[0] ); ?>">
						<meta itemprop="width" content="<?php echo esc_attr( wp_get_attachment_image_src( get_post_thumbnail_id( $post->id ), 'full' )[1] ); ?>">
						<meta itemprop="height" content="<?php echo esc_attr( wp_get_attachment_image_src( get_post_thumbnail_id( $post->id ), 'full' )[2] ); ?>">

					</div>
					<?php } ?>
					<?php if ( has_post_thumbnail() ) { ?>
					<div class="post__meta">

					<?php } else { ?>
					<div class="post__meta post__meta--nothumb">
					<?php } ?>
						<h1 class="post__title" itemprop="headline"><?php the_title(); ?></h1>
						<meta itemprop="name" content="<?php the_title_attribute(); ?>">
					</div>
				</header>
				<div class="post__main">
					<div id="main-content" class="post__content" itemprop="mainEntity">
						<?php the_content(); ?>
					</div>
					<footer class="post__sidebar" data-sticky-container>
						<div class="sticky" data-sticky data-anchor="main-content" data-check-every="0"<?php if ( is_admin_bar_showing() ) echo ' data-margin-top="2.5"'; ?>>
						<?php do_action( 'aos_before_content_footer' ); ?>
						<?php edit_post_link( esc_html__( 'Edit', 'aos' ), '<span class="edit-link" aria-label="' . esc_html__( 'Edit Article', 'aos' ) . '">', '</span>' ); ?>
						<?php do_action( 'aos_after_content_footer' ); ?>
						</div>
					</footer>
				</div>
			</article>
			<?php endwhile; ?>
			<?php else : ?>
				<article>
					<h1><?php esc_html_e( 'No Post.', 'aos' ); ?></h1>
				</article>
			<?php endif; ?>
			<?php if ( comments_open() || get_comments_number() ) {
				comments_template();
			} ?>
			</main>
		<?php get_sidebar(); ?>
	</div>
<?php get_footer(); ?>
