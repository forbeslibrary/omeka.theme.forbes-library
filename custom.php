<?php

/**
 * Utitlity functions used by the forbes-library theme
 */

/**
 * The ForbesTheme class contains static methods used by the theme's templates
 */
class ForbesTheme {
  private static $tidy;
  private static $tidy_config;

  public static function static_init() {
    self::$tidy = new tidy();
    self::$tidy_config= array(
      'show-body-only' => TRUE
    );
  }

  /**
   * Whether or not the current page is a search results page.
   */
  public static function on_search_results_page() {
      $tag = Zend_Controller_Front::getInstance()->getRequest()->getParam('tag');
      return array_key_exists('tags', $_GET)
          || array_key_exists('search', $_GET)
          || array_key_exists('collection', $_GET)
          || $tag;
  }

  /**
   * Creates a menu based on the custom_header_navigation theme option.
   */
  public static function public_header_nav() {
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
   * Creates an html class name for help in styling the featured content
   * on the homepage.
   *
   * Returns 'one-section', 'two-sections', or
   * 'three-sections' according to the number of selection in the theme
   * settings 'Display Featured Item', 'Display Featured Collection', and
   * 'Display Featured Exhibit'.
   */
  public static function featured_content_class() {
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
   public static function snippet($text, $startPos, $endPos, $append='&#8230;', $nlReplacement=' &#182; ') {
      $text = preg_replace('/<p.*?>/', $nlReplacement, $text);
      $text = preg_replace('/<br.*?>/', $nlReplacement, $text);
      $text = snippet($text, $startPos, $endPos, $append);
      return $text;
  }

  /**
   * Like ForbesTheme::snippet() except html new lines (from <p> or <br>) will
   * be preserved. (Though <p> will be converted to <br>.)
   */
  public static function snippet_with_new_lines($text, $startPos, $endPos, $append='&#8230;') {
      $text = ForbesTheme::snippet($text, $startPos, $endPos, $append, "\f");
      return str_replace("\f", '<br/>', $text);
  }

  /**
   * Displays a random featured exhibit
   */
  public static function display_random_featured_exhibit() {
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
          ForbesTheme::summary(metadata($exhibit, 'Description', array('no_escape' => true))) .
          '</div>';
      $html = exhibit_builder_link_to_exhibit($exhibit, $html);

      $featured_exhibits = get_records('exhibit', array('featured' => true));

      if (count($featured_exhibits) > 1) {
        $html .= '<details class="additional-features">';
        $html .= '<summary><h3>' . __('More Featured Collections') . '</h3><summary>';
        $html .= '<ul>';
        foreach ($featured_exhibits as $e) {
          if ($e->id == $exhibit->id) {
            continue; // skip this record
          }
          $html .= '<li>' . exhibit_builder_link_to_exhibit($e) . '</li>';
        }
        $html .= '</ul></details>';
      }

      return $html;
  }

  /**
   * Displays a random featured item.
   */
  public static function display_random_featured_item() {
      $item_array = get_random_featured_items(1);
      $item = $item_array[0] ?? null;
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
          '<img alt="' . $title . '" src="' . $file_uri . '">' .
          '<div class="description">' . ForbesTheme::summary(metadata('item', array('Dublin Core', 'Description'))) . '</div>';

        $html = link_to_item($html);

        $featured_items = get_records('item', array('featured' => true));

        if (count($featured_items) > 1) {
          $html .= '<details class="additional-features">';
          $html .= '<summary><h3>' . __('More Featured Items') . '</h3></summary>';
          $html .= '<ul>';
          foreach ($featured_items as $i) {
            if ($i->id == $item->id) {
              continue; // skip this record
            }
            set_current_record('item',$i);
            $html .= '<li>' . link_to_item() . '</li>';
          }
          $html .= '</ul></details>';
        }

        return $html;
      }
      return __('<p>No featured item found</p>');
  }

  /**
   * Displays a random featured collection.
   */
  public static function display_random_featured_collection() {
      $collection = get_random_featured_collection();
      set_current_record('collection', $collection);
      if ($collection) {
          $title = metadata($collection, array('Dublin Core', 'Title'));
          $description = metadata($collection, array('Dublin Core', 'Description'));
          $html = '<header>' .
              '<h2>' . __('Featured Collection') . '</h2>' .
              '<h3>' . $title . '</h3>' .
              '</header>' .
              '<div class="description">' . ForbesTheme::summary($description) . '</div>';
          $html =  link_to_collection($html);

          $featured_collections = get_records('collection', array('featured' => true));

          if (count($featured_collections) > 1) {
            $html .= '<details class="additional-features">';
            $html .= '<summary><h3>' . __('More Featured Collections') . '</h3></summary>';
            $html .= '<ul>';
            foreach ($featured_collections as $c) {
              if ($c->id == $collection->id) {
                continue; // skip this record
              }
              set_current_record('collection',$c);
              $html .= '<li>' . link_to_collection() . '</li>';
            }
            $html .= '</ul></details>';
          }

          return $html;
      }

      return '<h2>' . __('Featured Collection') . '</h2>' .
        __('<p>No featured collection found</p>');
  }

  /**
  * This function checks the Favicon theme option, then and returns an appropriate
  * link tag if it is set.
  *
  */
  public static function favicon_link_tag()
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
  public static function largeicon_link_tag()
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
   * Truncates text at the wordpress style <!-- more --> tag.
   */
  public static function summary($html, $strip_anchors = false) {
    //truncate at <!-- more -->
    $pattern = '/^(.*)<!--\s*more/is';
    preg_match($pattern, $html, $matches);
    if (isset ($matches[1])) {
      $html = $matches[1];
    }

    if ($strip_anchors) {
      // Remove anchor tags (the invalid tags will be cleaned up by tidy)
      $html = str_ireplace('<a','<invalid', $html);
      $html = str_ireplace('</a>','</invalid>', $html);
    }

    $html = self::$tidy->repairString($html, self::$tidy_config, 'utf8');
    return $html;
  }

}

ForbesTheme::static_init();
