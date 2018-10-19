<?php
/**
 * The template for displaying comments.
 *
 * @package aos
 */

if ( post_password_required() ) {
	return;
}
?>

<div class="comment" itemscope itemtype="http://schema.org/Comment">
	<h2><?php esc_html_e( 'Comments', 'aos' ); ?></h2>
	<div class="comments">
		<?php if ( have_comments() ) { ?>
			<div id="comment-area">
				<?php if ( have_comments() ) : ?>
					<ol class="comments-list">
						<?php wp_list_comments( array( 'callback' => 'aos_comment_format' ) ); ?>
					</ol>
				<?php endif; ?>
			</div>
			<?php paginate_comments_links();
		}

		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) { ?>
			<p><?php esc_html_e( 'Comments are closed.', 'aos' ); ?></p>
		<?php }

		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$args = array( 'fields' => apply_filters( 'comment_form_default_fields', array( 'author' => '<input name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="' . esc_attr__( 'Name', 'aos' ) . ' ' . ( $req ? '*' : '' ) . '"' . $aria_req . '>', 'email' => '<input name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" placeholder="' . esc_attr__( 'Mail', 'aos' ) . ' ' . ( $req ? '*' : '' ) . '"' . $aria_req . '>', 'url' => '<input name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="' . esc_attr__( 'Web', 'aos' ) . '">' ) ), 'comment_field' => '<textarea id="comment" name="comment" placeholder="' . esc_attr__( 'Comment', 'aos' ) . '"></textarea>', 'title_reply' => esc_html__( 'Reply comment', 'aos' ), 'label_submit' => esc_html__( 'Submit', 'aos' ), 'class_submit' => 'button' );
		comment_form( $args );
		?>
	</div>
</div>
