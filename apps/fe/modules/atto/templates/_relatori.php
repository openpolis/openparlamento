<b>Relatori</b>
<br />
<?php 
    use_helper('Slugger');
    foreach($relatori as $id => $relatore): ?>
  <?php echo link_to($relatore, '@parlamentare?id='.$id.'&slug='.slugify($relatore)) ?>
  <br />
<?php endforeach; ?>