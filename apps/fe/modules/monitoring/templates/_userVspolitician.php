<!-- Pagina monitoraggio utente - i miei parlamentari -->
<?php if ($ambient=='monitor') : ?>
  <?php if (count($vicini)>0 || count($lontani)>0): ?>
    <h5 class="subsection">quanto ti rappresentano i parlamentari?
      <span class="tools-container"><a class="ico-help" href="#">&nbsp;</a></span>
  		<div style="display: none;" class="help-box float-container">
  			<div class="inner float-container">

  				<a class="ico-close" href="#">chiudi</a><h5>come &egrave; calcolato ?</h5>
  				<p style="padding: 5px; font-size: 12px;font-weight:normal; color:#333333;">L'indice di quanto ti rappresentano i parlamentari &egrave; calcolato sulla base dei voti (favorevoli e contrari) che hai espresso sugli atti parlamentari.
  Maggiore &egrave; il numero di atti su cui esprimi un giudizio, pi&ugrave; preciso sar&agrave; l'indice di rappresentanza. <br />
  Un calcolo quindi che non si basa su percezioni e dichiarazioni, ma su dati di fatto, confrontando le decisioni prese da deputati e senatori con le tue. Per approfondire <?php echo link_to('clicca qui','http://'.sfConfig::get('sf_site_url').'/blog/2010/01/19/la-distanza-tra-te-e-gli-eletti',true) ?>.</p>
  			</div>
  		</div>
  	</h5>
  	<p style="font-size:14px; padding:10px;">L'indice di rappresentanza &egrave; calcolato considerando <?php echo ($voti_utente==1 ? '<strong>il voto da TE espresso su un solo atto parlamentare</strong>.' : 'i <strong>voti da TE espressi su '.$voti_utente.' atti parlamentari</strong>.')?> Maggiore &egrave; il numero di atti su cui esprimi un giudizio, pi&ugrave; preciso sarà l'indice di rappresentanza.</p>
<div class="W48_100 float-right">
  <?php if (count($lontani)>0) : ?>
     <?php if (!$sf_user->hasCredential('adhoc')) : ?>
         <h5 class="subsection" >i <?php echo (count($lontani)>9 ? 'dieci' :count($lontani)) ?> parlamentari che ti rappresentano <span style="color: red;">di   meno:</span> 
      <?php else : ?>     
        <h5 class="subsection-alt" ><?php echo count($lontani) ?> parlamentari ti rappresentano <span style="color: red;">di   meno:</span>
      <?php endif ?>    
  </h5>
  
  <table class="disegni-decreti column-table lazyload">
    <thead>
      <tr>
        <th scope="col">parlamentare:</th>
        <th scope="col">indice negativo:</th>
      </tr>
    </thead>
  <tbody>
  <?php foreach ($lontani as $pos=>$lontano) : ?>
  <tr class="even">
    <th scope="row" style="padding-left: 5px;">
    <h3 class="position-red" <?php echo ($sf_user->hasCredential('adhoc') ? ' style="width:40px;"' :'') ?> ><?php echo $pos+1 ?></h3>
     <p class="politician-id">
      
     <?php echo image_tag(OppPoliticoPeer::getThumbUrl($lontano[1]->getOppPolitico()->getId()), 
                          'icona parlamentare') ?>
                
     <?php echo link_to($lontano[1]->getOppPolitico()->getNome()." ".$lontano[1]->getOppPolitico()->getCognome(),'/parlamentare/'.$lontano[1]->getOppPolitico()->getId()) ?>
     <?php $gruppi = OppCaricaHasGruppoPeer::doSelectGruppiPerCarica($lontano[1]->getId()) ?>  	
     <?php foreach($gruppi as $nome => $gruppo): ?>
     <?php if(!$gruppo['data_fine']): ?>
      <?php print" (". $nome.")" ?>
     <?php endif; ?> 
     <?php endforeach; ?>
    </p> 
    </th>
    <td style="text-align:center;">
    <div class="meter-bar float-container" style="text-align:left; margin-bottom:0px; height:0px;">
      			<div class="meter-bar-container" style="margin-bottom:0px; height:0px;">


      				<div class="red-meter-bar" style="text-align:left; margin-bottom:0px; height:0px;">
      				<div class="meter-average" style="height:0px;"><label>indice: <?php echo number_format($lontano[0],1) ?></label> </div>
      					<span class="meter-value" style="width: <?php echo number_format(abs($lontano[0]),1)*$normalize ?>px; margin-bottom:0px; height:0px; padding:3px"> </span>
      				</div> 
      			   </div>
      			</div>
    </td>
  </tr>   
  <?php endforeach; ?>
  </tbody>  
  </table>
