<?php if (count($atti_presentati) > 0): ?>
<h5 class="subsection-alt">Atti su cui lavora</h5>
  <table class="disegni-decreti column-table" style="margin-top: 10px;">
    <thead>
      <tr> 
        <th scope="col">tipo di atto:</th>
        <th scope="col">Primo firmatario:</th>
        <th scope="col">Co-firmatario</th>
        <th scope="col">Relatore</th>    
      </tr>
    </thead>

    <tbody>	
     <?php $tr_class = 'even' ?>	
      <?php foreach ($atti_presentati as $tipo => $values): ?>
        <tr class="<?php echo $tr_class; ?>">
        <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?> 
          <th scope="row" style="padding-left:3px;"><?php echo $tipo ?></th>
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
           <?php if ($values['R'] > 0): ?>
            <td><?php echo link_to($values['R'],                                                   
                              sprintf('@parlamentare_atti?id=%s&stato_last_date=desc&filter_act_type=%s&filter_act_firma=R',
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
