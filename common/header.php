<!DOCTYPE html>
<html lang="<?php echo get_html_lang(); ?>">
<head><?php
    // Meta tags
    $this->headMeta()->setCharset('utf-8');
    $this->headMeta()->appendName('viewport', 'width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1');
    if ( $description = settings('description')) {
        $this->headMeta()->appendName('description', $description);
    }
    echo $this->headMeta();
    
    // title
    echo '<title>';
    if (isset($title)) {
        echo strip_formatting($title).' | ';	
    }
    echo settings('site_title');
    echo '</title>';

    // link tags
    echo auto_discovery_link_tags();
    echo forbes_theme_favicon_link_tag();
    echo forbes_theme_largeicon_link_tag();
    plugin_header();

    forbes_theme_queue_generated_css('style.php');
    display_css();
    display_js(); ?>
</head>

<?php echo body_tag(array('id' => @$bodyid, 'class' => @$bodyclass)); ?>
    <?php if(!array_key_exists('print',$_GET)):?>
    <?php plugin_body();?>
	<?php plugin_page_header(); ?>
	<header id="page-header">
        <nav id="top-level-nav" tabindex="0" onclick="void(0)";><!-- tabindex and onclick are neccesary for css dropdown menu! -->
            <h2 class="navigation-label"><?php echo __('Navigation'); ?></h2>
		<ul class="navigation">
                    <li class="nav-jump-to-content"><a href="#content" tabindex="0"><?php echo __('Skip to content') ?></a></li>
                    <?php echo forbes_theme_public_header_nav(); ?>
                    <?php if (get_theme_option('main_site_title')):?>
                    <li><a href="<?php echo get_theme_option('main_site_url');?>"><?php echo get_theme_option('main_site_title');?></a></li>
                    <?php endif; ?>
		</ul>
		<div class="navigation-close"/>
		</nav>
        
        <?php if ($logo = custom_display_logo()): ?>
        <div id="site-logo"><?php echo link_to_home_page($logo); ?></div>
        <?php endif; ?>		
		
		<?php if (!in_array(current_uri(),array(uri('/'),uri('/items/advanced-search')))): ?>
		<form id="simple-search" action="<?php echo uri('items/browse'); ?>" method="get">		
			<input type="search" name="search" id="search" value="" class="textinput">
			<input type="submit" name="submit_search" id="submit_search" value="Search">		
		</form>
		<?php endif; ?>
		<?php echo custom_header_image(); ?>
	</header>
	<?php endif; ?>

	<div id="content">
		<?php plugin_page_content(); ?>

