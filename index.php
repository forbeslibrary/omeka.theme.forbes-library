<?php

/**
 * index.php template for the forbes-library Omeka theme
*/

// == Content begins here =====================================================

<?php echo head(array('bodyid'=>'home')); ?>

<?php if (get_theme_option('Homepage Text')): ?>
  <div id="home-page-text">
    <?php echo get_theme_option('Homepage Text'); ?>
  </div>
<?php endif; ?>

<?php if (get_theme_option('Homepage Search')): ?>
  <form id="simple-search" action="<?php echo uri(array('controller'=>'items', 'action'=>'browse'))?>" method="get">
      <input type="search" name="search" id="search" value="" class="textinput">
      <input type="submit" name="submit_search" id="submit_search" value="Search">
  </form>
<?php endif; ?>

<div id="featured-content" class="<?php echo ForbesTheme::featured_content_class(); ?>">
	<?php if (get_theme_option('Display Featured Item') !== '0'): ?>
		<section class="featured-item">
      <?php echo ForbesTheme::display_random_featured_item(); ?>
    </section>
	<?php endif; ?>

	<?php if (get_theme_option('Display Featured Collection') !== '0'): ?>
		<section class="featured-collection">
			<?php echo ForbesTheme::display_random_featured_collection(); ?>
		</section>
	<?php endif; ?>

	<?php if (get_theme_option('Display Featured Exhibit') !== '0'): ?>
		<section class="featured-exhibit">
			<?php echo ForbesTheme::display_random_featured_exhibit(); ?>
		</section>
	<?php endif; ?>
</div>

<?php fire_plugin_hook('public_home', array('view' => $this)); ?>

<?php echo foot(); ?>
