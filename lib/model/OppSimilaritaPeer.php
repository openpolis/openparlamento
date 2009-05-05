<?php

/**
 * Subclass for performing query and update operations on the 'opp_similarita' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppSimilaritaPeer extends BaseOppSimilaritaPeer
{

  /**
   *  il fattore di similarità è la somma delle similarità per le singole firme:
   *  P - P  : 6
   *  P - R  : 6
   *  R - R  : 6
   *  P - C  : 3
   *  R - C  : 3
   *  C - C  : 1
   *  * - -  : 0
   */
  public static function similarityForSignatures($p1, $p2){

  	$sim = 0;
  	foreach ($p1['firme'] as $id => $value){
  	  if (!array_key_exists($id, $p2['firme']))
  	    $s = 0;
  	  elseif ($p1['firme'][$id] == 'P' && $p2['firme'][$id] == 'P')  $s = 6;
  	  elseif ($p1['firme'][$id] == 'P' && $p2['firme'][$id] == 'R' || 
  	          $p1['firme'][$id] == 'R' && $p2['firme'][$id] == 'P') $s = 6;
  	  elseif ($p1['firme'][$id] == 'R' && $p2['firme'][$id] == 'R') $s = 6;
  	  elseif ($p1['firme'][$id] == 'P' && $p2['firme'][$id] == 'C' || 
  	          $p1['firme'][$id] == 'C' && $p2['firme'][$id] == 'P') $s = 3;
  	  elseif ($p1['firme'][$id] == 'R' && $p2['firme'][$id] == 'C' || 
  	          $p1['firme'][$id] == 'C' && $p2['firme'][$id] == 'R') $s = 3;
  	  elseif ($p1['firme'][$id] == 'C' && $p2['firme'][$id] == 'C') $s = 1;
  	  else $s = 0;

  		$sim += $s;
  	}
  	return $sim;
  }


  /**
   *  il fattore di similarità è la somma delle similarità tra voti:
   *  Stesso voto: +6
   *  CON - FAV  : -6
   *  AST - FAV  : 2C | -4S
   *  AST - CON  : 2C |  4S
   *  Assenza o invalidità: 0  
   */
  public static function similarityForVotes($p1, $p2, $ramo){

  	$sim = 0;
  	foreach ($p1['voti'] as $id => $value){
  	  if (!array_key_exists($id, $p2['voti']))
  	    $s = 0;
  	  elseif ($p1['voti'][$id] == $p2['voti'][$id]) $s = 6;
  	  elseif ($p1['voti'][$id] == 'CON' && $p2['voti'][$id] == 'FAV' || 
  	          $p2['voti'][$id] == 'CON' && $p1['voti'][$id] == 'FAV') $s = -6;
  	  elseif ($p1['voti'][$id] == 'AST' && $p2['voti'][$id] == 'FAV' || 
  	          $p1['voti'][$id] == 'FAV' && $p2['voti'][$id] == 'AST') $s = ($ramo=='C')?2:-4;
  	  elseif ($p1['voti'][$id] == 'AST' && $p2['voti'][$id] == 'CON' || 
  	          $p1['voti'][$id] == 'CON' && $p2['voti'][$id] == 'AST') $s = ($ramo=='C')?2:4;
  	  else $s = 0;

  		$sim += $s;
  	}	
  	return $sim;
  }


  /**
   *  Funzione che calcola la similarità tra due politici, per quanto riguarda un solo voto
   *  Stesso voto:  +6
   *  CON - FAV  : -6
   *  AST - FAV  : 2C | -4S
   *  AST - CON  : 2C |  4S
   *  Assenza o invalidità: 0  
   */
  public static function similarityForVote($v1, $v2, $ramo){
	  if ($v1 == $v2) $s = 6;
	  elseif ($v1 == 'CON' && $v2 == 'FAV' || 
	          $v2 == 'CON' && $v1 == 'FAV') $s = -6;
	  elseif ($v1 == 'AST' && $v2 == 'FAV' || 
	          $v1 == 'FAV' && $v2 == 'AST') $s = ($ramo=='C')?2:-4;
	  elseif ($v1 == 'AST' && $v2 == 'CON' || 
	          $v1 == 'CON' && $v2 == 'AST') $s = ($ramo=='C')?2:4;
	  else $s = 0;

  	return $s;
  }
  
  
  public static function getMaxSimilarityForVotes()
  {
    $con = Propel::getConnection(self::DATABASE_NAME);
    $sql = "SELECT MAX(voting_similarity) FROM opp_similarita"; 
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_NUM);
    if($rs->next())
      return $rs->getFloat(1);
    else
      return null;
    
      
  }
  public static function getMaxSimilarityForSignatures()
  {
    $con = Propel::getConnection(self::DATABASE_NAME);
    $sql = "SELECT MAX(signing_similarity) FROM opp_similarita"; 
    $stm = $con->createStatement(); 
    $rs = $stm->executeQuery($sql, ResultSet::FETCHMODE_NUM);
    if($rs->next())
      return $rs->getFloat(1);
    else
      return null;
    
  }

  
}
