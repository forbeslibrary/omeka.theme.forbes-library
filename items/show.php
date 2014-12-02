<?php
$title       = metadata($item, array('Dublin Core', 'Title'));
$identifier  = metadata($item, array('Dublin Core', 'Identifier'));
$description = metadata($item, array('Dublin Core', 'Description'));
?>
<?php echo head(array('title' => $title, 'bodyid'=>'items','bodyclass' => 'show')); ?>
<div id="items-show-id">
    <?php
    if ($title) {
        echo $title, '. ';
    } ?>
    Image ID: <?php echo $identifier;
    if (function_exists('forbes_purchase_form_public_append_to_items_show')) {
	    echo ' (';
	    forbes_purchase_form_public_append_to_items_show();
	    echo ')';
    }?>
</div>
<div id="files-container">
	<!-- The following returns all of the files associated with an item. -->
	<div><?php echo files_for_item(array('imageSize' => 'fullsize')); ?></div>
</div>
<div id="items-show-description-box">
	<!-- If the item belongs to a collection, the following creates a link to that collection. -->
	<?php if ($item->collection): ?>
	<div id="items-show-collection">
		Part of the online collection <?php echo link_to_collection_for_item(); ?>
	</div>
	<?php endif; ?>
	<div id="items-show-description"><?php echo $description; ?></div>
</div>
<div id="item-metadata-wrapper">
	<h2 id="item-metadata-button" class="_toggle_button">Image Details</h2>
	<div id="item-metadata" class="_toggle">
    <?php echo all_element_texts($item); ?>
	</div>
</div>
<!-- The following prints a citation for this item. -->
<div id="item-citation-wrapper">
	<h2 id="item-citation-button" class="_toggle_button"><?php echo __('Citation'); ?></h2>
	<div class="toggle"><?php echo metadata($item, 'citation', array('no_escape' => True)); ?></div>
</div>
<?php $pluginAdditions = fire_plugin_hook('append_to_items_show');
if ($pluginAdditions) {
    echo '<div id="item-show-plugin-addtions">', $pluginAdditions, '</div>';
} ?>

<!-- The following prints a list of all tags associated with the item -->
<?php if (metadata($item, 'has tags')): ?>
<div id="items-show-tags">
	<h3><?php echo __('Tags'); ?></h3>
	<?php
	$tags = get_records('Tag', array('sort' => 'alpha', 'record' => $item ), null);
	echo tag_cloud($tags, 'items/browse');
	?>
</div>
<?php endif;
echo foot();
