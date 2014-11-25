<li class="items-show-in-browse">
	<h2><?php
		$title = metadata($item, array('Dublin Core', 'Title'), array('snippet'=>50));
		$id = metadata($item, array('Dublin Core', 'Identifier'));
		$line = $title ? $id.': '.$title : $id; 
		echo link_to_item($line, array('class'=>'permalink'));
	?></h2>
	<figure>
    	<?php $thumbnail = (metadata($item, 'has thumbnail') ? item_image('thumbnail', array('class'=>'thumbnail')) :  '<img src="'.img('image-not-available.png').'">' ); ?>
		<?php echo link_to_item($thumbnail); ?>
	</figure>
	<div class="items-show-in-browse-details">
	    <?php if ($format = metadata($item, array('Dublin Core', 'Format'))) {
	        echo __('Format: %s.', $format);
	    } ?>
	    <?php if ($creator = metadata($item, array('Dublin Core', 'Creator'))) {
	        echo __('Creator: %s.', $creator);
	    } ?>

        <div class="items-show-in-browse-description">
            <?php echo forbes_theme_snippet_with_new_lines(metadata($item, array('Dublin Core', 'Description')),0,200); ?>
        </div>
		<?php echo fire_plugin_hook('append_to_items_browse_each'); ?>
		<?php echo link_to_item(__('More information'), array('class'=>'items-show-in-browse-details')); ?>
	</div>
</li>
