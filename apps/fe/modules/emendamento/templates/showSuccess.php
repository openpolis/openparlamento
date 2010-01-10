<?php use_helper('Date', 'I18N') ?>

<?php include_partial('tabs', array('emendamento' => $emendamento, 'current' => 'emendamento', 
                                    'nb_comments' => $emendamento->getNbPublicComments())) ?>

<div id="content" class="tabbed float-container">
  <a name="top"></a>
  <div id="main">

    <div class="W25_100 float-right">
      <?php echo include_partial('emendamento/vote', array('emendamento' => $emendamento)); ?>
    </div>
    
    <div class="W73_100 float-left">
      <?php if ($emendamento->getTitoloAggiuntivo()): ?>
        <p class="titolo_aggiuntivo">[<?php echo $emendamento->getTitoloAggiuntivo() ?>]</p>        
      <?php endif ?>

      <?php if ($emendamento->getTipologia()): ?>
        <p><?php echo $emendamento->getTipologia() ?></p>
      <?php endif ?>
      
      relativo a:
      <ul>
      <?php foreach ($relatedAttos as $cnt => $atto_em): ?>
        <?php $atto = $atto_em->getOppAtto() ?>
        <li>
        <?php echo link_to('<em>'.$atto->getRamo().'.'.$atto->getNumfase().'</em> '.$atto->getTitolo(), '@singolo_atto?id='.$atto->getId()) ?>
        </li>
      <?php endforeach ?>
      </ul>
      <br/>

      <p class="content-meta">
        Presentato
        <?php if ($emendamento->getDataPres()): ?>
          il <span class="date"><?php echo format_date($emendamento->getDataPres(), 'dd/MM/yyyy') ?>,</span>                    
        <?php endif ?>
        in <span><?php echo $emendamento->getOppSede()->getDenominazione() ?>
        <?php $f_signers= OppEmendamentoPeer::doSelectPrimiFirmatari($emendamento->getId()); ?>
        <?php if (count($f_signers)>0) : ?>
           <?php $c = new Criteria() ?>
           <?php $c->add(OppPoliticoPeer::ID, key($f_signers), Criteria::EQUAL); ?>
           <?php $f_signer = OppPoliticoPeer::doSelectOne($c) ?>
           <?php echo ' da '.$f_signer->getCognome().(count($f_signers)>1 ? ' e altri' : '') ?>
         <?php endif; ?>   
        </span>
      </p>

      <!-- partial per la visualizzazione e l'edit-in-place dei tags associati all'atto -->
      <?php echo include_component('deppTagging', 'edit', array('content' => $emendamento)); ?>

      <!-- testo dell'emendamento -->
      <div class="coo-mind float-container">
        <h4 class="subsection">testo ufficiale dell'emendamento:</h4>
        <?php foreach ($emendamento->getOppEmTestos() as $cnt => $text): ?>
          <p><?php echo $text->getTesto() ?></p>        
        <?php endforeach ?>
      </div>
      
      <br/>

      <!-- DESCRIZIONE -->
      <div class="wiki-box-container">
      	<h5 class="description">descrivi insieme agli altri utenti questo emendamento:</h5>
      	<p style="padding:5px;">qui sotto puoi inserire o modificare la descrizione.
        	<?php if ($sf_user->isAuthenticated()) : ?>
        	   <?php echo 'Clicca su "modifica"' ?>
        	<?php else : ?>
        	   Per modificare <?php echo link_to('effettua il login', '@sf_guard_signin') ?> 
        	<?php endif ?>     
      	</p>
    	
        <!-- partial per la descrizione wiki -->	
        <?php echo include_component('nahoWiki', 'showContent', array('page_name' => 'emendamento_' . $emendamento->getId() )) ?>
      </div>	


    </div>
  </div>
</div>
<?php slot('breadcrumbs') ?>
    <?php echo link_to("home", "@homepage") ?> /
    <?php include_partial('atto/breadcrumbsAtti', array('atto' => $attoPortante)) ?> /
    <?php echo link_to(Text::denominazioneAttoShort($attoPortante), '@singolo_atto?id=' . $attoPortante->getId() ) ?> /
    <?php echo link_to('Emendamenti', '@emendamenti_atto?id='.$attoPortante->getId()) ?> /
    Emendamento <?php echo $emendamento->getTitolo() ?>
<?php end_slot() ?>
