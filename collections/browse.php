<?php


/**
 * collections/browse.php template for the forbes-library Omeka theme
 *
 * Outputs a list of collections.
 */

// == Set variables for this template =========================================
$pageTitle = __('Collections');
$sort_field = 'Dublin Core,Title';
$sort_dir = 'a';
if (get_option('defaultsort_collections_option')) {
	$sort_field = get_option('defaultsort_collections_option');
}
if (get_option('defaultsort_collections_direction')) {
	$sort_dir = get_option('defaultsort_collections_direction');
}
$headOptions = array(
	'title' => $pageTitle,
	'id' => 'collections',
	'class' => 'browse'
);

// == Content begins here =====================================================
echo head($headOptions);
?>
<h1>
	<?php echo $pageTitle; ?>
</h1>

<?php set_loop_records(
	'collections',
	get_records(
		'collection',
		array(
			'sort_field' => $sort_field,
			'sort_dir' => $sort_dir
		),
		null
	)
); ?>

<ul class="records-list collections-list">
<?php foreach (loop('collections') as $collection): ?>
	<?php set_current_record('collection', $collection); ?>
	<li class="record collection">
		<a href="<?php echo record_url($collection); ?>" class="block-link">
			<h2>
				<?php echo metadata('collection', array('Dublin Core', 'Title')); ?>
			</h2>
			<div class="element-text description">
				<?php echo ForbesTheme::summary(metadata('collection', array('Dublin Core', 'Description'))); ?>
			</div>
		</a>

		<?php fire_plugin_hook('public_collections_browse_each' , array('collection' => $collection, 'view' => $this)); ?>

		<?php if (is_allowed($collection, 'edit')): ?>
			<div class="edit-link">
				<a href="<?php echo admin_url('collections/edit/' . metadata('collection', 'id')); ?>">
					<?php echo __('edit collection'); ?>
				</a>
			</div>
		<?php endif; ?>

	</li>
<?php endforeach; ?>
</ul>

<?php fire_plugin_hook('public_collections_browse', array('collections' => $collections, 'view' => $this)); ?>
<?php echo foot(); ?>
