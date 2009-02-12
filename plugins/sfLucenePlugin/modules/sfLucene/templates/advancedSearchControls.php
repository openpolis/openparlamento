<?php
/**
 * @package sfLucenePlugin
 * @subpackage Module
 * @author Carl Vondrick <carlv@carlsoft.net>
 */
?>

<?php use_helper('I18N', 'sfLucene') ?>

<h2><?php echo __('Advanced Search') ?></h2>

<?php echo form_tag('sfLucene/advancedSearch', 'method=get') ?>
  <fieldset>
    <legend><?php echo __('Search Terms') ?></legend>

    <table>
      <tbody>
        <tr>
          <td><label for="sfl_keywords"><?php echo __('May contain keywords') ?></label></td>
          <td><?php echo input_tag('keywords', '', 'id=sfl_keywords') ?></td>
        </tr>
        <tr>
          <td><label for="sfl_musthave"><?php echo __('Must contain keywords') ?></label></td>
          <td><?php echo input_tag('musthave', '', 'id=sfl_musthave') ?></td>
        </tr>
        <tr>
          <td><label for="sfl_mustnothave"><?php echo __('Must exclude keywords') ?></label></td>
          <td><?php echo input_tag('mustnothave', '', 'id=sfl_mustnothave') ?></td>
        </tr>
        <tr>
          <td><label for="sfl_hasphrase"><?php echo __('Contains exact phrase') ?></label></td>
          <td><?php echo input_tag('hasphrase', '', 'id=sfl_hasphrase') ?></label></td>
        </tr>
        <?php if (has_search_categories()): ?>
          <tr>
            <td><label for="sfl_category"><?php echo __('Must be in category') ?></label></td>
            <td><?php include_search_categories() ?></td>
          </tr>
        <?php endif ?>
    </table>
  </fieldset>

  <?php echo submit_tag(__('Search'), 'accesskey=s') ?>
  <?php echo submit_tag(__('Basic'), 'accesskey=b') ?>

  <?php echo input_hidden_tag('mode', 'search') ?>
</form>