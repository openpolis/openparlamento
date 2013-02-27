<?php $giorno = substr($ddl->getTitolo(), strlen($ddl->getTitolo()) - 11, 2); ?>
<?php $mese = substr($ddl->getTitolo(), strlen($ddl->getTitolo()) - 8, 2); ?>
<?php $anno = substr($ddl->getTitolo(), strlen($ddl->getTitolo()) - 5, 4); ?>  
<?php if (is_int($giorno) && is_int($mese) && is_int($anno)) :?>
  <?php $data_scadenza = date("Y-m-d", mktime(0,0,0,$mese + 1, $giorno + 29, $anno)) ?>
<?php else :?>
  <?php $data_pres=explode("-",$ddl->getDataPres())?>
  <?php $data_scadenza = date("Y-m-d", mktime(0,0,0,$data_pres[1] + 1, $data_pres[2] + 29, $data_pres[0])) ?>
<?php endif ?>  
<?php $differenza = (strtotime($data_scadenza) - strtotime(date("Y-m-d", time())))/(86400); ?>      
<?php $status = $ddl->getStatus(); ?>

<?php foreach ($status as $data => $status_iter): ?> 
 <?php if($status_iter!=65 ) : ?>
  
    <?php if($data): ?>
	  <p class="date"><?php echo format_date($data, 'dd/MM/yyyy') ?></p>
    <?php endif; ?>
	<?php $c = new Criteria() ?>
    <?php $c->add(OppIterPeer::ID, $status_iter, Criteria::EQUAL); ?>
    <?php $iter = OppIterPeer::doSelectOne($c) ?>
    <?php if($iter->getId()!=63): ?>
       <p class="gold"><?php echo $iter->getFase() ?></p>
    <?php else: ?>
       <p class="green"><?php echo $iter->getFase() ?></p>
    <?php endif; ?>   
  
 <?php else: ?>
  
    <?php if($differenza >= 0): ?>
      <?php $differenza=intval($differenza); ?>
      <span class="gold">
      <?php echo format_number_choice('[0] In scadenza oggi|[1] 1 giorno alla scadenza|(1,+Inf] %1% giorni alla scadenza', array('%1%' => $differenza), $differenza) ?>
      </span>
    <?php else: ?>
     <span class="red">
      Decaduto
      </span>
    <?php endif; ?>
  	  
 <?php endif; ?>
<?php endforeach; ?>
