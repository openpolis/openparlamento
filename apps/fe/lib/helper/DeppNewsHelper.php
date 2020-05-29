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


// some costants, used in the code
define('CONTEXT_LIST', 1);
define('CONTEXT_ATTO', 0);
define('CONTEXT_POLITICO', 2);
define('CONTEXT_TAG', 3);

/**
 * print the date inside a strong tag
 *
 * @param string $newsdate 
 * @return string
 * @author Guglielmo Celata
 */
function news_date($newsdate)
{
  return content_tag('strong', $newsdate);
}

/**
 * print news for opp_atto_has_iter
 *
 * @param integer $iter_id 
 * @return string $gender
 * @author Ettore Di Cesare
 */
function news_text_for_iter($iter_id, $gender)
{
  switch ($iter_id) 
  {
    case 1:
      return "&Egrave; in attesa di essere assegnato ad una commissione";
      break;
    case 2:
      if ($gender=='m')
        return "&Egrave; stato rimesso all'Assemblea";
      else
        return "&Egrave; stata rimessa all'Assemblea";
      break;
    case 3:
      if ($gender=='m')
        return "&Egrave; stato assegnato in Commissione";
      else
        return "&Egrave; stata assegnata in Commissione";
      break;
    case 4:
      return "&Egrave; all'esame della Commissione";
      break;
    case 5:
      return "Si &egrave; concluso l'esame in Commissione per";
      break;
    case 6:
      return "&Egrave; in stato di relazione";
      break;
    case 7:
      return "&Egrave; all'esame dell'Assemblea";
      break;
    case 8:
      if ($gender=='m')
        return "&Egrave; stato rinviato dall'Assemblea in Commissione";
      else
        return "&Egrave; stata rinviata dall'Assemblea in Commissione";
      break;
    case 9:
      return "&Egrave; stata richiesta una nuova deliberazione per";
      break;
    case 11:
      return "&Egrave; stato assorbito in un altro ddl";
      break;
    case 12:
      if ($gender=='m')
        return "&Egrave; stato respinto";
      else
        return "&Egrave; stata respinta";
      break;
    case 13:
      return "Il primo firmatario ha ritirato";
      break;
    case 14:
      if ($gender=='m')
        return "&Egrave; decaduto";
      else
        return "&Egrave; decaduta";
      break;    
    case 15:
      return "&Egrave; stato approvato definitivamente";
      break;
    case 16:
      return "&Egrave; diventato legge (con pubblicazione in Gazzetta Ufficiale)";
      break;
    case 17:
      return "&Egrave; stato stralciato";
      break;
    case 18:
      return "L'Aula ha cancellato dall'ODG";
      break;
    case 19:
      return "&Egrave; stato rinviato al Presidente della Repubblica";
      break;
    case 20:
      if ($gender=='m')
        return "&Egrave; stato approvato";
      else
        return "&Egrave; stata approvata";
      break;  
    case 21:
      if ($gender=='m')
        return "&Egrave; stato restituito al Governo per essere ripresentato all'altro ramo";
      else
        return "&Egrave; stata restituita al Governo per essere ripresentata all'altro ramo";
      break;
    case 22:
      if ($gender=='m')
        return "&Egrave; stato approvato con modifiche nel testo";
      else
        return "&Egrave; stata approvata con modifiche nel testo";
      break;
    case 25:
      return "&Egrave; stato approvato in testo unificato";
      break;
    case 26:
      return "Ci sono nuovi firmatari per";
      break;  
    case 27:
      return "&Egrave; stato collegato";
      break;  
    case 28:
      return "Si &egrave; concluso";
      break;  
    case 29:
      if ($gender=='m')
        return "&Egrave; stato modificato nel corso della seduta";
      else
        return "&Egrave; stata modificata nel corso della seduta";
      break;
    case 30:
      return "Il Governo ha accolto";
      break;
    case 31:
      return "Il Governo ha dato parere per";
      break;
    case 32:
      return "C'&egrave; stata la rinuncia alla votazione per";
      break;
    case 33:
      return "&Egrave; in discussione";
      break;
    case 34:
      return "Il Governo non ha accolto";
      break;  
    case 35:
      return "Ha ricevuto un invito al ritiro";
      break;
    case 36:
      return "Il Governo ha accolto come raccomandazione";
      break;
    case 37:
      return "Il Governo ha in parte accolto come raccomandazione";
      break;  
    case 38:
      if ($gender=='m')
        return "&Egrave; stato assegnato ad un'altra Commissione";
      else
        return "&Egrave; stata assegnata ad un'altra Commissione";
      break;
    case 39:
      if ($gender=='m')
        return "&Egrave; stato assegnato in Commissione";
      else
        return "&Egrave; stata assegnata in Commissione";
      break;
    case 40:
      return "";
      break;  
    case 41:
      if ($gender=='m')
        return "&Egrave; stato trasformato in un altro atto";
      else
        return "&Egrave; stata trasformata in un altro atto";
      break;
    case 42:
      if ($gender=='m')
        return "Si &egrave; svolto e concluso";
      else
        return "Si &egrave; svolta e conclusa";
      break;  
    case 43:
      return "C'&egrave; stata una discussione congiunta per";
      break;
    case 44:
      return "&Egrave; stata rinviata ad altra seduta la discussione per";
      break;
    case 45:
      return "Il primo firmatario ha ritirato";
      break;  
    case 46:
      return "&Egrave; stata inoltrata una richiesta di sollecito per";
      break;
    case 47:
      if ($gender=='m')
        return "&Egrave; stato dichiarato precluso";
      else
        return "&Egrave; stata dichiarata preclusa";
      break; 
    case 48:
      if ($gender=='m')
        return "&Egrave; stato modificato";
      else
        return "&Egrave; stata modificata";
      break;
    case 49:
      return "&Egrave; cambiato il Ministro che dovrà rispondere a";
      break;
    case 50:
      if ($gender=='m')
        return "&Egrave; stato dichiarato decaduto";
      else
        return "&Egrave; stata dichiarata decaduta";
      break;
    case 51:
      if ($gender=='m')
        return "&Egrave; stato dichiarato inammissibile";
      else
        return "&Egrave; stata dichiarata inammissibile";
      break;   
    case 52:
      return "Il Governo ha in parte accolto";
      break; 
    case 53:
      if ($gender=='m')
        return "&Egrave; stato votato per parti";
      else
        return "&Egrave; stata votata per parti";
      break;
    case 54:
      return "&Egrave; stata approvata come risoluzione conclusiva";
      break;
    case 55:
      if ($gender=='m')
        return "&Egrave; stato rimesso all'Assemblea";
      else
        return "&Egrave; stata rimessa all'Assemblea";
      break;
    case 56:
      return "&Egrave; stata pubblicata la risposta del Governo per";
      break;
    case 57:
      return "Il Governo ha in parte accolto e in parte non accolto";
      break;
    case 58:
      if ($gender=='m')
        return "&Egrave; stato in parte approvato e in parte respinto";
      else
        return "&Egrave; stata in parte approvata e in parte respinta";
      break;   
    case 59:
      return "&Egrave; stato cambiato il destinatario per";
      break; 
    case 60:
      return "C'&egrave; un nuovo primo firmatario per";
      break;
    case 61:
      if ($gender=='m')
        return "&Egrave; stato approvato con voto di fiducia";
      else
        return "&Egrave; stata approvata con voto di fiducia";
      break; 
    case 62:
      if ($gender=='m')
        return "&Egrave; ritornato in Assemblea";
      else
        return "&Egrave; ritornata in Assemblea";
      break;
    case 63:
      return "&Egrave; stato converto in legge";
      break;
    case 64:
      return " &Egrave; confluito in altro Decreto Legge";
      break;
    case 65:
      return "&Egrave; entrato in vigore";
      break;
    default:
       return "";
       break;
  }
}


