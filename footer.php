<?php
/**
 * @package WordPress
 * @subpackage themename
 */
?>

	</div><!-- #main  -->
	</div><!-- #page -->
	<footer id="colophon" role="contentinfo">
			<div id="site-generator">
				<?php wp_nav_menu( array( 'theme_location' => 'footer' ) ); ?>
				<p id="copyright">&copy; Copyright <?php echo date('Y') . " " . esc_attr( get_bloginfo( 'name', 'display' ) ); ?></p>
			</div>
	</footer><!-- #colophon -->


<?php wp_footer(); ?>  

</body>
</html>