<?php

/**
 * Some utility static methods for parsing
 *
 * 
 *
 * @package lib.model
 */ 
class ParserTools
{
  /**
   * transform an array of any objects into an array of Primary Keys
   *
   * @return void
   * @author Guglielmo Celata
   **/
  public static function load_remote_html_page_into_dom($uri, $n_tentativi = 10, $timeout = 5)
  {
    include_once (SF_ROOT_DIR."/batch/parser/simple_html_dom.php");

    $ctx = stream_context_create(array( 
        'http' => array( 
            'timeout' => $timeout
            ) 
        ) 
    ); 
    
    for ($i = 1; $i <= $n_tentativi; $i++)
    {
      echo $i . "\n";
  	  $html = file_get_html($uri, 0, $ctx);
  	  if ($html != '')
  	  {
  	    break;
  	  }
    }
    
      return $html;
    
  } 
}
