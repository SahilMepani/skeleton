<?php
	if ( have_rows('wysiwyg_widgets') ) :
	while ( have_rows('wysiwyg_widgets') ) : the_row();
?>

	<?php if ( get_row_layout() == 'heading' ) : ?>
		<!-- Heading -->
		<?php
			$heading           = get_sub_field('heading');
			$heading_type      = get_sub_field('heading_type');
			$mb                = get_sub_field('mb');
		?>
		<<?php echo $heading_type; ?> class="wysiwyg-widgets--heading <?php echo $mb; ?>">
			<?php echo $heading; ?>
		</<?php echo $heading_type; ?>>
	<?php endif; ?>


	<?php if ( get_row_layout() == 'blockquote' ) : ?>
		<!-- Blockquote -->
		<?php
			$quote  = get_sub_field('quote');
			$author = get_sub_field('author');
			$mb     = get_sub_field('mb');
		?>
		<div class="blockquote-block <?php echo $mb; ?>">
			<blockquote class="h3"><?php echo $quote; ?></blockquote>
			<?php if ( $author != '' ) { ?>
				<p class="author"><?php echo $author; ?></p>
			<?php } ?>
		</div>
	<?php endif; ?>


	<?php if ( get_row_layout() == 'accordions' ) : ?>
		<!-- Accordions -->
		<?php
			$accordions = get_sub_field('accordions');
			$mb         = get_sub_field('mb');
		?>
		<ul class="list-accordions <?php echo $mb; ?>">
			<?php foreach( $accordions as $accordion ) { ?>
				<li class="mb-2">
					<h4 class="heading"><?php echo $accordion['heading']; ?></h4>
					<div class="content-block">
						<div class="inner-block">
							<?php echo $accordion['copy']; ?>
						</div> <!-- .inner-block -->
					</div> <!-- .content-block -->
				</li>
			<?php } ?>
		</ul> <!-- .list-accordions -->
	<?php endif; ?>


	<?php if ( get_row_layout() == 'wysiwyg' ) : ?>
		<!-- WYSIWYG -->
		<?php
			$copy = get_sub_field('copy');
			$mb   = get_sub_field('mb');
		?>
		<div class="<?php echo $mb; ?>">
			<?php echo $copy; ?>
		</div>
	<?php endif; ?>


	<?php if ( get_row_layout() == 'buttons' ) : ?>
		<!-- Buttons -->
		<?php
			$buttons = get_sub_field('buttons');
			$mb      = get_sub_field('mb');
		?>
		<div class="btns-row row gutters-10px <?php echo $mb; ?>">
			<?php foreach( $buttons as $button ) { ?>
				<div class="col-auto">
					<a href="<?php echo $button['link']['url']; ?>" class="btn btn-md btn-<?php echo $button['color']; ?>" target="<?php echo $button['link']['target']; ?>"><?php echo $button['link']['title']; ?></a>
				</div> <!-- .col-auto -->
			<?php } ?>
		</div> <!-- .row -->
	<?php endif; ?>


	<?php if ( get_row_layout() == 'alert' ) : ?>
		<!-- Alert -->
		<?php
			$type    = get_sub_field('type');
			$heading = get_sub_field('heading');
			$copy    = get_sub_field('copy');
			$mb      = get_sub_field('mb');
		?>
		<div class="alert alert--<?php echo $type; ?> <?php echo $mb; ?>">
			<h5><?php echo $heading; ?></h5>
			<?php echo $copy; ?>
		</div>
	<?php endif; ?>


	<?php if ( get_row_layout() == 'list' ) : ?>
		<!-- List -->
		<?php
			$type = get_sub_field('type');
			$list = get_sub_field('list');
			$mb   = get_sub_field('mb');
		?>
		<ul class="list--<?php echo $type; ?> <?php echo $mb; ?>">
			<?php foreach( $list as $item ) { ?>
				<li><?php echo $item['copy']; ?></li>
			<?php } ?>
		</ul>
	<?php endif; ?>


<?php
	endwhile; //layout
	endif; //layout
?>