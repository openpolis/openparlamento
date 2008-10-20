<?php use_helper('Date', 'sfRating') ?>

<h1><?php echo $ramo ?></h1>
<h2>Legislatura <?php echo $votazione->getOppSeduta()->getLegislatura() ?></h2>
<br />
<h3>seduta n&deg; <?php echo $votazione->getOppSeduta()->getNumero() ?> del <?php echo format_date($votazione->getOppSeduta()->getData(), 'dd/MM/yyyy') ?></h3>
<h3>VOTAZIONE <?php echo $votazione->getTitolo() ?></h3>
<h3>maggioranza: <?php echo $votazione->getMaggioranza() ?></h3>
<h3>esito: <?php echo $votazione->getEsito() ?></h3>
<h4><?php echo link_to('fonte', $votazione->getUrl(), array('target'=>'_blank')) ?></h4>
<br />


<!-- partial per la visualizzazione e l'edit-in-place dei tags associati al ddl -->
<?php echo include_component('deppTagging', 'edit', array('content' => $votazione)); ?>

<!-- blocco rating -->
<?php echo sf_rater($votazione) ?>

<!-- blocco dei commenti -->
<div id="comments-block">
    <hr />

    <a href="#top" class="go-top">torna su</a>
    <a name="comments"></a>
    <?php include_partial('deppCommenting/commentsList', array('content' => $votazione)) ?>

    <hr/>

    <?php include_component('deppCommenting', 'addComment',  
                            array('content' => $votazione,
                                  'read_only' => sfConfig::get('app_comments_enabled', false),
                                  'automoderation' => sfConfig::get('app_comments_automoderation', 'captcha')) ) ?>

    <hr/>
</div>


<?php include_partial('gruppi', array('votazione' => $votazione, 'risultati' => $risultati)) ?> 
<br />
<br />
<?php if ($ribelli): ?>
  <?php include_partial('ribelli', array('ribelli' => $ribelli)) ?>  
  <br />
  <br />
<?php endif; ?>  			
<?php include_partial('votanti', array('votanti' => $votanti)) ?>  