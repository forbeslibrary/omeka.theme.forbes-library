<?php

/**
 * header.php template for the forbes-library Omeka theme
 *
 * Outputs the 'top' of the HTML file, up until the content begins
 *
 * This partial template looks for the following variables:
 *  - $title
 *  - $bodyid
 *  - $bodyclass
 */

// == Set variables for this template =========================================
$headVars = array(
  'title' => isset($title) ? $title : null
  );
$bodyVars = array(
  'bodyid' => isset($bodyid) ? $bodyid : null,
  'bodyclass' => isset($bodyclass) ? $bodyclass : null,
  );

// == Content begins here =====================================================
?>
<!DOCTYPE html>
<html lang="<?php echo get_html_lang(); ?>">

<?php echo common('head', $headVars); ?>

<?php echo body_tag($bodyVars); ?>
  <!-- plugin hook 'public_body' -->
  <?php fire_plugin_hook('public_body', array('view'=>$this)); ?>
  <div id="wrapper">
    <header id="page-header">
      <!-- plugin hook 'public_header' -->
      <?php fire_plugin_hook('public_header', array('view'=>$this)); ?>

      <!-- front matter (includes site title, quick links, and search -->
      <div id="banner">

      <!-- site title and logo -->
      <h1 id="site-title">
        <?php
        if (theme_logo()) {
          echo link_to_home_page(theme_logo());
        } else {
          echo link_to_home_page();
        }
        ?>
      </h1>
    </div>

    <!-- navigation -->
    <nav id="top-level-nav" class="menu_bar">
      <h2 class="navigation-label">
        <a href="<?php echo url('?nav=True');?>">
          <?php echo __('Navigation'); ?>
        </a>
      </h2>
      <span class="nav-jump-to-content">
        <a href="#content" tabindex="0">
          <?php echo __('Skip to content') ?>
        </a>
      </span>
      <input type="checkbox" id="toggle" />
      <div>
        <label for="toggle" class="toggle" data-open="Main Menu" data-close="Close Menu" onclick></label>

        <!-- custom navigation links as defined in the theme configuration -->
        <div class="menu">
        <div id="header-buttons">
          <?php echo ForbesTheme::public_header_nav(); ?>
        </div>

        <!-- simple search form -->
        <form id="simple-search" action="<?php echo url('items/browse'); ?>" method="get">
          <input type="search" name="search" id="search" value="" class="textinput">
          <input type="submit" name="submit_search" id="submit_search" value="Search">
        </form>

        <!-- main menu -->
        <?php echo public_nav_main(); ?>
        </div>
      </div>
    </nav>
  </header>

  <div id="content">
    <?php fire_plugin_hook('public_content_top', array('view'=>$this)); ?>
