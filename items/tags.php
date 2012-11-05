<?php
$pageTitle = __('View Tags');
head(array('title'=>$pageTitle,'bodyid'=>'items','bodyclass'=>'tags'));
?>
<h1><?php echo $pageTitle;?></h1>
<?php common('browse-navigation', array('pageTitle'=>$pageTitle), 'items')?>
<?php echo tag_cloud($tags,uri('items/browse')); ?>

<?php foot();