<nav id="items-browse-nav">
<?php
$navArray = array(
    array( 'label' => __('Browse All'), 'uri' => url('items')), 
    array( 'label' => __('View Tags'), 'uri' => url('items/tags'))
);
echo nav($navArray);
?>
</nav>