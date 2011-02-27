<div class="W45_100 float-left">
   <div class="float-container">
   <p style="font-size:20px; font-weight:bold; padding: 5px;"><?php echo ($parlamentare1->getTipoCaricaId()==1 ? 'On. ' : 'Sen. '). link_to($parlamentare1->getOppPolitico()->getNome().'&nbsp;'.$parlamentare1->getOppPolitico()->getCognome(),'/parlamentare/'.$parlamentare1->getOppPolitico()->getId()) ?><?php echo ' ('.$parlamentare1->getOppPolitico()->getGruppoCorrente()->getAcronimo().')' ?></p>
       <?php echo image_tag(OppPoliticoPeer::getPictureUrl($parlamentare1->getOppPolitico()->getId()), 
                               array('class' => 'portrait-91x126 float-left', 
   			                             'alt' => $parlamentare1->getOppPolitico()->getNome() . ' ' . $parlamentare1->getOppPolitico()->getCognome(),
   			                             'width' => '91', 'height' => '126')) ?>
         <div class="politician-more-info">
	   <p><label><?php echo $parlamentare1->getLegislatura()."&#186; legislatura: " ?></label>in carica dal
		<?php echo $parlamentare1->getDataInizio('d/m/Y') ?></p>
       <p><label>voti ribelli:</label>    			                             	
          <?php echo round($parlamentare1->getRibelle()*100/$parlamentare1->getPresenze(),1).'% ('.link_to($parlamentare1->getRibelle(),'@parlamentare_voti?id='.$parlamentare1->getOppPolitico()->getId().'&filter_vote_rebel=1').' volte su '.$parlamentare1->getPresenze().' votazioni )' ?>
       </p>
       <p><label>assente:</label>    			                             	
          <?php echo $assenze1.'% ('.$parlamentare1->getAssenze().' volte)' ?>
          <?php if ($assenze1<$assenze2) : ?>
             <?php echo image_tag('ico-thumb-up.png') ?>
          <?php endif; ?>
          <?php if ($assenze1>$assenze2) : ?>
             <?php echo image_tag('ico-thumb-down.png') ?>
          <?php endif; ?>
       </p>
       <p><label>indice di produttivit&agrave;:</label>    			                             	
          <span style="font-size: 14px;"><?php echo $parlamentare1->getIndice() ?></span>
          <?php if ($parlamentare1->getIndice()>$parlamentare2->getIndice()) : ?>
             <?php echo image_tag('ico-thumb-up.png') ?>
          <?php endif; ?>
          <?php if ($parlamentare1->getIndice()<$parlamentare2->getIndice()) : ?>
             <?php echo image_tag('ico-thumb-down.png') ?>
          <?php endif; ?>
          <span style="margin-left:5px;">[<a href="http://indice.openpolis.it/info.html" style="font-size:11px;">come &egrave calcolato?</a>]</span>
       </p>
       <p><label>&egrave; parlamentare da</label> <?php echo link_to($durata1,'http://www.openpolis.it/politico/'.$parlamentare1->getPoliticoId().'#carriera') ?></p>
       </div>   			                             
    </div>
 </div>     


<div class="W45_100 float-left">
   <div class="float-container">
   <p style="font-size:20px; font-weight:bold; padding: 5px;"><?php echo ($parlamentare1->getTipoCaricaId()==1 ? 'On. ' : 'Sen. '). link_to($parlamentare2->getOppPolitico()->getNome().'&nbsp;'.$parlamentare2->getOppPolitico()->getCognome(),'/parlamentare/'.$parlamentare2->getOppPolitico()->getId()) ?><?php echo ' ('.$parlamentare2->getOppPolitico()->getGruppoCorrente()->getAcronimo().')' ?></p>
       <?php echo image_tag(OppPoliticoPeer::getPictureUrl($parlamentare2->getOppPolitico()->getId()), 
                               array('class' => 'portrait-91x126 float-left', 
   			                             'alt' => $parlamentare2->getOppPolitico()->getNome() . ' ' . $parlamentare2->getOppPolitico()->getCognome(),
   			                             'width' => '91', 'height' => '126')) ?>
         <div class="politician-more-info">
			<p><label><?php echo $parlamentare2->getLegislatura()."&#186; legislatura: " ?></label>in carica dal
				<?php echo $parlamentare2->getDataInizio('d/m/Y') ?></p>
       <p><label>voti ribelli:</label>    			                             	
          <?php echo round($parlamentare2->getRibelle()*100/$parlamentare2->getPresenze(),1).'% ('.link_to($parlamentare2->getRibelle(),'@parlamentare_voti?id='.$parlamentare2->getOppPolitico()->getId().'&filter_vote_rebel=1').' volte su '.$parlamentare2->getPresenze().' votazioni )' ?>
       </p>
       <p><label>assente:</label>    			                             	
          <?php echo $assenze2.'% ('.$parlamentare2->getAssenze().' volte)' ?>
          <?php if ($assenze2<$assenze1) : ?>
             <?php echo image_tag('ico-thumb-up.png') ?>
          <?php endif; ?>
          <?php if ($assenze2>$assenze1) : ?>
             <?php echo image_tag('ico-thumb-down.png') ?>
          <?php endif; ?>
       </p>
       <p><label>indice di produttivit&agrave;:</label>    			                             	
          <span style="font-size: 14px;"><?php echo $parlamentare2->getIndice() ?></span>
          <?php if ($parlamentare2->getIndice()>$parlamentare1->getIndice()) : ?>
             <?php echo image_tag('ico-thumb-up.png') ?>
          <?php endif; ?>
          <?php if ($parlamentare2->getIndice()<$parlamentare1->getIndice()) : ?>
             <?php echo image_tag('ico-thumb-down.png') ?>
          <?php endif; ?>
          <span style="margin-left:5px;">[<a href="http://indice.openpolis.it/info.html" style="font-size:11px;">come &egrave calcolato?</a>]</span>
       </p>
       <p><label>&egrave; parlamentare da</label> <?php echo link_to($durata2,'http://www.openpolis.it/politico/'.$parlamentare2->getPoliticoId().'#carriera') ?></p>
       </div>   			                             
    </div>
 </div>  
