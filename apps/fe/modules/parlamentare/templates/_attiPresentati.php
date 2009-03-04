<?php if (count($atti_presentati) > 0): ?>
  <table class="disegni-decreti column-table" style="margin-top: 10px;">
    <thead>
      <tr> 
        <th scope="col">tipo:</th>
        <th scope="col">come Primo firmatario:</th>
        <th scope="col">come Co-firmatario</th>  
      </tr>
    </thead>

    <tbody>		
      <?php foreach ($atti_presentati as $tipo => $values): ?>
        <tr>
          <td><?php echo $tipo ?></td>
          <?php if ($values['P'] > 0): ?>
            <td><?php echo link_to($values['P'],
                             sprintf('@parlamentare_atti?id=%s&stato_last_date=desc&filter_act_type=%s&filter_act_firma=P',
                                     $parlamentare->getId(), $values['id'] )) ?></td>
          <?php else: ?>
            <td> - </td>                        
          <?php endif ?>
          
          <?php if ($values['C'] > 0): ?>
            <td><?php echo link_to($values['C'],                                                   
                              sprintf('@parlamentare_atti?id=%s&stato_last_date=desc&filter_act_type=%s&filter_act_firma=C',
                                      $parlamentare->getId(), $values['id'] )) ?></td>
          <?php else: ?>
            <td> - </td>
          <?php endif ?>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php else: ?>  
  <p style="margin-top: 10px;">Non ha <b>presentato</b> nessun atto</p>
<?php endif; ?>
