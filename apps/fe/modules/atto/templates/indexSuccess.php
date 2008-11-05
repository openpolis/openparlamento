<?php use_helper('Date', 'I18N', 'deppVoting') ?>

<a name="top"></a> 
<h1><?php echo $atto->getOppTipoAtto()->getDenominazione() ?></h1>
<br />

<h2><?php echo Text::denominazioneAtto($atto, 'index') ?></h2>
<br />

<h3><?php echo $atto->getDescrizione() ?></h2>
<br />

<?php if($atto->getTipoAttoId()=='14'): ?>
  <?php if($atto->getRamo()=='C'): ?>
    <?php $link = 'http://www.camera.it/_dati/leg'.$atto->getLegislatura().'/lavori/stencomm/'.$atto->getNumfase().'/s010.htm'; ?>
  <?php else: ?>
    <?php $link = '#' ?>
  <?php endif; ?>
<?php else: ?>
  <?php $link = 'http://banchedati.camera.it/sindacatoispettivo_'.$atto->getLegislatura().'/showXhtml.Asp?idAtto='.$atto->getParlamentoId().'&stile=6&highLight=1'; ?>
<?php endif; ?>  	 	

<b><?php echo link_to("Testo dell'ATTO", $link, array('target' => '_blank')) ?></b>
<br /><br />

<b>data di presentazione: <?php echo format_date($atto->getDataPres(), 'dd/MM/yyyy') ?></b>
<br /><br />


<!-- partial per la gestione del monitoring di questo atto -->
<?php echo include_component('monitoring', 'manageItem', 
                             array('item_pk' => $atto->getPrimaryKey(), 
                                   'item_model' => get_class($atto))); ?>

<!-- partial per la visualizzazione e l'edit-in-place dei tags associati all'atto -->
<?php echo include_component('deppTagging', 'edit', array('content' => $atto)); ?>

<!-- blocco voting -->
<?php echo depp_voting_block($atto) ?>

<!-- blocco dei commenti -->
<div id="comments-block">
    <hr />

    <a href="#top" class="go-top">torna su</a>
    <a name="comments"></a>
    <?php include_partial('deppCommenting/commentsList', array('content' => $atto)) ?>

    <hr/>

    <?php include_component('deppCommenting', 'addComment',  
                            array('content' => $atto,
                                  'read_only' => sfConfig::get('app_comments_enabled', false),
                                  'automoderation' => sfConfig::get('app_comments_automoderation', 'captcha')) ) ?>

    <hr/>
</div>

<?php if(count($primi_firmatari)!=0): ?>
  <?php include_partial('primiFirmatari', array('primi_firmatari' => $primi_firmatari)) ?>
<?php endif; ?>

<?php if(count($co_firmatari)!=0): ?>
  <?php include_partial('coFirmatari', array('co_firmatari' => $co_firmatari)) ?>
<?php endif; ?>
<br /><br />

<?php if(count($relatori)!=0): ?>
<?php include_partial('relatori', array('relatori' => $relatori)) ?>
<?php endif; ?>
<br /><br />