/**
 * print articolo for tipo_atto
 *
 * @param integer $tipo_atto_id 
 * @author Ettore Di Cesare
 */
  function articolo($tipo_atto_id)
  {
    switch ($tipo_atto_id) 
    {
      case 1:
        return " il ";
        break;
      case 2:
        return " la ";
        break;
      case 3:
        return " l'";
        break;
      case 4:
        return " l'";
        break;
      case 5:
        return " l'";
        break;
      case 6:
        return " l'";
        break;
      case 7:
        return " la ";
        break;
      case 8:
        return " la ";
        break;
      case 9:
        return " la ";
        break;
      case 10:
        return " l'";
        break;    
      case 11:
        return " l'";
        break;
      case 12:
        return " il ";
        break;
      case 13:
        return " il ";
        break;
      case 14:
        return " l'";
        break;    
      case 15:
        return " il ";
        break;
      case 16:
        return " il ";
        break;
      case 17:
        return " il ";
        break;
    }
  }
  
/**
 * convert a link into an absolute link, to be used inside the emails
 *
 * @param string $name 
 * @param string $internal_uri 
 * @param string $options 
 * @return string
 * @author Guglielmo Celata
 */
function link_to_in_mail($name = '', $internal_uri = '', $options = array())
{
  $html_options = _parse_attributes($options);
  $html_options = _convert_options_to_javascript($html_options);

  $site_url = sfConfig::get('sf_site_url', 'op_openparlamento.openpolis.it');
  if (isset($html_options['site_url']))
  {
    $site_url = $html_options['site_url'];
  }

  $url = url_for($internal_uri, true);
  $url_in_mail = preg_replace('/.*\/symfony\/(.*)/i',  'http://'.$site_url.'/$1', $url);
  return "<a href=\"$url_in_mail\">$name</a>";
}


/**
 * torna un titolo e una descrizione per una news
 * strippando la parte iniziale in bold
 * da usare solo per i radicali, notizie per il singolo politico
 *
 * @param string $news - la singola notizia
 * @param string $for_mail_or_rss
 * @return array di 2 stringhe html: (title, description)
 * @author Guglielmo Celata
 */
function news_title_descr($news, $for_mail_or_rss = false, $context = null)
{
  // controlli
  $related_monitorable_model = $news->getRelatedMonitorableModel();
  if ($related_monitorable_model != 'OppPolitico')
    return array("", "");

  $generator_model = $news->getGeneratorModel();
  $pks = array_values(unserialize($news->getGeneratorPrimaryKeys()));
  $generator = call_user_func_array(array($generator_model.'Peer', 'retrieveByPK'), $pks);          

  $news_text = news_text($news, $generator_model, $pks, $generator, 
                         array('in_mail' => $for_mail_or_rss,
                               'context' => is_null($context)?'CONTEXT_LIST':$context));

  // todo: strip initial bold text
  $paragraphs = array();
  $pars = preg_split("/<p>/", $news_text, -1, PREG_SPLIT_NO_EMPTY);
  foreach ($pars as $k => $v)
  {
      $paragraphs[$k] = preg_replace("/<\/p>/", '', $v); // get rid of end "p" tags
  }
  
  return array(strip_tags($paragraphs[0]), (count($paragraphs) > 1)?$paragraphs[1]:'nessuna descrizione');
}

/**
 * torna l'elenco ul/li delle news passate in argomento
 *
 * @param string $news array di oggetti News
 * @return string html
 * @author Guglielmo Celata
 */
function news_list($news, $for_mail_or_rss = false, $context = null)
{
  $news_list = '';
  
  foreach ($news as $n)
  {
    // fetch del modello e dell'oggetto che ha generato la notizia
    $generator_model = $n->getGeneratorModel();
    if ($n->getGeneratorPrimaryKeys())
    {
      $pks = array_values(unserialize($n->getGeneratorPrimaryKeys()));
      $generator = call_user_func_array(array($generator_model.'Peer', 'retrieveByPK'), $pks);          
    } else {
      $pks = array();
      $generator = null;
    }
    
    $news_list .= content_tag('li', 
                              news_text($n, $generator_model, $pks, $generator, 
                                        array('in_mail' => $for_mail_or_rss, 
                                              'context' => is_null($context)?CONTEXT_LIST:$context)));    
  }
  return content_tag('ul', $news_list, array('class' => 'square-bullet'));  
}


