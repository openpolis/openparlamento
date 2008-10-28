<b>Commissioni assegnatarie</b>
<br />
<?php foreach($commissioni as $id => $commissione): ?>
  <?php if($commissione->getOppSede()->getRamo()=='S'): $sede_comm="Senato" ?>
  <?php else: $sede_comm="Camera" ?>
  <?php endif; ?>
  <?php echo "Sede ".$commissione->getTipo().": ".$sede_comm." Commissione ".$commissione->getOppSede()->getDenominazione(); ?>
  <br />
<?php endforeach; ?>
<br /><br />