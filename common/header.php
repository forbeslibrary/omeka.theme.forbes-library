<?php
$forbesThemeSession = new Zend_Session_Namespace('forbes_theme');

if(!isset($forbesThemeSession->useCss)) {
    $forbesThemeSession->useCss = True;
}
if (in_array(@strtolower($_GET['use_css']), array('1','true'))) {
    $forbesThemeSession->useCss = true;
}
if (in_array(@strtolower($_GET['use_css']), array('0','false'))) {
    $forbesThemeSession->useCss = false;
}

?>
<!DOCTYPE html>
<html lang="<?php echo get_html_lang(); ?>">

<?php common('head'); ?>

<?php echo body_tag(array('id' => @$bodyid, 'class' => @$bodyclass)); ?>
    <?php if(!array_key_exists('print',$_GET)):?>
    <?php fire_plugin_hook('public_body', array('view'=>$this)); ?>
	<header id="page-header">
	  <?php fire_plugin_hook('public_header', array('view'=>$this)); ?>
        <nav id="top-level-nav">
            <h2 class="navigation-label"><a href="<?php echo url('?nav=True');?>"><?php echo __('Navigation'); ?></a></h2>
		<ul class="navigation">
                    <li class="nav-jump-to-content"><a href="#content" tabindex="0"><?php echo __('Skip to content') ?></a></li>
                    <?php echo forbes_theme_public_header_nav(); ?>
                    <?php if (get_theme_option('main_site_title')):?>
                    <li><a href="<?php echo get_theme_option('main_site_url');?>"><?php echo get_theme_option('main_site_title');?></a></li>
                    <?php endif; ?>
		</ul>
		</nav>
        		
		<?php if (!in_array(current_url(),array(url('/'),url('/items/advanced-search')))): ?>
		<form id="simple-search" action="<?php echo url('items/browse'); ?>" method="get">		
			<input type="search" name="search" id="search" value="" class="textinput">
			<input type="submit" name="submit_search" id="submit_search" value="Search">		
		</form>
		<?php endif; ?>
	</header>
	<?php endif; ?>

	<div id="content">
		<?php fire_plugin_hook('public_content', array('view'=>$this));