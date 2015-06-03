<?php

/**
 * items/search-summary.php template for the forbes-library Omeka theme
 *
 * A partial template called by items/browse.php. This template describes the
 * search query, if any, in a human readable form.
 *
 * This template looks for the following variables
 * - $total_results : total number of matching items (not just on this page)
 */

if (isset($_GET['search']) && $_GET['search']!='') {
	$limits[] = __(
		'with at least one of the words in the query "%s"',
		html_escape($_GET['search'])
	);
}
if (isset($_GET['advanced'])) {
	foreach ($_GET['advanced'] as $search_line) {
		$element = @get_db()->getTable('Element')->find($search_line['element_id'])->name;
		$type = $search_line['type'];
		if (isset($search_line['terms'])) {
			$terms = $search_line['terms'];
		} else {
			$terms = '';
		}
		if ($element=='' or $type=='') {
				continue;
		}
		if ($terms=='') {
			$limits[] = html_escape(__('where the %1$s field %2$s', $element, $type));
		} else {
			$limits[] = html_escape(__('where the %1$s field %2$s \'%3$s\'', $element, $type, $terms));
		}
	}
}
if (isset($_GET['range']) && $_GET['range']!='') {
	$range = $_GET['range'];
	if (is_numeric($range)) {
		$limits[] = __('with id %s', html_escape($_GET['range']));
	} else {
		$limits[] = __('with ids %s', html_escape($_GET['range']));
	}
}
if (isset($_GET['collection']) && $_GET['collection']!='') {
	$collection_id = $_GET['collection'];
	if (is_numeric($collection_id) and ($collection = get_record_by_id('collection', $collection_id))) {
		set_current_record('collection', $collection);
		$limits[] = __(
			'in the collection <a href="%1$s">%2$s</a>',
			url('collections/show/'.$collection_id),
			metadata('collection', array('Dublin Core', 'Title'))
		);
	} elseif ($collection_id !='') {
			$limits[] = __('in the collection with id %s (collection does not exist)', html_escape($collection_id));
	}
}
if (isset($_GET['type']) && $_GET['type']!='') {
	$type_id = $_GET['type'];
	$table = get_db()->getTable('ItemType');
	$type_name = $table->find($type_id)->name;
	if ($type_name) {
		$limits[] = __('where the type is %s', html_escape($type_name));
	} else {
		$limits[] = __('where the type has the id %s (type does not exist)', html_escape($type_id));
	}
}
if (isset($_GET['tags']) && $_GET['tags']!='') {
	$delimiter = get_option('tag_delimiter');
	$tags = explode($delimiter, $_GET['tags']);
	$limits[] = __(
		'with the %1$s "%2$s"',
		count($tags) ? __('tag') : __('tags'),
		implode($delimiter, $tags)
	);
}
if (isset($_GET['user']) && $_GET['user']!='') {
	$user_id = $_GET['user'];
	$table = get_db()->getTable('User');
	$username = $table->find($user_id)->username;
	if ($username) {
		$limits[] = __('created by %s', html_escape($username));
	} else {
		$limits[] = __('created by user with the id %s (user does not exist)', html_escape($user_id));
	}
}
if (isset($_GET['public']) && $_GET['public']) {
	if ($_GET['public']==1) {
		$limits[] = __('which are public');
	} else {
		$limits[] = __('which are not public');
	}
}
if (isset($_GET['featured']) && $_GET['featured']) {
	if ($_GET['featured']==1) {
		$limits[] = __('which are featured');
	} else {
		$limits[] = __('which are not featured');
	}
}
if ($tag = Zend_Controller_Front::getInstance()->getRequest()->getParam('tag')) {
	$limits[] = __(
		'with the tag "%s"',
		$tag
	);
}
if (isset($limits)): ?>
<?php
echo __('%1$s %2$s your search for items %3$s.',
	$total_results,
	($total_results==1 ? __('item matches') : __('items match')),
	implode(__(' AND '), $limits)
);
endif;
