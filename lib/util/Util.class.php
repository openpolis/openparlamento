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
    $data = date('Y-m-t', strtotime($data_inizio));
    $date = array();
    
    // loop che costruisce l'array di tutti i fine mese, dalla data iniziale
    // tranne la data finale
    $cnt = 0;
    do {
      $date []= $data;
      $data = date('Y-m-t', strtotime('+1 day', strtotime($data)));
      $cnt++;
    } while ($data < $data_fine && $cnt < 100);

    // aggiunge la data finale
    $date []= $data_fine;
    
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
  
  
  /**
     * Slugify title, replacing whitespace and a few other characters with dashes.
     *
     * Limits the output to alphanumeric characters, underscore (_) and dash (-).
     * Whitespace becomes a dash.
     *
     *
     * @param string $title The title to be sanitized.
     * @param string $raw_title Optional. Not used.
     * @param string $context Optional. The operation for which the string is sanitized.
     * @return string The sanitized title.
     */
    public static function slugify($title, $raw_title = '', $context = 'display') {
            $title = strip_tags($title);
            // Preserve escaped octets.
            $title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
            // Remove percent signs that are not part of an octet.
            $title = str_replace('%', '', $title);
            // Restore octets.
            $title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);
            if (self::seems_utf8($title)) {
                    if (function_exists('mb_strtolower')) {
                            $title = mb_strtolower($title, 'UTF-8');
                    }
                    $title = self::utf8_uri_encode($title, 200);
            }
            $title = strtolower($title);
            $title = preg_replace('/&.+?;/', '', $title); // kill entities
            $title = str_replace('.', '-', $title);
            if ( 'save' == $context ) {
                    // nbsp, ndash and mdash
                    $title = str_replace( array( '%c2%a0', '%e2%80%93', '%e2%80%94' ), '-', $title );
                    // iexcl and iquest
                    $title = str_replace( array( '%c2%a1', '%c2%bf' ), '', $title );
                    // angle quotes
                    $title = str_replace( array( '%c2%ab', '%c2%bb', '%e2%80%b9', '%e2%80%ba' ), '', $title );
                    // curly quotes
                    $title = str_replace( array( '%e2%80%98', '%e2%80%99', '%e2%80%9c', '%e2%80%9d' ), '', $title );
                    // copy, reg, deg, hellip and trade
                    $title = str_replace( array( '%c2%a9', '%c2%ae', '%c2%b0', '%e2%80%a6', '%e2%84%a2' ), '', $title );
            }
            $title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
            $title = preg_replace('/\s+/', '-', $title);
            $title = preg_replace('|-+|', '-', $title);
            $title = trim($title, '-');
            return $title;
    }


    /**
     * Encode the Unicode values to be used in the URI.
     *
     * @param string $utf8_string
     * @param int $length Max length of the string
     * @return string String with Unicode encoded for URI.
     */
    private static function utf8_uri_encode( $utf8_string, $length = 0 ) {
            $unicode = '';
            $values = array();
            $num_octets = 1;
            $unicode_length = 0;
            $string_length = strlen( $utf8_string );
            for ($i = 0; $i < $string_length; $i++ ) {
                    $value = ord( $utf8_string[ $i ] );
                    if ( $value < 128 ) {
                            if ( $length && ( $unicode_length >= $length ) )
                                    break;
                            $unicode .= chr($value);
                            $unicode_length++;
                    } else {
                            if ( count( $values ) == 0 ) $num_octets = ( $value < 224 ) ? 2 : 3;
                            $values[] = $value;
                            if ( $length && ( $unicode_length + ($num_octets * 3) ) > $length )
                                    break;
                            if ( count( $values ) == $num_octets ) {
                                    if ($num_octets == 3) {
                                            $unicode .= '%' . dechex($values[0]) . '%' . dechex($values[1]) . '%' . dechex($values[2]);
                                            $unicode_length += 9;
                                    } else {
                                            $unicode .= '%' . dechex($values[0]) . '%' . dechex($values[1]);
                                            $unicode_length += 6;
                                    }
                                    $values = array();
                                    $num_octets = 1;
                            }
                    }
            }
            return $unicode;
    }

    /**
     * Checks to see if a string is utf8 encoded.
     *
     * NOTE: This function checks for 5-Byte sequences, UTF8
     *       has Bytes Sequences with a maximum length of 4.
     *
     * @author bmorel at ssi dot fr (modified)
     *
     * @param string $str The string to be checked
     * @return bool True if $str fits a UTF-8 model, false otherwise.
     */
    private static function seems_utf8($str) {
            $length = strlen($str);
            for ($i=0; $i < $length; $i++) {
                    $c = ord($str[$i]);
                    if ($c < 0x80) $n = 0; # 0bbbbbbb
                    elseif (($c & 0xE0) == 0xC0) $n=1; # 110bbbbb
                    elseif (($c & 0xF0) == 0xE0) $n=2; # 1110bbbb
                    elseif (($c & 0xF8) == 0xF0) $n=3; # 11110bbb
                    elseif (($c & 0xFC) == 0xF8) $n=4; # 111110bb
                    elseif (($c & 0xFE) == 0xFC) $n=5; # 1111110b
                    else return false; # Does not match any model
                    for ($j=0; $j<$n; $j++) { # n bytes matching 10bbbbbb follow ?
                            if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
                                    return false;
                    }
            }
            return true;
    }
    
}