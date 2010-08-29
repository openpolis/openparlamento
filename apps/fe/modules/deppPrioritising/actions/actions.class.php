<?php
/**
 * deppPrioritising actions.
 * 
 * @package    openparlamento
 * @subpackage deppPrioritising
 * @author     Guglielmo Celata <guglielmo.celata@gmail.com>
 */
class deppPrioritisingActions extends sfActions
{

  /**
   * Here we will initiate system messages translatable strings
   * 
   */
  public function preExecute()
  {
    parent::preExecute();
    sfLoader::loadHelpers('I18N');
    $this->messages = array(
      'missing_params'   => __('Parameters are missing to retrieve object'),
      'post_only'        => __('POST requests only'),
      'prioritisable_error'    => __('Unable to retrieve object: %s'),
      'thank_you'        => __('Thank you'),
      'user_error'       => __('A problem has occured, sorry for the inconvenience'),
    );
  }

  
  
  /**
   * <p>Vote a propel object, un-ajax style</p>
   * 
   * @see  deppPropelActAsVotableBehavior API
   */
  public function executePrioritise()
  {
    
    try
    {
      if ($this->getRequest()->getMethod() !== sfRequest::POST)
      {
        $this->setError($this->messages['post_only']);
      }
      
      // Retrieve parameters from request
      $object_id = $this->getRequestParameter('object_id');
      $object_model = $this->getRequestParameter('object_model');
      $priority = $this->getRequestParameter('priority');
      
      // Retrieve ratable propel object
      if (is_null($priority) || is_null($object_id) || is_null($object_model))
      {
        $this->setError($this->messages['missing_params']);
      }
      
      $object = deppPropelActAsPrioritisableBehaviorToolkit::retrievePrioritisableObject($object_model, $object_id);
      
      if (is_null($object))
      {
        $this->setError($this->message['prioritisable_error']);
      }
      
      // User retrieval
      $user_id = sfContext::getInstance()->getUser()->getId();
      if (!$object->allowsNullPriority() && $priority == 0)
      {
        $msg = $this->messages['null_not_allowed'];
        sfLogger::getInstance()->warning($msg);
        $this->setError($msg);
      }
      else
      {
        $object->setPriorityValue((int) $priority, $user_id);
        $message = $this->messages['thank_you'];          
      }          

      $this->setFlash('depp_prioritising_message', $message);
      $this->redirect($this->getRequest()->getReferer());
      
    }
    catch (Exception $e)
    {
      $this->setError($e->getMessage());
    }
  }
  
  protected function setError($err_msg)
  {
    $this->setFlash('depp_prioritising_message', $err_msg);
    $this->redirect($this->getRequest()->getReferer());
  }
   
}
