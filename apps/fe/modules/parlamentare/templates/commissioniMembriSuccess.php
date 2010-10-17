<br/>
    <table class="disegni-decreti column-table lazyload">
      <thead>
        <tr>
          <th scope="col">Parlamentare:</th>
          <th scope="col">Gruppo:</th> 	
          <th scope="col">Circoscrizione:</th>
        </tr>
      </thead>

      <tbody>
       
        
<?php if ($sort=='carica') :?>
  <?php $tr_class = 'even' ?>
  <?php foreach (array('presidente','vicepresidente','segretario','componente') as $tipo_carica) :?>
    <?php foreach (array_keys($c_membri, $tipo_carica) as $k) :?>
    <tr class="<?php echo $tr_class; ?>">
    <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?>
      <th scope="row">  
      <p class="politician-id">
        <?php echo image_tag(OppPoliticoPeer::getThumbUrl(OppCaricaPeer::retrieveByPk($k)->getOppPolitico()->getId()), 
                             array('width' => '40','height' => '53')) ?>
      <?php echo link_to((OppSedePeer::retrieveByPk($sede_id)->getRamo()=='CS' ? (OppCaricaPeer::retrieveByPk($k)->getTipoCaricaId()==1?'On. ':'Sen. ') :'').
      OppCaricaPeer::retrieveByPk($k)->getOppPolitico()->getNome()." ".OppCaricaPeer::retrieveByPk($k)->getOppPolitico()->getCognome(),'@parlamentare?id='.OppCaricaPeer::retrieveByPk($k)->getOppPolitico()->getId()) ?>
      <?php echo ($tipo_carica!='componente'? ' ('.ucfirst($tipo_carica).')' :'') ?>
      </p>
      </th>
      <td>
        <?php echo OppCaricaHasGruppoPeer::getGruppoCorrentePerCarica($k)->getAcronimo() ?>
      </td>
      <td>
        <?php echo OppCaricaPeer::retrieveByPk($k)->getCircoscrizione() ?>
      </td>
    </tr>        
    <?php endforeach ?>
  <?php endforeach ?>   
  

<?php else : ?>  
  <?php $tr_class = 'even' ?>
  <?php foreach ($g_membri as $g => $membri) : ?>
    <?php $temp=explode(",",trim($membri,",")) ?>
    <?php foreach ($temp as $k) :?>
      <?php $k=explode("-",$k)?>
      <tr class="<?php echo $tr_class; ?>">
      <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?>
        <th scope="row">  
        <p class="politician-id">
          <?php echo image_tag(OppPoliticoPeer::getThumbUrl(OppCaricaPeer::retrieveByPk($k[0])->getOppPolitico()->getId()), 
                               array('width' => '40','height' => '53')) ?>
        <?php echo link_to(OppCaricaPeer::retrieveByPk($k[0])->getOppPolitico()->getNome()." ".OppCaricaPeer::retrieveByPk($k[0])->getOppPolitico()->getCognome(),'@parlamentare?id='.OppCaricaPeer::retrieveByPk($k[0])->getOppPolitico()->getId()) ?>
        <?php echo ($k[1]!="componente" ? " (".ucfirst($k[1]).")":"" ) ?>
        </p>
        </th>
        <td>
          <?php echo OppGruppoPeer::retrieveByPk($g)->getAcronimo() ?>
        </td>
        <td>
          <?php echo OppCaricaPeer::retrieveByPk($k[0])->getCircoscrizione() ?>
        </td>
    <?php endforeach ?>
  <?php endforeach ?>
<?php endif ?>

   </tbody>
  </table>
