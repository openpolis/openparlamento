<?php

/**
 * Classe che tiene le date di inizio e fine delle diverse legislature
 * La classe contiene funzioni per estrarre la legislatura corrente (il numero)
 * per una determinata data
 *
 * 
 *
 * @package lib.model
 */ 
class OppLegislaturaPeer
{

  public static $legislature = array(
     0 => array('elezioni' => '1946-06-02', 'data_inizio' => '1946-06-25', 'data_fine' => '1948-01-31'),
     1 => array('elezioni' => '1948-04-18', 'data_inizio' => '1948-05-08', 'data_fine' => '1953-06-24'),   
     2 => array('elezioni' => '1953-06-07', 'data_inizio' => '1953-06-25', 'data_fine' => '1958-06-11'),   
     3 => array('elezioni' => '1958-05-25', 'data_inizio' => '1958-06-12', 'data_fine' => '1963-05-15'),   
     4 => array('elezioni' => '1963-04-28', 'data_inizio' => '1963-05-16', 'data_fine' => '1968-06-04'),   
     5 => array('elezioni' => '1968-05-19', 'data_inizio' => '1968-06-05', 'data_fine' => '1972-05-24'),   
     6 => array('elezioni' => '1972-05-07', 'data_inizio' => '1972-05-25', 'data_fine' => '1976-07-04'),   
     7 => array('elezioni' => '1976-06-20', 'data_inizio' => '1976-07-05', 'data_fine' => '1979-06-19'),   
     8 => array('elezioni' => '1979-06-03', 'data_inizio' => '1979-06-20', 'data_fine' => '1983-05-03'),   
     9 => array('elezioni' => '1983-06-23', 'data_inizio' => '1983-07-12', 'data_fine' => '1987-07-01'),   
    10 => array('elezioni' => '1987-06-14', 'data_inizio' => '1987-07-02', 'data_fine' => '1992-04-22'),
    11 => array('elezioni' => '1992-04-05', 'data_inizio' => '1992-04-23', 'data_fine' => '1994-04-14'),
    12 => array('elezioni' => '1994-03-27', 'data_inizio' => '1994-04-15', 'data_fine' => '1996-05-08'),
    13 => array('elezioni' => '1996-04-21', 'data_inizio' => '1996-05-09', 'data_fine' => '2001-05-29'),
    14 => array('elezioni' => '2001-05-13', 'data_inizio' => '2001-05-30', 'data_fine' => '2006-04-27'),
    15 => array('elezioni' => '2006-04-09', 'data_inizio' => '2006-04-28', 'data_fine' => '2008-04-28'),
    16 => array('elezioni' => '2008-04-13', 'data_inizio' => '2008-04-29', 'data_fine' => null),
  );
 
  /**
   * torna la legislatura corrente, a partire da una data in formato Y-m-d
   *
   * @param string $date 
   * @return integer
   * @author Guglielmo Celata
   */
  public static function getCurrent($date = null)
  {

    foreach (self::$legislature as $cnt => $leg)
    {
      if ($date >= $leg['data_inizio'] && $date < $leg['data_fine'])
        return $cnt;      
    }

    return count(self::$legislature) - 1;
    
  }
  
}
