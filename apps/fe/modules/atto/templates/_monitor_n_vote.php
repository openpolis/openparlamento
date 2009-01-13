<?php use_helper('deppVotingYesNo') ?>

<p class="last-update">
  data di ultimo aggiornamento: <strong><?php echo $atto->getDataAgg('d-m-Y') ?></strong>
</p>

<div id="monitor-n-vote">

  <h6>monitoraggio di questo atto</h6>
  <!-- partial per la gestione del monitoring di questo atto -->
  <?php echo include_component('monitoring', 'manageItem', 
                               array('item' => $atto, 'item_type' => 'atto')); ?>

  <p><a href="#monitoringusersdo" class="action">questi utenti monitorano anche...</a></p>		
  <hr class="dotted" />			


  <h6>sei favorevole o contrario?</h6>
  <!-- blocco voting -->
  <?php echo depp_voting_block($atto) ?>
  <hr class="dotted" />
</div>

<div class="section-box">
  <?php echo link_to(image_tag('ico-rss.png', array('alt' => 'RSS')), '#', array('class' => 'section-box-rss') ) ?>	
  <h6>Ultime notizie sull'atto</h6>

  <div class="news-disegni-decreti float-container"> 
    <ul>
      <li>
        <strong>23-10-2008</strong>
        <p><?php echo link_to('C.1386-B', '#') ?> <?php echo image_tag('ico-new.png', array('alt' => 'nuovo')) ?><br />
        interventi in commissione cultura della <a href="#" class="tools-container">Camera</a></p>
      </li>
      <li>
        <strong>18-10-2008</strong>
        <p><a href="singolo_atto.html">C.1386-B</a><br />
        aggiunto nuovo co-firmatario</p>
      </li>
      <li>
        <strong>17-10-2008</strong>
        <p><a href="singolo_atto.html">C.1386-B</a><br />
        aggiunto nuovo co-firmatario</p>
      </li>
      <li>
        <strong>09-10-2008</strong>
        <p><a href="singolo_atto.html">C.1386-B</a><br />
        assegnato in commissione</p>
      </li>
      <li>
        <strong>09-10-2008</strong>
        <p><a href="singolo_atto.html">C.1386-B</a><br />
        presentato</p>
      </li>
    </ul>
    <a href="#" class="see-all tools-container">vedi tutta la cronologia</a>
  </div>
  
</div>