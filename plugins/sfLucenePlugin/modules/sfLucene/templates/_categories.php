<?php
/**
 * @package sfLucenePlugin
 * @subpackage Module
 * @author Carl Vondrick <carlv@carlsoft.net>
 */
?>

<?php if ($show): ?>
  <?php echo select_tag('category', options_for_select($categories, $selected), array('multiple' => $multiple, 'id' => 'sfl_category')) ?>
<?php endif ?>