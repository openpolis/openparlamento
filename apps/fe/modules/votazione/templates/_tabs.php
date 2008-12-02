<ul id="content-tabs" class="float-container tools-container">
  <li class="current">
    <h2><?php echo link_to('Votazioni', 'votazione/list') ?></h2>   
  </li>
</ul>

<!--
<h1>legislatura: 
  <?php echo ( $sf_user->getAttribute('legislatura')=='16' ? '16esima' : link_to('16esima', '@votazioni?legislatura=16') ) ?>
  <?php echo ( $sf_user->getAttribute('legislatura')=='15' ? '15esima' : link_to('15esima', '@votazioni?legislatura=15') ) ?>
  <?php echo ( $sf_user->getAttribute('legislatura')=='tutte' ? 'tutte' : link_to('tutte', '@votazioni?legislatura=tutte') ) ?>
</h1>
<br />
<br />
<h1>ramo: 
  <?php echo ( $sf_user->getAttribute('ramo')=='entrambi' ? 'entrambi' : link_to('entrambi', '@votazioni?legislatura='.($sf_user->getAttribute('legislatura')=='16' ? '16' : '15').'&ramo=entrambi') ) ?>
  <?php echo ( $sf_user->getAttribute('ramo')=='C' ? 'camera' : link_to('camera', '@votazioni?legislatura='.($sf_user->getAttribute('legislatura')=='16' ? '16' : '15').'&ramo=C') ) ?>
  <?php echo ( $sf_user->getAttribute('ramo')=='S' ? 'senato' : link_to('senato', '@votazioni?legislatura='.($sf_user->getAttribute('legislatura')=='16' ? '16' : '15').'&ramo=S') ) ?>
</h1>
-->