<?php
header("HTTP/1.0 404 Not Found");
head(); ?>
<h1>404</h1>
<p>The URL <code><?php echo $_SERVER['REQUEST_URI']; ?></code> was not found on this server.</p>
<?php
if (get_theme_option('404_help_text')) {
  echo '<p>' . get_theme_option('404_help_text') . '</p>';
}
foot();
