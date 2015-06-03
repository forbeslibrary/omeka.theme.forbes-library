<?php

/**
 * items/show-in-browse.php template for the forbes-library Omeka theme
 *
 * Outputs a single item in a <li> element.
 *
 * This template looks for the following variables
 * - $item : the item to be output
 */

// == Set variables for this template =========================================
$thumbnail = "";
if (metadata($item, 'has thumbnail')) {
	$thumbnail = item_image('thumbnail', array('class' => 'thumbnail'));
} else {
	$thumbnail = '<img src="' . img('fallback-file.png') . '">';
}
// == Content begins here =====================================================
?>
<li class="item record">
	<a href="<?php echo record_url($item); ?>" class="block-link">
		<h2><?php echo metadata($item, array('Dublin Core', 'Title')); ?></h2>

		<?php echo $thumbnail; ?>

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
					<?php echo ForbesTheme::snippet_with_new_lines(metadata($item, array('Dublin Core', 'Description')),0,200); ?>
			</div>
		</div>
	</a>

	<?php if (is_allowed($item, 'edit')): ?>
		<div class="edit-link">
			<a href="<?php echo admin_url('items/edit/' . metadata('item', 'id')); ?>">
				<?php echo __('edit item'); ?>
			</a>
		</div>
	<?php endif; ?>
</li>
