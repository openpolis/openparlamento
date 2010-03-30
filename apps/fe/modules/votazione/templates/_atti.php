<ul class="presentation float-container">
  <?php foreach ($voto_atti as $voto_atto) : ?>
    <li>- Atto <?php echo link_to(Text::denominazioneAtto($voto_atto->getOppAtto(), 'list'), 'atto/index?id='.$voto_atto->getOppAtto()->getId()) ?></li>
   <?php endforeach; ?> 
   <?php foreach ($voto_ems as $voto_em) : ?>
     <li>- Emendamento <?php echo link_to(Text::denominazioneEmendamento($voto_em->getOppEmendamento(), 'list'), '@singolo_emendamento?id='.$voto_em->getOppEmendamento()->getId()) ?></li>
    <?php endforeach; ?>
</ul>