<b>Rappresentazione Iter</b>
<br />
<table border=1>
<tr>
<?php if ($rappresentazioni_pred=='') : ?>
  <th bgcolor="#00FF00"><?php echo ($atto->getRamo()=='C' ? 'Camera':'Senato'). " - ".format_date($atto->getDataPres(), 'dd/MM/yyyy') ?> Presentato</th>
  <?php if(count($rappresentazioni_this)!=0) : ?>
    <th>
      <?php foreach($rappresentazioni_this as $rappresentazione_this): ?>
        <?php $tempo= ($rappresentazione_this[3]=='C' ? 'Camera':'Senato').' - '.format_date($rappresentazione_this[1], 'dd/MM/yyyy').' '.$rappresentazione_this[2] ?>
      <?php endforeach; ?>
      <?php if(substr_count($tempo,'approvato')>0) : ?>
        <th bgcolor="#00FF00">
      <?php else : ?>
        <th bgcolor="#FF0000">
      <?php endif; ?>   
      <?php echo $tempo ?>       
    </th>
    <?php if(count($rappresentazioni_succ)==0) : ?>
      <th><i><?php echo 'Da Approvare'.($atto->getRamo()=='C' ? ' al Senato':' alla Camera') ?>
        <?php if($lettura_parlamentare_successiva): ?>
          <?php echo link_to($lettura_parlamentare_successiva->getRamo().'.'.$lettura_parlamentare_successiva->getNumfase(), 'atto/index?id='.$lettura_parlamentare_successiva->getId()) ?>
        <?php endif; ?>
      </i></th>
      <th><i><?php echo 'Diventa Legge!  ' ?></i></th>
    <?php endif; ?>   
  <?php endif; ?>   
  <?php if(count($rappresentazioni_this)==0) : ?>
    <th><i><?php echo 'Da Approvare'.($atto->getRamo()=='C' ? ' alla Camera':' al Senato') ?>
      <?php if($lettura_parlamentare_successiva): ?>
        <?php echo link_to($lettura_parlamentare_successiva->getRamo().'.'.$lettura_parlamentare_successiva->getNumfase(), 'atto/index?id='.$lettura_parlamentare_successiva->getId()) ?>
      <?php endif; ?>
    </i></th> 
    <th><i><?php echo 'Da Approvare'.($atto->getRamo()=='C' ? ' al Senato':' alla Camera') ?></i></th>
    <th><i><?php echo 'Diventa Legge!  ' ?></i></th>
  <?php endif; ?>     
<?php endif ?>
	
<?php if ($rappresentazioni_pred!=='') : ?>
  <th bgcolor="#00FF00">
    <?php echo link_to($rappresentazioni_pred[0][3].'.'.$rappresentazioni_pred[0][4],'atto/index?id='.$rappresentazioni_pred[0][5]) ?>
    <br />
    <?php echo ($rappresentazioni_pred[0][3]=='C' ? 'Camera':'Senato'). " - ".format_date($rappresentazioni_pred[0][6], 'dd/MM/yyyy') ?> Presentato
    </th>
  <?php foreach($rappresentazioni_pred as $rappresentazione_pred): ?>
      <?php $tempo= ($rappresentazione_pred[3]=='C' ? 'Camera':'Senato').' - '.format_date($rappresentazione_pred[1], 'dd/MM/yyyy').' '.$rappresentazione_pred[2] ?>
      <?php $chiuso_pred=$rappresentazione_pred[2] ?>
     <?php if(substr_count($tempo,'approvato')>0) : ?>
          <th bgcolor="#00FF00">
       <?php else : ?>
          <th bgcolor="#FF0000">
       <?php endif; ?>   
       <?php echo link_to($rappresentazione_pred[3].'.'.$rappresentazione_pred[4],'atto/index?id='.$rappresentazione_pred[5]) ?>
       <br />
        <?php echo $tempo ?>       
    </th>
   <?php endforeach; ?>  
  <?php if(count($rappresentazioni_this)!=0) : ?>
    
      <?php foreach($rappresentazioni_this as $rappresentazione_this): ?>
         <?php $tempo=($rappresentazione_this[3]=='C' ? 'Camera':'Senato').' - '.format_date($rappresentazione_this[1], 'dd/MM/yyyy').' '.$rappresentazione_this[2] ?>
         <?php $chiuso_this=$rappresentazione_this[2] ?>
       <?php if(substr_count($tempo,'approvato')>0) : ?>
          <th bgcolor="#00FF00">
       <?php else : ?>
          <th bgcolor="#FF0000">
       <?php endif; ?>   
       <br />
        <?php echo $tempo ?>       
    </th>
       <?php endforeach; ?> 
    
     <?php if (($chiuso_this=='approvato con modificazioni') && ($rappresentazioni_succ=='')) : ?>
         <th><i><?php echo 'Nuova Approvazione'.($atto->getRamo()=='C' ? ' al Senato':' alla Camera') ?>
       <?php if($lettura_parlamentare_successiva): ?>
         <?php echo link_to($lettura_parlamentare_successiva->getRamo().'.'.$lettura_parlamentare_successiva->getNumfase(), 'atto/index?id='.$lettura_parlamentare_successiva->getId()) ?>
      <?php endif; ?>
         </i></th>
         <th><i><?php echo 'Diventa Legge!  ' ?></i></th>
     <?php endif ?>           
  <?php endif ?>
  <?php if(count($rappresentazioni_this)==0) : ?> 
     <th><i><?php echo 'Approvazione'.($atto->getRamo()=='C' ? ' alla Camera':' al Senato') ?>
      <?php if($lettura_parlamentare_successiva): ?>
         <?php echo link_to($lettura_parlamentare_successiva->getRamo().'.'.$lettura_parlamentare_successiva->getNumfase(), 'atto/index?id='.$lettura_parlamentare_successiva->getId()) ?>
      <?php endif; ?>
     </i></th>
     <?php if ($chiuso_pred=='conclusione anomala per stralcio') : ?>
     <th><i>
     <?php echo 'Approvazione'.($atto->getRamo()=='C' ? ' al Senato':' alla Camera') ?>
     </i></th>
     <?php endif ?>  
       
     <th><i><?php echo 'Diventa Legge!  ' ?></i></th>
  <?php endif ?>      
