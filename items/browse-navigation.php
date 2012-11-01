<nav id="items-browse-nav">
<h1><?php echo $pageTitle;?></h1>
<ul class="navigation">
<?php echo public_nav_items(
    array(
        __('Browse All') => uri('items'), 
        __('View Tags') => uri('items/tags')
    )
);?>
</ul>
</nav>