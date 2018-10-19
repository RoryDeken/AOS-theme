<?php

class aos_Recent_Posts extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'aos_recent_posts', 'description' => esc_html__( 'Recent post widget with thumbnail.', 'aos' ) );
		parent::__construct( 'aos_recent-posts', esc_html__( 'Recent Posts ( with thumbnail )', 'aos' ), $widget_ops );
		$this->alt_option_name = 'aos_recent_posts';
	}

	function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		global $post;

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Recent Posts', 'aos' );


		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 5;
		}
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
		) ) );

		if ( $r->have_posts() ) :
		?>
		<?php echo $args['before_widget']; // WPCS: XSS OK. ?>
		<?php if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title']; // WPCS: XSS OK.
		} ?>
		<ul class="widget-recent-post">
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
			<li>
				<a href="<?php the_permalink(); ?>">
				<?php if ( has_post_thumbnail( $post->ID ) ) {
					$src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' ); ?>
				<div class="widget-recent-post__thumbnail" aria-hidden="true" style="background-image: url('<?php echo esc_url( $src[0] ) ?>');"></div>
				<?php } ?>
				<div class="widget-recent-post__meta">
					<div><?php get_the_title() ? the_title() : the_ID(); ?></div>
					<?php if ( $show_date ) : ?>
						<time datetime="<?php echo esc_attr( get_the_time( 'Y-m-d' )  . 'T' .  get_the_time( 'H:i:sP' ) ); ?>" class="timeago widget-recent-post__post-date"><?php the_time( 'Ymd' );?></time>
					<?php endif; ?>
				</div>
				</a>
			</li>
		<?php endwhile; ?>
		</ul>
		<?php echo $args['after_widget']; // WPCS: XSS OK.

		wp_reset_postdata();

		endif;
	}


	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		return $instance;
	}


	function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'aos' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of posts to show:', 'aos' ); ?></label>
		<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $number ); ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox"<?php checked( $show_date ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>" />
		<label for="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>"><?php esc_html_e( 'Display post date?', 'aos' ); ?></label></p>
<?php
	}
}
