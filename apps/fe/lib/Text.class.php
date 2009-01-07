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

  	public static function shorten( &$str_to_shorten, $chars_to_keep, $cut_words=false, $str_to_append='...' )
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
  public static function denominazioneAtto($atto, $action='list')
  {
    switch($atto->getTipoAttoId())
    {
      case '14':
        return $atto->getTitolo();
        break;
      case '2':
        if($atto->getRamo()=='C')
          $sub_str_pos = strpos($atto->getDescrizione(),  'La Camera');
        else
          $sub_str_pos = strpos($atto->getDescrizione(),  'Il Senato');
        
        $descrizione = substr($atto->getDescrizione(), $sub_str_pos + 10 );
        
        if($atto->getNumfase()==$atto->getTitolo())
        {
          if($action=='list')  
            return "<em>".$atto->getNumfase()."</em> ".strip_tags(Text::shorten($descrizione, 200));
          else
            return "<em>".$atto->getNumfase()."</em> ".$atto->getTitolo();
        }    
        else
        {  
          if($action=='list')
            return $atto->getNumfase().' '.$atto->getTitolo();
          else  
            return $atto->getNumfase().' '.$atto->getTitolo()." - ".strip_tags(Text::shorten($descrizione, 200));
        }
        break;   
              
      default:
	    //$descrizione = $atto->getDescrizione();
        $sub_str_pos = strpos($atto->getDescrizione(),  'seduta n.');
		$sub_str1 = substr($atto->getDescrizione(), $sub_str_pos + 10 );
		$sub_str_pos2 = strpos($sub_str1,  '<br/>');
		$sub_str2 = substr($sub_str1, $sub_str_pos2 + 5 );
		$descrizione =$sub_str2;
		
		if($atto->getNumfase()==$atto->getTitolo())
        {
          if($action=='list')  
            return "<em>".$atto->getNumfase()."</em> ".strip_tags(Text::shorten($descrizione, 200));
          else
            return "<em>".$atto->getNumfase()."</em> ".$atto->getTitolo();
        }    
        else
        {  
          if($action=='list')
            return $atto->getNumfase().' '.$atto->getTitolo();
          else  
            return $atto->getNumfase().' '.$atto->getTitolo()." - ".strip_tags(Text::shorten($descrizione, 200));
        }
        break;  
    }
  }
    
}

?>