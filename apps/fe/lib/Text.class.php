<?php
/**
 * Classe Text per l'elaborazione dei testi
 *
 *
 * @author Gianluca Canale
 * @version $Id$
 * @package lib
 */


class Text
{

  /** 
	* Metodo statico per prendere solo una parte di un testo 
	* 
	* @param  string testo 
	* @param  integer numero di caratteri da prendere  
	*/ 

  	public static function shorten( $str_to_shorten, $chars_to_keep, $cut_words=false, $str_to_append='...' )
	{
		if ( strlen( $str_to_shorten ) > $chars_to_keep )
		{
			$chop = $chars_to_keep - strlen( $str_to_append );
			if ( !$cut_words )
				while( substr( $str_to_shorten, $chop, 1 ) != ' ' && $chop < strlen( $str_to_shorten ) ){
					$chop--;
				}
			$str_to_shorten = substr( $str_to_shorten, 0, $chop );
			$str_to_shorten = trim( $str_to_shorten );
			$str_to_shorten = $str_to_shorten . $str_to_append;
		}
		
		return $str_to_shorten;
	}

  /**
   * Metodo statico per la visualizzazione completa dell'esito della votazione
   *
   *
   * @author Gianluca Canale
   * @version $Id$
   * @package lib
   */
  public static function decodeEsito($esito)
  {
    
    switch(strtolower($esito))
    {
      case 'appr.':
      case 'Appr.':
      case 'APPR.':
        return 'approvata';
        break;
      case 'annu.':
      case 'Annu.':
      case 'ANNU':
        return 'annullata';
        break;
      case 'resp.':
      case 'Resp.':
      case 'RESP':
        return 'respinta';
        break;
      default:
        return $esito;
    }
      
  }
  
  /**
   * Metodo statico per la costruzione della denominazione di un atto
   *
   *
   * @author Gianluca Canale
   * @version $Id$
   * @package lib
   */
  public static function denominazioneAtto($atto, $action='list', $aggiuntivo_only = false)
  {
    switch($atto->getTipoAttoId())
    {
      case '14':
        return $atto->getTitolo($aggiuntivo_only);
        break;

      case '2':
        if($atto->getRamo()=='C')
          $sub_str_pos = strpos(strip_tags($atto->getDescrizione(),'<br/>'),  'La Camera');
        else
          $sub_str_pos = strpos(strip_tags($atto->getDescrizione(),'<br/>'),  'Il Senato');
        
        $descrizione = substr(strip_tags($atto->getDescrizione(),'<br/>'), $sub_str_pos + 10 );
        
        if($atto->getNumfase()==$atto->getTitolo())
        {
          if($action=='list')  
            return "<em>".$atto->getRamo().".".(strlen($atto->getNumfase())>13 ? substr($atto->getNumfase(), 0, 12).' ...' : $atto->getNumfase())."</em> ".strip_tags(Text::shorten($descrizione, 200));
          else
            return strip_tags(Text::shorten($descrizione, 200));
        }    
        else
        {  
          if($action=='list')
            return "<em>".$atto->getRamo().".".(strlen($atto->getNumfase())>13 ? substr($atto->getNumfase(), 0, 12).' ...' : $atto->getNumfase())."</em> ".$atto->getTitolo($aggiuntivo_only);
          else  
            return $atto->getTitolo($aggiuntivo_only);
        }
        break;   
              
      default:
  	    //$descrizione = $atto->getDescrizione();
        $sub_str_pos = strpos(strip_tags($atto->getDescrizione(),'<br/>'),  'seduta n.');
  		  $sub_str1 = substr(strip_tags($atto->getDescrizione(),'<br/>'), $sub_str_pos + 10 );
  		  $sub_str_pos2 = strpos($sub_str1,  '<br/>');
  		  $sub_str2 = substr($sub_str1, $sub_str_pos2 + 5 );
  		  $descrizione =$sub_str2;
		
  	    if($atto->getNumfase()==$atto->getTitolo())
        {
          if($action=='list')  
            return "<em>".$atto->getRamo().".".(strlen($atto->getNumfase())>13 ? substr($atto->getNumfase(), 0, 12).' ...' : $atto->getNumfase())."</em> ".strip_tags(Text::shorten($descrizione, 200));
          else
            return strip_tags(Text::shorten($descrizione, 200));
        }    
        else
        {  
          if($action=='list')
            return $atto->getRamo().".".(strlen($atto->getNumfase())>13 ? substr($atto->getNumfase(), 0, 12).' ...' : $atto->getNumfase()).' '.$atto->getTitolo($aggiuntivo_only);
          else  
            return $atto->getTitolo($aggiuntivo_only);//." ".strip_tags(Text::shorten($descrizione, 200));
        }
        break;  
    }
  }
  
  public static function denominazioneAttoShort($atto)
  {
    switch($atto->getTipoAttoId())
    {
      case '1':
        return $atto->getRamo().".".(strlen($atto->getNumfase())>13 ? substr($atto->getNumfase(), 0, 12).' ...' : $atto->getNumfase());
        break;
      case '12':
        return "DL.".(strlen($atto->getNumfase())>13 ? substr($atto->getNumfase(), 0, 12).' ...' : $atto->getNumfase());
        break;  
      case '15':
      case '16':
      case '17':
        return "DLGS.".(strlen($atto->getNumfase())>13 ? substr($atto->getNumfase(), 0, 12).' ...' : $atto->getNumfase());
        break;  
      case '14':
        return $atto->getOppTipoAtto()->getDescrizione();
        break;
      case '13':
        return $atto->getOppTipoAtto()->getDescrizione();
        break;  
      default:
        if($atto->getRamo())
          return $atto->getRamo().'.'.(strlen($atto->getNumfase())>13 ? substr($atto->getNumfase(), 0, 12).' ...' : $atto->getNumfase());
        else return (strlen($atto->getNumfase())>13 ? substr($atto->getNumfase(), 0, 12).' ...' : $atto->getNumfase());  
    }
  }
  
  public static function denominazioneEmendamento($emendamento, $action='list')
  {	
    if(!$emendamento->getTitoloAggiuntivo())
    {
      $testoDoc=$emendamento->getOppEmTestos();
      if (count($testoDoc)>0)
      {
        $testoView=trim(strip_tags($testoDoc[0]->getTesto()));
        
        // Elimina gli spazi doppi ( doppi spazi )
        $testoView=str_replace(array("\n","\r","\n\r","\r\n","\t","\t\n"),"",$testoView);
        while (preg_match('/\s{2}/',$testoView)) {
          $testoView=preg_replace("/\s{2}/"," ",$testoView);
        }
        while (preg_match('/\&nbsp\;/',$testoView)) {
          $testoView=preg_replace("/\&nbsp\;/"," ",$testoView);
        }
        
        return '<strong>'.$emendamento->getNumfase().'</strong> - '.Text::shorten($testoView, 200);
      }
      else
        return $emendamento->getTitoloCompleto();
    }        
    else
      return '<strong>'.$emendamento->getNumfase().'</strong> - '.$emendamento->getTitoloCompleto();
  }
    
}

?>