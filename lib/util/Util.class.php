<?php

/**
 * Some utility static methods
 *
 * 
 *
 * @package lib.model
 */ 
class Util
{
  /**
   * transform an array of any objects into an array of Primary Keys
   *
   * @return void
   * @author Guglielmo Celata
   **/
  public static function transformIntoPKs($objects)
  {
    // creates a callback function able to invoke the object's getPrimaryKey method
    $getPK_callback = create_function('$e', 'return call_user_func(array($e, "getPrimaryKey"));');
    return array_map($getPK_callback, $objects);
  }
  
  
  public static function getLast2MonthsDate($data)
  {
    $end_of_last_month_date = date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-01', strtotime($data)))));
    $end_of_two_months_date = date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-01', strtotime($end_of_last_month_date)))));
    return array($end_of_last_month_date, $end_of_two_months_date);  
  }
  
  public static function buildCacheDatesArray($data_inizio, $data_fine)
  {
    $data = $data_inizio;
    $date = array();
    
    $cnt = 0;
    do {
      $date []= $data;
      $data = date('Y-m-t', strtotime('+1 day', strtotime($data)));
      $cnt++;
    } while ($data < $data_fine && $cnt < 100);
    
    return $date;
  }

  /**
   * torna data di inizio e fine periodo a partire da una data, risalendo da fine mese a n mesi precedenti
   *
   * @param string $data 
   * @param string $mesi 
   * @return array
   * @author Guglielmo Celata
   */
  public static function getLastNMonthsDates($data, $mesi = 1)
  {
    $first_of_month = date('Y-m-d', strtotime(date('Y-m-01', strtotime($data))));
    $end_of_period = date('Y-m-d', strtotime('-1 day', strtotime($first_of_month)));
    if ($mesi == 0)
      $start_of_period = 0;
    else 
      $start_of_period = date('Y-m-d', strtotime($mesi . ' months ago', strtotime($first_of_month)));
    return array($start_of_period, $end_of_period);  
  }

  public static function getLastMonthDates($data)
  {
    return self::getLastNMonthsDates($data);
  }
    
}