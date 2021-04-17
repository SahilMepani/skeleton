<div class="map-tooltip">
	<div class="heading-block">
		<h5 class="heading">State Name</h5>
		<div class="year">2021</div>
	</div> <!-- .heading-block -->
	<ul class="list-data">
		<li>
			<span class="label">Lavel</span>
			<span class="data">20,200</span>
		</li>
	</ul> <!-- .list-data -->
</div> <!-- .map-tooltip -->

<style>
.map-tooltip {
	background-color: #fff;
	color: #000;
	font-weight: 700;
}
.map-tooltip .heading-block {
	display: flex;
	justify-content: space-between;
}
.map-tooltip .heading-block .heading {
	font-size: 18px;
	text-transform: uppercase;
	letter-spacing: 1px;
	flex: 1 1 auto;
	text-align: center;
}
.map-tooltip .heading-block .year {
	font-size: 14px;
}
.map-tooltip .list-data {
	list-style: none;
	display: flex;
	justify-content: space-between;
	margin: 0;
}
</style>

<?php

// Do not delete these lines
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) )
die ( 'Please do not load this page directly. Thanks!' );

if ( ! empty($post->post_password) ) : ?>
	<?php if($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) : ?>
		<p class="no-comments"> This post is password protected. Enter the password to view comments. </p>
	<?php endif; ?>
<?php endif; ?>

<!-- You can start editing here. -->

<?php if (!empty($comments_by_type['comment'])) : ?>

	<h4 class="comments-counts"><?php comments_number( 'No Comments yet, your thoughts are welcome!', 'One Comment', '% Comments' );?></h4>

<!-- http://wpengineer.com/1420/hide-the-comment-pagination/ -->
	<?php if ( (int) get_option( 'page_comments' ) === 1 ): ?>
		<div class="comments-pagination">
			<?php paginate_comments_links(
				array(
					'prev_text' => '&lsaquo; Previous',
					'next_text' => 'Next &rsaquo;'
				)); ?>
		</div>
	<?php endif; ?>

	<ol class="comments-list">
		<?php wp_list_comments('type=comment&avatar_size=48'); ?>
	</ol>

	<?php if ( (int) get_option( 'page_comments' ) === 1 ): ?>
		<div class="comments-pagination">
			<?php paginate_comments_links(
				array(
					'prev_text' => '&lsaquo; Previous',
					'next_text' => 'Next &rsaquo;'
				)); ?>
		</div>
	<?php endif; ?>

<?php else : // this is displayed if there are no comments so far ?>

	<?php if ( 'open' == $post->comment_status ) : ?>
	<!-- If comments are open, but there are no comments. -->

	<?php else : // comments are closed ?>
	<!-- If comments are closed. -->
	<p class="no-comments"> Comments are closed. </p>

	<?php endif; ?>

<?php endif; ?>

<?php if (!empty($comments_by_type['pings'])) { ?>

	<h3 id="trackbacks">Pingbacks &amp; Trackbacks</h3>
	<ol class="comments-list">
		<?php wp_list_comments('type=pings'); ?>
	</ol>

<?php } ?>

<?php comment_form( array( 'title_reply' => 'Share your opinion.', 'label_submit' => 'Submit Comment' ) ); ?>