<?php
echo head(array(
  'title' => metadata('collection', array('Dublin Core', 'Title')),
  'bodyid' => 'collections',
  'bodyclass' => 'show'
  ));

$total_items = get_current_record('collection')->totalItems();

$link_to_all_items_in_collection = link_to_items_in_collection(
  __('See all %s items in this collection',
  $total_items)
);
?>

<h1><?php echo __('Collection: ') . metadata('collection', array('Dublin Core','Title')); ?></h1>
<section>
    <h2><?php echo __('Description'); ?></h2>

    <div class="element-text description"><?php
    // we get the description this way so that HTML will not be escaped
    // Note that the HTML is not sanitized either!
    echo text_to_paragraphs(metadata('collection', array('Dublin Core', 'Description')));
   ?></div>
</section>

<?php $collectors = metadata('collection', array('Dublin Core', 'Contributor')); ?>
<?php if ($collectors): ?>
<section>
    <h2><?php echo __('Collector(s)'); ?></h2>
    <ul>
        <li><?php echo $collectors; ?></li>
    </ul>
</section>
<?php endif; ?>

<section>
    <h2 class="collection-items-heading"><?php echo __('Items in this Collection'); ?></h2>
    <?php if ($total_items > 6): ?>
        <div class="collections-show-more-items-line">
            <?php echo $link_to_all_items_in_collection; ?>
            <?php echo __('Showing first six items in this collection.'); ?>
          </div>
    <?php endif; ?>
    <?php
    // Retrieve the items to show on this page.
    // We use options from the default sort plugin if they are set
    $sort_field = 'Dublin Core,Identifier';
    $sort_dir = 'a';
    if (get_option('defaultsort_items_option')) {
      $sort_field = get_option('defaultsort_items_option');
    }
    if (get_option('defaultsort_items_direction')) {
      $sort_dir = get_option('defaultsort_items_direction');
    }
    $items = get_records(
      'item',
      array(
        'sort_field' => $sort_field,
        'sort_dir' => $sort_dir,
        'collection' => get_current_record('collection')->id
        ),
      6);
    ?>
    <ul class="records-list items-list">
        <?php foreach (loop('items', $items) as $item): ?>
            <?php echo common("show-in-browse", array('item' => $item), 'items') ?>
        <?php endforeach; ?>
    </ul>
    <?php if($total_items > 6): ?>
        <div class="collections-show-more-items-line">
            <?php echo __('Showing first six items in this collection.');?>
            <?php echo $link_to_all_items_in_collection; ?>
        </div>
    <?php endif; ?>
</section>

<?php
fire_plugin_hook('public_collections_show', array('collection' => $collection, 'view' => $this));
echo foot();
