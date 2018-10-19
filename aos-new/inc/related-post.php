<?php
/**
 * The template part of displaying related posts.
 *
 * @package aos
 */

global $post;
$categories = get_the_category();

if ( $categories ) {
	$args = array(
		'post__not_in' => array( $post->ID ),
		'posts_per_page' => 6,
	);

	$cat_ids = array();
	if ( $categories ) {
		foreach ( $categories as $category ) $cat_ids[] = $category->cat_ID;
	}

	$args['category__in'] = $cat_ids;
	$my_query = new wp_query( $args );
	?>
	<div class="related-post">
		<h2><?php esc_html_e( 'Related Posts', 'aos' ); ?></h2>
		<div class="related-post__container">
			<?php if ( $my_query->have_posts() ) {
				while ( $my_query->have_posts() ) { ?>
					<div class="related-post__item">
						<?php $my_query->the_post();
						if ( has_post_thumbnail( $post->ID ) ) {
							$src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' ); ?>
							<a class="related-post__item-thumb" href="<?php the_permalink(); ?>" style="background-image: url('<?php echo esc_url( $src[0] ); ?>');"></a>
						<?php } else { ?>
							<a class="related-post__item-thumb" href="<?php the_permalink(); ?>" style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/image/default_thumb.png' ); ?>');"></a>
						<?php } ?>
						<h3 class="related-post__item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<time class="related-post__item-date timeago" id="relatedPostDate" datetime="<?php echo esc_attr( get_the_time( 'Y-m-d' )  . 'T' .  get_the_time( 'H:i:sP' ) ); ?>"><?php the_time( 'Ymd' );?></time>
					</div>
				<?php }
			} else { ?>
				<p class="nopost"><?php esc_html_e( 'No Related Post.', 'aos' ); ?></p>
			<?php
			}
		}
?>
		</div>
	</div>
<?php wp_reset_postdata();
