<?php if($atto->countOppDocumentos() != 0): ?>

  <table class="column-table">
    <thead>
      <tr><th scope="col">elenco documenti</th></tr>
    </thead>
    <tbody>
      
        <?php foreach($documenti as $documento): ?>
          <tr>
          <th scope="row">
            <p>
              <?php echo link_to($documento->getTitolo(), 'atto/documento?id='.$documento->getId() ) ?>
            </p>
          </th>  
          </tr>
        <?php endforeach; ?>
      
    </tbody>    
  </table>

<?php endif; ?>  