<?php endif ?>  
</div>  

<div class="W48_100 float-left">
<?php if (count($vicini)>0) : ?>
  <?php if (!$sf_user->hasCredential('adhoc')) : ?>
<h5 class="subsection" >i <?php echo (count($vicini)>9 ? 'dieci' :count($vicini)) ?> parlamentari che ti rappresentano <span style="color: green;">di pi&ugrave;:</span>
  <?php else : ?>
  <h5 class="subsection-alt" ><?php echo count($vicini) ?> parlamentari ti rappresentano <span style="color: green;">di pi&ugrave;:</span>
  <?php endif ?>  
</h5>
<table class="disegni-decreti column-table lazyload">
  <thead>
    <tr>
      <th scope="col">parlamentare:</th>
      <th scope="col">indice positivo:</th>
    </tr>
  </thead>
<tbody>
<?php foreach ($vicini as $pos=>$vicino) : ?>
<tr class="even">
  <th scope="row" style="padding-left: 5px;">
  <h3 class="position-green" <?php echo ($sf_user->hasCredential('adhoc') ? ' style="width:40px;"' :'') ?> ><?php echo $pos+1 ?></h3>
   <p class="politician-id">
   <?php echo image_tag(OppPoliticoPeer::getThumbUrl($vicino[1]->getOppPolitico()->getId()), 
                        'icona parlamentare') ?>
   <?php echo link_to($vicino[1]->getOppPolitico()->getNome()." ".$vicino[1]->getOppPolitico()->getCognome(),'/parlamentare/'.$vicino[1]->getOppPolitico()->getId()) ?>
   <?php $gruppi = OppCaricaHasGruppoPeer::doSelectGruppiPerCarica($vicino[1]->getId()) ?>  	
   <?php foreach($gruppi as $nome => $gruppo): ?>
   <?php if(!$gruppo['data_fine']): ?>
    <?php print" (". $nome.")" ?>
   <?php endif; ?> 
   <?php endforeach; ?>
  </p> 
  </th>
  <td style="text-align:center;">
  <div class="meter-bar float-container" style="text-align:left; margin-bottom:0px; height:0px; text-align: center;">
    			<div class="meter-bar-container" style="margin-bottom:0px; height:0px; text-align: center;">
    				
    				<div class="green-meter-bar" style="text-align:left; margin-bottom:0px; height:0px; text-align: center;">
    				<div class="meter-average" style="height:0px;"><label>indice: <?php echo number_format(abs($vicino[0]),1) ?></label> </div>
    					<span class="meter-value" style="width: <?php echo number_format(abs($vicino[0]),1)*$normalize ?>px; margin-bottom:0px; height:0px; text-align: center; padding:3px"> </span>
    				</div> 
    			   </div>
    			</div>
  </td>
</tr>   
<?php endforeach; ?>
</tbody>  
</table>
<br/>
<?php endif ?>
</div>
<?php else: ?>
  <div class="W100_100 float-left">
    <h5 class="subsection" >i parlamentari che pi&ugrave; ti rappresentano</h5>
    <p style="padding: 10px; font-size: 14px;">Per scoprire chi ti rappresenta, vota gli <?php echo link_to('atti parlamentari','/attiDisegni') ?> (disegni di legge, mozioni, interrogazioni, emendamenti ...) che ti interessano.<br />
      La tua classifica verr&agrave; immediatamente aggiornata!</p><br />
  </div>  
<?php endif ?>

