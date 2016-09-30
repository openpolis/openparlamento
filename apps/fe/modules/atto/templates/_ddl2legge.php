<h5 class="subsection">Progetti che sono diventati legge <?php echo ($gruppo!=null?'presentati  dai membri del Governo e parlamentari del gruppo '.$gruppo:'')?></h5>
<table class="disegni-decreti column-table">
  <thead>
    <tr> 
      <th scope="col">natura:</th>
      <th scope="col">ddl presentati:</th>  
      <th scope="col">ddl diventati legge:</th>
      <th scope="col">% di successo:</th>
      <?php if ($gruppo==null): ?>
        <th scope="col">media giorni per l'approvazione:</th>
      <?php endif ?>  
    </tr>
  </thead>

  <tbody>
<?php foreach ($arrs as $i=>$arr ) : ?>
  <tr>
    <td>
  <?php if ($i==0): ?>
    <?php echo "Parlamentare" ?>
  <?php endif ?>  
  <?php if ($i==1): ?>
    <?php echo "Governativa" ?>
  <?php endif ?>
  <?php if ($i==2): ?>
    <?php echo "Popolare" ?>
  <?php endif ?>
  <?php if ($i==3): ?>
    <?php echo "Regionale" ?>
  <?php endif ?>
  </td>
  <td><?php echo $arr[0] ?></td>
  <td><?php echo $arr[1] ?></td>
  <td><?php echo number_format($arr[1]*100/$arr[0],2) ?></td>
  <?php if ($gruppo==null): ?>
     <td><?php echo $arr[2] ?></td>
   <?php endif ?>
  </tr>
<?php endforeach ?>
</tbody>
</table>
<br /><br />
<h5 class="subsection">Quanto tempo impiegano i progetti <?php echo ($gruppo!=null?'presentati dai membri del Governo e parlamentari del gruppo '.$gruppo:'')?> a diventare leggi: dal più veloce al più lento</h5>
<?php //$veloci=array_slice($arr_alls, 0, 20) ?>
<?php $veloci=$arr_alls ?>
<table class="disegni-decreti column-table">
  <thead>
    <tr> 
      <th scope="col">disegno di legge:</th>
      <th scope="col">natura:</th>  
      <th scope="col">giorni per l'approvazione:</th>
    </tr>
  </thead>

  <tbody>
<?php foreach ($veloci as $veloce ) : ?>

     <?php $tr_class = 'even' ?>
     <tr class="<?php echo $tr_class; ?>">
     <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?>
       <th scope="row">
         <p class="content-meta">
           <span class="date"><?php echo $veloce[0]->getDataPres('d/m/Y') ?>,</span>
           <span><?php echo($veloce[0]->getRamo()=='C' ? 'presentato alla Camera' : 'presentato al Senato') ?>
             
             <?php $f_signers= OppAttoPeer::getRecordsetFirmatari($veloce[0]->getId(),'P'); ?>
                 <?php if ($f_signers->next()) :?>  
                   <?php echo ' da '.$f_signers->getString(2).' '.$f_signers->getString(3).($f_signers->getString(6)!='' ? ' ('.$f_signers->getString(6).')' :'').($f_signers->next() ? ' e altri' : '') ?>
                 <?php endif; ?>
           </span>
         </p>
         <p>
           <?php echo link_to('<em>'.$veloce[0]->getRamo().'.'.(strlen($veloce[0]->getNumfase())>13 ? substr($veloce[0]->getNumfase(), 0, 12).' ...' : $veloce[0]->getNumfase()). '</em> '.$veloce[0]->getTitolo(), '@singolo_atto?id='.$veloce[0]->getId()) ?>
         </p>
       </th>
       <td><p>
       <?php if ($veloce[0]->getIniziativa()==1) :?>
        Parlamentare
        <?php else :?>
          Governativa
        <?php endif ?>  
       </p></td>
       
       <td><p><?php echo '<span style="font-size:16px; font-weight:bold;">'.intval($veloce[1]).'</span>' ?></p></td>
  </tr>
<?php endforeach ?> 
</tbody>
</table>
<br /><br />

