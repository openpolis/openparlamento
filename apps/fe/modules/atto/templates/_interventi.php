<h5 class="subsection">gli interventi dei parlamentari sul disegno di legge:</h5>

<h5 class="subsection-spec">i pi&ugrave; recenti:</h5>
<table class="disegni-decreti column-table">
  <thead>
    <?php include_partial('atto/intervento_th', array()) ?>
  </thead>
  <tbody>
    <?php foreach($interventi as $cnt => $intervento): ?>
      <?php if ($cnt < $limit): ?>  	
        <?php include_partial('atto/intervento_tr', array('intervento' => $intervento)) ?>	
      <?php else: ?>
        <?php break; ?>  	  
      <?php endif; ?>
    <?php endforeach; ?>		  	
  </tbody>
</table>

<?php if($interventi_count > $limit): ?>
  <p class="indent">guarda tutti gli altri <strong><?php echo ($interventi_count - $limit - 1) ?> </strong> interventi...
    [ <?php echo link_to('apri', '#', array('class'=>'btn-open action') ) ?> <?php echo link_to('chiudi', '#', array('class'=>'btn-close action', 'style'=>'display:none') ) ?> ]
  </p>
  <!--<div class="more-results float-container" style="display: false;">-->
    <table class="disegni-decreti column-table">
      <thead>
        <?php include_partial('atto/intervento_th', array()) ?>
      </thead>
      <tbody>
        <?php foreach($interventi as $cnt => $intervento): ?>
          <?php if ($cnt > $limit): ?>  
            <?php include_partial('atto/intervento_tr', array('intervento' => $intervento)) ?>	
          <?php endif; ?>
        <?php endforeach; ?>		  	
      </tbody>
    </table>
    <div class="more-results-close">[ <?php echo link_to('chiudi', '#', array('class'=>'btn-close action') ) ?> ]</div>
  <!--</div>-->
<?php endif; ?>


<?php if ($sf_user->isAuthenticated() &&
          ($sf_user->hasCredential('amministratore') || $sf_user->hasCredential('adhoc'))): ?>
  <div id="popupContent">
    <a href="#" id="popupContentClose">x</a>
    <h1>Preview e voto</h1>
    <iframe style="width: 100%; height: 88%" id="contentArea" src=""></iframe>
  </div>
  <div id="backgroundPopup"></div>  
<?php endif ?>

