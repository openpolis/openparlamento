<?php echo use_helper('Javascript'); ?>

<?php echo include_component('monitoring', 'submenu', array('current' => 'alerts')); ?>

<div id="content" class="tabbed-orange float-container">
  <?php if ($sf_flash->has('warning')): ?>
    <div class="flash-messages">
      <?php echo $sf_flash->get('warning') ?>
    </div>
  <?php endif; ?>

  <div id="main">

    <?php if (count($alerts) > 0): ?>
    	<h5 class="subsection">I tuoi avvisi</h5>
    <?php else: ?>
    	<h5 class="subsection">Non hai nessun avviso attivo</h5>
    <?php endif ?>

    <div class="more-results float-container">
      <ul id="my_alerts" class="monitoring-list">
        <?php foreach ($alerts as $alert): ?>
          <li> 
            <?php $term = $alert->getOppAlertTerm()->getTerm() ?>
            <?php echo  link_to(image_tag('ico-remove_alert.png'), 
                                'monitoring/delAlert?term='. str_replace("/", "|", $term) , 
                                array('title' => 'smetti di ricevere alert su questo termine')) ?>
            <?php echo $term; ?><?php if ($alert->getTypeFilters() != ''): ?>:<?php endif ?><?php echo OppAlertTermPeer::get_filters_labels($alert->getTypeFilters()) ?>
          </li>
        <?php endforeach ?>
      </ul>
	  </div>
    
  </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  i miei alert
<?php end_slot() ?>

