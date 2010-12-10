<h5 class="subsection">gli interventi dei parlamentari sul disegno di legge:</h5>
<h5 class="subsection-spec">i pi&ugrave; recenti:</h5>

<table class="disegni-decreti column-table">
  <thead>
    <tr>
      <th scope="col"><br />data:</th>
      <th scope="col"><br />sede:</th>
      <th scope="col">intervento di:</th>
      <th scope="col">link al testo:</th>
      <?php if ($sf_user->isAuthenticated() && $sf_user->hasCredential('amministratore')): ?>
        <th scope="col">parere utenti:</th>  
        <th scope="col">il tuo parere:</th>
      <?php endif ?>
    </tr>
  </thead>
  <tbody>
  <?php $tr_class = 'even' ?>	
    <?php foreach($interventi as $intervento): ?>
      <?php $intervento_obj = OppInterventoPeer::retrieveByPK($intervento['id']); ?>
      <?php $interventi_array = explode('@', $intervento['link'] ); ?>
      <?php foreach($interventi_array as $intervento_singolo): ?>	  	
        <?php if($limit_count < $limit): ?>  	
           <tr class="clickable <?php echo $tr_class; ?>">
           <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?> 
            <td><p><?php echo format_date($intervento['data'], 'dd/MM/yyyy') ?></p></td>				
            <td><p><?php echo ($intervento['denominazione'].' '.($intervento['ramo']=='C' ? 'Camera' : 'Senato') ) ?></p></td>
            <td>
              <p><?php echo link_to($intervento['nome'].' '.$intervento['cognome'], '@parlamentare?id='.$intervento['politico_id']) ?></p></td>
            <td>  
              <?php echo link_to(image_tag('extlink.gif',
                                           array('title' => 'Vai all\'intervento sul sito '.($intervento['ramo'] == 'C'?'della Camera':'del Senato'))) ,
                                (preg_match("#^http:#",$intervento_singolo) ? $intervento_singolo : sfConfig::get('app_url_sito_camera', 'http://nuovo.camera.it/').$intervento_singolo),
                                array('class' => 'external-url-container') ) ?>
            </td>
            <?php if ($sf_user->isAuthenticated() && ($sf_user->hasCredential('amministratore') || $sf_user->hasCredential('adhoc'))): ?>
              <td>
                <div class="user-stats-column">
                  <?php include_component('deppVoting', 'votingDetailsSmall', array('object' => $intervento_obj)) ?>
                </div>
              </td>
              <td>
                <div class="user-vote-column">
                  <?php include_component('deppVoting', 'votingBlockSmall', array('object' => $intervento_obj)) ?>            
                </div>
              </td>
            <?php endif ?>
          </tr>
          <?php $limit_count++; ?>
        <?php else: ?>
          <?php break; ?>  	  
        <?php endif; ?>
      <?php endforeach; ?>		  	
	<?php endforeach; ?>
  </tbody>
</table>

<?php if($interventi_count > $limit): ?>
  <p class="indent">guarda tutti gli altri <strong><?php echo ($interventi_count - $limit - 1) ?> </strong> interventi...
    [ <?php echo link_to('apri', '#', array('class'=>'btn-open action') ) ?> <?php echo link_to('chiudi', '#', array('class'=>'btn-close action', 'style'=>'display:none') ) ?> ]
  </p>
  <div class="more-results float-container" style="display: none;">
    <table class="disegni-decreti column-table">
      <thead>
        <tr>
          <th scope="col"><br />data:</th>
          <th scope="col"><br />sede:</th>
          <th scope="col">intervento di:</th>
          <th scope="col">link al testo:</th>
          <?php if ($sf_user->isAuthenticated() && $sf_user->hasCredential('amministratore')): ?>
            <th scope="col">parere utenti:</th>  
            <th scope="col">il tuo parere:</th>
          <?php endif ?>
        </tr>
      </thead>
      <tbody>
      <?php $tr_class = 'even' ?>	
        <?php $limit_count = 0; ?> 
        <?php foreach($interventi as $intervento): ?>
          <?php $intervento_obj = OppInterventoPeer::retrieveByPK($intervento['id']); ?>
          <?php $interventi_array = explode('@', $intervento['link'] ); ?>
          <?php foreach($interventi_array as $intervento_singolo): ?>	  	
            <?php if ($limit_count >= $limit): ?>
              <tr class="clickable <?php echo $tr_class; ?>">
           <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?> 
                <td><p><?php echo format_date($intervento['data'], 'dd/MM/yyyy') ?></p></td>				
                <td><p><?php echo ($intervento['denominazione'].' '.($intervento['ramo']=='C' ? 'Camera' : 'Senato') ) ?></p></td>
                <td><p><?php echo link_to($intervento['nome'].' '.$intervento['cognome'], '@parlamentare?id='.$intervento['politico_id']) ?></p></td>
                <td>
                  <?php echo link_to(image_tag('extlink.gif',
                                               array('title' => 'Vai all\'intervento sul sito '.($intervento['ramo'] == 'C'?'della Camera':'del Senato'))) ,
                                    (preg_match("#^http:#",$intervento_singolo) ? $intervento_singolo : sfConfig::get('app_url_sito_camera', 'http://nuovo.camera.it/').$intervento_singolo),
                                    array('class' => 'external-url-container') ) ?>
                </td>
                <?php if ($sf_user->isAuthenticated() && ($sf_user->hasCredential('amministratore') || $sf_user->hasCredential('adhoc'))): ?>
                  <td>
                    <div class="user-stats-column">
                      <?php include_component('deppVoting', 'votingDetailsSmall', array('object' => $intervento_obj)) ?>
                    </div>
                  </td>
                  <td>
                    <div class="user-vote-column">
                      <?php include_component('deppVoting', 'votingBlockSmall', array('object' => $intervento_obj)) ?>            
                    </div>
                  </td>
                <?php endif ?>
              </tr>
            <?php else: ?>
              <?php $limit_count++; ?>  	  
            <?php endif; ?>
          <?php endforeach; ?>		  	
	    <?php endforeach; ?>
      </tbody>
    </table>
    <div class="more-results-close">[ <?php echo link_to('chiudi', '#', array('class'=>'btn-close action') ) ?> ]</div>
  </div>
<?php endif; ?>

<div id="popupContent">
  <a href="#" id="popupContentClose">x</a>
  <h1>Preview e voto</h1>
  <iframe style="width: 100%; height: 88%" id="contentArea" src=""></iframe>
</div>
<div id="backgroundPopup"></div>