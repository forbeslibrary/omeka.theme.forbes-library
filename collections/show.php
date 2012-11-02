<?php head(array('title'=>collection('Name'), 'bodyid'=>'collections', 'bodyclass' => 'show')); ?>

<h1><?php echo __('Collection: ') . collection('Name'); ?></h1>
<section>
    <h2><?php echo __('Description'); ?></h2>
    <div class="element-text"><?php echo nls2p(collection('Description')); ?></div>
</section>

<?php if (collection_has_collectors()): ?>
<section>
    <h2><?php echo __('Collector(s)'); ?></h2>
    <ul>
        <li><?php echo collection('Collectors', array('delimiter'=>'</li><li>')); ?></li>
    </ul>
</section>
<?php endif; ?>
    
<section id="collections-show-item-list">
    <h2><?php echo __('Items in this Collection'); ?></h2>
    <?php
    $total_items = total_items_in_collection();
    if ($total_items > 5): ?>
        <div class="collections-show-more-items-line">
            <?php echo __('Showing first five items in this collection.');?>
            <?php echo link_to_items_in_collection(__('See all %s items', $total_items));?>
        </div>
    <?php endif; ?>
    <ul>
        <?php while (forbes_theme_loop_items_in_collection(5, array('sort_field' => 'Dublin Core,Identifier'))): ?>
            <?php common("show-in-browse", $vars = array(), $dir = 'items') ?>
        <?php endwhile; ?>
    </ul>
    <? if ($total_items > 5): ?>
        <div class="collections-show-more-items-line">
            <?php echo __('Showing first five items in this collection.');?>
            <?php echo link_to_items_in_collection(__('See all %s items', $total_items));?>
        </div>
    <?php endif; ?>
</section>

<?php echo plugin_append_to_collections_show(); ?>
<?php foot(); ?>

