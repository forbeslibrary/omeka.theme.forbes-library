	</div><!-- end content -->

	<footer>

		<div id="footer-text">
			<?php echo get_theme_option('Footer Text'); ?>
			<?php if ((get_theme_option('Display Footer Copyright') == 1) && $copyright = settings('copyright')): ?>
				<p><?php echo $copyright; ?></p>
			<?php endif; ?>
			<p><?php echo __('Proudly powered by <a href="http://omeka.org">Omeka</a>.'); ?></p>
		</div>

		<?php plugin_footer(); ?>

	<footer>
</body>
</html>
