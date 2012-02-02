<?php if ($atto->getTipoAttoId()<12) : ?>
 <p class="interline"><?php echo format_number_choice('[1] e un cofirmatario|(1,+Inf] e altri %1% cofirmatari', array('%1%' => count($co_firmatari)), count($co_firmatari)) ?>...
   [ <?php echo link_to('apri', '#', array('class'=>'btn-open action') ) ?> <?php echo link_to('chiudi', '#', array('class'=>'btn-close action', 'style'=>'display:none') ) ?> ]
 </p>

 <div class="more-results float-container W66_100" style="display: none;">
  <ul class="square-bullet no-interline">
    <?php use_helper('Slugger'); foreach($co_firmatari as $id => $co_firmatario): ?>  
      <li>
	    <?php $info_array = explode('*', $co_firmatario ); ?>
	    <?php echo link_to($info_array[1], '@parlamentare?id='.$id.'&slug='.slugify($info_array[1])) ?>
      </li>
    <?php endforeach; ?>
  </ul>
  <div class="more-results-close">[ <?php echo link_to('chiudi', '#', array('class'=>'btn-close action') ) ?> ]</div>
 </div>
<?php endif; ?> 