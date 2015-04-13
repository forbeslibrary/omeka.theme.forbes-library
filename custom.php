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
 * Creates a menu based on the custom_header_navigation theme option.
 */
function forbes_theme_public_header_nav() {
  $navArray = array();
  if ($customHeaderNavigation = get_theme_option('custom_header_navigation')) {

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
              $navArray[] = array('label' => $link, 'uri' => $url);
          }
      }
  }

  return nav($navArray);
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
        return '<h2>' . __('Featured Exhbit') . '</h2>' .
            __('The "Display Featured Exhibit" option requires the ExhibitBuilder plugin.') .
            __('Please make sure the ExhbitBuilder plugin is installed and enabled.');
    }
    $exhibit = exhibit_builder_random_featured_exhibit();
    if (!$exhibit) {
        return '<h2>' . __('Featured Exhibit') . '</h2>' .
            __('No featured exhibits found');
    }
    $html = '<header>' .
        '<h2>' . __('Featured Exhibit') . '</h2>' .
        '<h3>' . metadata($exhibit, 'Title') . '</h3>'."\n" .
        '</header>' .
        '<div class="description">' .
        forbes_theme_summary(metadata($exhibit, 'Description', array('no_escape' => true))) .
        '</div>';
    $html = exhibit_builder_link_to_exhibit($exhibit, $html);

    $featured_exhibits = get_records('exhibit', array('featured' => true));

    if (count($featured_exhibits) > 1) {
      $html .= '<h3>' . __('More Featured Collections') . '</h3><ul>';
      foreach ($featured_exhibits as $e) {
        if ($e->id == $exhibit->id) {
          continue; // skip this record
        }
        $html .= '<li>' . exhibit_builder_link_to_exhibit($e) . '</li>';
      }
      $html .= '</ul>';
    }

    return $html;
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
			if ($creator = metadata('item', array('Dublin Core', 'Creator'))) {
					$creator =  '<p>' . __('Creator: %s.', $creator) . '</p>';
			}
			$files = $item->Files;
			foreach($files as $file) {
				$file_uri = file_display_url($file);
				break;
			}
			$html = '<h2>' . __('Featured Item') . '</h2>' .
        '<h3>' . $title . '</h3>' .
        '<img alt=' . $title . ' src=' . $file_uri . '>' .
        '<div class="description">' . forbes_theme_summary(metadata('item', array('Dublin Core', 'Description'))) . '</div>';

      $html = link_to_item($html);

      $featured_items = get_records('item', array('featured' => true));

      if (count($featured_items) > 1) {
        $html .= '<h3>' . __('More Featured Items') . '</h3><ul>';
        foreach ($featured_items as $i) {
          if ($i->id == $item->id) {
            continue; // skip this record
          }
          set_current_record('item',$i);
          $html .= '<li>' . link_to_item() . '</li>';
        }
        $html .= '</ul>';
      }

      return $html;
    }
    return __('<p>No featured item found</p>');
}

/**
 * Displays a random featured collection.
 */
function forbes_theme_display_random_featured_collection() {
    $collection = get_random_featured_collection();
    set_current_record('collection', $collection);
    if ($collection) {
        $title = metadata($collection, array('Dublin Core', 'Title'));
        $description = metadata($collection, array('Dublin Core', 'Description'));
        $html = '<header>' .
            '<h2>' . __('Featured Collection') . '</h2>' .
            '<h3>' . $title . '</h3>' .
            '</header>' .
            '<div class="description">' . forbes_theme_summary($description) . '</div>';
        $html =  link_to_collection($html);

        $featured_collections = get_records('collection', array('featured' => true));

        if (count($featured_collections) > 1) {
          $html .= '<h3>' . __('More Featured Collections') . '</h3><ul>';
          foreach ($featured_collections as $c) {
            if ($c->id == $collection->id) {
              continue; // skip this record
            }
            set_current_record('collection',$c);
            $html .= '<li>' . link_to_collection() . '</li>';
          }
          $html .= '</ul>';
        }

        return $html;
    }

    return '<h2>' . __('Featured Collection') . '</h2>' .
      __('<p>No featured collection found</p>');
}

/**
 * Returns the first available item thumbnail from the items in the current collection.
 */
function forbes_theme_collection_thumbnail() {
        $db = get_db();
        $select = $db->select()
            ->from(array('i' =>'omeka_items'),'id')
            ->join(array('f' =>'omeka_files'),'f.item_id = i.id', array())
            ->where('f.has_derivative_image = 1 AND i.collection_id = ?', metadata('collection', 'id'))
            ->limit(1);
        $result = $db->query($select)->fetch();
        if ($result) {
            set_current_record('item',get_record_by_id('item', $result['id']));
            return item_image('thumbnail');
        }
}

/**
* This function checks the Favicon theme option, then and returns an appropriate
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
* This function checks the Largeicon theme option, then and returns an appropriate
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
    $options = array_merge($options, array('collection'=>get_record('collection')->id));

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
        $collectionObj = get_current_record('collection');
    }

    $queryParams['collection'] = $collectionObj->id;

    if ($text === null) {
        $text = $collectionObj->totalItems();
    }

    return link_to('items', $action, $text, $props, $queryParams);
}

/**
 * Truncates text at the wordpress style <!-- more --> tag.
 */
function forbes_theme_summary($html) {
  $pattern = '/^(.*)<!--\s*more/is';
  preg_match($pattern, $html, $matches);
  if (isset ($matches[1])) {
    return forbes_theme_closetags($matches[1]);
  } else {
    return $html;
  }
}

/**
 * Close open html tags.
 *
 * Note that this is not a general HTML cleanup tool and will not help if the tags are improperly nested.
 * It's intended function is only to close tags when a fragment of valid HTML must be inserted into markup.
 */
 // close opened html tags
function forbes_theme_closetags($html) {
  #put all opened tags into an array
  preg_match_all ( "#<([a-z]+)( .*)?(?!/)>#iU", $html, $result );
  $openedtags = $result[1];
  #put all closed tags into an array
  preg_match_all ( "#</([a-z]+)>#iU", $html, $result );
  $closedtags = $result[1];
  $len_opened = count ( $openedtags );
  # all tags are closed
  if( count ( $closedtags ) == $len_opened )
  {
  return $html;
  }
  $openedtags = array_reverse ( $openedtags );
  # close tags
  for( $i = 0; $i < $len_opened; $i++ )
  {
      if ( !in_array ( $openedtags[$i], $closedtags ) )
      {
      $html .= "</" . $openedtags[$i] . ">";
      }
      else
      {
      unset ( $closedtags[array_search ( $openedtags[$i], $closedtags)] );
      }
  }
  return $html;
}
