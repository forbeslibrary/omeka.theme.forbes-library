<head><?php
    $forbesThemeSession = new Zend_Session_Namespace('forbes_theme');

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

    queue_css('style');
    if ($forbesThemeSession->useCss) {
        display_css();
    }
    display_js(); ?>
</head>

