<?php
header("HTTP/1.0 404 Not Found");
$pageTitle = __('404 Not Found');
echo head(
  array(
    'title' => $pageTitle,
    'bodyid' => '404',
    'bodyclass' => 'error 404'
  )
);
?>
<h2><?php echo $pageTitle; ?></h2>
<p>The URL <code><?php echo $_SERVER['REQUEST_URI']; ?></code> was not found on this server.</p>
<?php
if (get_theme_option('404_help_text')) {
  echo '<p>' . get_theme_option('404_help_text') . '</p>';
}
echo foot();
