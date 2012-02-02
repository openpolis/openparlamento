<tr class="clickable <?php echo ($cnt % 2)?'even':'odd'; ?>">
  <td>
    <p><?php print format_date($intervento['data'], 'dd/MM/yyyy') ?></p>
  </td>
  <td>
    <p><?php printf("%s %s", $intervento['denominazione'], ($intervento['ramo']=='C' ? 'Camera' : 'Senato')) ?></p>
  </td>
  <td>
    <p><?php 
    $fullName = sprintf("%s %s", $intervento['nome'], $intervento['cognome']);
    use_helper('Slugger');
    print link_to($fullName, 
                           '@parlamentare?id='.$intervento['politico_id'] .'&slug='. slugify($fullName)) ?></p>
  </td>
  <td>  
    <?php echo link_to(image_tag('extlink.gif',
                                 array('title' => sprintf(
                                   "Vai all'intervento sul sito %s", ($intervento['ramo'] == 'C'?'della Camera':'del Senato')))),
                      $intervento['url'],
                      array('class' => 'external-url-container')) ?>
  </td>
  <?php if ($sf_user->isAuthenticated() && ($sf_user->hasCredential('amministratore') || $sf_user->hasCredential('adhoc'))): ?>
    <td>
      <div class="user-stats-column">
        <?php include_component('deppVoting', 'votingDetailsSmall', array('object' => $intervento['obj'])) ?>
      </div>
    </td>
    <td>
      <div class="user-vote-column">
        <?php include_component('deppVoting', 'votingBlockSmall', array('object' => $intervento['obj'])) ?>            
      </div>
    </td>
  <?php endif ?>
</tr>
