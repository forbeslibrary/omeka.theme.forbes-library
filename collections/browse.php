<?php
$pageTitle = __('Collections');
head(array('title'=>$pageTitle,'bodyid'=>'collections','bodyclass' => 'browse'));
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
        <?php if ($thumbnail = forbes_theme_collection_thumbnail()): ?> 
            <figure><?php echo link_to_collection($thumbnail);?></figure>
        <?php endif; ?>
        </figure>
        
        <?php if ($description = forbes_theme_snippet_with_new_lines(get_current_collection()->description, 0, 400)): ?>
        <div>
            <h3><?php echo __('Description'); ?></h3>
            <div><?php echo nls2p($description); ?></div>
        </div>
        <?php endif; ?>
    
        <?php if(collection_has_collectors()): ?>
        <div>
            <h3><?php echo __('Collector(s)'); ?></h3>
            <div class="element-text">
                <p><?php echo collection('Collectors', array('delimiter'=>'. ')); ?>.</p>
            </div>
        </div>
        <?php endif; ?>
    
        <?php echo plugin_append_to_collections_browse_each(); ?>
        <?php echo link_to_collection(__('More on this collection.')); ?>
    </li>
<?php endforeach; ?>
</ul>

<?php echo plugin_append_to_collections_browse(); ?>
<?php foot(); ?>