<?php endif; ?> 

<!-- Home page box personalizzato per utente -->

<?php if ($ambient=='home') : ?>
<div style="border:1px solid #EE7F00;background-color:#F7F7F7; padding:5px; 
  -moz-border-radius-bottomleft:5px;
  -moz-border-radius-bottomright:5px;
  -moz-border-radius-topleft:5px;
  -moz-border-radius-topright:5px;">
   <h5><span class="username">Ciao<span style="color:#EE7F00;">  <?php echo $sf_user->getFirstname() ?></span>,
    <?php if (oppNewsPeer::countTodayNewsForUser(OppUserPeer::RetrieveByPk($sf_user->getId()))==0): ?>
      visita le tue pagine dedicate al <?php echo link_to('<strong>monitoraggio personalizzato</strong>', 'monitoring') ?>.
    <?php else: ?>  
      oggi hai 
      <?php if (oppNewsPeer::countTodayNewsForUser(OppUserPeer::RetrieveByPk($sf_user->getId()))==1): ?>
        <?php echo link_to(' una nuova notizia','monitoring') ?>.
      <?php else: ?> 
          <?php echo link_to(oppNewsPeer::countTodayNewsForUser(OppUserPeer::RetrieveByPk($sf_user->getId())).' nuove notizie','monitoring') ?>. 
      <?php endif ?>
      
    <?php endif; ?>   
   
   </span></h5><br />
   <h6><p>Chi ha detto che i parlamentari sono tutti uguali?</p>
   <p><em class="open">open</em><em class="parlamento">parlamento</em> ti fa capire chi ti rappresenta di pi&ugrave; e chi di meno!</p></h6>
   <br />
   <?php if (count($vicini)>0 && count($lontani)>0): ?>
      <table class="disegni-decreti column-table v-align-middle" style="width:85%; background-color:#F7F7F7;"> 
      <thead style="border-left:0px; border-top:0px;background-color:#F7F7F7;">
            <th scope="col" style="text-align:left; background-color:#F7F7F7; background-image:none;"><h6>ti rappresenta <span style="color: green;">di pi&ugrave;</span></h6></th>
            <th scope="col" style="text-align:left; background-color:#F7F7F7; background-image:none;"><h6>ti rappresenta <span style="color: red;">di meno</span></h6></th>  
          </tr>
        </thead>
      <tbody>	
      <tr class="even" style="background-color:#F7F7F7;">
      <th scope="row" style="border-bottom:0px">
     <?php foreach ($vicini as $pos=>$vicino) : ?>
     <p class="politician-id">
     <?php echo image_tag(OppPoliticoPeer::getThumbUrl($vicino[1]->getOppPolitico()->getId()), 
                           'icona parlamentare') ?>
      <?php echo link_to($vicino[1]->getOppPolitico()->getNome()." ".$vicino[1]->getOppPolitico()->getCognome(),'/parlamentare/'.$vicino[1]->getOppPolitico()->getId()) ?>
      <?php $gruppi = OppCaricaHasGruppoPeer::doSelectGruppiPerCarica($vicino[1]->getId()) ?>  	
       <?php foreach($gruppi as $nome => $gruppo): ?>
       <?php if(!$gruppo['data_fine']): ?>
        <?php print" (". $nome.")" ?>
       <?php endif; ?>
       <?php endforeach; ?>
    </p>
     <?php endforeach ?>
    </th>
    <th scope="row" style="border-bottom:0px;">
      <?php foreach ($lontani as $pos=>$lontano) : ?>
      <p class="politician-id">
      <?php echo image_tag(OppPoliticoPeer::getThumbUrl($lontano[1]->getOppPolitico()->getId()), 
                            'icona parlamentare') ?>
       <?php echo link_to($lontano[1]->getOppPolitico()->getNome()." ".$lontano[1]->getOppPolitico()->getCognome(),'/parlamentare/'.$lontano[1]->getOppPolitico()->getId()) ?>
     <?php $gruppi = OppCaricaHasGruppoPeer::doSelectGruppiPerCarica($lontano[1]->getId()) ?>  	
       <?php foreach($gruppi as $nome => $gruppo): ?>
       <?php if(!$gruppo['data_fine']): ?>
        <?php print" (". $nome.")" ?>
       <?php endif; ?>
       <?php endforeach; ?>
     </p>
      <?php endforeach ?>
   </th>
    </tr>
    </table>
    <span><?php echo link_to('Vai alla <strong>tua</strong> classifica completa!','/monitoring_politicians/'.$sf_user->getToken()."#rappresentometro") ?></span>
    <br />
  <?php else: ?>
  <p style="padding: 10px; font-size: 14px;">Per scoprire chi ti rappresenta, vota gli <?php echo link_to('atti parlamentari','/attiDisegni') ?> (disegni di legge, mozioni, interrogazioni, emendamenti ...) che ti interessano.<br />
    La tua classifica verr&agrave; immediatamente aggiornata!</p>
    <br/>    
  <?php endif ?>
 
 </div>
