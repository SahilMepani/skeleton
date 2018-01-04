</section> <!-- #site-content -->

<footer id="footer" class="clearfix">
<div class="container">

	<?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'menu_class' => 'footer-menu' ) ); ?>
	<p class="copyright">&copy; <?php echo date( 'Y' ); // WPCS: XSS ok. ?>. All Rights Reserved.</p>

</div> <!-- .container -->
</footer> <!-- #footer -->

<button id="scroll-top" class="btn"></button>

<?php wp_footer(); ?>
</body>
</html>