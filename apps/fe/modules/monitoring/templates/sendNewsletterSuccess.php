<?php echo use_helper('DeppNews', 'Date'); ?>

<?php 
  $sf_site_url = sfConfig::get('sf_site_url', 'openparlamento');
?>

<?php if ($user->isAdhoc()): ?>
  <?php include_partial('monitoring/mailHeaderPoliticalDesk', array('site_url' => $sf_site_url)) ?>  
<?php else: ?>
  <?php include_partial('monitoring/mailHeader', array('site_url' => $sf_site_url)) ?>
<?php endif ?>


<h2 style="color: #626262; font-family: Arial, Helvetica, sans-serif; padding-left: 12px; font-size: 20px;">Le notizie del tuo monitoraggio</h2>

<table style="width: 100%; vertical-align: top; margin-bottom: 20px; color: #626262; font-family: Arial, Helvetica, sans-serif; font-size: 13px;">
  
  <?php foreach ($grouped_news as $date_ts => $news): ?>
    <tr><td colspan="3">&nbsp;</td></tr>

    <?php foreach ($news as $cnt => $n): ?> 
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
      <tr>
        <!-- datebox cell / empty -->
        <?php if ($cnt == 0): ?>
          <td style="width: 80px;">
            <?php include_partial('news/dateboxmail', array('sf_site_url' => $sf_site_url,
                                                            'date_ts' => $date_ts, 
                                                            'date_format' => new sfDateFormat('it_IT'))) ?>
          </td> 
        <?php else: ?>
          <td>&nbsp;</td>
        <?php endif; ?>
        
        <!-- news icon -->
        <?php 
          $icon_img_name = news_icon_name($generator_model, $generator);
        ?>
        <td class="icon-id" style="width: 60px;">
          <img src="http://<?php echo $sf_site_url?>/images/<?php echo $icon_img_name ?>"
               size="44x42" style="border:none; display: block; border: none; background: transparent url(http://<?php echo $sf_site_url ?>/images/bg-ico-type.png)" />
        </td>
        
        <!-- news text -->
        <td>
          <?php echo news_text($n, $generator_model, $pks, $generator, 
                               array('in_mail' => true)) ?>
        </td>
        
      </tr>
    <?php endforeach ?>
      
  <?php endforeach; ?>
</table>

<?php if ($user->isAdhoc()): ?>
  <?php include_partial('monitoring/mailFooterPoliticalDesk', array('site_url' => $sf_site_url)) ?>  
<?php else: ?>
  <?php include_partial('monitoring/mailFooter', array('site_url' => $sf_site_url)) ?>
<?php endif ?>
