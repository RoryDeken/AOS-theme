<?php
/**
 * The template for displaying posts.
 *
 * @package aos
 */

get_header();
?>
<div class="site-main">
		<main class="content" id="main" role="main">
			<?php if ( have_posts() ) :
				while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/BlogPosting" itemref="data-site">
				<nav>
					<ul class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">
						<?php $breadcrumb_order = 1; ?>
						<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="item"><span itemprop="name"><?php esc_html_e( 'Home', 'aos' ); ?></span></a><meta itemprop="position" content="<?php echo esc_attr( intval( $breadcrumb_order++ ) ); ?>"></li>
						<?php $categories = get_the_category( $post->ID );
						$cat = $categories[0];
						if ( 0 !== $cat -> parent ) {
							$ancestors = array_reverse( get_ancestors( $cat -> cat_ID, 'category' ) );
							foreach ( $ancestors as $ancestor ) { ?>
							<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="<?php echo esc_url( get_category_link( $ancestor ) ); ?>" itemprop="item"><span itemprop="name"><?php echo esc_html( get_cat_name( $ancestor ) ); ?></span></a><meta itemprop="position" content="<?php echo esc_attr( intval( $breadcrumb_order++ ) ); ?>"></li>
							<?php }
						} ?>
						<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="<?php echo esc_url( get_category_link( $cat -> cat_ID ) ); ?>" itemprop="item"><span itemprop="name"><?php echo esc_html( $cat-> cat_name ); ?></span></a><meta itemprop="position" content="<?php echo esc_attr( intval( $breadcrumb_order++ ) ); ?>"></li>
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
						<div class="post__meta-top">
							<?php $category = get_the_category(); ?>
							<span class="meta-top__cat <?php echo esc_html( lcfirst($category[0]->cat_name) ); ?>">
							<?php if ( $category[0] ) {
								echo '<a href="' . esc_url( get_category_link( $category[0]->term_id ) ) . '" itemprop="genre">' . esc_html( $category[0]->cat_name ) . '</a>';
							} ?></span>
							<time class="meta-top__date" datetime="<?php echo esc_attr( get_the_time( 'Y-m-d' )  . 'T' .  get_the_time( 'H:i:sP' ) ); ?>" itemprop='datePublished'><?php the_time( get_option( 'date_format' ) ); ?></time>
					

						</div>
						<h1 class="post__title" itemprop="headline"><?php the_title(); ?></h1>
						
					</div>
				</header>
				<div class="post__main">
					<div id="main-content" class="post__content" itemprop="articleBody">
						<div id="social">
							<span>Share this article:
								<a href="http://www.facebook.com/share.php?u=
								<?php
										 echo get_the_permalink();
								?>">
									<i class="fa fa-facebook-square" aria-hidden="true"></i>
								</a>
								<a href="http://twitter.com/intent/tweet?text=<?php echo get_the_title() . '&amp;url=' . 	                                         get_the_permalink(); ?>">
									<i class="fa fa-twitter-square" aria-hidden="true"></i>
								</a>
							</span>
						</div>
						<hr/>
						<?php the_content(); ?>
					
					</div>
					<footer class="post__sidebar" data-sticky-container>
						<div class="sticky-content" data-sticky data-anchor="main-content" data-check-every="0"<?php if ( is_admin_bar_showing() ) echo ' data-margin-top="2.5"'; ?>>
							<?php do_action( 'aos_before_content_footer' ); ?>
							<?php if ( get_the_tags() ) { ?>
							<?php the_tags( '<ul class="post__tags"><li>', '</li><li>', '</li></ul>' ); ?>
							<meta itemprop="keywords" content="<?php
							$posttags = get_the_tags();
							if ( $posttags ) {
								foreach ( $posttags as $tag ) {
									echo esc_attr( $tag->name ) . ', ';
								}
							}
							?>">
							<?php } ?>
							<?php edit_post_link( esc_html__( 'Edit', 'aos' ), '<span class="edit-link" aria-label="' . esc_html__( 'Edit Article', 'aos' ) . '">', '</span>' ); ?>
							<?php do_action( 'aos_after_content_footer' ); ?>
						</div>
					</footer>
				</div>
				<nav>
					<?php wp_link_pages( array( 'before' => '<div class="post__pagination">', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
					<ul class="post__preview-next">
						<?php if ( get_previous_post() ) { ?>
						<li>
							<a href="<?php echo esc_url( get_permalink( get_previous_post()->ID ) ); ?>">
								<i class="fa fa-angle-left"></i>
								<span class="screen-reader-text"><?php esc_html_e( 'Previous Post', 'aos' ); ?></span>
							</a>
						</li>
						 <?php } ?>
						 <?php if ( get_next_post() ) { ?>
						<li>
							<a href="<?php echo esc_url( get_permalink( get_next_post()->ID ) ); ?>">
								<i class="fa fa-angle-right"></i>
								<span class="screen-reader-text"><?php esc_html_e( 'Next Post', 'aos' ); ?></span>
							</a>
						</li>
						<?php } ?>
					</ul>
				</nav>
			</article>
			<?php endwhile; ?>
			<?php else : ?>
				<article>
					<h1><?php esc_html_e( 'No Post.', 'aos' ); ?></h1>
				</article>
			<?php endif; ?>
			<?php get_template_part( 'inc/related-post' ); ?>
			
		</main>
		<?php get_sidebar(); ?>
	</div>
<?php get_footer(); ?>
