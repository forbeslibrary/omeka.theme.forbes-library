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
head(array('title'=>$pageTitle,'bodyid'=>'items','bodyclass' => 'browse'));
?>

<h1><?php echo $pageTitle;?></h1>
<?php
if (!forbes_theme_on_search_results_page()) {
    common('browse-navigation', array(), 'items');
} else {
    common('search-warnings', array(), 'items');
    common('search-summary', array(), 'items');
}
?>
<div id="pagination-top" class="pagination"><?php echo pagination_links(); ?></div>
<div id="items-browse-loop">
	<?php while (loop_items()): ?>
		<?php common("show-in-browse", array(), 'items') ?>
	<?php endwhile; ?>
</div>
<div id="pagination-bottom" class="pagination"><?php echo pagination_links(); ?></div>

<?php echo plugin_append_to_items_browse(); ?>
<?php foot();?>
