<?php use_helper('I18N', 'Date') ?>

<?php include_partial('filter') ?>
<br />
<br />
<?php include_partial('list', array('pager' => $pager)) ?>

<?php echo link_to('tutti i parlamentari', '@parlamentari') ?>