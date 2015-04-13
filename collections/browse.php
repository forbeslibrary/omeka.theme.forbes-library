<?php
$pageTitle = __('Collections');
echo head(array('title'=>$pageTitle,'bodyid'=>'collections','bodyclass' => 'browse'));
?>
<h1><?php echo $pageTitle; ?></h1>

<?php
// Retrieve the collections to show on this page.
// We use options from the default sort plugin if they are set
$sort_field = 'Dublin Core,Title';
$sort_dir = 'a';
if (get_option('defaultsort_collections_option')) {
  $sort_field = get_option('defaultsort_collections_option');
}
if (get_option('defaultsort_collections_direction')) {
  $sort_dir = get_option('defaultsort_collections_direction');
}
set_loop_records(
  'collections',
  get_records(
    'collection',
    array(
      'sort_field' => $sort_field,
      'sort_dir' => $sort_dir
    )
  )
);
?>

<ul class="records-list collections-list">
<?php foreach (loop('collections') as $collection): ?>
    <?php set_current_record('collection', $collection); ?>
    <li class="record collect">
      <h2>
          <?php echo link_to_collection(metadata('collection', array('Dublin Core', 'Title'))); ?>
      </h2>
      <div class="element-text description">
        <?php echo text_to_paragraphs(metadata('collection', array('Dublin Core', 'Description'))); ?>
       </div>
      <?php echo fire_plugin_hook('append_to_collections_browse_each'); ?>
      <?php echo link_to_collection(__('More on this collection.')); ?>
    </li>
<?php endforeach; ?>
</ul>

<?php echo fire_plugin_hook('append_to_collections_browse'); ?>
<?php echo foot(); ?>
