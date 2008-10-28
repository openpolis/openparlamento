<?php use_helper('Date', 'I18N', 'deppVoting') ?>

<a name="top"></a> 
<h1>Pagina DDL</h1>
<br />

<h2><?php echo ($ddl->getRamo().'.'.$ddl->getNumfase().' '.$ddl->getTitolo()) ?></h2>
<br />

<b><?php echo link_to('Testo del DDL', 'http://www.senato.it/leg/'.$ddl->getLegislatura().'/BGT/Schede/Ddliter/testi/'.$ddl->getParlamentoId().'_testi.htm', array('target' => '_blank')) ?></b>
<br /><br />

<b>data di presentazione: <?php echo format_date($ddl->getDataPres(), 'dd/MM/yyyy') ?></b>
<br /><br />

<?php switch($ddl->getIniziativa()): ?>
<?php case '1': ?>
<b>Iniziativa Parlamentare</b>
<?php break; ?>
<?php case '2': ?>
<b>Iniziativa di Governo</b>
<?php break; ?>
<?php case '3': ?>
<b>IniziativaPopolare</b>
<?php break; ?>
<?php endswitch; ?>
<br /><br />

<!-- partial per la visualizzazione e l'edit-in-place dei tags associati al ddl -->
<?php echo include_component('deppTagging', 'edit', array('content' => $ddl)); ?>

<!-- blocco voting -->
<?php echo depp_voting_block($ddl) ?>

<!-- blocco dei commenti -->
<div id="comments-block">
    <hr />

    <a href="#top" class="go-top">torna su</a>
    <a name="comments"></a>
    <?php include_partial('deppCommenting/commentsList', array('content' => $ddl)) ?>

    <hr/>

    <?php include_component('deppCommenting', 'addComment',  
                            array('content' => $ddl,
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

  <th bgcolor="#00FF00"><?php echo ($ddl->getRamo()=='C' ? 'Camera':'Senato'). " - ".format_date($ddl->getDataPres(), 'dd/MM/yyyy') ?> Presentato</th>
  
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
      <th><i><?php echo 'Da Approvare'.($ddl->getRamo()=='C' ? ' al Senato':' alla Camera') ?>
      <?php if($lettura_parlamentare_successiva): ?>
         <?php echo link_to($lettura_parlamentare_successiva->getRamo().'.'.$lettura_parlamentare_successiva->getNumfase(), 'atto/ddlIndex?id='.$lettura_parlamentare_successiva->getId()) ?>
      <?php endif; ?>
      </i></th>
      <th><i><?php echo 'Diventa Legge!  ' ?></i></th>
     <?php endif; ?>   
  <?php endif; ?>   
  <?php if(count($rappresentazioni_this)==0) : ?>
     <th><i><?php echo 'Da Approvare'.($ddl->getRamo()=='C' ? ' alla Camera':' al Senato') ?>
       <?php if($lettura_parlamentare_successiva): ?>
         <?php echo link_to($lettura_parlamentare_successiva->getRamo().'.'.$lettura_parlamentare_successiva->getNumfase(), 'atto/ddlIndex?id='.$lettura_parlamentare_successiva->getId()) ?>
      <?php endif; ?>
     </i></th> 
     <th><i><?php echo 'Da Approvare'.($ddl->getRamo()=='C' ? ' al Senato':' alla Camera') ?></i></th>
     <th><i><?php echo 'Diventa Legge!  ' ?></i></th>
  <?php endif; ?>     
<?php endif ?>	
<?php if ($rappresentazioni_pred!=='') : ?>
       <th bgcolor="#00FF00">
       <?php echo link_to($rappresentazioni_pred[0][3].'.'.$rappresentazioni_pred[0][4],'atto/ddlIndex?id='.$rappresentazioni_pred[0][5]) ?>
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
       <?php echo link_to($rappresentazione_pred[3].'.'.$rappresentazione_pred[4],'atto/ddlIndex?id='.$rappresentazione_pred[5]) ?>
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
         <th><i><?php echo 'Nuova Approvazione'.($ddl->getRamo()=='C' ? ' al Senato':' alla Camera') ?>
       <?php if($lettura_parlamentare_successiva): ?>
         <?php echo link_to($lettura_parlamentare_successiva->getRamo().'.'.$lettura_parlamentare_successiva->getNumfase(), 'atto/ddlIndex?id='.$lettura_parlamentare_successiva->getId()) ?>
      <?php endif; ?>
         </i></th>
         <th><i><?php echo 'Diventa Legge!  ' ?></i></th>
     <?php endif ?>           
  <?php endif ?>
  <?php if(count($rappresentazioni_this)==0) : ?> 
     <th><i><?php echo 'Approvazione'.($ddl->getRamo()=='C' ? ' alla Camera':' al Senato') ?>
      <?php if($lettura_parlamentare_successiva): ?>
         <?php echo link_to($lettura_parlamentare_successiva->getRamo().'.'.$lettura_parlamentare_successiva->getNumfase(), 'atto/ddlIndex?id='.$lettura_parlamentare_successiva->getId()) ?>
      <?php endif; ?>
     </i></th>
     <?php if ($chiuso_pred=='conclusione anomala per stralcio') : ?>
     <th><i>
     <?php echo 'Approvazione'.($ddl->getRamo()=='C' ? ' al Senato':' alla Camera') ?>
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
        <?php echo link_to($rappresentazione_succ[3].'.'.$rappresentazione_succ[4],'atto/ddlIndex?id='.$rappresentazione_succ[5]) ?>
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
<br /><br />

<?php if(count($tesei)!=0): ?>
  <?php include_partial('teseo', array('tesei' => $tesei)) ?>
<?php endif; ?>

<!--
<?php if($lettura_parlamentare_precedente || $lettura_parlamentare_successiva): ?>
  <b>Successioni delle letture parlamentari</b>
  <br />
  <?php if($lettura_parlamentare_precedente): ?>
    Precedente: <?php echo link_to($lettura_parlamentare_precedente->getRamo().'.'.$lettura_parlamentare_precedente->getNumfase(), 'atto/ddlIndex?id='.$lettura_parlamentare_precedente->getId()) ?>
    <br />
  <?php endif; ?> 
  <?php if($lettura_parlamentare_successiva): ?>
    Successiva: <?php echo link_to($lettura_parlamentare_successiva->getRamo().'.'.$lettura_parlamentare_successiva->getNumfase(), 'ato/ddlIndex?id='.$lettura_parlamentare_successiva->getId()) ?>
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