/**
 * generate textual representation for a news
 *
 * @param News $news 
 * @param String $generator_model 
 * @param Array $pks 
 * @param BaseObject $generator 
 * @param Array $options 
 *   context  - 0: box, 1: news per politico, 2:pagina di un atto, 3: argomento
 *   in_mail  - if the news lives in a mail or not
 * @return string (html)
 * @author Guglielmo Celata
 */
function news_text(News $news, $generator_model, $pks, $generator, $options = array())
{
  sfLoader::loadHelpers('Asset');
  
  // default value for context
  if (!array_key_exists('context', $options))
    $context = CONTEXT_LIST;
  else
    $context = $options['context'];
    
  // default value for in_mail
  if (!array_key_exists('in_mail', $options))
    $in_mail = false;
  else
    $in_mail = $options['in_mail'];

  $news_string = "";
  
  // notizie di gruppo (votazioni, interventi o emendamenti)
  if (count($pks) == 0)
  {

    if ($generator_model == 'OppVotazioneHasAtto')
    {
      if ($news->getPriority() == 1)
      {
        $news_string .= content_tag('p', ($news->getRamoVotazione()=='C') ? 'Camera -  ' : 'Senato - ');      
        $news_string .= content_tag('p', 'si &egrave; svolta almeno una VOTAZIONE');
      } 
      else {
        $news_string .= "<p>";
        $news_string .= ($news->getRamoVotazione()=='C')?'Camera -  ' : 'Senato - ';
        $news_string .= 'si &egrave; svolta una VOTAZIONE</p>';
         
        if ($context == CONTEXT_LIST)
        {    
          $atto = call_user_func_array(array($news->getRelatedMonitorableModel().'Peer', 'retrieveByPK'), 
                                          $news->getRelatedMonitorableId());
     
          $atto_link = link_to_in_mail($atto->getRamo() . '.' .$atto->getNumfase().' '.$atto->getTitolo(true), 
                            'atto/index?id=' . $atto->getId(),
                            array('title' => $atto->getTitolo(true)));
          $news_string .= 'per ' . OppTipoAttoPeer::retrieveByPK($news->getTipoAttoId())->getDenominazione() .  ' ';
          $news_string .= '<p>'.$atto_link.'</p>';
        }   
      }
    }
    
    if ($generator_model == 'OppIntervento') 
    {
      $news_string .= "<p>";
      $news_string .= (OppSedePeer::retrieveByPK($news->getSedeInterventoId())->getRamo()=='C'?'Camera -  ' : 'Senato - ');
      $news_string .= 'C\'&egrave; stato <strong>almeno un intervento</strong> in ';
       if (OppSedePeer::retrieveByPK($news->getSedeInterventoId())->getTipologia() != 'Assemblea') {
          $news_string .= OppSedePeer::retrieveByPK($news->getSedeInterventoId())->getTipologia();
        }
      $news_string .= ' '.OppSedePeer::retrieveByPK($news->getSedeInterventoId())->getDenominazione();

      if ($context = CONTEXT_LIST)
      {    
          $news_string .= '   per ' . OppTipoAttoPeer::retrieveByPK($news->getTipoAttoId())->getDescrizione() .  '</p> ';

          // link all'atto
          $atto = call_user_func_array(array($news->getRelatedMonitorableModel().'Peer', 'retrieveByPK'), 
                                         array($news->getRelatedMonitorableId()));
      
          $atto_link = link_to_in_mail($atto->getRamo() . '.' .$atto->getNumfase().' '.$atto->getTitolo(true), 
                           'atto/index?id=' . $atto->getId(),
                           array('title' => $atto->getTitolo(true)));
          $news_string .= '<p>'.$atto_link.'</p>';
      }  else $news_string .= '</p>'; 
      
    }


    if ($generator_model == 'OppEmendamento') 
    {
      $related_monitorable_model = $news->getRelatedMonitorableModel();

      if ($related_monitorable_model == 'OppAtto')
      {
        $atto = OppAttoPeer::retrieveByPK($news->getRelatedMonitorableId());
        $n_pres = $atto->countPresentedEmendamentiAtDate($news->getDate());
        if ($n_pres > 1)
          $news_string .= content_tag('p', sprintf("Sono stati presentati %s",link_to($n_pres." emendamenti",'/emendamenti_atto/'.$atto->getId())));        
        else
          $news_string .= content_tag('p', sprintf("&Egrave; stato presentato %s",link_to("un emendamento",'/emendamenti_atto/'.$atto->getId())));
        
      }
      else if ($related_monitorable_model == 'OppPolitico')
      {
        // fetch del politico
        $politico = OppPoliticoPeer::retrieveByPK($news->getRelatedMonitorableId());
        
        $n_signs = $politico->countSignedEmendamentiAtDate($news->getDate());
        if ($n_signs > 1)
          $news_string .= content_tag('p', "Ha firmato <b>$n_signs</b> emendamenti");        
        else
          $news_string .= content_tag('p', "Ha firmato un emendamento");        
        
      }       
    }
      
    return $news_string;
  }
  

  // eccezione per firma, quando in pagina argomenti
  // corregge bug #307
  if ($context == CONTEXT_TAG && $generator_model == 'OppCaricaHasAtto')
  {
    $atto = $generator->getOppAtto();
    $carica = $generator->getOppCarica();
    $tipo = $atto->getOppTipoAtto(); 
    $tipo_firma = $generator->getTipo();
    switch ($tipo_firma) 
    {
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
    
    $atto_link = link_to_in_mail(troncaTesto(Text::denominazioneAtto($atto,'list', true),200), 
                         'atto/index?id=' . $atto->getId(),
                         array('title' => $atto->getTitolo(true)));

    $politico = $carica->getOppPolitico();
    $politico_link = link_to_in_mail($politico, 
                        '@parlamentare?' . $politico->getUrlParams(),
                        array('title' => 'Vai alla scheda del politico'));
      

    $news_string .= '<p>';

    $news_string .= $politico_link;
    $news_string .= " <strong>".$tipo_firma."</strong> ";

    if ($tipo_firma=='&egrave; relatore')
      $news_string .= "dell'atto ";
    else
      $news_string .= "l'atto ";

          
    $news_string .= $tipo->getDescrizione() . "</p>";
    $news_string .= '<p>'.$atto_link.'</p>';

    return $news_string;
    
  }


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
                           '@parlamentare?' . $politico->getUrlParams(),
                           array('title' => 'Vai alla scheda del politico'));


      // nuovo incarico
      if ($generator_model == 'OppCarica')
      {
        if ($context != CONTEXT_POLITICO) 
        {
         $news_string .= "<p><strong>assume l'incarico di " . $generator->getCarica()."</strong> il politico</p>";
         $news_string .= "<p>".$politico_link."</p>";
        }
        else {
          $news_string .= "<p><strong>Assume l'incarico di " . $generator->getCarica()."</strong></p>";  
        }  
      }
    
      // nuovo gruppo
      else if ($generator_model == 'OppCaricaHasGruppo') 
      {
        if ($context != CONTEXT_POLITICO) {
          $news_string .= "<p><strong>si unisce al gruppo " . $generator->getOppGruppo()->getNome()."</strong> il politico</p>";
          $news_string .= "<p>".$politico_link."</p>";
        }  
        else {
          $news_string .= "<p><strong>Si unisce al gruppo " . $generator->getOppGruppo()->getNome()."</strong></p>";  
        }  
      }

      // intervento
      else if ($generator_model == 'OppIntervento')
      {
        $atto = $generator->getOppAtto();
        $tipo = $atto->getOppTipoAtto();
        $atto_link = link_to_in_mail(troncaTesto(Text::denominazioneAtto($atto,'list', true),200), 
                             'atto/index?id=' . $atto->getId(),
                             array('title' => $atto->getTitolo(true)));
        if ($context == CONTEXT_LIST) 
        {      
          $news_string .= "<p>".$politico_link. " <strong>interviene</strong>";
          if ($generator->getUrl()!=NULL) {
          	if (substr_count($generator->getUrl(),'@')>0) {
          		$int_urls=explode("@",$generator->getUrl()); 
          		$intervento_link= " [vai ai testi";
          		foreach ($int_urls as $cnt => $int_url) 
          		{
          		  if (!preg_match('#^http://#',$int_url)) $int_url=sfConfig::get('app_url_sito_camera', 'http://nuovo.camera.it/').$int_url;
          			$intervento_link .= " ".link_to(($cnt+1),$int_url).",";
          		}
          		$intervento_link= rtrim($intervento_link,",");
          		$intervento_link .= "]";
          	}
          	else
          		$intervento_link=" [".link_to('vai al testo',$generator->getUrl())."]"; 
          }
          else
          	$intervento_link="";
        	
          $news_string .= $intervento_link." in ";
          if ($generator->getOppSede()->getId()!=35 && $generator->getOppSede()->getId()!=36)
           $news_string .= $generator->getOppSede()->getTipologia()." ";

          $news_string .= strtoupper($generator->getOppSede()->getDenominazione())." su "; 
          $news_string .= $tipo->getDescrizione() . "</p>";
          $news_string .= "<p>".$atto_link."</p>";
        }
        
        if ($context == CONTEXT_ATTO) 
        {                    
           $news_string .= "<p>";
          if ($generator->getOppSede()->getId()!=35 && $generator->getOppSede()->getId()!=36)
           $news_string .= $generator->getOppSede()->getTipologia()." - ";

          $news_string .= ucfirst(strtolower($generator->getOppSede()->getDenominazione()));       
          $news_string .= $politico_link . " <strong>&egrave; intervenuto</strong>";
          if ($generator->getUrl()!=NULL) {
          	if (substr_count($generator->getUrl(),'@')>0) {
          		$int_urls=explode("@",$generator->getUrl()); 
          		$intervento_link= " [vai ai testi";
          		foreach ($int_urls as $cnt => $int_url) 
          		{
          		  if (!preg_match('#^http://#',$int_url)) $int_url=sfConfig::get('app_url_sito_camera', 'http://nuovo.camera.it/').$int_url;
          			$intervento_link .= " ".link_to(($cnt+1),$int_url).",";
          		}
          		$intervento_link= rtrim($intervento_link,",");
          		$intervento_link .= "]";
          	}
          	else
          		$intervento_link=" [".link_to('vai al testo',$generator->getUrl())."]"; 
          }
          else
          	$intervento_link="";
        	
          $news_string .= $intervento_link." sull'atto </p>";
        
        }  

        if ($context == CONTEXT_POLITICO) 
        {  
          $news_string .= "<p><strong>Interviene</strong>";
           if ($generator->getUrl()!=NULL) {
          	if (substr_count($generator->getUrl(),'@')>0) {
          		$int_urls=explode("@",$generator->getUrl()); 
           		$intervento_link= " [vai ai testi";
          		foreach ($int_urls as $cnt => $int_url) 
          		{
          		  if (!preg_match('#^http://#',$int_url)) $int_url=sfConfig::get('app_url_sito_camera', 'http://nuovo.camera.it/').$int_url;
          			$intervento_link .= " ".link_to(($cnt+1),$int_url).",";
          		}
          		$intervento_link= rtrim($intervento_link,",");
          		$intervento_link .= "]";
          	}
          	else
          		$intervento_link=" [".link_to('vai al testo',$generator->getUrl())."]"; 
          }
          else
          	$intervento_link="";
        	
          $news_string .= $intervento_link." in ";
          $news_string .= $generator->getOppSede()->getTipologia()." ";
        
          $news_string .= strtoupper($generator->getOppSede()->getDenominazione())." su "; 
          $news_string .= $tipo->getDescrizione() . "</p>";
          $news_string .= "<p>".$atto_link."</p>";
        }
      
      }

      // firma
      else if ($generator_model == 'OppCaricaHasAtto')
      {
        
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
      
        $atto_link = link_to_in_mail(troncaTesto(Text::denominazioneAtto($atto,'list', true),200), 
                             'atto/index?id=' . $atto->getId(),
                             array('title' => $atto->getTitolo()));
      
        if ($context == CONTEXT_POLITICO)                      
            $news_string .= '<p><strong>'.ucfirst($tipo_firma)."</strong> ";
        else
            $news_string .= '<p>'.$politico_link ." <strong>".$tipo_firma."</strong> ";
          
        if ($context != CONTEXT_ATTO)
        {    
           $news_string .= $tipo->getDescrizione() . "</p>";
           $news_string .= '<p>'.$atto_link.'</p>';
        }
        else {
          if ($tipo_firma=='&egrave; relatore')
            $news_string .= "dell'atto</p>";
          else
            $news_string .= "l'atto</p>";
        }    
      }

      else if ($generator_model == 'OppCaricaHasEmendamento')
      {
        $emendamento = $generator->getOppEmendamento();
        
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

        $news_string .= "<p>";
        
        if ($context == CONTEXT_POLITICO)                      
            $news_string .= '<strong>'.ucfirst($tipo_firma)."</strong> ";
        else
            $news_string .= $politico_link ." <strong>".$tipo_firma."</strong> ";
          
        if ($tipo_firma=='&egrave; relatore')
          $news_string .= "dell'emendamento";
        else
          $news_string .= "l'emendamento";

        
        $news_string .= ' "'. link_to_in_mail($emendamento->getTitoloCompleto(),
                                            '@singolo_emendamento?id=' . $emendamento->getId()) .'"';
                                            

        if ($context != CONTEXT_ATTO)
        {
          $atto = $emendamento->getAttoPortante();

          // tipo di atto e genere per gli articoli e la desinenza
          $tipo = $atto->getOppTipoAtto();
          if (in_array($tipo->getId(), array(1, 10, 11,12,13,15,16,17)))
            $gender = 'm';
          else
            $gender = 'f';

          $news_string .= " riferito ".($gender=='m'?'al ':'alla ');
          $news_string .= $atto->getOppTipoAtto()->getDescrizione()." ";
          $news_string .= link_to_in_mail(
            troncaTesto(
               Text::denominazioneAtto($atto, 'list'), 200
            ), 'atto/index?id='.$atto->getId());
        } 

      }
      
      else $news_string .= $generator_model;
    
    }
  
    else if ($related_monitorable_model == 'OppAtto')
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
      $atto_link = link_to_in_mail(troncaTesto(Text::denominazioneAtto($atto,'list', true),200), 
                           'atto/index?id=' . $atto->getId(),
                           array('title' => $atto->getTitolo(true)));
    
      // presentazione o passaggio di stato
      if ($generator_model == 'OppAtto')
      { 
        if ($tipo->getId() == 1 && $news->getSucc() !== null)
        {
          // passaggio di stato (cambio ramo?)

          // fetch dell'oggetto succ
          $succ_atto = OppAttoPeer::retrieveByPK($news->getSucc());
          $succ_atto_link = link_to_in_mail($succ_atto->getRamo() . "." . $succ_atto->getNumFase(), 
                               'atto/index?id=' . $succ_atto->getId(),
                               array('title' => $succ_atto->getTitolo(true)));
          $this_atto_link = link_to_in_mail($atto->getRamo() . "." . $atto->getNumFase(), 
                               'atto/index?id=' . $atto->getId(),
                               array('title' => $atto->getTitolo(true)));

          $news_string .= "<p>";
          $news_string .= "il ddl $this_atto_link, approvato ";
        
          if ($atto->getRamo()=='C') $news_string .= "alla Camera, ";
          else $news_string .= "al Senato, ";
        
          $news_string .= "<strong>&egrave; ora approdato ";

          if ($succ_atto->getRamo()=='C') $news_string .= "alla Camera</strong> ";
          else $news_string .= "al Senato</strong> ";
        
          $news_string .= "come $succ_atto_link.";
        
          $news_string .= "</p>";
        
        } 
        else 
        {

          // presentazione atto
          switch ($tipo_atto = $tipo->getId()) {
            case 13:
              $news_string .= "<p>Comunicato del governo: "; 
              $news_string .= $atto_link."</p>";
              break;
            
            case 14:
              $news_string .= "<p>";
              $news_string .= ($news->getRamoVotazione()=='C')?'Camera -  ' : 'Senato - ';
              $news_string .= "<strong>Svolta</strong> audizione "; 
              $news_string .= $atto_link."</p>";
              break;
              
            default:
              $news_string .= "<p>";
              $news_string .= ($news->getRamoVotazione()=='C')?'Camera -  ' : 'Senato - ';
              $news_string .= "<strong>Presentat" .($gender=='m'?'o':'a') . "</strong> ";
              if ($context!=0)
              {
                $news_string .= $tipo->getDescrizione() . "</p>";
                $news_string .= "<p>".$atto_link."</p>";
              }  
              else  $news_string .= "</p>"; 
              break;
          }

        
        } 
      
      }
      
      // intervento 
      else if ($generator_model == 'OppIntervento')
      {
        $politico = $generator->getOppCarica()->getOppPolitico();
        $politico_link = link_to_in_mail($politico, 
                             '@parlamentare?' . $politico->getUrlParams(),
                             array('title' => 'Vai alla scheda del politico'));
      
        $news_string .= "<p>".$politico_link . " <strong>interviene</strong>";
        if ($generator->getUrl()!=NULL) {
        	if (substr_count($generator->getUrl(),'@')>0) {
        		$int_urls=explode("@",$generator->getUrl()); 
        		$intervento_link= " [vai ai testi";
        		foreach ($int_urls as $cnt => $int_url) 
        		{
        		  if (!preg_match('#^http://#',$int_url)) $int_url=sfConfig::get('app_url_sito_camera', 'http://nuovo.camera.it/').$int_url;
        			$intervento_link .= " ".link_to_in_mail(($cnt+1),$int_url).",";
        		}
        		$intervento_link= rtrim($intervento_link,",");
        		$intervento_link .= "]";
        	}
        	else
        		$intervento_link=" [".link_to_in_mail('vai al testo',$generator->getUrl())."]"; 
        }
        else
        	$intervento_link="";
        	
        $news_string .= $intervento_link." in ";
        
        if ($generator->getOppSede()->getId()!=35 && $generator->getOppSede()->getId()!=36)
           $news_string .= $generator->getOppSede()->getTipologia()." ";
        $news_string .= strtoupper($generator->getOppSede()->getDenominazione()); 
      
        $news_string .= ($news->getRamoVotazione()=='C')?' alla Camera su' : ' al Senato su'; 
        $news_string .= " ".$tipo->getDescrizione() . "</p>";
        $news_string .= '<p>'.$atto_link.'</p>';

      
      }

      // firma
      else if ($generator_model == 'OppCaricaHasAtto')
      {
       $tipo_firma=$generator->getTipo();
        switch ($tipo_firma) {
          case "P":
          $tipo_firma='presentato';
          break;
          case "C":
          $tipo_firma='firmato';
          break;
          case "R":
          $tipo_firma='&egrave; relatore';
          break;
        }
        $politico = $generator->getOppCarica()->getOppPolitico();
        $politico_link = link_to_in_mail($politico, 
                             '@parlamentare?' . $politico->getUrlParams(),
                             array('title' => 'Vai alla scheda del politico'));
        if ($tipo_firma!='&egrave; relatore' )
        {
          $news_string .= "<p>";
          $news_string .= $politico_link;
          $news_string .= " <strong>ha ".$tipo_firma. "</strong> ";
          $news_string .= $tipo->getDescrizione() . "</p>";
          $news_string .= '<p>'.$atto_link.'</p>';
        
        }        
      }
    
      // spostamento in commissione
      else if ($generator_model == 'OppAttoHasSede')
      {
        $news_string .= "<p>";
        $news_string .= ($news->getRamoVotazione()=='C')?'Camera -  ' : 'Senato - '; 	
        $news_string .= "<strong>&egrave; all'esame</strong> in ";
        $news_string .= $generator->getOppSede()->getTipologia()." ";
        $news_string .= content_tag('b', strtoupper($generator->getOppSede()->getDenominazione()));
        if ($context!=0)
        {
        
           $news_string .= " ".$tipo->getDescrizione() . "</p>";
           $news_string .= "<p>".$atto_link . "</p>";
        }
        else
           $news_string .= "</p>";
      }
    
      // votazioni
      else if ($generator_model == 'OppVotazioneHasAtto')
      {
        $news_string .= "<p>";
        $news_string .= ($news->getRamoVotazione()=='C')?'Camera -  ' : 'Senato - '; 	
        if ($news->getPriority()==1) 
             $news_string .= link_to(' <strong>si &egrave; svolta la votazione finale</strong>','@votazione?'.$generator->getOppVotazione()->getUrlParams());
        else
             $news_string .= " si &egrave; svolta la votazione per ".link_to($generator->getOppVotazione()->getTitolo(),'@votazione?'.$generator->getOppVotazione()->getUrlParams());     
        if ($context!=0)
        {
           $news_string .= " relativa a ".$tipo->getDescrizione() . "</p>";
           $news_string .= "<p>".$atto_link."</p>"; 
        }
        else
           $news_string .= "</p>";     
      } 
    
      // status conclusivo
      else if ($generator_model == 'OppAttoHasIter') 
      {
        $news_string .= "<p>";
        $news_string .= ($news->getRamoVotazione()=='C')?'Camera -  ' : 'Senato - ';
        $news_string .= content_tag('b', news_text_for_iter($generator->getOppIter()->getId(),$gender));
        $news_string .= articolo($tipo->getId()). $tipo->getDescrizione() . "</p>";
        if ($context != CONTEXT_ATTO) 
          $news_string .= "<p>".$atto_link . "</p>";
        else  $news_string .= "";
     
      } 
    
      else if ($generator_model == 'Tagging')
      {
        $news_string .= "<p>".articolo($tipo->getId());
        $news_string .= $tipo->getDescrizione() . " ";
        $news_string .= $atto_link . " ";
        $news_string .= "presentat" .($gender=='m'?'o':'a') . " ";
        if ($news->getRamoVotazione()=='C') $news_string .= ' alla Camera ';
        else
        {
          if ($news->getRamoVotazione()=='S') $news_string .= ' al Senato ';
        }
        $news_string .= "il " . $news->getDataPresentazioneAtto('d/m/Y') . " ";
        $news_string .= "&egrave; stat".($gender=='m'?'o':'a'). " <b>aggiunt".($gender=='m'?'o':'a'). " al monitoraggio dell'argomento ";
        $news_string .= $generator->getTag()->getTripleValue()."</b></p>";
      }
    
      else if ($generator_model == 'OppDocumento')
      {
        $news_string .= "<p>";
        $news_string .= ($news->getRamoVotazione()=='C')?'Camera -  ' : 'Senato - ';
        $news_string .= "E' disponibile il <strong>nuovo documento</strong> ";
        $news_string .= '"'.link_to($generator->getTitolo(),'atto/documento?id='.$generator->getId()).'"';
        if ($context != CONTEXT_ATTO)
        {
          $news_string .= " riferito ".($gender=='m'?'al ':'alla ');
          $news_string .= $generator->getOppAtto()->getOppTipoAtto()->getDescrizione()."</p>";
          $news_string .="<p>".link_to($generator->getOppAtto()->getRamo().".".$generator->getOppAtto()->getNumfase()." ".troncaTesto(Text::denominazioneAtto($generator->getOppAtto(),'list'),200),'atto/index?id='.$generator->getOppAtto()->getId())."</p>";
        } 
      }
    
      else if ($generator_model == 'OppAttoHasEmendamento')
      {
        $emendamento = $generator->getOppEmendamento();
        $news_string .= "<p>";
        $news_string .= ($news->getRamoVotazione()=='C')?'Camera -  ' : 'Senato - ';
        $news_string .= "E' stato presentato  ";
        $news_string .= " in " . $emendamento->getOppSede()->getDenominazione();
        $news_string .= " l'<b>emendamento</b> ";
        $news_string .= '"'. link_to_in_mail($emendamento->getTitoloCompleto(),
                                            '@singolo_emendamento?id=' . $emendamento->getId()) .'"';
        if ($context != CONTEXT_ATTO)
        {
          $news_string .= " riferito ".($gender=='m'?'al ':'alla ');
          $news_string .= $generator->getOppAtto()->getOppTipoAtto()->getDescrizione()." ";
          $news_string .= link_to_in_mail(
            troncaTesto(
               Text::denominazioneAtto($generator->getOppAtto(), 'list'), 200
            ), 'atto/index?id='.$generator->getOppAtto()->getId());
        } 
        
        $news_string .= "</p>";
        
      }
      
      else if ($generator_model == 'OppEmendamentoHasIter')
      {
        $emendamento = $generator->getOppEmendamento();
        $atti = $emendamento->getOppAttoHasEmendamentosJoinOppAtto();
        $news_string .= "<p>";
        $news_string .= ($news->getRamoVotazione()=='C')?'Camera:  ' : 'Senato: ';
        $news_string .= $emendamento->getOppSede()->getDenominazione()." - ";
        $news_string .= "L'<b>emendamento</b> ";
        $news_string .= '"'. link_to_in_mail($emendamento->getTitoloCompleto(),
                                            '@singolo_emendamento?id=' . $emendamento->getId()) .'"';
        
        if ($context != CONTEXT_ATTO)
        {
          $news_string .= " riferito " . ($gender=='m'?'al ':'alla ');
          $news_string .= $atto_link;
        }
        
        $news_string .= " &egrave; stato " . content_tag('b', strtolower($generator->getOppEmIter()->getFase()));
      }
      
      else if ($generator_model == 'OppEsitoSeduta')
      {
        $sede = $generator->getOppSede();
        $news_string .= "<p>";
        $news_string .= ($news->getRamoVotazione()=='C')?'Camera - ' : 'Senato - ';
        $news_string .= "<strong>Si &egrave; svolta una seduta</strong> in ";
        if ($sede->getTipologia() != 'Assemblea') {
            $news_string .= $sede->getTipologia().' ';
        }
        
        $news_string .= $sede->getDenominazione().' ';
        if ($generator->getTipologia() != 'Assemblea') {
          $news_string .= " (".$generator->getTipologia().") ";
        }
        $news_string .= "<strong><a class='external' target='_blank' href=" .$generator->getUrl() . ">";
        $news_string .= $generator->getEsito();
        $news_string .= "</a></strong>";
        if ($context != CONTEXT_ATTO)
        {
          $news_string .= " per il disegno di legge<br/>";
          $news_string .= $atto_link;
        }
        $news_string .= "</p>";
        
      }
      
      else $news_string .= $generator_model;
    
    }

    else if ($related_monitorable_model == 'Tag')
    {
      
      // tag fetch
      $tag = TagPeer::retrieveByPK($news->getRelatedMonitorableId());
      
      if ($generator_model == 'Tagging')
      {
        $tagging_pks = array_values(unserialize($news->getGeneratorPrimaryKeys()));
        $tagging_id = $tagging_pks[0];
        $tagging = TaggingPeer::retrieveByPK($tagging_id);
        
        $taggable_model = $tagging->getTaggableModel();
        $taggable_id = $tagging->getTaggableId();
        $tagged_obj = call_user_func_array(array($taggable_model.'Peer', 'retrieveByPK'), array($taggable_id));
        
        if ($taggable_model == 'OppAtto')
        {
          // the tagged object is an atto
          $atto = $tagged_obj;
          
          // tipo di atto e genere per gli articoli e la desinenza
          $tipo = $atto->getOppTipoAtto();
          if (in_array($tipo->getId(), array(1, 10, 11,12,13,15,16,17)))
            $gender = 'm';
          else
            $gender = 'f';

          $atto_link = link_to_in_mail(troncaTesto(Text::denominazioneAtto($atto,'list', true),200), 
                               'atto/index?id=' . $atto->getId(),
                               array('title' => $atto->getTitolo()));

          $news_string .= "<p>".articolo($tipo->getId());
          $news_string .= $tipo->getDescrizione() . " ";
          $news_string .= $atto_link . " ";
          $news_string .= "presentat" .($gender=='m'?'o':'a') . " ";
          if ($atto->getRamo()=='C') $news_string .= ' alla Camera ';
          else
          {
            if ($atto->getRamo()=='S') $news_string .= ' al Senato ';
          }
          $news_string .= "il " . $atto->getDataPres('d/m/Y') . " ";
          $news_string .= "&egrave; stat".($gender=='m'?'o':'a'). " <b>aggiunt".($gender=='m'?'o':'a'). " al monitoraggio dell'argomento ";
          if ($context != CONTEXT_TAG)
            $news_string .= $generator->getTag()->getTripleValue();
          $news_string .= "</b></p>";          
        } 
        
        if ($taggable_model == 'OppEmendamento')
        {
          $emendamento = $tagged_obj;
          $emendamento_link = link_to_in_mail($emendamento->getTitoloCompleto(),
                                              '@singolo_emendamento?id=' . $emendamento->getId());
          $news_string .= "<p>";
          $relatedAttos = $emendamento->getOppAttoHasEmendamentosJoinOppAtto();
          $ddl_em="";
          if (count($relatedAttos)>0)
          {
            if (count($relatedAttos)==1)
              $ddl_em= " relativo al ddl ";
            else
              $ddl_em= " relativo ai ddl ";
            foreach ($relatedAttos as $relatedAtto)
            {
              $atto = $relatedAtto->getOppAtto();
              $ddl_em=$ddl_em." ".link_to($atto->getRamo().'.'.$atto->getNumfase(), '@singolo_atto?id='.$atto->getId(), array('title' => $atto->getTitolo()));
            }  
          }
         
          $news_string .= "l'emendamento " . $emendamento_link .", presentato il ".$emendamento->getDataPres('d/m/Y').", ".$ddl_em. " &egrave; stato <b>aggiunto al monitoraggio dell'argomento ";
          if ($context != CONTEXT_TAG)
            $news_string .= $generator->getTag()->getTripleValue();
          $news_string .= "</b></p>";          
        }
      }
      
    }
  } 
  
  else {
    sfLogger::getInstance()->info('xxx: errore per: ' . $generator_model . ': chiavi: ' . $news->getGeneratorPrimaryKeys());
  }
  
  if ($in_mail)
  {
    $sf_site_url = sfConfig::get('sf_site_url', 'openparlamento');
    $news_string = str_replace('./symfony', $sf_site_url, $news_string); # per il test e per sicurezza
    $news_string = str_replace('a href=', 'a style="color: #339;" href=', $news_string);    
  }
  
  return $news_string;
}


