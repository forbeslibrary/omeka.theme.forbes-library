<?php
$headOptions = array(
	'title' => html_escape(metadata('exhibit', 'title') . ' : ' . metadata('exhibit_page', 'title')),
	'id' => 'exhibit',
	'class' => 'show'
);
?>
<?php echo head($headOptions); ?>
<h1>
	<?php echo link_to_exhibit(); ?>
</h1>

<nav id="nav-container">
	<?php echo exhibit_builder_page_nav();?>
</nav>

<h2>
	<?php echo metadata('exhibit_page', 'title'); ?>
</h2>

<?php exhibit_builder_render_exhibit_page(); ?>

<nav id="exhibit-page-navigation">
	<?php echo exhibit_builder_link_to_previous_page(); ?>
	<?php echo exhibit_builder_link_to_next_page(); ?>
</nav>
<?php echo foot();
