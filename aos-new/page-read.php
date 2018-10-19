<?php
/**
  * Template Name: Blog Listing
 *
 * @package aos
 */
get_header(); ?>

		<div class="site-main">
		<main class="content" id="main" role="main">
		
			<div class="posts">
				<?php $query = new WP_Query( array(
	'post_type'=>'post',
	'ignore_sticky_posts' => 1,
    'tax_query' => array(
        array(                
            'taxonomy' => 'post_format',
            'field' => 'slug',
            'terms' => array( 
              
                'post-format-audio',            
            ),
            'operator' => 'NOT IN'
        )
    )
) );
?>
				
				<?php if ( $query->have_posts() ) :
				while ( $query->have_posts()) : $query->the_post(); ?>
				<?php if(get_post_format() !== 'audio'){ ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'posts__item' ); ?> itemscope itemtype="http://schema.org/BlogPosting">
					<?php if ( has_post_thumbnail( $post->ID ) ) {
					$src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' ); ?>
					<a class="posts__item-thumb" href="<?php the_permalink(); ?>" style="background-image: url('<?php echo esc_url( $src[0] ) ?>');" itemprop="image">
						<div class="posts__item-thumb--hover" aria-hidden="true" role="presentation"><div class="hover-item">
							<?php 
									esc_html_e( 'Continue Reading', 'aos' );
								
							?>
							
							</div></div>
					</a>
					<?php } else { ?>
					<a class="posts__item-thumb" href="<?php the_permalink(); ?>" style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/image/default_thumb.png' ) ?>');" itemprop="image">
						<div class="posts__item-thumb--hover" aria-hidden="true" role="presentation"><div class="hover-item">
							<?php if(get_post_format() !== 'audio'){ 
									esc_html_e( 'Continue Reading', 'aos' );
									}
								  	else {
									  esc_html_e( 'Listen', 'aos' );
								  	}
							?>
							
							</div></div>
					</a>
					<?php } ?>
					<h2 class="posts__item-title" itemprop="headline"><a href="<?php the_permalink(); ?>" itemprop="url"><?php the_title(); ?></a></h2>
					<p class="posts__item-description" itemprop="description"><?php echo esc_html( get_the_excerpt() ); ?></p>
					<div class="posts__item-meta">
						<time datetime="<?php echo esc_attr( get_the_time( 'Y-m-d' )  . 'T' .  get_the_time( 'H:i:sP' ) ); ?>" itemprop='datePublished'><?php the_time( get_option( 'date_format' ) ); ?></time>
						<?php if ( get_the_category() ) { ?>
						<?php $category = get_the_category();?>
						<span class="category <?php echo esc_html( lcfirst($category[0]->cat_name) ); ?>" itemprop="genre" aria-label="<?php esc_html_e( 'Category', 'aos' ); ?>"><?php
							if ( $category[0] ) {
								echo '<a href="' . esc_url( get_category_link( $category[0]->term_id ) ) . '">' . esc_html( $category[0]->cat_name ) . '</a>';
							} ?></span>

						
					
					</div>
				</article>
				<?php } ?>
				<?php } ?>
				<?php endwhile;
				wp_reset_postdata();
				else : ?>
				<div>
					<h2><?php esc_html_e( 'No Posts.', 'aos' ); ?></h2>
				</div>
				<?php endif; ?>
			</div>
			<?php global $wp_query;
			$big = 999999999;
			?><div class="pagination" role="navigation"><?php
			echo wp_kses( paginate_links( array( 'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ), 'format' => '?paged=%#%', 'current' => max( 1, get_query_var( 'paged' ) ), 'total' => $wp_query->max_num_pages ) ), array( 'a' => array( 'class' => array(), 'href' => array() ), 'span' => array( 'class' => array() ) ) );
			?></div>
		</main>
		<?php get_sidebar(); ?>
	</div>
<?php get_footer(); ?>
