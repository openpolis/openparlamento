<?php
$act = $this->getContext()->getActionName(); 
$mod = $this->getContext()->getModuleName();
?>

<div id="breadcrumbs">

<?php switch($mod): ?>
<?php case 'atto': ?>
  <?php echo link_to("Home", "@homepage") ?>
  /
  <?php if($act=='disegnoList'): ?>
  Disegni di legge
  <?php elseif($act=='decretoList'): ?>
  Decreti legge
  <?php elseif($act=='decretoLegislativoList'): ?>
  Decreti legislativi
  <?php elseif($act=='attoNonLegislativoList'): ?>
  Atti non legislativi
  <?php elseif($act=='documento'): ?>
    <?php $documento = OppDocumentoPeer::retrieveByPk($sf_params->get('id')); ?>
	<?php echo link_to(Text::denominazioneAttoShort($documento->getOppAtto()),'atto/index?id='.$documento->getOppAtto()->getId()) ?>
    /
	<?php echo $documento->getTitolo() ?>
  <?php elseif($sf_params->get('id')): ?>
    <?php $atto = OppAttoPeer::retrieveByPk($sf_params->get('id')); ?>
<?php switch($atto->getTipoAttoId()): ?>
<?php case '1': ?>
<?php echo link_to("Disegni di legge", "atto/disegnoList") ?>
 /
<?php echo Text::denominazioneAttoShort($atto) ?>
<?php break; ?>
<?php case '12': ?>
<?php echo link_to("Decreti legge", "atto/decretoList") ?>
 /
<?php echo Text::denominazioneAttoShort($atto) ?>
<?php break; ?>
<?php case '15': ?>
<?php case '16': ?>
<?php case '17': ?>
<?php echo link_to("Decreti legislativi", "atto/decretoLegislativoList") ?>
 /
<?php echo Text::denominazioneAttoShort($atto) ?>
<?php break; ?>
<?php default: ?>
<?php echo link_to("Atti non legislativi", "atto/attoNonLegislativoList") ?>
 /
<?php echo Text::denominazioneAttoShort($atto) ?>
<?php endswitch; ?>
  <?php endif; ?> 
 
  <?php break; ?>
  
<?php case 'votazione': ?>
  <?php echo link_to("Home", "@homepage") ?>
  /
  <?php if($act=='list'): ?>
  Votazioni
  <?php elseif($sf_params->get('id')): ?>
  <?php echo link_to('Votazioni', '@votazioni') ?>
  /
  <?php $votazione = OppVotazionePeer::retrieveByPk($sf_params->get('id')); ?>
  <?php echo $votazione->getTitolo(); ?>
  <?php endif; ?>
  <?php break; ?>
<?php case 'parlamentare': ?>
  <?php echo link_to("Home", "@homepage") ?>
  /
  <?php if($act=='list'): ?>
    <?php if($sf_params->get('ramo') && $sf_params->get('ramo')=='senato' ): ?>
	Senato
	<?php else: ?>
	Camera
	<?php endif; ?>
  <?php else: ?>
    <?php $c = new Criteria(); ?>
	<?php $c->add(OppCaricaPeer::LEGISLATURA, '16', Criteria::EQUAL); ?>
	<?php $c->add(OppCaricaPeer::POLITICO_ID, $sf_params->get('id'), Criteria::EQUAL); ?>
	<?php $carica = OppCaricaPeer::doSelectOne($c); ?>
	<?php if($carica->getCarica()=='Deputato'): ?>
	  <?php echo link_to('Camera', '@parlamentari?ramo=camera') ?>
	  /
	<?php else: ?>
	  <?php echo link_to('Senato', '@parlamentari?ramo=senato') ?>
	  /
	<?php endif;?>
	<?php echo $carica->getOppPolitico()->getNome()." ".$carica->getOppPolitico()->getCognome(); ?>      	
  <?php endif;?>	
  <?php break; ?>
<?php case 'argomento': ?>
  <?php include_slot('argomento_breadcrumbs'); ?>
  <?php break; ?>
<?php case 'sfSimpleBlog': ?>
  <?php include_slot('blog_breadcrumbs'); ?>
  <?php break; ?>
<?php default: ?>
  Home    
<?php endswitch; ?>
</div>