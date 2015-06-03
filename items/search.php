<?php

/**
 * items/search.php template for the forbes-library Omeka theme
 *
 * Outputs a the items search page (advanced search).
 */

// == Set variables for this template =========================================
$pageTitle = __('Search Items');
$headOptions = array(
	'title' => $pageTitle,
	'class' => 'items advanced-search'
);
// == Content begins here =====================================================
?>
<?php echo head($headOptions); ?>
<h1>
	<?php echo $pageTitle; ?>
</h1>
<?php echo $this->partial('items/search-form.php',
	array('formAttributes' =>
		array('id'=>'advanced-search-form')
	)
); ?>
<?php echo foot(); ?>
