<?php echo use_helper('PagerNavigation'); ?>

<h5 class="subsection"><?php echo $pager->getNbResults() ?> interventi</h5>

<table class="disegni-decreti column-table">
  <thead>
    <tr> 
      <th scope="col">data:</th>
      <th scope="col">sede:</th>
      <th scope="col">atto:</th>  
      <th scope="col">link:</th>  
      <?php if ($sf_user->isAuthenticated() && $sf_user->hasCredential('amministratore')): ?>
        <th scope="col">parere utenti:</th>  
        <th scope="col">il tuo parere:</th>
      <?php endif ?>
    </tr>
  </thead>

  <tbody>
  <?php $tr_class = 'even' ?>			
    <?php foreach ($pager->getResults() as $intervento): ?>
      <?php $atto = $intervento->getOppAtto(); ?>
       <tr class="clickable <?php echo $tr_class; ?>">
       <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?> 
        <th scope="row">
          <p class="content-meta">
            <span class="date"><?php echo ($intervento->getData() ? $intervento->getData('d-m-Y') : '') ?></span>
          </p>
        </th>
        <td>
          <p>
            <?php echo $intervento->getOppSede()->getDenominazione() ?>
          </p>
        </td>
        <th scope="row">
         <p class="content-meta">
         <?php echo $atto->getOppTipoAtto()->getDescrizione().($atto->getRamo()=='C' ? ' alla Camera' : ' al Senato') ?>
         </p>
          <p>
            <?php echo link_to(Text::denominazioneAtto($atto, 'list'), 'atto/index?id='.$atto->getId()) ?>
          </p>
        </th>
        <td>          
          <?php echo link_to(image_tag('extlink.gif',
                                       array('title' => 'Vai all\'intervento sul sito '.($intervento->getOppSede()->getRamo() == 'C'?'della Camera':'del Senato'))) ,
                            (preg_match("#^http:#",$intervento->getUrl()) ? $intervento->getUrl() : sfConfig::get('app_url_sito_camera', 'http://nuovo.camera.it/').$intervento->getUrl()),
                            array('class' => 'external-url-container') ) ?>
        </td>
        
        <?php if ($sf_user->isAuthenticated() && ($sf_user->hasCredential('amministratore') || $sf_user->hasCredential('adhoc'))): ?>
          <td>
            <div class="user-stats-column">
              <?php include_component('deppVoting', 'votingDetailsSmall', array('object' => $intervento)) ?>
            </div>
          </td>
          <td>
            <div class="user-vote-column">
              <?php include_component('deppVoting', 'votingBlockSmall', array('object' => $intervento)) ?>            
            </div>
          </td>
        <?php endif ?>
      </tr>
    <?php endforeach; ?>
    
    <tr>
      <td align="center" colspan='6'>
        <?php echo pager_navigation($pager, '@parlamentare_interventi?id='.$parlamentare_id .'&slug='.$parlamentare_slug) ?>
      </td>
    </tr>

    <tr>
      <td align="center" colspan='6'>
        <?php echo format_number_choice('[0] nessun risultato|[1] 1 risultato|(1,+Inf] %1% risultati', array('%1%' => $pager->getNbResults()), $pager->getNbResults()) ?>
      </td>
    </tr>
  </tbody>
</table>

<div id="popupContent">
  <a href="#" id="popupContentClose">x</a>
  <h1>Preview e voto</h1>
  <iframe style="width: 100%; height: 88%" id="contentArea" src=""></iframe>
</div>
<div id="backgroundPopup"></div>

