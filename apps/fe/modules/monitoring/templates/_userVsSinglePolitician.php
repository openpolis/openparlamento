<?php if (count($comes)>0) : ?>
<div style="padding:0px 0px 5px 10px">
Sei <span style="color:green;">d'accordo</span> su <?php echo (count($comes)==1 ? 'un atto presentato o firmato da ' : count($comes).' atti presentati o firmati da ') ?><?php echo $politico->getNome() ?> <?php echo $politico->getCognome() ?>
<span class="indent">[ <?php echo link_to('apri', '#', array('class'=>'btn-open action') ) ?> <?php echo link_to('chiudi', '#', array('class'=>'btn-close action', 'style'=>'display:none') ) ?> ]
</span>

<div class="more-results float-container" style="padding:0px 5px 5px 0px; display: none;">
<table class="disegni-decreti column-table">

  <tbody>
  <?php foreach ($comes as $key => $come) : ?>
    <?php $rs=OppAttoPeer::retrieveByPk($come); ?>
    <tr class="even">
    <th scope="row">
    <p class="content-meta">
    <span class="date">
    <?php $tipo=OppTipoAttoPeer::retrieveByPk($rs->getTipoAttoId()); ?>  
      <?php echo $tipo->getDescrizione() ?>
      </span>
    </p>
    <p>
      <?php echo link_to(Text::denominazioneAtto($rs, 'list'), 'atto/index?id='.$rs->getId()) ?>
    </p>
    </th>
  </tr>
<?php endforeach; ?>

  </tbody>
</table>
<div class="more-results-close">[ <a href="#" class="btn-close action">chiudi</a> ]</div>
</div>
</div>
<?php endif; ?>

<?php if (count($contros)>0) : ?>
<div style="padding:0px 0px 5px 10px">
Sei <span style="color:red;">in disaccordo</span> su <?php echo (count($contros)==1 ? 'un atto presentato o firmato da ' : count($contros).' atti presentati o firmati da ') ?><?php echo $politico->getNome() ?> <?php echo $politico->getCognome() ?>
<span class="indent">[ <?php echo link_to('apri', '#', array('class'=>'btn-open action') ) ?> <?php echo link_to('chiudi', '#', array('class'=>'btn-close action', 'style'=>'display:none') ) ?> ]
</span>

<div class="more-results float-container" style="padding:0px 5px 5px 0px; display: none;">
<table class="disegni-decreti column-table">

  <tbody>
  <?php foreach ($contros as $key => $contro) : ?>
    <?php $rs=OppAttoPeer::retrieveByPk($contro); ?>
    <tr class="even">
    <th scope="row">
    <p class="content-meta">
    <span class="date"> 
    <?php $tipo=OppTipoAttoPeer::retrieveByPk($rs->getTipoAttoId()); ?>  
      <?php echo $tipo->getDescrizione() ?>
      </span>
    </p>
    <p>
      <?php echo link_to(Text::denominazioneAtto($rs, 'list'), 'atto/index?id='.$rs->getId()) ?>
    </p>
    </th>
  </tr>
<?php endforeach; ?>

  </tbody>
</table>
<div class="more-results-close">[ <a href="#" class="btn-close action">chiudi</a> ]</div>
</div>
</div>
<?php endif; ?>