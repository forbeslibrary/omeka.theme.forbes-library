<?php
$forbesThemeSession = new Zend_Session_Namespace('forbes_theme');
?>
<!DOCTYPE html>
<html lang="<?php echo get_html_lang(); ?>">

<?php echo common('head'); ?>

<?php echo body_tag(array('id' => @$bodyid, 'class' => @$bodyclass)); ?>
  <!-- plugin hook 'public_body' -->
  <?php fire_plugin_hook('public_body', array('view'=>$this)); ?>
  <div id="wrapper">
	<header id="page-header">
    <!-- plugin hook 'public_header' -->
	  <?php fire_plugin_hook('public_header', array('view'=>$this)); ?>

		<!-- front matter (includes site title, quick links, and search -->

		<div id="banner">
      <?php theme_logo(); ?>
      <h1 id="site-title"><?php echo link_to_home_page(); ?></h1>
    </div>

    <!-- custom navigation links as defined in the theme configuration -->
		<div id="header-buttons">
		  <?php echo forbes_theme_public_header_nav(); ?>
		</div>

		<!-- simple search form -->
		<form id="simple-search" action="<?php echo url('items/browse'); ?>" method="get">
			<input type="search" name="search" id="search" value="" class="textinput">
			<input type="submit" name="submit_search" id="submit_search" value="Search">
		</form>

		<!-- menu bar -->
		<nav id="top-level-nav" class="menu_bar">
			<h2 class="navigation-label"><a href="<?php echo url('?nav=True');?>"><?php echo __('Navigation'); ?></a></h2>
			<span class="nav-jump-to-content"><a href="#content" tabindex="0"><?php echo __('Skip to content') ?></a></span>
			<?php echo public_nav_main(); ?>
		</nav>
	</header>

	<div id="content">
		<?php fire_plugin_hook('public_content', array('view'=>$this));
