<?php
/*****************************************************************************
 *    Questo file e' parte del progetto openpolis.
 * 
 *    openpolis - la politica trasparente
 *    copyright (C) 2008
 *    Ass. Democrazia Elettronica e Partecipazione Pubblica, 
 *    Via Luigi Montuori 5, 00154 - Roma, Italia
 *
 *    openpolis e' free software; e' possibile redistribuirlo o modificarlo
 *    nei termini della General Public License GNU, versione 2 o successive;
 *    secondo quanto pubblicato dalla Free Software Foundation.
 *
 *    openpolis e' distribuito nella speranza che risulti utile, 
 *    ma SENZA ALCUNA GARANZIA.
 *    
 *    Potete trovare la licenza GPL e altre informazioni su licenze e 
 *    copyright, nella cartella "licenze" del package.
 *
 *    $HeadURL$
 *    $LastChangedDate$
 *    $LastChangedBy$
 *    $LastChangedRevision$
 *
 ****************************************************************************/
?>
<?php
/**
 * funzione che raggruppa gli argomenti passati a linea di comando al PHP
 * 
 * $php myscript.php arg1 -arg2=val2 --arg3=arg3 -arg4 --arg5 -arg6=false
 * 
 * Array
 * (
 *     [input] => Array
 *         (
 *             [0] => myscript.php
 *             [1] => arg1
 *         )
 * 
 *     [arg2] => val2
 *     [arg3] => arg3
 *     [arg4] => true
 *     [arg5] => true
 *     [arg5] => false
 * )
 *
 * @return array
 * @author Guglielmo Celata
 **/
function arguments($argv)
{
  $_ARG = array();
  foreach ($argv as $arg)
  {
    if (preg_match('#^-{1,2}([a-zA-Z0-9]*)=?(.*)$#', $arg, $matches))
    {
      $key = $matches[1];
      switch ($matches[2])
      {
        case '':
        case 'true':
          $arg = true;
          break;
        case 'false':
          $arg = false;
          break;
        default:
          $arg = $matches[2];
      }
      $_ARG[$key] = $arg;
    }
    else
    {
      $_ARG['input'][] = $arg;
    }
  }
  return $_ARG;
}
?>