<?php echo head(array('bodyid'=>'home')); ?>

<?php if (get_theme_option('Homepage Text')): ?>
<div id="home-page-text"><?php echo get_theme_option('Homepage Text'); ?></div>
<?php endif; ?>

<?php if (get_theme_option('Homepage Search')): ?>
<form id="simple-search" action="<?php echo uri(array('controller'=>'items', 'action'=>'browse'))?>" method="get">
    <input type="search" name="search" id="search" value="" class="textinput">
    <input type="submit" name="submit_search" id="submit_search" value="Search">
</form>
<?php endif; ?>

<div id="featured-content" class="<?php echo forbes_theme_featured_content_class(); ?>">
	<?php if (get_theme_option('Display Featured Item') !== '0'): ?>
		<section class="featured-item">
      <?php echo forbes_theme_display_random_featured_item(); ?>
    </section>
	<?php endif; ?>

	<?php if (get_theme_option('Display Featured Collection') !== '0'): ?>
		<section class="featured-collection">
			<?php echo forbes_theme_display_random_featured_collection(); ?>
		</section>
	<?php endif; ?>

	<?php if (get_theme_option('Display Featured Exhibit') !== '0'): ?>
		<section class="featured-exhibit">
			<?php echo forbes_theme_display_random_featured_exhibit(); ?>
		</section>
	<?php endif; ?>
</div>

<?php echo foot(); ?>
