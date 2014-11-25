<?php
if (isset($_GET['search'])) {
	$pageTitle = __('Search Results');
} elseif ($tag = Zend_Controller_Front::getInstance()->getRequest()->getParam('tag')) {
	$pageTitle = __('Browse by Tag: %s', $tag);
} elseif (isset($_GET['collection'])) {
	$pageTitle = __('Browse Collection');
} else {
	$pageTitle = __('Browse Items');
}
echo head(array('title'=>$pageTitle,'bodyid'=>'items','bodyclass' => 'browse'));
?>

<h1><?php echo $pageTitle;?></h1>
<?php
if (!forbes_theme_on_search_results_page()) {
    echo common('browse-navigation', array(), 'items');
} else {
    echo common('search-warnings', array(), 'items');
    echo common('search-summary', array(), 'items');
}
?>
<div id="pagination-top" class="pagination"><?php echo pagination_links(); ?></div>
<div id="items-browse-loop">
	<?php foreach (loop('items') as $item): ?>
		<?php echo common("show-in-browse", array('item' => $item), 'items') ?>
	<?php endforeach; ?>
</div>
<div id="pagination-bottom" class="pagination"><?php echo pagination_links(); ?></div>

<?php echo fire_plugin_hook('append_to_items_browse'); ?>
<?php echo foot();?>
