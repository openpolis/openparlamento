<?php include_partial('tabs',array('ramo' => $sf_params->get('ramo'),'gruppi'=> false)) ?>

<div id="content" class="tabbed float-container">
  <div id="main">
    
    <?php echo include_partial('secondLevelMenuParlamentari', 
                               array('current' => 'giorni_di_carica',
                               'ramo' => $sf_params->get('ramo'))); ?>
    <div class="intro-box"><p style="font-size:14px;">
      Non manca in Italia occasione in cui non si discuta, a torto o a ragione, della necessit&agrave; del ricambio della classe politica.<br/>
      Per quanto riguarda i <?php echo ($ramo=='C')?'deputati':'senatori (esclusi quelli a a vita)'?> attualmente in carica abbiamo calcolato da quanto tempo ricoprono incarichi parlamentari, ovvero per quanti anni e giorni sono stati seduti sugli scranni di Montecitorio o Palazzo Madama. Il calcolo viene aggiornato quotidianamente.<br/>
      Oltre al riepilogo complessivo ed a quello diviso per gruppi parlamentari, di seguito la lista dei primi cinquanta <?php echo ($ramo=='C')?'deputati':'senatori (esclusi quelli a a vita)'?> "pi&ugrave; esperti" (<?php echo link_to('clicca qui','@giorni_di_carica?ramo='.($ramo=='C'?'senato':'camera')).' se vuoi la lista dei '.($ramo=='C'?'senatori':'deputati')?>). <br/>Come al solito openparlamento fornisce i dati, a voi analizzarli e trarne le vostre conclusioni.<br/>
      </p></div>                         
    <div class="W73_100 float-left" style="width:55%">

   <h5 class="subsection">La lista dei cinquanta <?php echo ($ramo=='C')?'deputati':'senatori'?> con maggior anni di incarichi parlamentari</h2>
<table class="disegni-decreti column-table lazyload">
  <thead>
    <tr>
      <th scope="col">Parlamentare:</th>
      <th scope="col">E' stato deputato o senatore per:</th>
    </tr>
  </thead>

  <tbody>
  <?php $tr_class = 'even' ?>  
  <?php $cnt = 0; ?>  
<?php foreach ($classifica as $k=>$c) :?>
  <?php $cnt = $cnt+1; ?>  
  <?php if ($cnt>50) : ?>
    <?php break; ?>
  <?php endif;?>  
  <tr class="<?php echo $tr_class; ?>">
  <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?>
    <th scope="row">  
    <p class="politician-id">
      <?php echo image_tag(OppPoliticoPeer::getThumbUrl($k), 
                           array('width' => '40','height' => '53')) ?>
    <?php echo (OppCaricaPeer::retrieveByPk($c[1])->getTipoCaricaId()==1?'On. ':'Sen. '). link_to(OppPoliticoPeer::retrieveByPk($k)->getCognome()." ".OppPoliticoPeer::retrieveByPk($k)->getNome(), "@parlamentare?id=".$k) ?> (<?php echo OppCaricaHasGruppoPeer::getGruppoCorrentePerCarica($c[1])->getAcronimo() ?>)
    </p>
    </th>
    <td><?php echo $c[0] ?></td>
  </tr>  
<?php endforeach ?>      
</tbody>
</table>
  </div>
  <div class="W73_100 float-right" style="width:42%">
    <h5 class="subsection">I dati complessivi sui <?php echo ($ramo=='C')?'deputati':'senatori'?> attualmente in carica</h2>
    <img src="https://chart.googleapis.com/chart?cht=p3&chd=s:Uf9a&chs=400x130&chdl=con oltre 20 anni di incarichi: <?php echo $stat[4].' ('.round($stat[4]*100/array_sum($stat),2)?>%)|da 15 a 20 anni di incarichi: <?php echo $stat[3].' ('.round($stat[3]*100/array_sum($stat),2)?>%)|da 10 a 15 anni di incarichi: <?php echo $stat[2].' ('.round($stat[2]*100/array_sum($stat),2)?>%)|da 5 a 10 anni di incarichi: <?php echo $stat[1].' ('.round($stat[1]*100/array_sum($stat),2)?>%)|con+meno di 5 anni di incarichi: <?php echo $stat[0].' ('.round($stat[0]*100/array_sum($stat),2)?>%)&chd=t:<?php echo "$stat[4],$stat[3],$stat[2],$stat[1],$stat[0]" ?>&chco=FF0000,FFFF10">
  <?php foreach ($stat_gruppi as $k=>$sg) : ?>
    <h5 class="subsection"><?php echo OppGruppoPeer::retrieveByPk($k)->getNome()?></h2>
    <img src="https://chart.googleapis.com/chart?cht=p3&chd=s:Uf9a&chs=400x130&chdl=con oltre 20 anni di incarichi: <?php echo $sg[4].' ('.round($sg[4]*100/array_sum($sg),2)?>%)|da 15 a 20 anni di incarichi: <?php echo $sg[3].' ('.round($sg[3]*100/array_sum($sg),2)?>%)|da 10 a 15 anni di incarichi: <?php echo $sg[2].' ('.round($sg[2]*100/array_sum($sg),2)?>%)|da 5 a 10 anni di incarichi: <?php echo $sg[1].' ('.round($sg[1]*100/array_sum($sg),2)?>%)|con+meno di 5 anni di incarichi: <?php echo $sg[0].' ('.round($sg[0]*100/array_sum($sg),2)?>%)&chd=t:<?php echo "$sg[4],$sg[3],$sg[2],$sg[1],$sg[0]" ?>&chco=FF0000,FFFF10">
    <p>
    Con maggior anni di incarichi: <?php echo link_to(OppPoliticoPeer::retrieveByPk($max_gruppi[$k][0])->getNome()." ".OppPoliticoPeer::retrieveByPk($max_gruppi[$k][0])->getCognome(), "@parlamentare?id=".$k).", ".$max_gruppi[$k][1] ?>.
    </p>
  <?php endforeach ?>  
  </div>  
  </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  <?php if ($ramo=='C') :?>
    <?php echo link_to("deputati", "/parlamentari/camera") ?>/
  <?php else :?>  
    <?php echo link_to("senatori", "/parlamentari/senato") ?> /
  <?php endif; ?>  
    da quanto tempo sono in parlamento i <?php echo ($ramo=='C')?'deputati':'senatori'?>  
<?php end_slot() ?>