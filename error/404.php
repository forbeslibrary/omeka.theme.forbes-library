<?php

/**
 * error/404.php template for the forbes-library Omeka theme
 */

// == Output HTTP header ======================================================
header("HTTP/1.0 404 Not Found");

// == Set variables for this template =========================================
$errorMessage = __(
	'The URL %s was not found on this server.',
	$_SERVER['REQUEST_URI']
	);
$pageTitle = __('404 Not Found');
$headVars = array(
	'title' => $pageTitle,
	'bodyid' => '404',
	'bodyclass' => 'error 404'
	);

// == Content begins here =====================================================
?>
<?php echo head($headVars); ?>
<h2>
	<?php echo $pageTitle; ?>
</h2>
<p>
	<?php echo $errorMessage; ?>
</p>
<?php if (get_theme_option('404_help_text')): ?>
	<p>
		<?php echo get_theme_option('404_help_text'); ?>
	</p>
<?php endif ?>
<?php echo foot();
