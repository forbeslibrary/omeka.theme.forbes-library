<head><?php
    $forbesThemeSession = new Zend_Session_Namespace('forbes_theme');

    // Meta tags
    $this->headMeta()->setCharset('utf-8');
    $this->headMeta()->appendName('viewport', 'width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1');
    if ( $description = option('description')) {
        $this->headMeta()->appendName('description', $description);
    }
    echo $this->headMeta();
    
    // title
    echo '<title>';
    if (isset($title)) {
        echo strip_formatting($title).' | ';	
    }
    echo option('site_title');
    echo '</title>';

    // link tags
    echo auto_discovery_link_tags();
    echo forbes_theme_favicon_link_tag();
    echo forbes_theme_largeicon_link_tag();
    fire_plugin_hook('public_head', array('view'=>$this));

		queue_css_file('style');
    queue_css_url('//fonts.googleapis.com/css?family=Lato:300,400,700,900,400italic,700italic');
    echo head_css();

    echo head_js(); 
    ?>
</head>

