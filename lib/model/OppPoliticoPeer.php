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
	  return sfConfig::get('sf_pol_images_host', "http://op_openparlamento_images.s3.amazonaws.com/") . "parlamentari/picture/" . $id . '.jpeg';
	}

	public static function getThumbUrl($id)
	{
	  return sfConfig::get('sf_pol_images_host', "http://op_openparlamento_images.s3.amazonaws.com/") . "parlamentari/thumb/" . $id . '.jpeg';
	}
  
	
}
