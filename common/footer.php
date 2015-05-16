<?php

/**
 * header.php template for the forbes-library Omeka theme
 *
 * This partial template looks for the following variables:
 *  - $title
 *  - $bodyid
 *  - $bodyclass
 */

// == Set variables for this template =========================================
$copyright = null;
if (get_theme_option('Display Footer Copyright') == 1) {
	$copyright = get_option('copyright');
}

// == Content begins here =====================================================
?>
	</div><!-- end content -->
		<footer>
			<div id="footer-text">
				<?php echo get_theme_option('Footer Text'); ?>
				<?php if ($copyright): ?>
					<p>
						<?php echo $copyright; ?>
					</p>
				<?php endif; ?>
				<p><?php echo __('Proudly powered by <a href="http://omeka.org">Omeka</a>.'); ?></p>
			</div>
			<?php fire_plugin_hook('public_footer', array('view'=>$this)); ?>
		</footer>
  </div>
</body>
</html>