/**
* return the correct icon for the given news
 *
 * @param String $generator_model 
 * @param BaseObject $generator 
 * @return string
 * @author Guglielmo Celata
 */
function news_icon_name($generator_model, $generator)
{
  $icon_types = array('OppIntervento'       => 'intervento',
                      'OppVotazioneHasAtto' => 'votazione',
                      'OppCaricaHasAtto'    => 'ordinanza',
                      'OppCarica'           => 'politico',
                      'OppCaricaHasGruppo'  => 'politico',
                      'OppCaricaHasAtto'    => 'ordinanza',
                      'OppAttoHasSede'      => 'next-iter',
                      'Tagging'             => 'etichetta',
                      'OppDocumento'        => 'document',
                      'OppAttoHasIter'      => 'next-iter',
                      'OppEsitoSeduta'      => 'votazione',
                      'OppCaricaHasEmendamento' => 'ordinanza',
                      'OppAttoHasEmendamento' => 'attonoleg',
                      'OppEmendamentoHasIter' => 'next-iter',
                      'OppEmendamento'      => 'descrizione',
                      'OppResoconto'        => 'descrizione',
                      );

  // attos are special
  if ($generator_model == 'OppAtto')
  {	
    $tipo_atto_id = $generator->getOppTipoAtto()->getId();
    
    // distinction between legislative and non-legislative acts
    if (in_array($tipo_atto_id, array(1, 12, 15, 16, 17)))
      $type = 'proposta';
    else
      $type = 'attonoleg';    
  } else {
    $type = $icon_types[$generator_model];
  }
  
  
  return "ico-type-$type.png";
}


