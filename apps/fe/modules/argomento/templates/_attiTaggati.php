<h5 class="subsection-alt">Atti presentati sull'argomento</h5>
<?php if (count($atti_taggati) > 0): ?>
  <table class="disegni-decreti column-table" style="margin-top: 10px;">
    <thead>
      <tr> 
        <th scope="col">tipo di atto:</th> 
        <th scope="col">camera:</th>
        <th scope="col">senato:</th> 
        <th scope="col">totale:</th>
     
      </tr>
    </thead>

    <tbody>
    <?php $tr_class = 'even' ?>		
      <?php foreach ($atti_taggati as $tipo => $values): ?>
      <tr class="<?php echo $tr_class; ?>">
      <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?> 
           <th scope="row"><?php echo $tipo ?></th>
          <?php if (array_key_exists('nc', $values) && $values['nc'] > 0): ?>
            <td><?php echo link_to($values['nc'],
                             sprintf('@argomento_%s?triple_value=%s&filter_act_%s_type=%s&filter_act_ramo=C',
                                      $values['routing'], $triple_value, 
                                      $values['routing'], $values['type_filter'] )) ?></td>
          <?php else: ?>
            <td> 0 </td>                        
          <?php endif ?>
          
          <?php if (array_key_exists('ns', $values) && $values['ns'] > 0): ?>
            <td><?php echo link_to($values['ns'],
                             sprintf('@argomento_%s?triple_value=%s&filter_act_%s_type=%s&filter_act_ramo=S',
                                      $values['routing'], $triple_value, 
                                      $values['routing'], $values['type_filter'] )) ?></td>
          <?php else: ?>
            <td> 0 </td>
          <?php endif ?>
            
           <?php if ((array_key_exists('ns', $values) || array_key_exists('nc', $values)) && ($values['nc']+$values['ns']) > 0): ?>
            <td><?php echo link_to($values['nc']+$values['ns'],
                             sprintf('@argomento_%s?triple_value=%s&filter_act_%s_type=%s&filter_act_ramo=0',
                                      $values['routing'], $triple_value, 
                                      $values['routing'], $values['type_filter'] )) ?></td>
          <?php else: ?>
            <td> 0 </td>                              
          <?php endif ?>
          
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php else: ?>  
  <p style="margin-top: 10px;">Nessun atto è stato taggato con questo argomento</p>
<?php endif; ?>
