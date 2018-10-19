<?php
/**
 * The template part of top posts.
 *
 * @package aos
 */

$sticky = get_option( 'sticky_posts' );

if ( get_theme_mod( 'top_post_sortby' ) ) {
	$sortby = get_theme_mod( 'top_post_sortby' );
} else {
	$sortby = 'random';
}

if ( 'none' !== $sortby ) {

	global $post;

	if ( 'random' === $sortby ) {
		$args = array(
			'orderby' => 'rand',
			'posts_per_page' => 3,
			'ignore_sticky_posts' => 1,
		);
	} else {
		$args = array(
			'posts_per_page' => 3,
			'post__in' => $sticky,
			'ignore_sticky_posts' => 1,
		);
	}

	$my_query = new WP_Query( $args );

	if ( $my_query->have_posts() ) { ?>
		<div class="top-post">
			<?php while ( $my_query->have_posts() ) :
				$my_query->the_post(); ?>
				<a href="<?php the_permalink(); ?>" class="top-post__item">
					<?php if ( has_post_thumbnail( $post->ID ) ) {
						$src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
						echo '<div class="top-post__thumb" style="background-image: url(' . esc_url( $src[0] ) . ')"></div>';
					} else {
						echo '<div class="top-post__thumb" style="background-image: url(' . esc_url( get_template_directory_uri() ) . '/image/default_thumb.png)"></div>';
					} ?>
					<?php 
									$category = get_the_category();
									$format = get_post_format();
									
					?>
					<div class="top-post__description">
						<div class="top-post__description-cat <?php echo esc_html( lcfirst($category[0]->cat_name) ); ?>">
							<?php if ( $category[0] ) {
								echo esc_html( $category[0]->cat_name );
							} ?>
							<?php if($format == 'audio'){
										echo '<i class="fa fa-headphones" aria-hidden="true"></i>'; 
									} else {
										echo '<i class="fa fa-book" aria-hidden="true"></i>';
									} ?>
						</div>
						<div class="top-post__description-desc">
							<h2><?php the_title(); ?></h2>
						</div>
					</div>
				</a>
			<?php endwhile; ?>
		</div>
	<?php }

	wp_reset_postdata();
}
