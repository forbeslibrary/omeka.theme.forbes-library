<?php
header("HTTP/1.0 404 Not Found");
head(); ?>
<h1>404</h1>
<p>The URL <?php echo $_SERVER['REQUEST_URI']; ?> was not found on this server.</p>
 
<?php foot(); ?>
