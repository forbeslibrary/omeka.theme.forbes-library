<nav id="items-browse-nav">
<ul class="navigation">
<?php
$navArray = array(
    __('Browse All') => url('items'), 
    __('View Tags') => url('items/tags')
);
echo forbes_theme_nav($navArray, 'items');
?>
</ul>
</nav>