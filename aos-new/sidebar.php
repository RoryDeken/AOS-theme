<?php
/**
 * The template for displaying sidebar.
 *
 * @package aos
 */
?>
<aside class="sidebar">
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) {
		dynamic_sidebar( 'sidebar-1' );
	} ?>
</aside>
