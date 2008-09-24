<?php use_helper('Date') ?>
 
<h1>Pagina DDL</h1>
<br />

<h2><?php echo ($ddl->getRamo().'.'.$ddl->getNumfase().' '.$ddl->getTitolo()) ?></h2>
<br />

<b><?php echo link_to('Testo del DDL', 'http://www.senato.it/leg/'.$ddl->getLegislatura().'/BGT/Schede/Ddliter/testi/'.$ddl->getParlamentoId().'_testi.htm') ?></b>
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

<?php if(count($primi_firmatari)!=0): ?>
<b>Primi firmatari</b>
<br />
<?php foreach($primi_firmatari as $id => $primo_firmatario): ?>
  <?php $info_array = explode('-', $primo_firmatario ); ?>
  <?php echo format_date($info_array[0], 'dd/MM/yyyy').' - '.link_to($info_array[1], '@parlamentare?id='.$id) ?>
  <br />
<?php endforeach; ?>
<br /><br />
<?php endif; ?>

<?php if(count($co_firmatari)!=0): ?>
<b>Co-firmatari</b>
<br />
<?php foreach($co_firmatari as $id => $co_firmatario): ?>
  <?php $info_array = explode('-', $co_firmatario ); ?>
  <?php echo format_date($info_array[0], 'dd/MM/yyyy').' - '.link_to($info_array[1], '@parlamentare?id='.$id) ?>
  <br />
<?php endforeach; ?>
<?php endif; ?>
<br /><br />

<?php if(count($relatori)!=0): ?>
<b>Relatori</b>
<br />
<?php foreach($relatori as $id => $relatore): ?>
  <?php echo link_to($relatore, '@parlamentare?id='.$id) ?>
  <br />
<?php endforeach; ?>
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
         <?php echo link_to($lettura_parlamentare_successiva->getRamo().'.'.$lettura_parlamentare_successiva->getNumfase(), 'ddl/index?id='.$lettura_parlamentare_successiva->getId()) ?>
      <?php endif; ?>
      </i></th>
      <th><i><?php echo 'Diventa Legge!  ' ?></i></th>
     <?php endif; ?>   
  <?php endif; ?>   
  <?php if(count($rappresentazioni_this)==0) : ?>
     <th><i><?php echo 'Da Approvare'.($ddl->getRamo()=='C' ? ' alla Camera':' al Senato') ?>
       <?php if($lettura_parlamentare_successiva): ?>
         <?php echo link_to($lettura_parlamentare_successiva->getRamo().'.'.$lettura_parlamentare_successiva->getNumfase(), 'ddl/index?id='.$lettura_parlamentare_successiva->getId()) ?>
      <?php endif; ?>
     </i></th> 
     <th><i><?php echo 'Da Approvare'.($ddl->getRamo()=='C' ? ' al Senato':' alla Camera') ?></i></th>
     <th><i><?php echo 'Diventa Legge!  ' ?></i></th>
  <?php endif; ?>     
<?php endif ?>	
<?php if ($rappresentazioni_pred!=='') : ?>
       <th bgcolor="#00FF00">
       <?php echo link_to($rappresentazioni_pred[0][3].'.'.$rappresentazioni_pred[0][4],'ddl/index?id='.$rappresentazioni_pred[0][5]) ?>
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
       <?php echo link_to($rappresentazione_pred[3].'.'.$rappresentazione_pred[4],'ddl/index?id='.$rappresentazione_pred[5]) ?>
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
         <?php echo link_to($lettura_parlamentare_successiva->getRamo().'.'.$lettura_parlamentare_successiva->getNumfase(), 'ddl/index?id='.$lettura_parlamentare_successiva->getId()) ?>
      <?php endif; ?>
         </i></th>
         <th><i><?php echo 'Diventa Legge!  ' ?></i></th>
     <?php endif ?>           
  <?php endif ?>
  <?php if(count($rappresentazioni_this)==0) : ?> 
     <th><i><?php echo 'Approvazione'.($ddl->getRamo()=='C' ? ' alla Camera':' al Senato') ?>
      <?php if($lettura_parlamentare_successiva): ?>
         <?php echo link_to($lettura_parlamentare_successiva->getRamo().'.'.$lettura_parlamentare_successiva->getNumfase(), 'ddl/index?id='.$lettura_parlamentare_successiva->getId()) ?>
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
        <?php echo link_to($rappresentazione_succ[3].'.'.$rappresentazione_succ[4],'ddl/index?id='.$rappresentazione_succ[5]) ?>
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




<b>Status</b>
<?php foreach($status as $data => $status_iter): ?>
<?php echo format_date($data, 'dd/MM/yyyy') ?> <?php echo $status_iter ?>
<br />
<?php endforeach; ?>
<br /><br />

