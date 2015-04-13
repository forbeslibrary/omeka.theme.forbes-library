<?php
$pageTitle = __('Exhibits');
echo head(array('title'=>$pageTitle,'bodyid'=>'exhibits','bodyclass' => 'browse'));
?>
<h1><?php echo $pageTitle; ?></h1>

<?php
// We will include all exhibits on this page, sorted by exhibit name
// We have sacrificed easy pagination in order to allow for easy sorting
set_loop_records('exhibits', get_records('exhibit', array ('sort_field'=>'name')));
?>

<ul class="records-list exhibits-list">
<?php foreach (loop('exhibits') as $exhibit): ?>
    <?php set_current_record('exhibit', $exhibit); ?>
    <li class="exhibit record">
      <h2>
          <?php echo link_to_exhibit(metadata('exhibit', 'Title')); ?>
      </h2>
      <div class="element-text description">
        <?php echo text_to_paragraphs(metadata('exhibit', 'Description', array('no_escape' => true))); ?>
       </div>
      <?php echo fire_plugin_hook('append_to_exhibits_browse_each'); ?>
      <?php echo link_to_exhibit(__('More on this exhibit.')); ?>
    </li>
<?php endforeach; ?>
</ul>

<?php echo fire_plugin_hook('append_to_exhibits_browse'); ?>
<?php echo foot(); ?>