/**
 * generate the html representation for the given news
 *
 * @param string $news 
 * @return string (html)
 * @author Guglielmo Celata
 */
function community_news_text($news)
{
  $news_string = "";
  
  // fetch generator model
  $generator_model = $news->getGeneratorModel();

  // fetch related model and object (item)
  $related_model = $news->getRelatedModel();
  $related_id = $news->getRelatedId();
  $item = call_user_func_array($related_model.'Peer::retrieveByPK', array($related_id));

  if (is_null($item))
    return "notizia su oggetto inesistente: ($related_model:$related_id)";
  
  // build item link
  switch ($related_model)
  {
    case 'OppPolitico':
      // link al politico
      $item_type = 'il parlamentare';
      $link = link_to_in_mail($item, 
                             '@parlamentare?' . $item->getUrlParams(),
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
      $atto_link .= link_to_in_mail(Text::denominazioneAtto($related_atto, 'list', true), 
                                   'atto/index?id=' . $related_atto->getId(),
                                   array('title' => $related_atto->getTitolo()));
      
      break;

    case 'OppAtto': 
      // link all'atto 
      if (in_array($item->getTipoAttoId(), array(1, 10, 11,12,13,15,16,17)))  
        $gender = 'm'; 
      else 
        $gender = 'f';   

      $item_type = articolo($item->getTipoAttoId()).$item->getOppTipoAtto()->getDescrizione()." "; 
      $link = link_to_in_mail(Text::denominazioneAtto($item, 'list'),  
                            'atto/index?id=' . $related_id, 
                            array('title' => $item->getTitolo())); 
      break; 

    case 'OppVotazione': 
      // link alla votazione 
      $item_type = 'la votazione'; 
      $link = link_to_in_mail($item->getTitolo(),  
                            '@votazione?' . $item->getUrlParams(), 
                            array('title' => 'Vai alla pagina della votazione')); 
      break; 


    case 'OppEmendamento':
      // link all'emendamento
      $item_type = 'l\'emendamento';
      $link = link_to_in_mail($item->getTitoloCompleto(),
                              '@singolo_emendamento?id=' . $item->getId(),
                              array('title' => 'Vai alla pagina dell\'emendamento'));
      break;
      
    case 'Tag': 
      // link all'argomento 
      $item_type = 'l\'argomento'; 
      $link = link_to_in_mail($item->getTripleValue(),  
                            '@argomento?triple_value=' . $item->getTripleValue(), 
                            array('title' => 'Vai alla pagina dell\'argomento')); 
      break; 
 	}       
 	 
 	// build html code   
 	switch ($generator_model)  
 	{ 

    case 'sfEmendComment':
      // link al documento
      $link = link_to_in_mail($item->getTitolo(), 
                              '@documento?id=' . $related_id,
                              array('title' => $item->getTitolo()));

      if ($news->getType() == 'C')
        return sprintf("<div class='ico-type float-left'>%s</div><p>%s ha commentato il documento</p><p><strong>%s</strong></p><p>relativo %s</p>", 
                       image_tag('/images/ico-type-commento.png', array('alt' => 'commento')),
                       strtolower($news->getUsername()), $link, $atto_link);      
      break;
    
    
    case 'sfComment':
      return sprintf("<div class='ico-type float-left'>%s</div><p>%s ha commentato %s</p><p> %s</p>", 
                     image_tag('/images/ico-type-commento.png', array('alt' => 'commento')),strtolower($news->getUsername()), $item_type, $link);
      break;

      
    case 'Monitoring':
      if ($news->getType() == 'C')
      {
          if ($news->getTotal()>0)
          {
            if ($news->getTotal()>1)
               return sprintf("<div class='ico-type float-left'>%s</div><p>un utente si è aggiunto agli altri %d che stanno monitorando %s</p><p> %s", 
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
