<?php $giorno = substr($ddl->getTitolo(), strlen($ddl->getTitolo()) - 11, 2); ?>
<?php $mese = substr($ddl->getTitolo(), strlen($ddl->getTitolo()) - 8, 2); ?>
<?php $anno = substr($ddl->getTitolo(), strlen($ddl->getTitolo()) - 5, 4); ?>  
<?php $data_scadenza = date("Y-m-d", mktime(0,0,0,$mese + 1, $giorno + 29, $anno)) ?>
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
    <p class="gold"><?php echo $iter->getFase() ?></p>
  
 <?php else: ?>
  <span class="gold">
    <?php if($differenza >= 0): ?>
      <?php $differenza=intval($differenza); ?>
      <?php echo format_number_choice('[0] In scadenza oggi|[1] 1 giorno alla scadenza|(1,+Inf] %1% giorni alla scadenza', array('%1%' => $differenza), $differenza) ?>
    <?php else: ?>
      Decaduto
    <?php endif; ?>
  </span>	  
 <?php endif; ?>
<?php endforeach; ?>