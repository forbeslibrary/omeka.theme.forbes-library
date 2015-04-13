<?php
$pageTitle = __('View Item Tags');
echo head(array('title'=>$pageTitle,'bodyid'=>'items','bodyclass'=>'tags'));
?>
<h1><?php echo $pageTitle;?></h1>
<?php common('browse-navigation', array('pageTitle'=>$pageTitle), 'items')?>
<?php
$tags = get_records('Tag', array('sort_field' => 'name', 'type' => 'item'), null);
// Remove tags to unreachable items (such as non-public items for a non-logged in user)
foreach ($tags as $i => $tag) {
    $tag_name = $tag['name'];
    $items = get_records('Item', array('tags' => $tag_name));
    if (count($items)==0) {
        unset($tags[$i]);
    }
}
echo tag_cloud($tags,url('items/browse'));
echo foot();
