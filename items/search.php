<?php
$pageTitle = __('Search Items');
echo head(array('title' => $pageTitle,
'bodyclass' => 'items advanced-search'));
?>

<h1><?php echo $pageTitle; ?></h1>

<?php echo $this->partial('items/search-form.php',
array('formAttributes' =>
array('id'=>'advanced-search-form'))); ?>

<?php fire_plugin_hook('public_items_search', array('view' => $this)); ?>

<?php echo foot(); ?>
