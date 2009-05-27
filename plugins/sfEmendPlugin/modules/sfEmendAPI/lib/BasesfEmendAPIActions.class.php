<?php
/**
 * sfEmendPlugin base actions.
 * 
 * @package    plugins
 * @subpackage sfEmendPlugin/sfEmendAPI
 */
class BasesfEmendAPIActions extends sfActions
{  
  // remove the web debug toolbar, that clashes with the XML layout
  public function preExecute()
  {
    sfConfig::set('sf_web_debug', false);
  }

  public function executeGetComments()
  {
    $resource = $this->_clearResource($this->getRequestParameter('url'));
    $this->comments = sfEmendCommentPeer::getAllCommentsForResource($resource);
    $this->n_comments = count($this->comments);
  }
  
  public function executeAddComment()
  {
    $resource = $this->_clearResource($this->getRequestParameter('url'));

    try {      
      $this->comment = sfEmendCommentPeer::addComment($resource,
        array('title'          => $this->getRequestParameter('title'),
              'body'           => $this->getRequestParameter('body'),
              'selection'      => $this->getRequestParameter('selection'),
              'author_name'    => $this->hasRequestParameter('author_name')?$this->getRequestParameter('author_name'):null,
              ));
    } catch (Exception $e) {
      $this->error = 'It was not possible to add the comment to the document. ' . $e->getMessage();
    }
  }
  
  /**
   * da qualcosa_atto_documento_id_$ID_qualcosaltro
   * torna atto_documento_id_$ID
   * TODO:: questa è relativa al progetto e non generica, va spostata
   *
   * @param string $value 
   * @return String
   * @author Guglielmo Celata
   */
  protected function _clearResource($value)
  {
    $token = strtok($value, '_');
    while ($token !== 'atto')
      $token = strtok('_');
    
    $clean_value = 'atto_';
    $clean_value .= strtok('_')."_";
    $clean_value .= strtok('_')."_";
    $clean_value .= strtok('_');
    
    return $clean_value;
    
    
  }

}