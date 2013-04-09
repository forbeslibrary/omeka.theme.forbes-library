<h1><?php echo __('Navigation');?></h1>
<ul>
    <?php echo forbes_theme_public_header_nav(); ?>
    <?php if (get_theme_option('main_site_title')):?>
    <li><a href="<?php echo get_theme_option('main_site_url');?>"><?php echo get_theme_option('main_site_title');?></a></li>
    <?php endif; ?>
</ul>
