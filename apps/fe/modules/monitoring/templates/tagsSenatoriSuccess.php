<?php echo use_helper('Javascript'); ?>

<?php echo include_component('monitoring', 'submenu', array('current' => 'tags')); ?>

<div id="content" class="tabbed-orange float-container">
  <?php echo include_partial('secondLevelMenuArgomenti', 
                             array('current' => 'senatori')); ?>

  <div id="main">

    <?php if ($sf_flash->has('subscription_promotion')): ?>
      <div class="flash-messages">
        <?php echo $sf_flash->get('subscription_promotion') ?>
      </div>
    <?php endif; ?>
    
    <?php if (!$sf_user->hasCredential('premium') && !$sf_user->hasCredential('adhoc')): ?>    
      <div style="width:40%; font-size:14px; line-height:1.2em; border:1px solid #EE7F00; padding:5px;" ><strong>Promuovi la trasparenza e la partecipazione!</strong><br /><?php echo link_to('Prenota la tua tessera 2010 all\'associazione openpolis','@tesseramento') ?>
      </div>
    <?php endif; ?>

    <?php include_partial('monitoring/groupFilter', array('items' => $groups, 'group_filter' => $group_filter)) ?>

    <?php include_partial('monitoring/tagsMonitoredByUser', 
                          array('opp_user' => $opp_user, 'sf_user' => $sf_user, 
                                'my_tags' => $my_tags, 'remaining_tags' => $remaining_tags)) ?>

    <p id="chart_container" style="background-color:#fff;">
      <img src="/google_chart_image.php?chart_img_name=<?php echo $chart_img_name ?>" alt="<?php echo $chart_title ?>" />
    </p>


    <?php include_partial('monitoring/classifica', 
                          array('politici' => $politici, 'tags_ids' => $tags_ids,
                                'chart_params' => $chart_params, 'chart_title' => $chart_title,
                                'chart_img_name' => $chart_img_name, 'sf_user' => $sf_user)) ?>

  </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  <?php echo link_to('i miei argomenti', 
                     '@monitoring_tags?user_token='. sfContext::getInstance()->getUser()->getToken()) ?> /
  le classifiche dei senatori
<?php end_slot() ?>

