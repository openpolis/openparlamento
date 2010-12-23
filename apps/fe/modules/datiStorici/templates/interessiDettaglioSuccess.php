<?php if (count($firme_p)): ?>
  <h6>Come primo firmatario (<?php echo $totale_firme_p ?>)</h6>
  <ul>
    <?php foreach ($firme_p as $firma): ?>
      <?php $atto = $firma['atto'] ?>
      <li>
        Atto:  <?php echo link_to($atto->getShortTitle(),'@singolo_atto?id='.$atto->getId()) ?>
        punti: <?php echo $firma['punti_atto'] ?> x 
               <?php echo OppCaricaHasAttoPeer::get_nuovo_fattore_firma('P') ?> = 
               <?php echo $firma['punti_atto']*OppCaricaHasAttoPeer::get_nuovo_fattore_firma('P')?>
      </li>    
    <?php endforeach ?>
  </ul>  
<?php endif ?>

<?php if (count($firme_r)): ?>
  <h6>Come relatore (<?php echo $totale_firme_r ?>)</h6>
  <ul>
    <?php foreach ($firme_r as $firma): ?>
      <?php $atto = $firma['atto'] ?>
      <li>
        Atto:  <?php echo link_to($atto->getShortTitle(), '@singolo_atto?id='.$atto->getId()) ?>
        punti: <?php echo $firma['punti_atto'] ?> x 
               <?php echo OppCaricaHasAttoPeer::get_nuovo_fattore_firma('R') ?> = 
               <?php echo $firma['punti_atto']*OppCaricaHasAttoPeer::get_nuovo_fattore_firma('R')?>
      </li>    
    <?php endforeach ?>
  </ul>  
<?php endif ?>

<?php if (count($firme_c)): ?>
  <h6>Come cofirmatario (<?php echo $totale_firme_c ?>)</h6>
  <ul>
    <?php foreach ($firme_c as $firma): ?>
      <?php $atto = $firma['atto'] ?>
      <li>
        Atto:  <?php echo link_to($atto->getShortTitle(), '@singolo_atto?id='.$atto->getId()) ?>
        punti:  <?php echo $firma['punti_atto'] ?> x 
                <?php echo OppCaricaHasAttoPeer::get_nuovo_fattore_firma('C') ?> = 
                <?php echo $firma['punti_atto']*OppCaricaHasAttoPeer::get_nuovo_fattore_firma('C')?>
      </li>    
    <?php endforeach ?>
  </ul>  
<?php endif ?>

<?php if (count($interventi)): ?>
  <h6>Interventi (<?php echo $totale_interventi ?>)</h6>
  <ul>
    <?php foreach ($interventi as $intervento): ?>
      <?php $atto = $intervento['atto'] ?>
      <li>
        <?php echo $intervento['n_interventi'] ?> Interventi:
        Atto:  <?php echo link_to($atto->getShortTitle(), '@singolo_atto?id='.$atto->getId()) ?>
        punti: <?php echo $intervento['n_interventi'] ?> x <?php echo $intervento['punti_atto'] ?> x 
               <?php echo OppCaricaHasAttoPeer::get_nuovo_fattore_firma('I') ?> = 
               <?php echo $intervento['punti_atto']*$intervento['n_interventi']*OppCaricaHasAttoPeer::get_nuovo_fattore_firma('I')?>
      </li>    
    <?php endforeach ?>
  </ul>  
<?php endif ?>
