<!-- common/head -->
<head>
	<?php $forbesThemeSession = new Zend_Session_Namespace('forbes_theme'); ?>

	<!-- meta tags -->
	<?php
	$this->headMeta()->setCharset('utf-8');
	$this->headMeta()->appendName('viewport', 'width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1');
	if ( $description = option('description')) {
			$this->headMeta()->appendName('description', $description);
	}
	echo $this->headMeta();
	?>
	
	<!-- title -->
	<title>
	<?php
	if (isset($title)) {
		echo strip_formatting($title).' | ';	
	}
	echo option('site_title');
	?>
	</title>

	<!-- link tags -->
	<?php
	echo auto_discovery_link_tags();
	echo forbes_theme_favicon_link_tag();
	echo forbes_theme_largeicon_link_tag();
	?>
	
	<!-- plugin hook: public_head -->
	<?php fire_plugin_hook('public_head', array('view'=>$this)); ?>
	
	<!-- stylesheets -->
	<?php
	queue_css_url('//fonts.googleapis.com/css?family=Lato:300,400,700,900,400italic,700italic');
	queue_css_file('style');
	echo head_css();
	?>
	
	<!-- scripts -->
	<?php echo head_js(); ?>
</head>
<!-- end common/head -->

