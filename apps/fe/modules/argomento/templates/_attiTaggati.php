<?php if (count($atti_taggati) > 0): ?>
  <table class="disegni-decreti column-table" style="margin-top: 10px;">
    <thead>
      <tr> 
        <th scope="col">tipo:</th>
        <th scope="col">numero di atti:</th>
      </tr>
    </thead>

    <tbody>
    <?php $tr_class = 'even' ?>		
      <?php foreach ($atti_taggati as $tipo => $values): ?>
      <tr class="<?php echo $tr_class; ?>">
      <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?> 
           <th scope="row"><?php echo $tipo ?></th>
          <?php if ($values['n'] > 0): ?>
            <td><?php echo link_to($values['n'],
                             sprintf('@argomento_%s?triple_value=%s&filter_act_%s_type=%s',
                                      $values['routing'], $triple_value, 
                                      $values['routing'], $values['type_filter'] )) ?></td>
          <?php else: ?>
            <td> - </td>                        
          <?php endif ?>
          
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php else: ?>  
  <p style="margin-top: 10px;">Nessun atto è stato taggato con questo argomento</p>
<?php endif; ?>
