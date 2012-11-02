<?php

/**
 * Displays the main site navigation.
 *
 * A slightly modified custom_public_nav_header(), this version uses public_nav_main()
 * throughout and so will automatically include additions from plugins.
 */
function forbes_theme_public_header_nav()
{    
    if ($customHeaderNavigation = get_theme_option('custom_header_navigation')) {
        $navArray = array();
        $customLinkPairs = explode("\n", $customHeaderNavigation);
        foreach ($customLinkPairs as $pair) {
            $pair = trim($pair);
            if ($pair != '') {
                $pairArray = explode('|', $pair, 2);
                if (count($pairArray) == 2) {
                    $link = trim($pairArray[0]);
                    $url = trim($pairArray[1]); 
                    if (strncmp($url, 'http://', 7) && strncmp($url, 'https://', 8)){                        
                        $url = uri($url);
                    }
                }
                $navArray[$link] = $url;
            }
        }
        return public_nav_main($navArray);
    } else {
        $navArray = array(__('Browse Items') => uri('items'), __('Browse Collections') =>uri('collections'));
        return public_nav_main($navArray);
    }
}

/**
 * Returns an array of item-type id-name pairs suitable for use with
 * select() in html forms. Only item-types in use will be returned. 
 */
function forbes_theme_item_type_pairs_for_select() {
    $select = get_db()->select()
        ->distinct()
        ->from(array('T'=>'omeka_item_types'), array('id', 'name'))
        ->join(array('I'=>'omeka_items'),'T.id=I.item_type_id', array());
    
    $pairs = get_db()->fetchPairs($select);
    asort($pairs);
    return $pairs;
}

/**
 * Returns an array of element id-name pairs suitable for use with
 * select() in html forms. Only elements in use will be returned. 
 */
function forbes_theme_element_pairs_for_select() {
    $select = get_db()->select()
        ->distinct()
        ->from(array('T'=>'omeka_elements'), array('id', 'name'))
        ->join(array('I'=>'omeka_element_texts'),'T.id=I.element_id', array());
    
    $pairs = get_db()->fetchPairs($select);
    asort($pairs);
    return $pairs;
}

/**
 * Creates an html class name for help in styling the featured content
 * on the homepage.
 *
 * Returns 'one-section', 'two-sections', or
 * 'three-sections' according to the number of selection in the theme
 * settings 'Display Featured Item', 'Display Featured Collection', and
 * 'Display Featured Exhibit'. 
 */
function forbes_theme_featured_content_class() {
    $count = (int)(bool)get_theme_option('Display Featured Item');  
    $count += (int)(bool)get_theme_option('Display Featured Collection');
    $count += (int)(bool)get_theme_option('Display Featured Exhibit');
    switch ($count) {
        case 1: return 'one-section';
        case 2: return 'two-sections';
        case 3: return 'three-sections';
        default: return '';
    }
}

/**
 * Processes $file as a php file and queues the output to be inserted 
 * into the <head> as an embedded style.
 */
function forbes_theme_queue_generated_css($file) {
    ob_start(); // Capture all output (output buffering)
    require(physical_path_to('css/'.$file)); // Generate CSS
    $css = ob_get_clean(); // Get generated CSS (output buffering)
    /* remove comments */
        $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
        /* remove tabs, spaces, newlines, etc. */
        $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);
    queue_css_string($css);
}

/**
 * The Omeka snippet function strips all html formatting. This function
 * first converts p and br tags to a pillcrow or a specified string before
 * passing it to Omeka's snippet.
 * 
 * @param string $text Text to take snippet of
 * @param int $startPos Starting position of snippet in string
 * @param int $endPos Maximum length of snippet
 * @param string $append String to append to snippet if truncated
 * @return string Snippet of given text
 */
 function forbes_theme_snippet($text, $startPos, $endPos, $append='&#8230;', $nlReplacement=' &#182; ') {
    $text = preg_replace('/<p.*?>/', $nlReplacement, $text);
    $text = preg_replace('/<br.*?>/', $nlReplacement, $text);
    $text = snippet($text, $startPos, $endPos, $append);
    return $text;
}

/**
 * Like forbes_theme_snippet() except html new lines (from <p> or <br>) will
 * are preserved. (Though <p> will be converted to <br>.) 
 */
function forbes_theme_snippet_with_new_lines($text, $startPos, $endPos, $append='&#8230;') {
    $text = forbes_theme_snippet($text, $startPos, $endPos, $append, "\f");
    return str_replace("\f", '<br/>', $text);
}

/**
 * Displays a random featured exhibit
 */
function forbes_theme_display_random_featured_exhibit() {
    if (!plugin_is_active('ExhibitBuilder')) {
        echo '<h2>', __('Featured Exhbit'), '</h2>',
            __('The "Display Featured Exhibit" option requires the ExhibitBuilder plugin.'),
            __('Please make sure the ExhbitBuilder plugin is installed and enabled.');
        return;
    }
    $featuredExhibit = exhibit_builder_random_featured_exhibit();
    if (!$featuredExhibit) {
        echo '<h2>', __('Featured Exhibit'), '</h2>',
            __('No featured exhibits found');
        return;
    }
    echo '<hgroup>',
        '<h2>', __('Featured Exhibit'), '</h2>',
        '<h3>', exhibit_builder_link_to_exhibit($featuredExhibit), '</h3>'."\n",
        '</hgroup>',
        '<p>', snippet_by_word_count(exhibit('description', array(), $featuredExhibit), 100), '</p>',
        '<a id="link-from-feature-to-exhibits" href="', uri('exhibits'), '">See all exhibits</a>';
}

