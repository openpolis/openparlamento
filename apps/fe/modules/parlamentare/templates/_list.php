<!--
<p><strong>Nota:
        <span style="background-color: yellow">
            l'indice di produttività è in fase di aggiornamento e sarà nuovamente visible entro qualche giorno.
        </span>
    </strong>

<p>Nota: l'indice di produttività non prende in considerazione il lavoro,
    anche rilevante, che alcuni parlamentari svolgono per gli incarichi necessari
    al funzionamento della macchina politica e amministrativa del Parlamento
    (Commissioni, Gruppi, Comitati, Giunte, Collegi e Uffici di Camera e Senato).
    <strong>
        Per la spiegazione dettagliata dei criteri di valutazione del nuovo indice
        di produttività <a href="http://indice.openpolis.it/info.html">vai qui</a>.
    </strong>
<br/>
    <a id="nota"></a>
<br/>
-->
<strong>
    Nota: <i>Con assenza si intendono i casi di non partecipazione al voto: sia quello in cui
    il parlamentare è fisicamente assente (e non in missione) sia quello in cui è presente
    ma non vota e non partecipa a determinare il numero legale nella votazione</i>.
</strong>
    Purtroppo attualmente i sistemi di documentazione dei resoconti di Camera e Senato non consentono
    di distinguere un caso dall'altro. I regolamenti non prevedono la registrazione del motivo dell'assenza al voto
    del parlamentare. Non si può distinguere, pertanto, l'assenza ingiustificata da quella, ad esempio,
    per ragioni di salute.

<br/><br/>
</p>
<table class="disegni-decreti column-table lazyload">
  <thead>
    <tr>
      <th scope="col">parlamentare:</th>
      <?php  if ($sf_user->isAuthenticated() && $sf_user->hasCredential('amministratore')): ?>
      <th scope="col">indice di produttivit&agrave;: <?php // echo image_tag('ico-new.png')?></th>
      <?php  endif; ?>
      <th scope="col">voti ribelli:</th>			
      <th scope="col" class="evident">presenze:</th>			
      <th scope="col" class="evident">assenze:</th>
      <th scope="col" class="evident">missioni:</th>
      <th scope="col">circoscrizione:</th>
      <!--<th scope="col">utenti che lo seguono:</th>-->
    </tr>
  </thead>

  <tbody>
  
    <?php
     $tr_class = 'even'; 
     empty($presidenti_ids) AND $presidenti_ids = array();
     empty($membri_governo_ids) AND $membri_governo_ids = array();
     ?>
        
     <?php while($parlamentari->next()): ?>
      <tr class="<?php echo $tr_class; ?>">
      <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?>
        <th scope="row">
          <p class="politician-id">
            <?php echo image_tag('/images/ico-type-politico-portrait.png', 
                                 array('width' => '40','height' => '53', 'highsrc' => OppPoliticoPeer::getThumbUrl($parlamentari->getInt(2))  )) ?>	
            <?php 
            use_helper('Slugger');
            $slugParlamentare = slugify($parlamentari->getString(3).' '.$parlamentari->getString(4));
            echo link_to($parlamentari->getString(3).' '.$parlamentari->getString(4), '@parlamentare?id='.$parlamentari->getInt(2) .'&slug='.$slugParlamentare) ?>
            <?php $gruppi = OppCaricaHasGruppoPeer::doSelectGruppiPerCarica($parlamentari->getInt(1)) ?>  	
	        <?php foreach($gruppi as $nome => $gruppo): ?>
	          <?php if(!$gruppo['data_fine']): ?>
		        <?php print" (". $nome.")" ?>
	          <?php endif; ?> 
	     <?php endforeach; ?> 
            <?php if($parlamentari->getString(14)>'2018-03-05' and $parlamentari->getString(14)!=3 and $parlamentari->getString(14)!=4): ?>
              
                <br /><small>in carica dal <?php echo format_date($parlamentari->getString(14), 'dd/MM/yyyy') ?></small>
               <?php endif; ?>
