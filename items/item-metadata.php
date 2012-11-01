<table class="element-set">
	<?php $setName = html_escape(__($setName)); 
	if ($setName != "Dublin Core"): ?>
		<tr><th colspan="2" class="element-set-name"><?php echo $setName; ?></th></tr>
	<?php endif ?>
	<?php foreach ($elementsInSet as $info): 
	$elementName = $info['elementName'];
	$elementRecord = $info['element'];
	if ($info['isShowable']): ?>
	<tr>
	<td class="element-name"><?php echo html_escape(__($elementName)); ?></td>
	<td class="element-text"><?php if ($info['isEmpty']): ?>
		<div class="element-text-empty"><?php echo __($info['emptyText']); ?></div>
	</td>
	</tr>
	<?php else: ?>
	<?php
	// We need to extract the element set name from the record b/c
	// $setName contains the 'pretty' version of it that may be named differently
	// than the actual element set.
	?>
	<?php foreach ($info['texts'] as $text): ?>
		<div><?php echo $text; ?></div>
	<?php endforeach; ?>
	<?php endif; ?>
<?php endif; ?>
<?php endforeach; ?>
</table>
