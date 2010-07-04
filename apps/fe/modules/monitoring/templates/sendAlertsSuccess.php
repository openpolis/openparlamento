<?php use_helper('I18N', 'sfSolr', 'DeppNews') ?>

<style type="text/css" media="screen">
  strong.highlight { font-size: bold; background-color: #dedede;}
  tr.even { background-color: #ffffff; }
  tr.odd { background-color: #fafafa; }
  tr.even:hover { background-color: #fffaea; }
  tbody tr.odd:hover { background-color: #fffaea; }
  
</style>

<?php if ($user->isAdhoc()): ?>
  <?php include_partial('monitoring/mailHeaderPoliticalDesk', array('site_url' => $sf_site_url)) ?>  
<?php else: ?>
  <?php include_partial('monitoring/mailHeader', array('site_url' => $sf_site_url)) ?>
<?php endif ?>

<h2 style="color: #626262; font-family: Arial, Helvetica, sans-serif; padding-left: 12px; font-size: 20px;">
  Oggi hai 
  <?php echo format_number_choice('[1] 1 avviso |(1,+Inf] %1% avvisi', array('%1%' => $n_total_notifications), $n_total_notifications) ?>
  per <?php echo format_number_choice('[1] il termine |(1,+Inf] i %1% termini', array('%1%' => $n_alerts), $n_alerts) ?> che stai monitorando
</h2>

<table style="width: 100%; vertical-align: top; margin-bottom: 20px; color: #626262; font-family: Arial, Helvetica, sans-serif; font-size: 13px; padding-left: 12px">

  <?php foreach ($user_alerts as $user_alert): ?>
    <?php if (count($user_alert['results']) > 0): ?>      

      <tr>
        <td style="font-size: 16px; font-weight: bold">
          <div style="margin-top:1.5em">
            Il termine <i><?php echo $user_alert['term'] ?></i>
            &egrave; stato trovato <?php echo format_number_choice('[1] una volta |(1,+Inf] %1% volte', array('%1%' => count($user_alert['results'])), count($user_alert['results'])) ?>             
          </div>
        </td>
      </tr>

      <?php $tr_class = 'even' ?>	
      <?php foreach ($user_alert['results'] as $i => $res): ?>
        <tr class="<?php echo $tr_class; ?>">
          <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?>          
          <td style="height: 30px;">
            <?php echo get_partial($res->getInternalAlertPartial(), array('result' => $res, 'term' => $user_alert['term'])) ?>
          </td>
        </tr>  
      <?php endforeach ?>
    <?php endif ?>
      
  <?php endforeach; ?>
</table>

<?php include_partial('monitoring/mailFooter', array('site_url' => $sf_site_url, 'user' => $user, 'msg_type' => 'alerts')) ?>  

