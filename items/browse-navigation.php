<nav id="items-browse-nav">
<ul class="navigation">
<?php
$navArray = array(
    __('Browse All') => uri('items'), 
    __('View Tags') => uri('items/tags')
);
echo forbes_theme_nav($navArray, 'items');
?>
</ul>
</nav>