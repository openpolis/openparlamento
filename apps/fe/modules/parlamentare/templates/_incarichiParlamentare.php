<?php
if (count($cariche)>0 || count($pasts)>0)
{
  echo "<h5 class='subsection-alt' style='margin:0'>Incarichi in organi parlamentari  ".image_tag('/images/ico-new.png')."</h5>";
  echo "<div class='politician-more-info' style='padding-left:10px;'>";
  if (count($cariche)>0)
  {
    foreach ($cariche as $carica)
    {
      echo "<p><label>dal ".$carica->getDataInizio('d/m/Y').": ".OppTipoCaricaPeer::retrieveByPk($carica->getTipoCaricaId())->getNome()." ";
      if((stristr(OppSedePeer::retrieveByPk($carica->getSedeId())->getDenominazione(),"commissione")==false) && 
      (stristr(OppSedePeer::retrieveByPk($carica->getSedeId())->getDenominazione(),"giunta")==false) &&
      (stristr(OppSedePeer::retrieveByPk($carica->getSedeId())->getDenominazione(),"presidenza")==false))
      {
        echo OppSedePeer::retrieveByPk($carica->getSedeId())->getTipologia()." ";
      }
      echo strpos(OppSedePeer::retrieveByPk($carica->getSedeId())->getDenominazione(),"giunta");
      if (OppSedePeer::retrieveByPk($carica->getSedeId())->getTipologia()=='Commissione permanente')
        $uri="/commissioni_";
      elseif((OppSedePeer::retrieveByPk($carica->getSedeId())->getTipologia()=='Commissione bicamerale'))
        $uri="/commissioni_bicamerali/";
      elseif((OppSedePeer::retrieveByPk($carica->getSedeId())->getTipologia()=='Giunta'))
        $uri="/giunte/";  
      elseif((OppSedePeer::retrieveByPk($carica->getSedeId())->getTipologia()=='Presidenza'))
        $uri="/organi/";

      echo link_to(OppSedePeer::retrieveByPk($carica->getSedeId())->getDenominazione(),$uri.$ramo."#".$carica->getSedeId())."</label></p>";
    }
  }
  else
  {
    echo "<p><label>Attualmente non ricopre alcun incarico parlamentare</label></p>";
  }
  

  if(count($pasts)>0)
  {

    echo "<p class='indent' style='font-weight:normal;'>guarda i <strong>".count($pasts)."</strong> incarichi passati in questa legislatura ...";
    echo "[". link_to('apri', '#', array('class'=>'btn-open action') ) .link_to('chiudi', '#', array('class'=>'btn-close action', 'style'=>'display:none') ). " ]<br /><br />";
    echo "</p> <div class='more-results float-container' style='display: none;'>";

    foreach ($pasts as $carica)
    {    
     echo "<p style='font-weight:normal;'><label>";
     echo "dal ".$carica->getDataInizio('d/m/Y');
     echo " al ".$carica->getDataFine('d/m/Y').": ";
     echo OppTipoCaricaPeer::retrieveByPk($carica->getTipoCaricaId())->getNome()." ";

      if((stristr(OppSedePeer::retrieveByPk($carica->getSedeId())->getDenominazione(),"commissione")==false) && 
      (stristr(OppSedePeer::retrieveByPk($carica->getSedeId())->getDenominazione(),"giunta")==false) &&
      (stristr(OppSedePeer::retrieveByPk($carica->getSedeId())->getDenominazione(),"presidenza")==false))
      {
        echo OppSedePeer::retrieveByPk($carica->getSedeId())->getTipologia()." ";
      }
      echo strpos(OppSedePeer::retrieveByPk($carica->getSedeId())->getDenominazione(),"giunta");
      if (OppSedePeer::retrieveByPk($carica->getSedeId())->getTipologia()=='Commissione permanente')
        $uri="/commissioni_";
      elseif((OppSedePeer::retrieveByPk($carica->getSedeId())->getTipologia()=='Commissione bicamerale'))
        $uri="/commissioni_bicamerali/";
      elseif((OppSedePeer::retrieveByPk($carica->getSedeId())->getTipologia()=='Giunta'))
        $uri="/giunte/";  
      elseif((OppSedePeer::retrieveByPk($carica->getSedeId())->getTipologia()=='Presidenza'))
        $uri="/organi/";

      echo link_to(OppSedePeer::retrieveByPk($carica->getSedeId())->getDenominazione(),$uri.$ramo."#".$carica->getSedeId());
      echo "</label></p>";


    }
    echo "</div>";
  }
  echo "</div>";
}

?>
