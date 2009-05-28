<?php 

/*
 * This file is part of the deppPropelMonitoringBehaviors package.
 * (c) 2008 Guglielmo Celata
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @package    deppPropelMonitoringBehaviors
 * @author     Guglielmo Celata <guglielmo.celata@symfony-project.com>
 * @version    SVN: $Id$
 */

function news($news,$context=1)
{ 
  return news_date($news->getDate('d/m/Y')). "<p>" . news_text($news,$context). "</p>";
}

function news_date($newsdate)
{
  return content_tag('strong',$newsdate);
}



function link_to_in_mail($name = '', $internal_uri = '', $options = array())
{

  $html_options = _parse_attributes($options);
  $html_options = _convert_options_to_javascript($html_options);

  $site_url = sfConfig::get('app_site_url', '');
  if (isset($html_options['site_url']))
  {
    $site_url = $html_options['site_url'];
  }

  $url = url_for($internal_uri);
  $url_in_mail = preg_replace('/.*\/symfony\/(.*)/i',  'http://'.$site_url.'/$1', $url);
  return "<a href=\"$url_in_mail\">$name</a>";
}

/**
 * torna l'elenco ul/li delle news passate in argomento
 *
 * @param string $news array di oggetti News
 * @return string html
 * @author Guglielmo Celata
 */
function news_list($news)
{
  $news_list = '';
  
  foreach ($news as $n)
  {
    $news_list .= content_tag('li', news_text($n));
  }
  
  return content_tag('ul', $news_list, array('class' => 'square-bullet')); 
}


