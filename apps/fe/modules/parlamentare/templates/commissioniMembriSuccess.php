
    <table class="disegni-decreti column-table lazyload">
      <thead>
        <tr>
          <th scope="col">Parlamentare:</th>
          <th scope="col">Gruppo:</th> 	
          <th scope="col">Circoscrizione:</th>
        </tr>
      </thead>

      <tbody>
        </tbody>
      </table>  
        
<?php if ($sort=='carica') :?>

  <?php if(count(array_keys($c_membri, "presidente"))>0 ) :?>
    Presidente
    <br/>
  <?php foreach (array_keys($c_membri, "presidente") as $k) :?>
    <?php echo link_to(OppCaricaPeer::retrieveByPk($k)->getOppPolitico()->getNome()." ".OppCaricaPeer::retrieveByPk($k)->getOppPolitico()->getCognome(),'@parlamentare?id='.OppCaricaPeer::retrieveByPk($k)->getOppPolitico()->getId())."-".
    OppCaricaPeer::retrieveByPk($k)->getCircoscrizione()."-". 
    OppCaricaHasGruppoPeer::getGruppoCorrentePerCarica($k)->getAcronimo() ?>
     <br/>
  <?php endforeach ?> 
  <?php endif ?> 

  <?php if(count(array_keys($c_membri, "vicepresidente"))>0 ) :?>
    <?php echo (array_keys($c_membri, "vicepresidente")==1?'Vicepresidente':'Vicepresidenti')?>
  <br/>
  <?php foreach (array_keys($c_membri, "vicepresidente") as $k) :?>
    <?php echo link_to(OppCaricaPeer::retrieveByPk($k)->getOppPolitico()->getNome()." ".OppCaricaPeer::retrieveByPk($k)->getOppPolitico()->getCognome(),'@parlamentare?id='.OppCaricaPeer::retrieveByPk($k)->getOppPolitico()->getId())."-".
    OppCaricaPeer::retrieveByPk($k)->getCircoscrizione()."-". 
    OppCaricaHasGruppoPeer::getGruppoCorrentePerCarica($k)->getAcronimo() ?>
     <br/>
  <?php endforeach ?>
  <?php endif ?> 
  <?php if(count(array_keys($c_membri, "segretario"))>0 ) :?>
    <?php echo (array_keys($c_membri, "segretario")==1?'Segretario':'Segretari')?>
    <br/>
  <?php foreach (array_keys($c_membri, "segretario") as $k) :?>
    <?php echo link_to(OppCaricaPeer::retrieveByPk($k)->getOppPolitico()->getNome()." ".OppCaricaPeer::retrieveByPk($k)->getOppPolitico()->getCognome(),'@parlamentare?id='.OppCaricaPeer::retrieveByPk($k)->getOppPolitico()->getId())."-".
    OppCaricaPeer::retrieveByPk($k)->getCircoscrizione()."-". 
    OppCaricaHasGruppoPeer::getGruppoCorrentePerCarica($k)->getAcronimo() ?>
     <br/>
  <?php endforeach ?>
  <?php endif ?> 
  <?php if(count(array_keys($c_membri, "componente"))>0 ) :?>
    Membri
    <br/>
  <?php foreach (array_keys($c_membri, "componente") as $k) :?>
    <?php echo link_to(OppCaricaPeer::retrieveByPk($k)->getOppPolitico()->getNome()." ".OppCaricaPeer::retrieveByPk($k)->getOppPolitico()->getCognome(),'@parlamentare?id='.OppCaricaPeer::retrieveByPk($k)->getOppPolitico()->getId())."-".
    OppCaricaPeer::retrieveByPk($k)->getCircoscrizione()."-". 
    OppCaricaHasGruppoPeer::getGruppoCorrentePerCarica($k)->getAcronimo() ?>
     <br/>
  <?php endforeach ?>
  <?php endif ?> 
<?php else : ?>  
  <br/><br/><br/><br/>
  <?php foreach ($g_membri as $g => $membri) : ?>
    <?php echo OppGruppoPeer::retrieveByPk($g)->getNome() ?>
    <br/>
    <?php $temp=explode(",",trim($membri,",")) ?>
    <?php foreach ($temp as $k) :?>
      <?php $k=explode("-",$k)?>
      <?php echo link_to(OppCaricaPeer::retrieveByPk($k[0])->getOppPolitico()->getNome()." ".OppCaricaPeer::retrieveByPk($k[0])->getOppPolitico()->getCognome(),'@parlamentare?id='.OppCaricaPeer::retrieveByPk($k[0])->getOppPolitico()->getId())."-".
      OppCaricaPeer::retrieveByPk($k[0])->getCircoscrizione(). 
      ($k[1]!="componente" ? "-".ucfirst($k[1]):"" ) ?>
       <br/>
    <?php endforeach ?>
  <?php endforeach ?>
<?php endif ?>
