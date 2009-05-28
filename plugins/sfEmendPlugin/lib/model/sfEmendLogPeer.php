<?php

/**
 * Subclass for performing query and update operations on the 'sf_emend_log' table.
 *
 * 
 *
 * @package plugins.sfEmendPlugin.lib.model
 */ 
class sfEmendLogPeer extends BasesfEmendLogPeer
{
  public static function add($log)
  {
    $l = new sfEmendLog();

    $l->setMsgType(strip_tags($log['msg_type']));
    $l->setMsg(sfEmendToolkit::clean($log['msg']));
    
    // store permanently in the db
    $l->save();
    
    // return the comment object
    return $l;
    
  }
  
}
