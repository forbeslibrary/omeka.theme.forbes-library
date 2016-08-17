<?php

/**
 * items/browse.php template for the forbes-library Omeka theme
 *
 * Outputs a list of items.
 *
 * This template looks for the following variables
 * - $items : the items to be displayed on this page
 * - $total_results : total number of matching items (not just on this page)
 */

// == Set variables for this template =========================================
$tag = Zend_Controller_Front::getInstance()->getRequest()->getParam('tag');
$pageTitle = __('Items');
if (isset($_GET['search'])) {
	$pageTitle = __('Search Results');
} elseif ($tag) {
	$pageTitle = __('Browse by Tag: %s', $tag);
} elseif (isset($_GET['collection'])) {
	$pageTitle = __('Browse Collection');
}
$headOptions = array(
	'title' => $pageTitle,
	'id' => 'items',
	'class' => 'browse'
);
// == Content begins here =====================================================
echo head($headOptions); ?>
<h1>
	<?php echo $pageTitle;?>
</h1>
<?php
if (ForbesTheme::on_search_results_page()) {
	echo common(
		'search-summary',
		array('total_results' => $total_results),
		'items'
	);
}
?>
<div id="pagination-top" class="pagination">
	<?php echo pagination_links(); ?>
</div>
<ul class="records-list items-list">
	<?php foreach (loop('items') as $item): ?>
		<?php echo common("show-in-browse", array('item' => $item), 'items') ?>
		<!-- plugin hook append_to_items_browse_each -->
		<?php fire_plugin_hook('public_items_browse', array('items' => $items, 'view' => $this)); ?>
	<?php endforeach; ?>
</ul>
<div id="pagination-bottom" class="pagination"><?php echo pagination_links(); ?></div>

<?php fire_plugin_hook('public_items_browse', array('items' => $items, 'view' => $this)); ?>

<?php echo foot();?>