/**
 * Displays a random featured item.
 */
function forbes_theme_display_random_featured_item() {
    $item = random_featured_item();
    if ($item) {
        set_current_item($item);
        $title = item('Dublin Core', 'Title');
        $description = forbes_theme_snippet_with_new_lines(item('Dublin Core', 'Description'),0, 100);
        if ($format = item('Dublin Core', 'Format')) {
	    $format = '<p>' . __('Format: %s.', $format) . '</p>';
	}
	if ($creator = item('Dublin Core', 'Creator')) {
	    $creator =  '<p>' . __('Creator: %s.', $creator) . '</p>';
	}
        echo '<hgroup>',
            '<h2>', __('Featured Item'), '</h2>',
            '<h3>', link_to_item($title), '</h3>',
            '</hgroup>',
            '<figure>', link_to_item(item_thumbnail()), '</figure>',
            $format,
            $creator,
            '<p class="description">', $description, '</p>',
            link_to_item(__('More information'), array('class'=>'items-show-in-browse-details')),
            '<a id="link-from-feature-to-items" href="', uri('items'), '">See all items</a>';
    } else {
        echo '<h2>', __('Featured Item'), '</h2>',
            __('<p>No featured item found</p>');
    }
}

/**
 * Displays a random featured collection.
 */
function forbes_theme_display_random_featured_collection() {
    $collection = random_featured_collection();
    if ($collection) {
        set_current_collection($collection);
        $title = collection('Name');
        $description = snippet_by_word_count(collection('Description'), 100);
        echo '<hgroup>',
            '<h2>', __('Featured Collection'), '</h2>',
            '<h3>', link_to_collection($title), '</h3>',
            '</hgroup>',
            '<figure>', link_to_collection(forbes_theme_collection_thumbnail()), '</figure>',
            '<p class="description">', $description, '</p>',
            '<a id="link-from-feature-to-collections" href="', uri('collections'), '">See all collections</a>';
    } else {
        echo '<h2>', __('Featured Collection'), '</h2>',
            __('<p>No featured collection found</p>');
    }
}

/**
 * Returns the first available item thumbnail from the items in the current collection.
 */
function forbes_theme_collection_thumbnail() {
        $db = get_db();
        $select = $db->select()
            ->from(array('i' =>'omeka_items'),'id')
            ->join(array('f' =>'omeka_files'),'f.item_id = i.id', array())
            ->where('f.has_derivative_image = 1 AND i.collection_id = ?', collection('id'))
            ->limit(1);
        $result = $db->query($select)->fetch();
        if ($result) {  
            set_current_item(get_item_by_id($result['id']));
            return item_thumbnail();
        }
}

/**
* This function checks the Favicon theme option, then and echos an appropriate
* link tag if it is set.
*
*/
function forbes_theme_favicon_link_tag()
{
    if(function_exists('get_theme_option')) {
    
        $favicon = get_theme_option('favicon');

        if ($favicon) {
            $storage = Zend_Registry::get('storage');
            $uri = $storage->getUri($storage->getPathByType($favicon, 'theme_uploads'));
            return '<link rel="icon" sizes="16x16" href="'.$uri.'" />';
        }
    }
    return null;
}

/**
* This function checks the Largeicon theme option, then and echos an appropriate
* link tag if it is set.
*
*/
function forbes_theme_largeicon_link_tag()
{
    if(function_exists('get_theme_option')) {
    
        $largeicon = get_theme_option('largeicon');
        $size = get_theme_option('largeiconsize');

        if ($largeicon) {
            $storage = Zend_Registry::get('storage');
            $uri = $storage->getUri($storage->getPathByType($largeicon, 'theme_uploads'));
            return '<link rel="icon" sizes="'.$size.'" href="'.$uri.'" />'.
                '<link rel="apple-touch-icon-precomposed" sizes="'.$size.'" href="'.$uri.'" />';
        }
    }
    return null;
}

/**
 * Retrieve and loop through a subset of items in the collection.
 *
 * This is identical to Omeka's built in loop_items_in_collection except that it actually
 * uses the option parameter (which is ignored due to a bug in omeka 1.3).
 * 
 * @param integer $num 
 * @param array $options Optional
 * @return Item|null
 ***/
function forbes_theme_loop_items_in_collection($num = 10, $options = array())
{
    $options = array_merge($options, array('collection'=>get_current_collection()->id));
    
    // Cache this so we don't end up calling the DB query over and over again
    // inside the loop.
    static $loopIsRun = false;
    
    if (!$loopIsRun) {
        // Retrieve a limited # of items based on the collection given.
        $items = get_items($options, $num);
        set_items_for_loop($items);
        $loopIsRun = true;
    }
    
    $item = loop_items();
    if (!$item) {
        $loopIsRun = false;
    }
    return $item;
}

