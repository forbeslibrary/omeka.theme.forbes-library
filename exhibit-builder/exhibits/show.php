<?php
$headOptions = array(
	'title' => html_escape(metadata('exhibit', 'title') . ' : ' . metadata('exhibit_page', 'title')),
	'id' => 'exhibit',
	'class' => 'exhibits show'
);
?>
<?php echo head($headOptions); ?>
<h2>
	<?php echo link_to_exhibit(); ?>
	<?php if (is_allowed($exhibit, 'edit')): ?>
		<div class="edit-link">
			<a href="<?php echo admin_url('exhibits/edit/' . metadata('exhibit', 'id')); ?>">
				<?php echo __('edit exhibit'); ?>
			</a>
		</div>
	<?php endif; ?>
</h2>
<?php $thisPage = $exhibitPage = get_current_record('exhibit_page'); ?>
<?php set_exhibit_pages_for_loop_by_exhibit(); ?>
<?php if (has_loop_records('exhibit_page')): ?>
<nav id="exhibit-pages">
	<ul>
		<?php foreach (loop('exhibit_page') as $exhibitPage): ?>
			<?php echo exhibit_builder_page_summary($exhibitPage); ?>
		<?php endforeach; ?>
	</ul>
</nav>
<?php endif; ?>
<?php set_current_record('exhibit_page', $thisPage); ?>
<div id="primary">
	<h2>
		<?php echo metadata('exhibit_page', 'title'); ?>
	</h2>

	<?php exhibit_builder_render_exhibit_page(); ?>

	<nav id="exhibit-page-navigation">
		<?php echo exhibit_builder_link_to_previous_page(); ?>
		<?php echo exhibit_builder_link_to_next_page(); ?>
	</nav>
</div>
<?php echo foot();
