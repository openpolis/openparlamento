<ul class="presentation float-container">
  <?php foreach ($voto_atti as $voto_atto) : ?>
    <li><?php echo link_to(Text::denominazioneAtto($voto_atto->getOppAtto(), 'list'), 'atto/index?id='.$voto_atto->getOppAtto()->getId()) ?></li>
   <?php endforeach; ?> 
</ul>     
  