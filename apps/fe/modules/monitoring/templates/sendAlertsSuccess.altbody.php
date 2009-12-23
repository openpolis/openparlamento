I tuoi alert di oggi.

<?php foreach ($user_alerts as $user_alert): ?>
  <?php sprintf("La parola %s è stata trovata %d volte:\n", 
                 $user_alert['term'], count($user_alert['results'])) ?>

  <?php foreach ($user_alert['results'] as $i => $res): ?>
    <?php echo get_partial($res->getInternalAlertPartial(), array('result' => $res, 'term' => $user_alert['term'])) ?>
  <?php endforeach ?>  

<?php endforeach; ?>


per rimuovere gli alert, vai alla pagina: http://<?php echo $sf_site_url ?>/monitoring_alerts/<?php echo $user_token ?>