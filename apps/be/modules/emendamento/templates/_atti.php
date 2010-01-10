<?php $relatedAttos = $opp_emendamento->getOppAttoHasEmendamentosJoinOppAtto(); ?>
<?php foreach ($relatedAttos as $cnt => $atto_em): ?>
  <?php echo $atto_em->getOppAtto()->getId() ?><?php if ($cnt < count($relatedAttos)-1): ?>,<?php endif ?>
<?php endforeach ?>
