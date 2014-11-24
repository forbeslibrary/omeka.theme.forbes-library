<?php echo head(array('bodyid'=>'home')); ?>

<h1 id="site-title"><?php echo link_to_home_page(); ?></h1>

<?php if (get_theme_option('Homepage Text')): ?>
<div id="home-page-text"><?php echo get_theme_option('Homepage Text'); ?></div>
<?php endif; ?>

<?php if (get_theme_option('Homepage Search')): ?>
<form id="simple-search" action="<?php echo uri(array('controller'=>'items', 'action'=>'browse'))?>" method="get">      
    <input type="search" name="search" id="search" value="" class="textinput">
    <input type="submit" name="submit_search" id="submit_search" value="Search">        
</form>
<?php endif; ?>

<div id="featured-content" class="<?php echo forbes_theme_featured_content_class(); ?>">
    <?php if (get_theme_option('Display Featured Item') !== '0'): ?>
        <section id="featured-item"><?php forbes_theme_display_random_featured_item(); ?></section>
        <?php endif; ?>

        <?php if (get_theme_option('Display Featured Collection') !== '0'): ?>
        <section id="featured-collection"><?php forbes_theme_display_random_featured_collection(); ?></section>
    <?php endif; ?>

    <?php if (get_theme_option('Display Featured Exhibit') !== '0'): ?>
        <section id="featured-exhibit"><?php forbes_theme_display_random_featured_exhibit(); ?></section>
    <?php endif; ?>
</div>

<?php echo foot(); ?>
