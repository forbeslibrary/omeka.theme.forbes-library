<?php
/**
 * Whether or not the current page is a search results page.
 */
function forbes_theme_on_search_results_page() {
    $tag = Zend_Controller_Front::getInstance()->getRequest()->getParam('tag');
    return array_key_exists('tags', $_GET)
        || array_key_exists('search', $_GET)
        || array_key_exists('collection', $_GET)
        || $tag;
}

/**
 * Displays the main site navigation.
 *
 * A slightly modified custom_public_nav_header(), this version uses forbes_theme_nav()
 * throughout and gives plugins the change to modify the nav array. Furthermore, it will
 * have at most one entry with with class="current". (Omeka's public_header_nav would
 * often have multiple entries with class="current" and didn't always give plugins the
 * opportunity to filter the navigation array.)
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
                        $url = url($url);
                    }
                }
                $navArray[$link] = $url;
            }
        }
    } else {
        $navArray = array(__('Browse Items') => url('items'), __('Browse Collections') =>url('collections'));
    }
    return forbes_theme_nav($navArray, 'main');
}

/*
 * Generate an unordered list of navigation links with class "current" for the link which
 * best matches the current page.
 *
 * This differs from Omeka's nav() function in that it always has a depth of 0 (sub menus
 * are respected but not shown) and that it will never give more than one entry the class
 * "current".
 *
 * In order to allow plugins to modify the navigation, this function also takes a $navType
 * argument, similar to Omeka's public_nav() function.
 */
function forbes_theme_nav(array $links, $navType=Null)
{
    // apply any defined plugin filters so that plugins may modify the array
    if ($navType) {
        $filterName = 'public_navigation_' . $navType;
        $links = apply_filters($filterName, $links);
    }
    
    // flatten array by getting single link from any subarrays
    $lambda = create_function('$value', 'if (is_array($value)) { return (string) $value["uri"]; } return $value;');
    $links = array_map($lambda, $links);
    
    // determine which link should get class="current"
    $bestMatch = '';
    $currentUri = current_url();
    foreach ($links as $text => $uri) {
        if (strlen($uri) > strlen($bestMatch) && strpos($currentUri, $uri)!==False) {
            $bestMatch = $uri;
        }
    }
    
    $nav = '';
    foreach ($links as $text => $uri) {
        $class = text_to_id($text, 'nav');
        if ($uri === $bestMatch) {
           $class .= ' current';
        }
        $nav .= '<li class="' . $class . '">' ;
        $nav .= '<a href="' . html_escape($uri) . '">' . html_escape($text) . '</a>';
        $nav .= '</li>' . "\n";
    }
    return $nav;
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
        echo '<hgroup><h2>', __('Featured Exhbit'), '</h2></hgroup>',
            __('The "Display Featured Exhibit" option requires the ExhibitBuilder plugin.'),
            __('Please make sure the ExhbitBuilder plugin is installed and enabled.');
        return;
    }
    $featuredExhibit = exhibit_builder_random_featured_exhibit();
    if (!$featuredExhibit) {
        echo '<hgroup><h2>', __('Featured Exhibit'), '</h2></hgroup>',
            __('No featured exhibits found');
        return;
    }
    echo '<hgroup>',
        '<h2>', __('Featured Exhibit'), '</h2>',
        '<h3>', exhibit_builder_link_to_exhibit($featuredExhibit), '</h3>'."\n",
        '</hgroup>',
        '<p>', snippet_by_word_count(exhibit('description', array(), $featuredExhibit), 100), '</p>',
        '<a id="link-from-feature-to-exhibits" href="', url('exhibits'), '">See all exhibits</a>';
}

/**
 * Displays a random featured item.
 */
function forbes_theme_display_random_featured_item() {
    $item_array = get_random_featured_items(1);
    $item = $item_array[0];
    if ($item) {
        set_current_record('item',$item);
        $title = metadata('item', array('Dublin Core', 'Title'));
        $description = forbes_theme_snippet_with_new_lines(metadata('item', array('Dublin Core', 'Description')),0, 300);
		if ($creator = metadata('item', array('Dublin Core', 'Creator'))) {
				$creator =  '<p>' . __('Creator: %s.', $creator) . '</p>';
		}
		while(loop_files_for_item()) {
		  $file_uri = item_file('uri');
		  break;
		}
		$style = "background-image:url($file_uri); height:400px; background-size:cover; background-position:center; margin:0;";
        echo '<hgroup>',
            '<h2>', __('Featured Item'), '</h2>',
            '<h3>', link_to_item($title), '</h3>',
            '</hgroup>',
            link_to_item('<figure style="'. $style. '"></figure>'),
            $format,
            $creator,
            '<p class="description">', $description, '</p>';
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
        $image_uris = forbes_theme_collection_image_uris();
        echo '<hgroup>',
            '<h2>', __('Featured Collection'), '</h2>',
            '<h3>', link_to_collection($title), '</h3>',
            '</hgroup>',
            '<figure style="margin:0;">',
            link_to_collection(			
			  '<div style="float:left; border-right:solid black 1px; box-sizing:border-box; width:33%;  height:400px; background-position:center; background-size:cover; background-image:url(' . $image_uris[0] . ');"></div>' .
			  '<div style="float:left; border-right:solid black 1px; box-sizing:border-box; width:32%; height:400px; background-position:center; background-size:cover; background-image:url(' . $image_uris[1] . ');"></div>' .
			  '<div style="float:left; box-sizing:border-box; width:33%;  height:400px; background-position:center; background-size:cover; background-image:url(' . $image_uris[2] . ');"></div>'
			),
            '</figure>',
            '<p class="description">', $description, '</p>';
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
            set_current_record('item',get_item_by_id($result['id']));
            return item_thumbnail();
        }
}

/**
 * Returns the first 3 available item image uris from the items in the current collection.
 */
function forbes_theme_collection_image_uris() {
        $db = get_db();
        $select = $db->select()
            ->from(array('i' =>'omeka_items'),'id')
            ->join(array('f' =>'omeka_files'),'f.item_id = i.id', array())
            ->where('f.has_derivative_image = 1 AND i.collection_id = ?', collection('id'));
        $results = $db->query($select)->fetchAll();
        $image_uris = array();
        foreach ($results as $result) {  
            set_current_record('item',get_record_by_id('item', $result['id']));
            while(loop_files_for_item()) {
				       $image_uris[] = item_file('uri');
				       break;
				    }
				    if (count($image_uris)==3) { break; }
        }
        return $image_uris;
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
            $uri = $storage->geturl($storage->getPathByType($favicon, 'theme_uploads'));
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
            $uri = $storage->geturl($storage->getPathByType($largeicon, 'theme_uploads'));
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


/**
 * Creates a link to the items in a collection, using the current collection if none is
 * specified.
 *
 * This function is identical to the built in link_to_items_in_collection() accept that it
 * accepts a queryParams argument.
 */
function fobres_theme_link_to_items_in_collection(
    $text = null,
    $props = array(),
    $action = 'browse',
    $collectionObj = null,
    $queryParams = array()
    )
{
    if (!$collectionObj) {
        $collectionObj = get_current_collection();
    }
 
    $queryParams['collection'] = $collectionObj->id;
    
    if ($text === null) {
        $text = $collectionObj->totalItems();
    }
 
    return link_to('items', $action, $text, $props, $queryParams);
}