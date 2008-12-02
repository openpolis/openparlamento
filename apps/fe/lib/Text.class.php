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
      default:
        $descrizione = $atto->getDescrizione();
        if($atto->getNumfase()==$atto->getTitolo())
        {
          if($action=='list')  
            return strip_tags(Text::shorten($descrizione, 150));
          else
            return $atto->getTitolo();
        }    
        else
        {  
          if($action=='list')
            return $atto->getNumfase().' '.$atto->getTitolo();
          else  
            return $atto->getNumfase().' '.$atto->getTitolo()." - ".strip_tags(Text::shorten($descrizione, 150));
        }
        break;  
    }
  }
    
}

?>