<?php endif; ?>

<!-- Pagina parlamentare box personalizzato per utente -->

<?php if ($ambient=='politico' && array_key_exists($parlamentare->getId(),$posizione)) : ?>
  <div class="evidence-box float-container" style="margin-top:0; border:1px solid #EE7F00;">
    	<h5 class="subsection" style="margin-top:0; background-color:#EE7F00; color:#FFFFFF;">Quanto TI rappresenta <?php echo $parlamentare->getNome() ?> <?php echo $parlamentare->getCognome() ?>?
       <span class="tools-container"><img alt="Ico-new" src="/images/ico-new.png"/></span>
       <span class="tools-container"><a class="ico-help" href="#">&nbsp;</a></span>
     	<div style="display: none;" class="help-box float-container">
     		<div class="inner float-container">

     			<a class="ico-close" href="#">chiudi</a><h5>come &egrave; calcolato ?</h5>
     			<p style="padding: 5px; font-size: 12px;font-weight:normal; color:#333333;">L'indice di quanto ti rappresentano i parlamentari &egrave; calcolato sulla base dei voti (favorevoli e contrari) che hai espresso sugli atti parlamentari.
     Maggiore &egrave; il numero di atti su cui esprimi un giudizio, pi&ugrave; preciso sar&agrave; l'indice di rappresentanza. <br />
     Un calcolo quindi che non si basa su percezioni e dichiarazioni, ma su dati di fatto, confrontando le decisioni prese da deputati e senatori con le tue. Per approfondire <?php echo link_to('clicca qui','http://'.sfConfig::get('sf_site_url').'/blog/2010/01/19/la-distanza-tra-te-e-gli-eletti',true) ?>.</p>
     		</div>
     	</div>
       </h5>
    	<p class="pad10">
    	  <?php $i=0 ?>
        <?php foreach ($posizione as $key=>$pos) : ?>
        <?php $i=$i+1 ?>
        <?php if ($key==$parlamentare->getId()) 
        {
          echo "<strong><span style='font-size:14px;'>Indice di rappresentanza:
          ".($pos>0 ? '<span style="color:green; font-size:22px;">+' : '<span style="color:red; font-size:22px;">' ).$pos.'</span></span></strong>';
          echo "<br />";
          echo "<br />";
          echo "Nella ". link_to('classifica dei tuoi rappresentanti','/monitoring_politicians/'.$sf_user->getToken()."#rappresentometro")." &egrave; <span style='font-size:18px; font-weight:bold;'>".$i."&deg;</span> su ".count($posizione)." parlamentari che hanno presentato o firmato".($voti_utente==1 ? ' il solo atto da te votato.' : ' qualcuno dei '.$voti_utente.' atti parlamentari che hai votato.');
          echo "<br />";
          break;
        }?>
        <?php endforeach ?>
        </p>
        <?php
        echo include_component('monitoring', 'userVsSinglePolitician', 
                         array('user' => $sf_user, 
                               'politico' => $parlamentare, 
                               'legislatura' => '16'));
        ?>                       
    	  
  </div>  	
  
<?php endif; ?>     

