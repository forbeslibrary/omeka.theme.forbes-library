<?php
$forbesThemeSession = new Zend_Session_Namespace('forbes_theme');
?>
	</div><!-- end content -->

	<footer>

		<div id="footer-text">
			<?php echo get_theme_option('Footer Text'); ?>
			<?php if ((get_theme_option('Display Footer Copyright') == 1) && $copyright = settings('copyright')): ?>
				<p><?php echo $copyright; ?></p>
			<?php endif; ?>
			<p><?php echo __('Proudly powered by <a href="http://omeka.org">Omeka</a>.'); ?></p>
		</div>

		<?php
		fire_plugin_hook('public_footer', array('view'=>$this));
        
        // provide links to turn css on and off
        $params = $_GET;
        if ($forbesThemeSession->useCss) {
            $params['use_css'] = 'false';
            echo 'Having trouble using this site? Try using the <a href="' . current_url($params) . '">simple style</a>.';
        } else {
            $params['use_css'] = 'true';
            echo 'You are using the simple style. You may return to the <a href="' . current_url($params) . '">styled site</a> at any time.';
        }
        ?>
	</footer>
</body>
</html>
