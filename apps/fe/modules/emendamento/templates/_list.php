      <table class="disegni-decreti column-table">

        <thead>
          <tr> 
            <th scope="col">emendamento:</th>
            <th scope="col">status:</th> 
            <th scope="col">articolo<br />interessato:</th> 
            <th scope="col">voti e commenti<br />degli utenti:</th>
          </tr>
        </thead>

        <tbody>		
         <?php $tr_class = 'even' ?>	
          <?php foreach ($pager->getResults() as $cnt => $em_at): ?>
            <?php $em = $em_at->getOppEmendamento() ?>
            <tr class="<?php echo $tr_class; ?>">
            <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?>
              <th scope="row">
                <p class="content-meta">
                  Presentato
                  <?php if ($em->getDataPres()): ?>
                    il <span class="date"><?php echo format_date($em->getDataPres(), 'dd/MM/yyyy') ?>,</span>                    
                  <?php endif ?>
                  in <span><?php echo $em->getOppSede()->getDenominazione() ?>
                  <?php $f_signers= OppEmendamentoPeer::doSelectPrimiFirmatari($em->getId()); ?>
                  <?php if (count($f_signers)>0) : ?>
                     <?php $c = new Criteria() ?>
                     <?php $c->add(OppPoliticoPeer::ID, key($f_signers), Criteria::EQUAL); ?>
                     <?php $f_signer = OppPoliticoPeer::doSelectOne($c) ?>
                     <?php echo ' da '.$f_signer->getCognome().(count($f_signers)>1 ? ' e altri' : '') ?>
                   <?php else :?>
                     <?php if ($em->getNota()) : ?>
                        <?php if ($em->getNota()=='commissione') echo 'dalla' ?>
                        <?php if ($em->getNota()=='governo') echo 'dal' ?>
                        <?php if (preg_match('#^commissioni#',$em->getNota())) echo 'dalle' ?>
                        <?php if ($em->getNota()=='relatori') echo 'dai' ?>
                        
                      <?php echo strtoupper($em->getNota()) ?>
                      
                     <?php endif ?>   
                   <?php endif; ?>   
                  </span>
                </p>
                <p>
                  <?php echo link_to(Text::denominazioneEmendamento($em, 'list'), '@singolo_emendamento?id='.$em->getId()) ?>
                </p>
              </th>
              <td>
                <?php $last_status = $em->getLastStatus(); ?>
                  <?php if ($last_status->getData()): ?>
                    <p class="date"><?php echo format_date($last_status->getData(), 'dd/MM/yyyy') ?></p>                    
                  <?php endif ?>
                  <?php
                  
                    if ($last_status->getOppEmIter()->getFase()=='Approvato' || $last_status->getOppEmIter()->getFase()=='Accolto')
                                echo '<p style="color:green;">';
                    else
                    {
                      if ($last_status->getOppEmIter()->getFase()=='Respinto' || $last_status->getOppEmIter()->getFase()=='Ritirato' ||   $last_status->getOppEmIter()->getFase()=='Inammissibile' || $last_status->getOppEmIter()->getFase()=='Precluso')
                        echo '<p style="color:red;">';
                      else
                        echo '<p>';
                    }  
                  ?>
                  <?php echo $last_status->getOppEmIter()->getFase() ?></p>
              </td>
              <td>
                <?php if ($em->getArticolo()) {
                  echo $em->getArticolo();
                }
                else echo "--";
                ?>
              </td>  
              <td>
                <div class="user-stats-column">
                  <span class="green thumb-up"><?php echo $em->getUtFav() ?></span><span class="red thumb-down"><?php echo $em->getUtContr() ?></span>
                  <p><?php echo link_to($em->getNbCommenti().' <strong>commenti</strong>', '@commenti_emendamento?id='.$em->getId()) ?></p>
                </div>
              </td>	
            </tr>
          <?php endforeach; ?>
          <tr>
            <td align="center" colspan='4'>
              <?php echo pager_navigation($pager, 'emendamento/list') ?>
            </td>
          </tr>

          <tr>
            <td align="center" colspan='4'>
              <?php echo format_number_choice('[0] nessun risultato|[1] 1 risultato|(1,+Inf] %1% risultati', array('%1%' => $pager->getNbResults()), $pager->getNbResults()) ?>
            </td>
          </tr>
        </tbody>
      </table>
