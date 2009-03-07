<?php

/**
 * Subclass for performing query and update operations on the 'opp_politico' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppPoliticoPeer extends BaseOppPoliticoPeer
{
  public static function getPictureUrl($id)
	{
	  return "parlamentari/picture/" . $id . '.jpeg';
	}

	public static function getThumbUrl($id)
	{
	  return "parlamentari/thumb/" . $id . '.jpeg';
	}
  
	
}
