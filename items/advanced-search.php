<?php
$pageTitle = __('Advanced Search');
if (!$isPartial):
    head(array('title' => $pageTitle,
               'bodyclass' => 'advanced-search',
               'bodyid' => 'advanced-search-page'));
?>
<h1><?php echo $pageTitle; ?></h1>
<?php endif; ?>

<?php if ($formActionUri):
    $formAttributes['action'] = $formActionUri;
else:
    $formAttributes['action'] = uri(array('controller'=>'items',
                                          'action'=>'browse'));
endif;
$formAttributes['method'] = 'GET'; ?>
    <form <?php echo _tag_attributes($formAttributes); ?>>
        <fieldset id="search-keywords" class="field">
            <?php echo label('keyword-search', __('Search for Keywords')); ?>
            <div class="inputs">
            <?php echo text(array(
                    'name' => 'search',
                    'size' => '40',
                    'id' => 'keyword-search',
                    'class' => 'textinput'), @$_REQUEST['search']); ?>
            </div>
        </fieldset>
        
        <fieldset id="search-narrow-by-fields" class="field">
            <div class="label"><?php echo __('Narrow by Specific Fields'); ?></div>
            <div class="inputs">
            <?php
            // If the form has been submitted, retain the number of search
            // fields used and rebuild the form
            if (!empty($_GET['advanced'])) {
                $search = $_GET['advanced'];
            } else {
                $search = array(array('field'=>'','type'=>'','value'=>''));
            }

            //Here is where we actually build the search form
            foreach ($search as $i => $rows): ?>
                <div class="search-entry">
                    <?php
                    //The POST looks like =>
                    // advanced[0] =>
                    //[field] = 'description'
                    //[type] = 'contains'
                    //[terms] = 'foobar'
                    //etc
                    echo __v()->formSelect(array(
			'name'=>"advanced[$i][element_id]",
			'value'=>@$rows['element_id'],
			'options'=>(array(''=>__('Select Field')) + forbes_theme_element_pairs_for_select())
			));
                    echo __v()->formSelect(array(
			'name'=>"advanced[$i][type]",
			'value'=>@$rows['type'],
			'options'=>array('contains' => __('contains'),
                              'does not contain' => __('does not contain'),
                              'is exactly' => __('is exactly'),
                              'is empty' => __('is empty'),
                              'is not empty' => __('is not empty'))
			));
                    echo text(
                        array('name' => "advanced[$i][terms]",
                              'size' => 20),
                        @$rows['terms']); ?>
                    <button type="button" class="remove_search" disabled="disabled" style="display: none;">-</button>
                </div>
            <?php endforeach; ?>
            </div>
            <button type="button" class="add_search"><?php echo __('Add a Field'); ?></button>
        </fieldset>

        <?php if (get_theme_option('search_by_id_range')): ?>
        <fieldset id="search-by-range" class="field">
            <label for="range"><?php echo __('Search by a range of ID#s (example: 1-4, 156, 79)'); ?></label>
            <div class="inputs">
            <?php echo text(
                    array('name' => 'range',
                          'size' => '40',
                          'class' => 'textinput'),
                    @$_GET['range']); ?>
            </div>
        </fieldset>
        <?php endif; ?>

		<fieldset id="search-by-collection" class="field">
			<?php echo label('collection-search', __('Search By Collection')); ?>
			<div class="inputs"><?php
				echo select_collection(array(
					'name' => 'collection',
					'id' => 'collection-search'
				), @$_REQUEST['collection']); ?>
			</div>
		</fieldset>

		<?php
		$usedItemTypes = forbes_theme_item_type_pairs_for_select();
		if (count($usedItemTypes)>1): ?>
		<fieldset id="search-by-type" class="field">
			<?php echo label('item-type-search', __('Search By Type')); ?>
			<div class="inputs"><?php
				echo __v()->formSelect(array(
					'name'=>'type',
					'id'=>'item-type-search',
					'options'=>(array(''=>__('Any Type')) + $usedItemTypes),
					'value'=>@$_REQUEST['type']
				    )); ?>
			</div>
		</fieldset>
		<?php endif; ?>

		<?php if (get_theme_option('search_by_tags')): ?>
		<fieldset id="search-by-tag" class="field">
			<?php echo label('tag-search', __('Search By Tags')); ?>
			<div class="inputs"><?php
				echo text(array(
					'name' => 'tags',
					'size' => '40',
					'id' => 'tag-search',
					'class'=>'textinput'),
				@$_REQUEST['tags']); ?>
			</div>
		</fieldset>
		<?php endif; ?>

		<?php if(has_permission('Users', 'browse')): ?>
		<fieldset id="search-by-user" class="field items-advanced-search-special-permissions">
		<?php
			echo label('user-search', __('Search By User'));?>
			<div class="inputs"><?php
				echo select_user(array(
						'name' => 'user',
						'id' => 'user-search'),
					@$_REQUEST['user']);?>
			</div>
		</fieldset>
		<?php endif; ?>

        <?php if (has_permission('Items','showNotPublic')): ?>
        <fieldset id="search-by-public-private-status" class="field items-advanced-search-special-permissions">
            <?php echo label('public', __('Public/Non-Public')); ?>
            <div class="inputs">
                <?php echo __v()->formSelect(array(
			'name'=>'public',
			'value'=>@$_REQUEST['public'],
			'options'=>array(
			    ''  => __('Public and Non-Public Items'),
			    '1' => __('Only Public Items'),
			    '0' => __('Only Non-Public Items')
			)
		    )); ?>
            </div>
        </fieldset>
        <?php endif; ?>

        <?php if (get_theme_option('search_by_featured_non_featured')): ?>
        <fieldset id="search-by-featured-status" class="field">
            <?php echo label('featured', __('Featured/Non-Featured')); ?>
            <div class="inputs">
                <?php echo __v()->formSelect(array(
                        'name'=>'featured',
                        'value'=>@$_REQUEST['featured'],
                        'options'=>array(
                                '' => __('Featured and Non-Featured Items'),
                                '1' => __('Only Featured Items'),
                                '0' => __('Only Non-Featured Items')
                                )      
                    )); ?>
            </div>
        </fieldset>
        <?php endif; ?>

	<?php is_admin_theme() ? fire_plugin_hook('admin_append_to_advanced_search') : fire_plugin_hook('public_append_to_advanced_search'); ?>
        <input type="submit" class="submit" name="submit_search" id="submit_search_advanced" value="<?php echo __('Search'); ?>" />
    </form>

<?php echo js('search'); ?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        Omeka.Search.activateSearchButtons();
    });
</script>

<?php if (!$isPartial): ?>
<?php foot(); ?>
<?php endif; ?>
