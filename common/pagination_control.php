<?php

/**
 * pagination_control.php template for the forbes-library Omeka theme
 *
 * Outputs links for navigating multi-page results. This template is used by
 * the pagination_links() function.
 *
 * This partial template does not take any arguments.
 */

// == Content begins here =====================================================
if ($this->pageCount > 1): ?>
<nav class="common-pagination-control">
	<ul class="pagination_list">
		<?php if (isset($this->previous)): ?>
		<!-- Previous page link -->
		<li class="pagination_previous">
			<a href="<?php echo html_escape($this->url(array('page' => $this->previous), null, $_GET)); ?>">
				<?php echo __('Previous'); ?>
			</a>
		</li>
		<?php endif; ?>

		<?php if (!array_key_exists($this->first, $this->pagesInRange)): ?>
			<li class="pagination_first">
				<a href="<?php echo html_escape($this->url(array('page' => $this->first), null, $_GET)); ?>">
					<?php echo $this->first; ?>
				</a>
			</li>
			<li>
				&hellip;
			</li>
		<?php endif; ?>

		<!-- Numbered page links -->
		<?php foreach ($this->pagesInRange as $page): ?>
			<?php if ($page != $this->current): ?>
				<li class="pagination_range">
					<a href="<?php echo html_escape($this->url(array('page' => $page), null, $_GET)); ?>">
						<?php echo $page; ?>
					</a>
				</li>
			<?php else: ?>
				<li class="pagination_current">
					<?php echo $page; ?>
				</li>
			<?php endif; ?>
		<?php endforeach; ?>

		<?php if (!array_key_exists($this->last, $this->pagesInRange)): ?>
			<li>
				&hellip;
			</li>
			<li class="pagination_last">
				<a href="<?php echo html_escape($this->url(array('page' => $this->last), null, $_GET)); ?>">
					<?php echo $this->last; ?>
				</a>
			</li>
		<?php endif; ?>

		<?php if (isset($this->next)): ?>
			<!-- Next page link -->
			<li class="pagination_next">
				<a href="<?php echo html_escape($this->url(array('page' => $this->next), null, $_GET)); ?>">
					<?php echo __('Next'); ?>
				</a>
			</li>
		<?php endif; ?>
	</ul>
</nav>
<?php endif; ?>
