<?php
echo head(array('title'=>metadata('collection', array('Dublin Core', 'Title')), 'bodyid'=>'collections', 'bodyclass' => 'show'));

$total_items = get_record('collection')->totalItems();

$link_to_all_items_in_collection = fobres_theme_link_to_items_in_collection(
    __('See all %s items', $total_items),
    null,
    null,
    null,
    array('sort_field' => 'Dublin Core,Identifier')
);
?>

<h1><?php echo __('Collection: ') . metadata('collection', array('Dublin Core','Title')); ?></h1>
<section>
    <h2><?php echo __('Description'); ?></h2>

    <div class="element-text"><?php
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

<section id="collections-show-item-list">
    <h2><?php echo __('Items in this Collection'); ?></h2>
    <?php if ($total_items > 5): ?>
        <div class="collections-show-more-items-line">
            <?php echo __('Showing first five items in this collection.'); ?>
            <?php echo $link_to_all_items_in_collection; ?>
        </div>
    <?php endif; ?>
    <ul>
        <?php while (forbes_theme_loop_items_in_collection(5, array('sort_field' => 'Dublin Core,Identifier'))): ?>
            <?php common("show-in-browse", $vars = array(), $dir = 'items') ?>
        <?php endwhile; ?>
    </ul>
    <?php if($total_items > 5): ?>
        <div class="collections-show-more-items-line">
            <?php echo __('Showing first five items in this collection.');?>
            <?php echo $link_to_all_items_in_collection; ?>
        </div>
    <?php endif; ?>
</section>

<?php
echo fire_plugin_hook('append_to_collections_show');
echo foot();
