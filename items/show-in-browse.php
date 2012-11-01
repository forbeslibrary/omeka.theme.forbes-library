<li class="items-show-in-browse">
	<h2><?php
		$title = item('Dublin Core', 'Title', array('snippet'=>50));
		$id = item('Dublin Core', 'Identifier');
		$line = $title ? $id.': '.$title : $id; 
		echo link_to_item($line, array('class'=>'permalink'));
	?></h2>
	<figure>
    	<?php $thumbnail = (item_has_thumbnail() ? item_thumbnail() :  '<img src="'.img('image-not-available.png').'">' ); ?>
		<?php echo link_to_item($thumbnail); ?>
	</figure>
	<div class="items-show-in-browse-details">
	    <?php if ($format = item('Dublin Core', 'Format')) {
	        echo __('Format: %s.', $format);
	    } ?>
	    <?php if ($creator = item('Dublin Core', 'Creator')) {
	        echo __('Creator: %s.', $creator);
	    } ?>

        <div class="items-show-in-browse-description">
            <?php echo forbes_theme_snippet_with_new_lines(item('Dublin Core', 'Description'),0,200) ?>
        </div>
		<?php echo plugin_append_to_items_browse_each(); ?>
		<?php echo link_to_item(__('More information'), array('class'=>'items-show-in-browse-details')); ?>
	</div>
</li>