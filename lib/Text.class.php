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
        return 'approvata';
        break;
      case 'annu.':
        return 'annullata';
        break;
      case 'resp.':
        return 'respinta';
        break;
      default:
        return $esito;
    }  
  }
    
}

?>