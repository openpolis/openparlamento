<b>Relatori</b>
<br />
<?php foreach($relatori as $id => $relatore): ?>
  <?php echo link_to($relatore, '@parlamentare?id='.$id) ?>
  <br />
<?php endforeach; ?>