<?php if(count($iter_completo)!=0): ?>
  <b>Iter completo</b>
  <br />
  <?php foreach($iter_completo as $iter => $data): ?>
    <?php echo format_date($data, 'dd/MM/yyyy') ?> <?php echo $iter ?>
    <br />
  <?php endforeach; ?>
  <br /><br />
<?php endif; ?>

<?php if(count($commissioni)!=0): ?>
<b>Commissioni assegnatarie</b>
<br />
<?php foreach($commissioni as $id => $commissione): ?>
  <?php if($commissione->getOppSede()->getRamo()=='S'): $sede_comm="Senato" ?>
  <?php else: $sede_comm="Camera" ?>
  <?php endif; ?>
  <?php echo "Sede ".$commissione->getTipo().": ".$sede_comm." Commissione ".$commissione->getOppSede()->getDenominazione(); ?>
  <br />
<?php endforeach; ?>
<?php endif; ?>
<br /><br />

<?php if(count($argomenti)!=0): ?>
  <b>Argomenti</b>
  <br />
  <?php foreach($argomenti as $id => $argomento): ?>
    <?php echo link_to($argomento.' ('.$id.')', '#') ?>
    <br />
  <?php endforeach; ?>
  <br /><br />
<?php endif; ?>  

<!--
<?php if($lettura_parlamentare_precedente || $lettura_parlamentare_successiva): ?>
  <b>Successioni delle letture parlamentari</b>
  <br />
  <?php if($lettura_parlamentare_precedente): ?>
    Precedente: <?php echo link_to($lettura_parlamentare_precedente->getRamo().'.'.$lettura_parlamentare_precedente->getNumfase(), 'ddl/index?id='.$lettura_parlamentare_precedente->getId()) ?>
    <br />
  <?php endif; ?> 
  <?php if($lettura_parlamentare_successiva): ?>
    Successiva: <?php echo link_to($lettura_parlamentare_successiva->getRamo().'.'.$lettura_parlamentare_successiva->getNumfase(), 'ddl/index?id='.$lettura_parlamentare_successiva->getId()) ?>
  <?php endif; ?>
  <br /><br />
<?php endif; ?>
-->

<?php if(count($votazioni)!=0): ?>
<h2>Votazioni riferite al DDL</h2>
<table>
<tr>
  <th>Data</th>
  <th>Ramo</th>
  <th>Titolo</th>
  <th>Favorevoli</th>
  <th>Contrari</th>
  <th>Esito</th>
  <th>Ribelli</th>	
</tr>	
<?php foreach($votazioni as $votazione): ?>
 
  <tr <?php echo ($votazione->getFinale()=='1' ? 'style="font-weight:bold"' : '') ?> >
    <td><?php echo format_date($votazione->getOppSeduta()->getData(), 'dd/MM/yyyy') ?></td>
	<td><?php echo ($votazione->getOppSeduta()->getRamo()=='C' ? 'Camera' : 'Senato' ) ?></td>
	<td><?php echo link_to($votazione->getTitolo(), '@votazione?id='.$votazione->getId()) ?></td>
	<td><?php echo $votazione->getFavorevoli() ?></td>
	<td><?php echo $votazione->getContrari() ?></td>
	<td><?php echo $votazione->getEsito() ?></td>
	<td><?php echo $votazione->getRibelliCount() ?></td>	
  </tr> 
<?php endforeach; ?>
</table>
<?php endif; ?>
<br /><br />

<?php if(count($interventi)!=0): ?>
<h2>Interventi riferiti al DDL</h2>
<table>
<tr>
  <th>Data</th>
  <th>Parlamentare</th>
  <th>link</th>
  <th>Tipo intervento</th>
  <th>Sede</th>
</tr>	
<?php foreach($interventi as $intervento): ?>
<?php $interventi_array = explode('@', $intervento['link'] ); ?>
  <?php foreach($interventi_array as $intervento_singolo): ?>  
    <tr>
      <td><?php echo format_date($intervento['data'], 'dd/MM/yyyy') ?></td>
      <td><?php echo link_to($intervento['nome'].' '.$intervento['cognome'], '@parlamentare?id='.$intervento['politico_id']) ?></td>
      <td><?php echo link_to("vai all'intervento", $intervento_singolo) ?></td>
      <td>
<?php switch($intervento['tipo']): ?>
<?php case 'Referente': ?>
Intervento in sede referente
<?php break; ?>
<?php case 'Consultiva': ?>
Intervento in sede consultiva
<?php break; ?>
<?php case 'Assemblea': ?>
Intervento
<?php break; ?>
<?php endswitch; ?>  	
      </td>
      <td><?php echo ($intervento['denominazione'].' '.($intervento['ramo']=='C' ? 'Camera' : 'Senato') ) ?></td>
    </tr>
  <?php endforeach; ?>	
<?php endforeach; ?>
</table>
<?php endif; ?>    