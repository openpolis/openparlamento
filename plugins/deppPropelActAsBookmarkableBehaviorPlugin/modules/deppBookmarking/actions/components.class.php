<?php
/**
 * Bookmarking components
 * 
 */
class deppBookmarkingComponents extends sfComponents 
{

  /**
   * Gets object rating details and end it to according view
   * 
   */
  public function executeBookmarkingDetails()
  {
    if ($this->object)
    {
      $total_bookmarkings = $this->object->countBookmarkings();
      $details = $this->object->getBookmarkingDetails(true);
      $full_details = array();
      foreach ($details as $bookmarking => $nb_bookmarkings)
      {
        if ($total_bookmarkings > 0)
          $percent = $nb_bookmarkings / $total_bookmarkings * 100;
        else 
          $percent = 0;
          
        $full_details[$bookmarking] = array('count'   => $nb_bookmarkings,
                                       'percent' => $percent);
      }
      $this->total_bookmarkings = $total_bookmarkings;
      $this->bookmarking_details = $full_details;
      $this->object_type = get_class($this->object);
    }
  }

}
