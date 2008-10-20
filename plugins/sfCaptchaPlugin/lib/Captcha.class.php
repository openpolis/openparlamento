<?php
  require_once 'jpgraph/jpgraph_antispam.php';

  class Captcha extends AntiSpam {

    public function plot() {
      return $this->stroke();
    }

    public function generate() {
      $this->iData = '';
      
      $alphabet = sfConfig::get('app_captcha_alphabet', '123456789');
      $alphabet_length = strlen($alphabet);
      $length = sfConfig::get('app_captcha_length', 5);
      for($i = 0; $i < $length; ++$i) {
        $this->iData .= $alphabet{mt_rand(0,$alphabet_length-1)};
      }
      
      sfContext::getInstance()->getUser()->setAttribute('iData', $this->iData);
      return $this->iData;  
    }

    public function verify($s) {
      return (sfContext::getInstance()->getUser()->getAttribute('iData') == strtolower($s));
    }
  }
  ?>
