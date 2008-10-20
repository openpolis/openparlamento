<?php

/**
 * captcha actions.
 *
 * @package    captcha
 * @subpackage captcha
 * @author     Voznyak Nazar <voznyaknazar@gmail.com>
 * @version    
 */
class sfCaptchaActions extends sfActions
{
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    $this->getResponse()->setContentType('image/jpeg');

    $g = new Captcha($this->getUser()->getAttribute('captcha'));
    print($g->plot());
  }
}