function news_text($news,$context=1)
{
  $news_string = "";
  
  // fetch del modello e dell'oggetto che ha generato la notizia
  $generator_model = $news->getGeneratorModel();

  if (is_null($news->getGeneratorPrimaryKeys()))
  {
    if ($generator_model == 'OppVotazioneHasAtto')
    {
      if ($news->getPriority() == 1)
      {
        $news_string .= '<td class="icon-id" style="width: 60px;">'.image_tag('/images/ico-type-votazione.png',array('width' => '44','height' => '42' )).'</td>'; 
        $news_string .= "<td><p>";
       	
        $news_string .= ($news->getRamoVotazione()=='C')?'Camera -  ' : 'Senato - '.'</p>';      
        $news_string .= '<p>si &egrave; svolta almeno una VOTAZIONE</p></td>';
          
      } else {
        $news_string .= '<td class="icon-id" style="width: 60px;">'.image_tag('/images/ico-type-votazione.png',array('width' => '44','height' => '42' )).'</td>'; 
        $news_string .= "<td><p>";
        $news_string .= ($news->getRamoVotazione()=='C')?'Camera -  ' : 'Senato - ';
        $news_string .= 'si &egrave; svolta una VOTAZIONE</p>';
         
        if ($context==1)
        {    
           $news_string .= 'per ' . OppTipoAttoPeer::retrieveByPK($news->getTipoAttoId())->getDenominazione() .  ' ';
        // link all'atto
           $atto = call_user_func_array(array($news->getRelatedMonitorableModel().'Peer', 'retrieveByPK'), 
                                           $news->getRelatedMonitorableId());
        
           $atto_link = link_to_in_mail($atto->getRamo() . '.' .$atto->getNumfase(), 
                             'atto/index?id=' . $atto->getId(),
                             array('title' => $atto->getTitolo()));
           $news_string .= '<p>'.$atto_link.'</p></td>';
        }   
        else $news_string .= '</td>';
      }
    } else if ($generator_model == 'OppIntervento') {
              $news_string .= '<td class="icon-id" style="width: 60px;">'.image_tag('/images/ico-type-intervento.png',array('width' => '44','height' => '42' )).'</td>'; 
       $news_string .= "<td><p>";
      $news_string .= ($news->getRamoVotazione()=='C')?'Camera -  ' : 'Senato - ';
      $news_string .= 'c\'&egrave; stato almeno un intervento ';
      $news_string .= 'in ' . OppSedePeer::retrieveByPK($news->getSedeInterventoId())->getTipologia().' '.OppSedePeer::retrieveByPK($news->getSedeInterventoId())->getDenominazione() .  '</p>';
      if ($context==1)
      {    
          $news_string .= 'per ' . OppTipoAttoPeer::retrieveByPK($news->getTipoAttoId())->getDescrizione() .  ' ';

          // link all'atto
          $atto = call_user_func_array(array($news->getRelatedMonitorableModel().'Peer', 'retrieveByPK'), 
                                         $news->getRelatedMonitorableId());
      
          $atto_link = link_to_in_mail($atto->getRamo() . '.' .$atto->getNumfase(), 
                           'atto/index?id=' . $atto->getId(),
                           array('title' => $atto->getTitolo()));
          $news_string .= '<p>'.$atto_link.'</p></td>';
       }  
       else $news_string .= '</td>'; 
      
    }
      
    return $news_string;
  }
  
  $pks = array_values(unserialize($news->getGeneratorPrimaryKeys()));
  $generator = call_user_func_array(array($generator_model.'Peer', 'retrieveByPK'), $pks);

  if ($generator) 
  {

  $related_monitorable_model = $news->getRelatedMonitorableModel();
  if ($related_monitorable_model == 'OppPolitico')
  {
    // fetch del politico
    $c = new Criteria(); $c->add(OppPoliticoPeer::ID, $news->getRelatedMonitorableId());
    $politici = OppPoliticoPeer::doSelect($c);

    if (count($politici) == 0) return 'empty OppPolitico:' . $news->getRelatedMonitorableId();

    $politico = $politici[0];

    // link al politico
    $politico_link = link_to_in_mail($politico->getNome() . ' ' .$politico->getCognome(), 
                         '@parlamentare?id=' . $politico->getId(),
                         array('title' => 'Vai alla scheda del politico'));


    // nuovo incarico
    if ($generator_model == 'OppCarica'){
      if ($context!=2) {
               $news_string .= '<td class="icon-id" style="width: 60px;">'.image_tag('/images/ico-type-politico.png',array('width' => '44','height' => '42' )).'</td>'; 
       $news_string .= "<td><p>assume l'incarico di " . $generator->getCarica()." il politico</p>";
       $news_string .= "<p>".$politico_link."</p></td>";
      }
      else {
                $news_string .= '<td class="icon-id" style="width: 60px;">'.image_tag('/images/ico-type-politico.png',array('width' => '44','height' => '42' )).'</td>'; 
        $news_string .= "<td><p>Assume l'incarico di " . $generator->getCarica()."</p></td>";  
      }  
    }
    
    // nuovo gruppo
    else if ($generator_model == 'OppCaricaHasGruppo') {
      if ($context!=2) {
                $news_string .= '<td class="icon-id" style="width: 60px;">'.image_tag('/images/ico-type-politico.png',array('width' => '44','height' => '42' )).'</td>'; 
        $news_string .= "<td><p>si unisce al gruppo " . $generator->getOppGruppo()->getNome()." il politico</p>";
        $news_string .= "<p>".$politico_link."</p></td>";
      }  
      else {
                $news_string .= '<td class="icon-id" style="width: 60px;">'.image_tag('/images/ico-type-politico.png',array('width' => '44','height' => '42' )).'</td>'; 
        $news_string .= "<td><p>Si unisce al gruppo " . $generator->getOppGruppo()->getNome()."</p></td>";  
      }  
    }

    // intervento
    else if ($generator_model == 'OppIntervento'){
      $atto = $generator->getOppAtto();
      $tipo = $atto->getOppTipoAtto();
      $atto_link = link_to_in_mail(troncaTesto(Text::denominazioneAtto($atto,'list'),200), 
                           'atto/index?id=' . $atto->getId(),
                           array('title' => $atto->getTitolo()));
      if ($context==1) 
      {      
         $news_string .= '<td class="icon-id" style="width: 60px;">'.image_tag('/images/ico-type-intervento.png',array('width' => '44','height' => '42' )).'</td>';               
         $news_string .= "<td><p>";
        if ($generator->getOppSede()->getId()!=35 && $generator->getOppSede()->getId()!=36)
         $news_string .= $generator->getOppSede()->getTipologia()." ";

        $news_string .= ucfirst(strtolower($generator->getOppSede()->getDenominazione()));
        
        $news_string .= $politico_link . " - interviene su ";
        $news_string .= $tipo->getDescrizione() . "</p>";
        $news_string .= "<p>".$atto_link."</p></td>";
      }
      if ($context==0) 
      {                    
          $news_string .= '<td class="icon-id" style="width: 60px;">'.image_tag('/images/ico-type-intervento.png',array('width' => '44','height' => '42' )).'</td>';       
         $news_string .= "<td><p>";
        if ($generator->getOppSede()->getId()!=35 && $generator->getOppSede()->getId()!=36)
         $news_string .= $generator->getOppSede()->getTipologia()." ";

        $news_string .= ucfirst(strtolower($generator->getOppSede()->getDenominazione()));       
        $news_string .= $politico_link . " - ha effettuato un intervento sull'atto </p></td>";
      }  
      if ($context==2) 
      {  
        $news_string .= '<td class="icon-id" style="width: 60px;">'.image_tag('/images/ico-type-intervento.png',array('width' => '44','height' => '42' )).'</td>';                                
        $news_string .= "<td><p>";
        if ($generator->getOppSede()->getId()!=35 && $generator->getOppSede()->getId()!=36)
         $news_string .= $generator->getOppSede()->getTipologia()." ";
        $news_string .= ucfirst(strtolower($generator->getOppSede()->getDenominazione()));
        
        $news_string .= " - interviene su ";
        $news_string .= $tipo->getDescrizione() . "</p>";
        $news_string .= "<p>".$atto_link."</p></td>";
      }
      
    }

    // firma
    else if ($generator_model == 'OppCaricaHasAtto'){
      $atto = $generator->getOppAtto();
      $tipo = $atto->getOppTipoAtto(); 
      $tipo_firma=$generator->getTipo();
      switch ($tipo_firma) {
        case "P":
        $tipo_firma='presenta';
        break;
        case "C":
        $tipo_firma='firma';
        break;
        case "R":
        $tipo_firma='&egrave; relatore';
        break;
      }
      
      $atto_link = link_to_in_mail(troncaTesto(Text::denominazioneAtto($atto,'list'),200), 
                           'atto/index?id=' . $atto->getId(),
                           array('title' => $atto->getTitolo()));
      
              $news_string .= '<td class="icon-id" style="width: 60px;">'.image_tag('/images/ico-type-ordinanza.png',array('width' => '44','height' => '42' )).'</td>';                      
      if ($context==2)                      
          $news_string .= '<td><p>'.ucfirst($tipo_firma)." ";
      else
          $news_string .= '<td><p>'.$politico_link ." ".$tipo_firma." ";
      if ($context!=0)
      {    
         $news_string .= $tipo->getDescrizione() . "</p>";
         $news_string .= '<p>'.$atto_link.'</p></td>';
      }
      else
      {
        if ($tipo_firma=='&egrave; relatore')
          $news_string .= "dell'atto</p></td>";
        else
          $news_string .= "l'atto</p></td>";
      }    
    }

    else $news_string .= $generator_model;
    
  }
  
  if ($related_monitorable_model == 'OppAtto')
  {
    // fetch dell'atto
    $c = new Criteria(); $c->add(OppAttoPeer::ID, $news->getRelatedMonitorableId());
    $atti = OppAttoPeer::doSelectJoinOppTipoAtto($c);

    // detect a void query
    if (count($atti) == 0) return 'empty OppAtto:' . $news->getRelatedMonitorableId();

    $atto = $atti[0];
    
    // tipo di atto e genere per gli articoli e la desinenza
    $tipo = $atto->getOppTipoAtto();
    if (in_array($tipo->getId(), array(1, 10, 11,12,13,15,16,17)))
      $gender = 'm';
    else
      $gender = 'f';

    // link all'atto
    $atto_link = link_to_in_mail(troncaTesto(Text::denominazioneAtto($atto,'list'),200), 
                         'atto/index?id=' . $atto->getId(),
                         array('title' => $atto->getTitolo()));
    
    // presentazione
    if ($generator_model == 'OppAtto'){ 
         if (in_array($tipo->getId(), array(1, 12, 15,16,17)))
            $news_string .= '<td class="icon-id" style="width: 60px;">'.image_tag('/images/ico-type-proposta.png',array('width' => '44','height' => '42' )).'</td>';
         else
            $news_string .= '<td class="icon-id" style="width: 60px;">'.image_tag('/images/ico-type-attonoleg.png',array('width' => '44','height' => '42' )).'</td>';
                 
      if ($tipo->getId()!=13 ) {
          $news_string .= "<td><p>";
          $news_string .= ($news->getRamoVotazione()=='C')?'Camera -  ' : 'Senato - ';
          $news_string .= "Presentat" .($gender=='m'?'o':'a') . " ";
      }    
      else
          $news_string .= "<td><p>";    
      
      if ($context!=0)
      {
        $news_string .= $tipo->getDescrizione() . "</p>";
        $news_string .= "<p>".$atto_link."</p></td>";
      }  
      else  $news_string .= "</p></td>"; 
    } 
    
    // intervento 
    else if ($generator_model == 'OppIntervento'){
              $news_string .= '<td class="icon-id" style="width: 60px;">'.image_tag('/images/ico-type-intervento.png',array('width' => '44','height' => '42' )).'</td>';  
      $news_string .= "<td><p>";
      if ($generator->getOppSede()->getId()!=35 && $generator->getOppSede()->getId()!=36)
         $news_string .= $generator->getOppSede()->getTipologia()." ";
      $news_string .= strtoupper($generator->getOppSede()->getDenominazione()); 
      
      $news_string .= ($news->getRamoVotazione()=='C')?' Camera -  ' : ' Senato - ';
      $politico = $generator->getOppCarica()->getOppPolitico();
      $politico_link = link_to_in_mail($politico, 
                           '@parlamentare?id=' . $politico->getId(),
                           array('title' => 'Vai alla scheda del politico'));
                           
      $news_string .= $politico_link . " interviene su";
      if ($context!=0)
      {
        $news_string .= " ".$tipo->getDescrizione() . "</p>";
        $news_string .= '<p>'.$atto_link.'</p></td>';
      }
      else 
        $news_string .= "ll'atto</p></td>";
      
    }

    // firma
    else if ($generator_model == 'OppCaricaHasAtto'){
     $tipo_firma=$generator->getTipo();
      switch ($tipo_firma) {
        case "P":
        $tipo_firma='presentat';
        break;
        case "C":
        $tipo_firma='firmat';
        break;
        case "R":
        $tipo_firma='&egrave; relatore';
        break;
      }
      $politico = $generator->getOppCarica()->getOppPolitico();
      $politico_link = link_to_in_mail($politico, 
                           '@parlamentare?id=' . $politico->getId(),
                           array('title' => 'Vai alla scheda del politico'));
      if ($tipo_firma!='&egrave; relatore' )
      {
                $news_string .= '<td class="icon-id" style="width: 60px;">'.image_tag('/images/ico-type-ordinanza.png',array('width' => '44','height' => '42' )).'</td>';  
        $news_string .= "<td><p>";
        $news_string .= ($news->getRamoVotazione()=='C')?'Camera -  ' : 'Senato - '; 	
        $news_string .= ' '.$tipo_firma. ($gender=='m'?'o':'a') . " ";
         $news_string .= " da " . $politico_link;
        $news_string .= $tipo->getDescrizione() . "</p>";
        $news_string .= '<p>'.$atto_link.'</p></td>';
        
      }        
    }
    
    // spostamento in commissione
    else if ($generator_model == 'OppAttoHasSede'){
              $news_string .= '<td class="icon-id" style="width: 60px;">'.image_tag('/images/ico-type-approvato.png',array('width' => '44','height' => '42' )).'</td>';  
      $news_string .= "<td><p>";
      $news_string .= ($news->getRamoVotazione()=='C')?'Camera -  ' : 'Senato - '; 	
      $news_string .= "&egrave; discuss" . ($gender=='m'?'o':'a') . " in ";
      $news_string .= $generator->getOppSede()->getTipologia()." ";
      $news_string .= content_tag('b', strtoupper($generator->getOppSede()->getDenominazione()));
      if ($context!=0)
      {
        
         $news_string .= " ".$tipo->getDescrizione() . "</p>";
         $news_string .= "<p>".$atto_link . "</p></td>";
      }
      else
         $news_string .= "</p></td>";
         
      
    }
    
    // votazioni
    else if ($generator_model == 'OppVotazioneHasAtto'){
              $news_string .= '<td class="icon-id" style="width: 60px;">'.image_tag('/images/ico-type-votazione.png',array('width' => '44','height' => '42' )).'</td>';  
      $news_string .= "<td><p>";
      $news_string .= ($news->getRamoVotazione()=='C')?'Camera -  ' : 'Senato - '; 	
      if ($news->getPriority()==1) 
           $news_string .= link_to(' <strong>si &egrave; svolta la votazione finale</strong>','/votazione/'.$generator->getOppVotazione()->getId())." relativa a";
      else
           $news_string .= " si &egrave; svolta la votazione per ".link_to($generator->getOppVotazione()->getTitolo(),'/votazione/'.$generator->getOppVotazione()->getId())."relativa a";     
      if ($context!=0)
      {
         $news_string .= " ".$tipo->getDescrizione() . "</p>";
         $news_string .= "<p>".$atto_link."</p></td>"; 
      }
      else
         $news_string .= "ll'atto</p></td>";     
    } 
    
    // status conclusivo
    else if ($generator_model == 'OppAttoHasIter') {
              $news_string .= '<td class="icon-id" style="width: 60px;">'.image_tag('/images/ico-type-approvato.png',array('width' => '44','height' => '42' )).'</td>';  
      $news_string .= "<td><p>";
      $news_string .= ($news->getRamoVotazione()=='C')?'Camera -  ' : 'Senato - '; 	
      $news_string .= "Lo status &egrave; ora ";
      $news_string .= content_tag('b', ucfirst(strtolower($generator->getOppIter()->getFase())));
      $news_string .= " per " .($gender=='m'?" ":"la "). $tipo->getDescrizione() . "</p>";
      if ($context!=0) $news_string .= "<p>".$atto_link . "</p></td>";
      else  $news_string .= "</td>";
     
    } 
    
    else if ($generator_model == 'Tagging')
    {
              $news_string .= '<td class="icon-id" style="width: 60px;">'.image_tag('/images/ico-type-etichetta.png',array('width' => '44','height' => '42' )).'</td>';  
      $news_string .= "<td><p>".($gender=='m'?"il ":"la ");
      $news_string .= $tipo->getDescrizione() . " ";
      $news_string .= $atto_link . " ";
      $news_string .= "presentat" .($gender=='m'?'o':'a') . " ";
      if ($news->getRamoVotazione()=='C') $news_string .= ' alla Camera ';
      else
      {
        if ($news->getRamoVotazione()=='S') $news_string .= ' al Senato ';
      }
      $news_string .= "il " . $news->getDataPresentazioneAtto('d/m/Y') . " ";
      $news_string .= "&egrave; stat".($gender=='m'?'o':'a'). " <b>associat".($gender=='m'?'o':'a'). " all'argomento ";
      $news_string .= $generator->getTag()->getTripleValue()."</b></p></td>";
    }
    
    else if ($generator_model == 'OppDocumento')
    {
             $news_string .= '<td class="icon-id" style="width: 60px;">'.image_tag('/images/ico-type-document.png',array('width' => '44','height' => '42' )).'</td>';  
     $news_string .= "<td><p>";
     $news_string .= ($news->getRamoVotazione()=='C')?'Camera -  ' : 'Senato - ';
     $news_string .= "E' disponibile il nuovo documento ";
     $news_string .= '"'.link_to($generator->getTitolo(),'atto/documento?id='.$generator->getId()).'"';
     if ($context!=0)
     {
      $news_string .= " riferito ".($gender=='m'?'al ':'alla ');
      $news_string .= $generator->getOppAtto()->getOppTipoAtto()->getDescrizione()."</p>";
      $news_string .="<p>".link_to($generator->getOppAtto()->getRamo().".".$generator->getOppAtto()->getNumfase()." ".troncaTesto(Text::denominazioneAtto($generator->getOppAtto(),'list'),200),'atto/index?id='.$generator->getOppAtto()->getId())."</p></td>";
     } 
    }
    
    else $news_string .= $generator_model;
                                  
    
    
  }

  } else {
    sfLogger::getInstance()->info('xxx: errore per: ' . $generator_model . ': chiavi: ' . $news->getGeneratorPrimaryKeys());
  }
  
  return $news_string;
  
}

