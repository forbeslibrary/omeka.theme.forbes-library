<?php head(array('title' => item('Dublin Core', 'Title'), 'bodyid'=>'items','bodyclass' => 'show')); ?>
<div id="items-show-id">
    <?php
    if (item('Dublin Core', 'Title')) {
        echo item('Dublin Core', 'Title'), '. ';
    } ?>
    Image ID: <?php echo item('Dublin Core', 'Identifier');
    if (function_exists('forbes_purchase_form_public_append_to_items_show')) {
	    echo ' (';
	    forbes_purchase_form_public_append_to_items_show();
	    echo ')';
    }?>
</div>
<div id="files-container">
	<!-- The following returns all of the files associated with an item. -->
	<div><?php echo display_files_for_item(array('imageSize' => 'fullsize')); ?></div>
</div>
<div id="items-show-description-box">
	<!-- If the item belongs to a collection, the following creates a link to that collection. -->
	<?php if (item_belongs_to_collection()): ?>
	<div id="items-show-collection">
		Part of the online collection <?php echo link_to_collection_for_item(); ?>
	</div>
	<?php endif; ?>
	<div id="items-show-description"><?php echo item('Dublin Core', 'Description'); ?></div>
</div>
<div id="item-metadata-wrapper">
	<h2 id="item-metadata-button" class="_toggle_button">Image Details</h2>
	<div id="item-metadata" class="_toggle">
		<?php echo custom_show_item_metadata(); ?>
	</div>
</div>
<!-- The following prints a citation for this item. -->
<div id="item-citation-wrapper">
	<h2 id="item-citation-button" class="_toggle_button"><?php echo __('Citation'); ?></h2>
	<div class="toggle"><?php echo item_citation(); ?></div>
</div>
<?php $pluginAdditions = plugin_append_to_items_show();
if ($pluginAdditions) {
    echo '<div id="item-show-plugin-addtions">', $pluginAdditions, '</div>';
} ?>

<!-- The following prints a list of all tags associated with the item -->
<?php if (item_has_tags()): ?>
<div id="items-show-tags">
	<h3><?php echo __('Tags'); ?></h3>
	<ul>
	<?php $tags = get_tags(array('sort' => 'alpha', 'record' => $item ), 20);
	$link_base = uri('items/browse/tag/');
	foreach ($tags as $tag) {
		echo '<li><a href="'.$link_base.urlencode($tag).'">'.html_escape($tag).'</a></li>';
	} ?>
	</ul>
</div>
<?php endif;
foot();
