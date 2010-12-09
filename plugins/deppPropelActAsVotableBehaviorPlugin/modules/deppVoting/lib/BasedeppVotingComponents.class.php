<?php
/**
 * deppPropelActAsVotableBehaviorPlugin base components.
 * 
 * @package    plugins
 * @subpackage voting 
 */
class BasedeppVotingComponents extends sfComponents
{
  /**
   * Gets object rating details and end it to according view
   * 
   */
  public function executeVotingDetails()
  {
    if ($this->object)
    {
      $total_votings = $this->object->countVotings();
      $details = $this->object->getVotingDetails(true);
      $full_details = array();
      foreach ($details as $voting => $nb_votings)
      {
        if ($total_votings > 0)
          $percent = $nb_votings / $total_votings * 100;
        else 
          $percent = 0;
          
        $full_details[$voting] = array('count'   => $nb_votings,
                                       'percent' => $percent);
      }
      $this->total_votings = $total_votings;
      $this->voting_details = $full_details;
      $this->object_type = get_class($this->object);
    }
  }
  
}