function community_news_text($news)
{
  $news_string = "";
  
  // fetch del modello e dell'oggetto che ha generato la notizia
  $generator_model = $news->getGeneratorModel();

  $related_model = $news->getRelatedModel();
  $related_id = $news->getRelatedId();

  // fetch dell'item
  $item = call_user_func_array($related_model.'Peer::retrieveByPK', array($related_id));

  if (is_null($item))
    return "notizia su oggetto inesistente: ($related_model:$related_id)";
  
 
  
  // costruzione del link all'item (differente a seconda dell'item)
  switch ($related_model)
  {
    case 'OppPolitico':
      // link al politico
      $item_type = 'il parlamentare';
      $link = link_to_in_mail($item, 
                             '@parlamentare?id=' . $related_id,
                             array('title' => 'Vai alla scheda del politico'));
      break;

    case 'OppDocumento':
      // link al documento
      $link = link_to_in_mail($item->getTitolo(), 
                              '@documento?id=' . $related_id,
                              array('title' => $item->getTitolo()));

      $related_atto = OppAttoPeer::retrieveByPK($item->getAttoId());

      // costruzione del link all'atto relativo al documento
      if (in_array($related_atto->getTipoAttoId(), array(1, 3, 4, 5, 6, 10, 11, 14))) 
        $atto_article = 'all\'';
      elseif (in_array($related_atto->getTipoAttoId(), array(12, 13, 15, 16, 17)))
        $atto_article = 'al ';
      else
        $atto_article = 'alla ';  
          
      $atto_link = $atto_article.$related_atto->getOppTipoAtto()->getDescrizione()." ";
      $atto_link .= link_to_in_mail(Text::denominazioneAtto($related_atto, 'list'), 
                                   'atto/index?id=' . $related_atto->getId(),
                                   array('title' => $related_atto->getTitolo()));
      
      break;

    case 'sfEmendComment':
      if ($news->getType() == 'C')
        return sprintf("<div class='ico-type float-left'>%s</div><p>%s ha commentato il documento</p><p>%s</p><p>relativo %s</p>", 
                       image_tag('/images/ico-type-commento.png', array('alt' => 'commento')),
                       strtolower($news->getUsername()), $link, $atto_link);      
      break;
    
    
    case 'sfComment':
      return sprintf("<div class='ico-type float-left'>%s</div><p>%s ha commentato %s</p><p> %s</p>", 
                     image_tag('/images/ico-type-approvato.png', array('alt' => 'commento')),strtolower($news->getUsername()), $item_type, $link);
      break;
      
    case 'Monitoring':
      if ($news->getType() == 'C')
      {
          if ($news->getTotal()>0)
          {
            if ($news->getTotal()>1)
               return sprintf("<div class='ico-type float-left'>%s</div><p>un utente si è aggiunto agli  %d che stanno monitorando %s</p><p> %s", 
                              image_tag('/images/ico-type-monitoring.png', array('alt' => 'monitor')),$news->getTotal(), $item_type, $link); 
            else
               return sprintf("<div class='ico-type float-left'>%s</div><p>un utente si è aggiunto a un altro che sta monitorando %s</p><p> %s", 
                              image_tag('/images/ico-type-monitoring.png', array('alt' => 'monitor')),$item_type, $link); 
          }                    
          else
               return sprintf("<div class='ico-type float-left'>%s</div><p>un primo utente ha avviato il monitoraggio per %s</p><p> %s", 
                              image_tag('/images/ico-type-monitoring.png', array('alt' => 'monitor')),$item_type, $link);      
      }                              
      else
         return sprintf("<div class='ico-type float-left'>%s</div><p>un utente ha smesso di monitorare %s</p><p> %s</p>", 
                              image_tag('/images/ico-type-monitoring.png', array('alt' => 'monitor')),$item_type, $link);
      break;
      
    case 'sfVoting':
      if ($news->getType() == 'C')
      {
        if ($news->getVote() == 1) $fav_contr = '<span style="color:green; font-weight:bold;">favorevoli</span>';
        else $fav_contr = '<span style="color:red; font-weight:bold;">contrari</span>';
        if ($news->getTotal()>0)
        {
           if ($news->getTotal()>1)
               return sprintf("<div class='ico-type float-left'>%s</div><p>un utente si è aggiunto agli altri %d %s al%s </p><p> %s</p>", 
                              image_tag('/images/ico-type-votazione-user.png', array('alt' => 'voto')),$news->getTotal(), $fav_contr, $item_type, $link);
           else
           {
               if (substr_count($fav_contr,'favorevoli') == 1) $fav_contr = '<span style="color:green; font-weight:bold;">favorevole</span>';
               else $fav_contr = '<span style="color:red; font-weight:bold;">contrario</span>';
               return sprintf("<div class='ico-type float-left'>%s</div><p>un utente si è aggiunto a un altro %s al%s</p><p>%s</p>", 
                              image_tag('/images/ico-type-votazione-user.png', array('alt' => 'voto')),$fav_contr, $item_type, $link);
           }                    
        }                      
        else
        {
               if (substr_count($fav_contr,'favorevoli') == 1) $fav_contr = '<span style="color:green; font-weight:bold;">favorevole</span>';
               else $fav_contr = '<span style="color:red; font-weight:bold;">contrario</span>';
               return sprintf("<div class='ico-type float-left'>%s</div><p>un utente &egrave; %s al%s</p><p> %s</p>", 
                               image_tag('/images/ico-type-votazione-user.png', array('alt' => 'voto')),$fav_contr, $item_type, $link);           
        }                           
      } else {
        return sprintf("<div class='ico-type float-left'>%s</div><p>utente ha ritirato il suo voto per %s</p><p> %s</p>", 
                      image_tag('/images/ico-type-votazione-user.png', array('alt' => 'voto')),$item_type, $link);          
      }
      break;
    case 'nahoWikiRevision':
      return sprintf("<div class='ico-type float-left'>%s</div><p>%s ha modificato la descrizione wiki per %s</p><p> %s</p>", 
                     image_tag('/images/ico-type-descrizione.png', array('alt' => 'wiki!')),strtolower($news->getUsername()), $item_type, $link);
      break;
  }
  
  
}



function troncaTesto($testo, $caratteri) { 

    if (strlen($testo) <= $caratteri) return $testo; 
    $nuovo = wordwrap($testo, $caratteri, "|"); 
    $nuovotesto=explode("|",$nuovo); 
    return $nuovotesto[0]."..."; 
} 


?>
