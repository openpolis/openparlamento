<?php

/**
 * Subclass for performing query and update operations on the 'sf_votings' table.
 *
 * 
 *
 * @package plugins.deppPropelActAsVotableBehaviorPlugin.lib.model
 */ 
class sfVotingPeer extends BasesfVotingPeer
{

  protected static function _getItemsPKsVotedByUsers($users_pks, $voting_attitude = null, $model = null)
  {
    $c = new Criteria();
    $c->setDistinct();
    $c->clearSelectColumns();
    $c->addSelectColumn(self::VOTABLE_ID);

    // analyze voting attitude
    if (!is_null($voting_attitude))
    {
      if ($voting_attitude > 0)
        $c->add(self::VOTING, 0, Criteria::GREATER_THAN);
      elseif ($voting_attitude < 0)
        $c->add(self::VOTING, 0, Criteria::LESS_THAN);
      else
        $c->add(self::VOTING, 0);
    }
    
    
    $c->add(self::USER_ID, $users_pks, Criteria::IN);
    if (!is_null($model))
      $c->add(self::VOTABLE_MODEL, $model);

    $rs = self::doSelectRS($c);
    $pks = array();
    while($rs->next())
      $pks[] = $rs->getInt(1);
    
    return $pks;        
  }

  public static function getItemsPKsFavouredByUsers($users_pks, $model = null)
  {
    return self::_getItemsPKsVotedByUsers($users_pks, 1, $model);
  }

  public static function getItemsPKsOpposedByUsers($users_pks, $model = null)
  {
    return self::_getItemsPKsVotedByUsers($users_pks, -1, $model);
  }

  public static function getItemsFavouredByUsers($users_pks, $model = null)
  {
    $items_pks = self::getItemsPKsFavouredByUsers($users_pks, $model);
    $items = call_user_func_array(array($model."Peer", 'retrieveByPKs'), array($items_pks));
    return $items;
  }

  public static function getItemsOpposedByUsers($users_pks, $model = null)
  {
    $items_pks = self::getItemsPKsOpposedByUsers($users_pks, $model);
    $items = call_user_func_array(array($model."Peer", 'retrieveByPKs'), array($items_pks));
    return $items;
  }

  public static function compareItemsByProUsers($a, $b)
  {
    if ($a->getUtFav() < $b->getUtFav()) return 1;
    if ($a->getUtFav() > $b->getUtFav()) return -1;
    if ($a->getUtFav() == $b->getUtFav()) return 0;
  }

  public static function compareItemsByAntiUsers($a, $b)
  {
    if ($a->getUtContr() < $b->getUtContr()) return 1;
    if ($a->getUtContr() > $b->getUtContr()) return -1;
    if ($a->getUtContr() == $b->getUtContr()) return 0;
  }

}
