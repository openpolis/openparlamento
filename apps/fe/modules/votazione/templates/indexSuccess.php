<?php use_helper('Date') ?>

<h1><?php echo $ramo ?></h1>
<h2>Legislatura <?php echo $votazione->getOppSeduta()->getLegislatura() ?></h2>
<br />
<h3>seduta n&deg; <?php echo $votazione->getOppSeduta()->getNumero() ?> del <?php echo format_date($votazione->getOppSeduta()->getData(), 'dd/MM/yyyy') ?></h3>
<h3>VOTAZIONE <?php echo $votazione->getTitolo() ?></h3>
<h3>maggioranza: <?php echo $votazione->getMaggioranza() ?></h3>
<h3>esito: <?php echo $votazione->getEsito() ?></h3>
<h4><?php echo link_to('fonte', $votazione->getUrl(), array('target'=>'_blank')) ?></h4>
<br />

<?php include_partial('gruppi', array('votazione' => $votazione, 'risultati' => $risultati)) ?> 
<br />
<br />
<?php if ($ribelli): ?>
  <?php include_partial('ribelli', array('ribelli' => $ribelli)) ?>  
  <br />
  <br />
<?php endif; ?>  			
<?php include_partial('votanti', array('votanti' => $votanti)) ?>  