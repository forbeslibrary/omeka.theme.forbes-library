<?php
$pageTitle = __('Collections');
echo head(array('title'=>$pageTitle,'bodyid'=>'collections','bodyclass' => 'browse'));
?>
<h1><?php echo $pageTitle; ?></h1>

<?php
// We will include all collections on this page, sorted by collection name
// We have sacrificed easy pagination in order to allow for easy sorting
set_loop_records('collections', get_records('collection', array ('sort_field'=>'name')));
?>

<ul class="collections-browse-collection-list">
<?php foreach (loop('collections') as $collection): ?>
    <?php set_current_record('collection', $collection); ?>
    <li class="collections-browse-collection-entry">
      <?php echo link_to_collection('<h2>'.metadata('collection', array('Dublin Core', 'Title')).'</h2>'); ?>
      <?php echo text_to_paragraphs(metadata('collection', array('Dublin Core', 'Description'))); ?>
      <?php echo fire_plugin_hook('append_to_collections_browse_each'); ?>
      <?php echo link_to_collection(__('More on this collection.')); ?>
    </li>
<?php endforeach; ?>
</ul>

<?php echo fire_plugin_hook('append_to_collections_browse'); ?>
<?php echo foot(); ?>
