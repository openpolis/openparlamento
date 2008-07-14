<h1>legislatura: 
  <?php echo ( $sf_user->getAttribute('legislatura')=='16' ? '16esima' : link_to('16esima', 'default/index?legislatura=16') ) ?>
  <?php echo ( $sf_user->getAttribute('legislatura')=='15' ? '15esima' : link_to('15esima', 'default/index?legislatura=15') ) ?>
  <?php echo ( $sf_user->getAttribute('legislatura')=='tutte' ? 'tutte' : link_to('tutte', 'default/index?legislatura=tutte') ) ?>
</h1>
<br />
<br />
<h1>ramo: 
  <?php echo ( $sf_user->getAttribute('ramo')=='entrambi' ? 'entrambi' : link_to('entrambi', 'default/index?ramo=entrambi') ) ?>
  <?php echo ( $sf_user->getAttribute('ramo')=='C' ? 'camera' : link_to('camera', 'default/index?ramo=C') ) ?>
  <?php echo ( $sf_user->getAttribute('ramo')=='S' ? 'senato' : link_to('senato', 'default/index?ramo=S') ) ?>
</h1>