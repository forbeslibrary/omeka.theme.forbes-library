<?php
if (array_key_exists('search', $_GET)) {
    if (preg_match('/\band\b|\bor\b|"/', $_GET['search'])) {
        $warnings[] = __('Warning! Boolean operators and quotation marks are ignored in keyword search.');
    }
    if (preg_match_all('/(?!and|or)\b(\w{1,3})\b/', $_GET['search'], $short_words)) {
        $warnings[] = __(
            'The following %1$s too short and %2$s been ignored: %3$s.',
            (count($short_words[0])==1) ? __('word is') : __('words are'),
            (count($short_words[0])==1) ? __('has') : __('have'),
            html_escape(implode(', ', $short_words[0]))
            );
    }
}
?>
<?php if (isset($warnings)): foreach ($warnings as $warning):?>
	<div class="items-browse-warning-line"><?php echo $warning; ?></div>
<?php endforeach; endif; ?>
