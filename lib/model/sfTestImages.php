<?php

/**
 * Subclass for representing a row from the 'sf_test_images' table.
 *
 * 
 *
 * @package lib.model
 */ 
class sfTestImages extends BasesfTestImages
{
  public function setPicture($filename)
  {
    if(!stat($filename)){
      parent::setPicture($filename);
    } else {
			try {
				$this->picture = new Clob();
				$this->picture->readFromFile($filename);
				$this->modifiedColumns[] = sfTestImagesPeer::PICTURE;
			} catch (Exception $e) {
				echo("Exception " . $e . " encountered!\n");
			}
		}
	}
  
}
