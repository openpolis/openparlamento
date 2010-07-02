<?php echo use_helper('DeppNews'); ?>

<?php 
  $df = new sfDateFormat('it_IT'); 
  $sf_site_url = sfConfig::get('sf_site_url', 'openparlamento');
?>



Le ultime notizie
=================

<?php foreach ($grouped_news as $date_ts => $news): ?>
  <?php foreach ($news as $i => $n): ?>

    <?php
      // fetch del modello e dell'oggetto che ha generato la notizia
      $generator_model = $n->getGeneratorModel();
      if ($n->getGeneratorPrimaryKeys())
      {
        $pks = array_values(unserialize($n->getGeneratorPrimaryKeys()));
        $generator = call_user_func_array(array($generator_model.'Peer', 'retrieveByPK'), $pks);          
      } else {
        $pks = array();
        $generator = null;
      }    
    ?>
    
    <?php if( $i == 0 ): ?>
      <?php if ($date_ts > 0): ?>
        <?php $date_string = $df->format($date_ts, 'dd') ." ". $df->format($date_ts, 'MMM') ." ". $df->format($date_ts, 'yyyy'); ?>
<?php echo $date_string ?>
<?php echo str_repeat('-', strlen($date_string))?>
      <?php else: ?>
NO data
-------
      <?php endif ?>
    <?php endif ?>
<?php echo html_entity_decode(strip_tags(news_text($n, $generator_model, $pks, $generator, 
                         array('in_mail' => true))), ENT_COMPAT, 'UTF-8'); ?>
:::

  <?php endforeach; ?>
  
  
<?php endforeach; ?>

Saluti,
il team Openpolis