<?php endif ?>

<?php if ($rappresentazioni_succ!=='') : ?>
  <?php foreach($rappresentazioni_succ as $rappresentazione_succ): ?>
    
      <?php $tempo= ($rappresentazione_succ[3]=='C' ? 'Camera':'Senato').' - '.format_date($rappresentazione_succ[1], 'dd/MM/yyyy').' ' .$rappresentazione_succ[2] ?>
        <?php if(substr_count($tempo,'approvato')>0) : ?>
          <th bgcolor="#00FF00">
       <?php else : ?>
          <th bgcolor="#FF0000">
       <?php endif; ?>   
        <?php echo link_to($rappresentazione_succ[3].'.'.$rappresentazione_succ[4],'atto/index?id='.$rappresentazione_succ[5]) ?>
        <br />
        <?php echo $tempo ?>       
    </th>
   <?php endforeach; ?>  
<?php endif ?>
</tr>
</table>
<br /><br />

<!-- SE ESISTE LEGGE ASSOCIATA LA MOSTRA -->
<?php if ($legge!=="") : ?>
      <?php echo link_to('Legge n.'. $legge->getNumero().' del '.format_date($legge->getData(), 'dd/MM/yyyy'),$legge->getUrl()) ?>, pubblicata su <?php echo $legge->getGu() ?>  
      <br /><br />
<?php endif ?>

<?php include_partial('status', array('status' => $status)) ?>

<?php if(count($iter_completo)!=0): ?>
  <?php include_partial('iterCompleto', array('iter_completo' => $iter_completo)) ?>
<?php endif; ?>

<?php if(count($commissioni)!=0): ?>
  <?php include_partial('commissioni', array('commissioni' => $commissioni)) ?>
<?php endif; ?>

<?php if(count($tesei)!=0): ?>
  <?php include_partial('teseo', array('tesei' => $tesei)) ?>
<?php endif; ?>  

<!--
<?php if($lettura_parlamentare_precedente || $lettura_parlamentare_successiva): ?>
  <b>Successioni delle letture parlamentari</b>
  <br />
  <?php if($lettura_parlamentare_precedente): ?>
    Precedente: <?php echo link_to($lettura_parlamentare_precedente->getRamo().'.'.$lettura_parlamentare_precedente->getNumfase(), 'atto/index?id='.$lettura_parlamentare_precedente->getId()) ?>
    <br />
  <?php endif; ?> 
  <?php if($lettura_parlamentare_successiva): ?>
    Successiva: <?php echo link_to($lettura_parlamentare_successiva->getRamo().'.'.$lettura_parlamentare_successiva->getNumfase(), 'atto/index?id='.$lettura_parlamentare_successiva->getId()) ?>
  <?php endif; ?>
  <br /><br />
<?php endif; ?>
-->

<?php if(count($votazioni)!=0): ?>
  <?php include_partial('votazioni', array('votazioni' => $votazioni)) ?>
<?php endif; ?>


<?php if(count($interventi)!=0): ?>
  <?php include_partial('interventi', array('interventi' => $interventi)) ?>
<?php endif; ?>  