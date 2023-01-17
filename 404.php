<?php get_header();?>

<div class="content-section">

	<section class="main-content container">

		<span class="text-404">404</span>

		Sometimes you take the road less travelled …
		We're not sure how you got here, but you should head home.

		It's probably our fault that you're here; but if you're having trouble with the site just shoot us an email.

		<p>1) Perhaps you can find what you are looking for by <strong>searching the site</strong>.</p>

		<?php get_search_form();?>

		<p>2) <strong>If you typed in a URL</strong>... make sure your spelling is correct. Then try reloading the page.
		</p>

		<p>3) <strong>Look for</strong> it in our <a href="<?php echo home_url(); ?>/sitemap"
				title="sitemap">sitemap</a>.</p>

		<p>4) <strong>Return to</strong> <a href="<?php echo home_url(); ?>"
				title="<?php esc_attr_e( get_bloginfo( 'name' ) );?>">our homepage</a> (and please contact us to say
			what went wrong, so we can fix it, pronto).</p>

	</section> <!-- .main-content -->

</div> <!-- .content-section -->

<?php get_footer();?>
