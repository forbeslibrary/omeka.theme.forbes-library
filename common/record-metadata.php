<?php foreach ($elementsForDisplay as $setName => $setElements): ?>
  <table class="element-set">
    <?php if ($showElementSetHeadings): ?>
      <tr><th colspan="2" class="element-set-name"><?php echo html_escape(__($setName)); ?></th></tr>
    <?php endif ?>
    <?php foreach ($setElements as $elementName => $elementInfo): ?>
    <tr>
    <td class="element-name"><?php echo html_escape(__($elementName)); ?></td>
    <td class="element-text">
      <?php foreach ($elementInfo['texts'] as $text): ?>
            <div class="element-text"><?php echo $text; ?></div>
       <?php endforeach; ?>
    </td>
    </tr>
  <?php endforeach; ?>
  </table>
<?php endforeach;
