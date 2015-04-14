<li class="item record">
	<!-- item section header -->
	<h2><?php
		echo link_to_item(
		  metadata($item, array('Dublin Core', 'Title')),
			array('class'=>'permalink')
			);
	?></h2>

	<!-- item section thumbnail -->
  <?php $thumbnail = (metadata($item, 'has thumbnail') ? item_image('thumbnail', array('class'=>'thumbnail')) :  '<img src="'.img('image-not-available.png').'">' ); ?>
	<?php echo link_to_item($thumbnail); ?>

	<!-- item section metadata -->
	<div class="items-show-in-browse-details">
		<?php if ($identifier = metadata($item, array('Dublin Core', 'Identifier'))) {
				echo __('Identifier: %s.<br>', $identifier);
		} ?>
		<?php if ($format = metadata($item, array('Dublin Core', 'Format'))) {
				echo __('Format: %s.<br>', $format);
		} ?>
		<?php if ($creator = metadata($item, array('Dublin Core', 'Creator'))) {
				echo __('Creator: %s.<br>', $creator);
		} ?>

		<div class="items-show-in-browse-description">
				<?php echo forbes_theme_snippet_with_new_lines(metadata($item, array('Dublin Core', 'Description')),0,200); ?>
		</div>
	</div>

	<?php if (is_allowed($item, 'edit')): ?>
    <div class="edit-link">
			<a href="<?php echo admin_url('items/edit/' . metadata('item', 'id')); ?>">
				<?php echo __('edit item'); ?>
			</a>
		</div>
	<?php endif; ?>

	<!-- plugin hook append_to_items_browse_each -->
	<?php echo fire_plugin_hook('append_to_items_browse_each'); ?>

	<!-- link to item -->
	<?php echo link_to_item(__('More information'), array('class'=>'items-more-info-link')); ?>
</li>
