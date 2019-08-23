<?php /* Template Name: Documentation */ ?>

<?php get_header(); ?>

<div class="container">

	<div class="row py-5">

		<div class="col-sm-4 sidebar-col">
			<div class="sidebar-inner-block">

				<div class="search-block">

				</div> <!-- .search-block -->

				<ul class="list-unstyled">
					<li><a href="#wp-installation">WP Installation</a></li>
					<li><a href="#theme-installation">Theme Installation</a></li>
				</ul> <!-- .list-unstyled -->

			</div> <!-- .sidebar-inner-block -->
		</div> <!-- .col-sm-4 -->

		<div class="col-sm-8 content-col">
			<h3 id="wp-installation">WP Installation</h3>
			<ol>
				<li>Edit wp-config.php file in root directory</li>
		    <ul>
		    	<li>Set <b>$table_prefix</b> to <b>tse_</b></li>
			    <li>Set <b>WP_DEBUG</b> variable to <b>true</b></li>
			    <li>Add <b>define( 'WP_POST_REVISIONS', 3 );</b></li>
		    </ul>
			  <li>Create a user "<b>threesixtyeight</b>" with password "<b>$$3hree6ixty8ight$$</b>" and email "<b>dev@threesixtyeight.com</b>"</li>
			  <li>Create pages "<b>Home</b>" and "<b>Blog</b>"</li>
			  <li>Go to <b>Settings => General</b> and update "<b>Site Title</b>" and "<b>Tagline</b>"</li>
			 	<li>Go to <b>Settings => Reading</b></li>
			 	<ul>
			 		<li>Select "<b>A static page</b>" and select page <b>home for "Homepage"</b> and page <b>blog for "Posts page"</b></li>
					<li>Check "<b>Discourage search engine...</b>"</li>
					<li>Set "<b>Blog pages show at most</b>" to "<b>5</b>"</li>
			 	</ul>
			 	<li>Go to <b>Settings => Permalinks</b> and select "<b>Custom structure</b>" and set its value to "<b>/%postname%/</b>" without quotes</li>
			 	<li>Go to <b>Settings => Discussions</b></li>
			 	<ul>
			 		<li>If comments not allowed, Uncheck "<b>Allow people to post comments on new articles</b>"</li>
      		<li>If comments not allowed, Uncheck "<b>Show Avatars</b>"</li>
			 	</ul>
			  <li>Install and activate the following plugins:</li>
			</ol>
			<div class="mb-5"></div> <!-- .mb-5 -->
			<h3 id="theme-installation">Theme Installation</h3>
			<ol>
				<li>Clone the skeleton theme
					<div class="mt-1">
						<b>SSH</b>: <br /> <code>git clone git@bitbucket.org:threesixtyeight/skeleton-reloaded.git</code>
					</div> <!-- .mt-1 -->
					<div class="mt-1">
						<b>HTTP</b>: <br /> <code>git clone https://sahilmepani@bitbucket.org/threesixtyeight/skeleton-reloaded.git</code>
					</div> <!-- .mt-1 -->
				</li>
				<li>Rename the theme folder name to match the project name <small>(ask manager)</small></li>
				<li>Delete .git, .sass-cache, .php folders in the theme directory, if present</li>
				<li>Update theme info in sass/style.scss file. Theme name should match the project name</li>
				<li>Create a screenshot.png (1200 x 900) file in the theme directory <small>(ask designer)</small></li>
				<li>Go to Appearance => Themes and Activate the theme</li>
				<li>Create favicon.png and favicon.ico files <small>(ask designer)</small></li>
				<li>Make the Initial Commit</li>
			  <li>Create all the pages from sitemap with heirarchy and required URL structure</li>
			</ol>
			<div class="mb-5"></div> <!-- .mb-5 -->
		</div> <!-- .col-sm-8 content-col -->

	</div> <!-- .row -->

</div> <!-- .container -->

<?php get_footer(); ?>