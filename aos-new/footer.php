<?php
/**
 * The template for displaying footer.
 *
 * @package aos
 */
?>

	<footer class="site-footer" id="footer" itemscope itemtype="http://schema.org/WPFooter">
		<div class="footer-widget-area">
			<div class="footer-widget-area-1">
				<?php if ( is_active_sidebar( 'sidebar-footer-1' ) ) {
					dynamic_sidebar( 'sidebar-footer-1' );
				} ?>
			</div>
		</div>
		<p class="copyright"><?php
			echo wp_kses( aos_get_footer_copyright(), array( 'a' => array( 'href' => array(), 'title' => array(), 'rel' => array(), 'target' => array() ), 'em' => array(), 'strong' => array(), 'i' => array() ) );
			?></p>
	</footer>
	<?php wp_footer(); ?>
</body>
</html>
