<?php
$pageTitle = __('Exhibits');
echo head(array('title'=>$pageTitle,'id'=>'exhibits', 'class' => 'browse'));
?>
<h2><?php echo $pageTitle; ?></h2>

<?php
// We will include all exhibits on this page, sorted by exhibit name
// We have sacrificed easy pagination in order to allow for easy sorting
set_loop_records('exhibits', get_records('exhibit', array ('sort_field'=>'name')));
?>

<ul class="records-list exhibits-list">
<?php foreach (loop('exhibits') as $exhibit): ?>
	<?php set_current_record('exhibit', $exhibit); ?>
	<li class="exhibit record">
		<a href="<?php echo record_url($exhibit); ?>" class="block-link">
			<h2>
					<?php echo metadata('exhibit', 'Title'); ?>
			</h2>
			<div class="element-text description">
				<?php echo text_to_paragraphs(metadata('exhibit', 'Description', array('no_escape' => true))); ?>
			</div>
		</a>
		<?php if (is_allowed($exhibit, 'edit')): ?>
			<div class="edit-link">
				<a href="<?php echo admin_url('exhibits/edit/' . metadata('exhibit', 'id')); ?>">
					<?php echo __('edit exhibit'); ?>
				</a>
			</div>
		<?php endif; ?>
	</li>
<?php endforeach; ?>
</ul>

<?php echo foot(); ?>
