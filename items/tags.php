<?php
$pageTitle = __('View Tags');
head(array('title'=>$pageTitle,'bodyid'=>'items','bodyclass'=>'tags'));
?>
<h1><?php echo $pageTitle;?></h1>
<?php common('browse-navigation', array('pageTitle'=>$pageTitle), 'items')?>
<?php
$tags = get_tags(array('sort' => 'alpha'), null);
// Remove tags to unreachable items (such as non-public items for a non-logged in user)
foreach ($tags as $i => $tag) {
    $tag_name = $tag['name'];
    $items = get_items(array('tags' => $tag_name));
    if (count($items)==0) {
        unset($tags[$i]);
    }
}
echo tag_cloud($tags,uri('items/browse'));
?>

<?php foot();
