<div class="evidence-box float-container" style="float: left; width: 50%">

  <h5 class="subsection">
    I <?php echo count($politici) ?> deputati
    che 
    <?php if (count($politici) == sfConfig::get('app_limit_classifica_parlamentari_sioccupanodi', 15)): ?>
      pi&ugrave;       
    <?php endif ?>
    si occupano di questi argomenti 
  </h5>


  <div class="pad10">

    <?php if (isset($politici) && count($politici) > 0): ?>
        <table class="disegni-decreti column-table lazyload">

          <thead>
            <tr>
              <th scope="col">Pos:</th>
              <th scope="col">Parlamentare:</th>
              <th scope="col">Gruppo:</th> 	
              <th scope="col">Circoscrizione:</th>
              <th scope="col">Commissone Perm.:</th>              
              <th scope="col">Punteggio:</th>
            </tr>
          </thead>

          <tbody>

        	  <?php $tr_class = 'even'; $cnt = 0; foreach ($politici as $carica_id => $politico): ?>
       	        
                <tr class="<?php echo $tr_class; ?>" id="carica-<?php echo $carica_id ?>">
                <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?>
                  <td><?php echo ++$cnt ?></td>
                  <th scope="row">  
                    <p class="politician-id">
                      <?php echo image_tag(OppPoliticoPeer::getThumbUrl($politico['politico_id']), 
                                           array('width' => '40','height' => '53')) ?>
                      <?php echo link_to($politico['nome'] . " " . $politico['cognome'] . " (".$politico['acronimo'].")", '@parlamentare?id='.$politico['politico_id'], array('class' => 'folk2')); ?>
                    </p>
                  </th>
                  <td>
                    <?php echo $politico['acronimo'] ?>
                  </td>
                  <td>
                    <?php echo $politico['circoscrizione'] ?>
                  </td>
                  <td>
                    <?php foreach ($cariche_interne = OppCaricaInternaPeer::getPermanentiAttuali($carica_id) as $cnt => $carica_interna): ?>
                      <?php echo $tipo_carica = $carica_interna->getOppTipoCarica()->getNome() != 'Componente' ? $tipo_carica : ''; ?>
                      <?php echo $carica_interna->getOppSede()->getDenominazione(); ?>
                      <?php if ($cnt < count($cariche_interne)): ?>,<?php endif ?>
                    <?php endforeach ?>
                  </td>                  
                  <td style="text-align: right; padding-right: 20px">
                    <?php printf("%01.2f", $politico['punteggio']) ?>
                  </td>
                </tr>        
        	  <?php endforeach ?>

         </tbody>

        </table>

    <?php else: ?>
      Nessun politico trovato        
    <?php endif ?>
  </div> 
  
</div>

