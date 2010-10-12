<div id="content" class="tabbed float-container">
  <a name="top"></a>
  <div id="main">

    <div class="evidence-box float-container">

      <h5 class="subsection">
        I 
        <?php if ($ramo == 'C'): ?>
          deputati
        <?php else: ?>
          senatori
        <?php endif ?>
        del gruppo <em><?php echo $gruppo->getNome() ?></em>
        che pi&ugrave; si occupano di <em><?php echo $argomento->getTripleValue() ?></em>
      </h5>

      <div class="pad10">

        <?php if (isset($politici) && count($politici) > 0): ?>
        	<ul>
        	  <?php $cnt = 0; foreach ($politici as $carica_id => $politico): ?>
              <?php include_component('monitoring', 'attivitaPoliticoArgomento', 
                                      array('carica_id' => $carica_id, 'politico' => $politico, 
                                            'argomento_id' => $argomento->getId(), 'data' => $data)) ?>
        	  <?php endforeach ?>
          </ul>

        <?php else: ?>
          Nessun politico trovato        
        <?php endif ?>
      </div> 

    </div>

  </div>
</div>
