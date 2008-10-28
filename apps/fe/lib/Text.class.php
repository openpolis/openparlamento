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
    
}

?>