<?php echo $parlamentari->getInt(11) ?>
	      
	    
          </p>
        </th>

        <?php  if ($sf_user->isAuthenticated() && $sf_user->hasCredential('amministratore')): ?>
        <td>
		  <?php 
		    if ($parlamentari->getString(14) > date("Y-m-d", strtotime('today - 365 days')) ||
		        in_array($parlamentari->getInt(2), array_merge($presidenti_ids, $membri_governo_ids))) 
		    {
		      print "Non applicabile";
		    } else {
  		      if($parlamentari->getInt(10)!='-1')
  		      {
  		        printf('<b>%01.1f</b><br /><span class="small">(%d° su %d)</span>',
                       $parlamentari->getFloat(9), $parlamentari->getInt(10), $numero_parlamentari);
                if($parlamentari->getString(14)>'2018-03-05')
           	       	echo "<br /><small style='background-color:yellow;'>N.B subentrato il ".format_date($parlamentari->getString(14), 'dd/MM/yyyy')."</small>";       
              } else {
                printf('<b>%01.1f</b> ', $parlamentari->getFloat(9));
                if($parlamentari->getString(14)>'2018-03-05')
                  echo "<br /><small style='background-color:yellow;'>N.B subentrato il ".format_date($parlamentari->getString(14), 'dd/MM/yyyy')."</small>";
              }
		    }
          ?>
	    </td>
        <?php endif; ?>
        
        <td>
          <?php if($parlamentari->getInt(6)!=0 && $parlamentari->getInt(12)!=0): ?>
                <b><?php echo link_to($parlamentari->getInt(12),'@parlamentare_voti?id='.$parlamentari->getInt(2)."&slug=".$slugParlamentare."&filter_vote_rebel=1") ?></b>
	  <?php else: ?>
	        <?php print('<b>0</b>') ?>
	  <?php endif; ?>
        </td>    
        
	<?php $num_votazioni = $parlamentari->getInt(6) + $parlamentari->getInt(7) + $parlamentari->getInt(8) ?>

    <?php if($num_votazioni==0): ?>
		  <td class="evident">
		    <?php print('<b>0</b>% <br /><span class="small">(0 su 0)</span>') ?>
		  </td>
		  <td class="evident">
		    <?php print('<b>0</b>% <br /><span class="small">(0 su 0)</span>') ?>
		  </td>
		  <td class="evident">
		    <?php print('<b>0</b>% <br /><span class="small">(0 su 0)</span>') ?>
		  </td>
		<?php elseif ($parlamentari->getInt(2)!=494864): ?>

      <?php //print_r($parlamentari) ?>
          <td class="evident"> 
            <b><?php echo number_format($parlamentari->getInt(6)*100/$num_votazioni,2) ?>%</b><br /><span class="small"><?php echo "(".$parlamentari->getInt(6)." su ". $num_votazioni.")" ?></span>
          </td>
          <td class="evident">
            
            <b><?php echo number_format($parlamentari->getInt(7)*100/$num_votazioni,2) ?>%</b> <a href="#nota">*</a><br /><span class="small"><?php echo "(".$parlamentari->getInt(7)." su ". $num_votazioni.")" ?></span>
          </td>
          <td class="evident">
             <b><?php echo number_format($parlamentari->getInt(8)*100/$num_votazioni,2) ?>%</b><br /><span class="small"><?php echo "(".$parlamentari->getInt(8)." su ". $num_votazioni.")" ?></span>
            
          </td>
      <?php else: ?>
        <td class="evident"  colspan="3"> 
            <b>Non applicabile</b><br/><span class="small">La Camera dei Deputati, a differenza del Senato, non pubblica i dati sulla partecipazione al voto del suo Presidente.</span>
          </td>

      <?php endif; ?>
        <?php if($parlamentari->getString(5)!=""): ?>
        <td><span class="small"><?php echo $parlamentari->getString(5) ?></span></td>
         <?php else: ?>
         <td><span class="small"><?php echo '* Senatore a vita' ?></span></td>
        <?php endif; ?>
       <!--<td><p>
       <?php if($parlamentari->getInt(10)!='-1'): ?>
          <?php echo $parlamentari->getInt(13) ?>
       <?php else : ?>
          <?php echo $parlamentari->getInt(14) ?>
       <?php endif; ?>
       </p></td>-->
      </tr>
    <?php endwhile; ?>
  </tbody>    
</table>
