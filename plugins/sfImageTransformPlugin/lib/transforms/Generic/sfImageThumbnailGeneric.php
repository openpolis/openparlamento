<?php
/*
 * This file is part of the sfImageTransform package.
 * (c) 2007 Stuart Lowes <stuart.lowes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/**
 * sfImageThumbnailGeneric class
 * 
 * generic thumbnail transform
 * 
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Miloslav Kmet <miloslav.kmet@gmail.com>
 * 
 */
class sfImageThumbnailGeneric extends sfImageTransformAbstract
{
  /**
   * width of the thumbnail
   */
  protected $width;
  
  /**
   * height of the thumbnail
   */
  protected $height;
  
  /**
   * method for thumbnail creation
   */
  protected $method;
  
  /**
   * constructor
   * 
   * @param integer $width of the thumbnail
   * @param integer $height of the thumbnail
   * 
   * @return void
   */
  public function __construct($width, $height, $method='scale')
  {
    $this->setWidth($width);
    $this->setHeight($height);
    $this->setMethod($method);
  }
  
  /**
   * sets the height of the thumbnail
   * @param integer $height of the image
   * 
   * @return void
   */
  public function setHeight($height)
  {
    $this->height = $height;
  }
  
  /**
   * returns the height of the thumbnail
   * 
   * @return integer
   */
  public function getHeight()
  {
    return $this->height;
  }
  
  /**
   * sets the width of the thumbnail
   * @param integer $width of the image
   * 
   * @return void
   */
  public function setWidth($width)
  {
    $this->width = $width;
  }
  
  /**
   * returns the width of the thumbnail
   * 
   * @return integer
   */
  public function getWidth()
  {
    return $this->width;
  }
  
  public function setMethod($method)
  {
    $this->method = strtolower($method);
  }
  
  /**
   * returns the method for thumbnail creation
   * 
   * @return integer
   */
  public function getMethod()
  {
    return $this->method;
  }
  /**
   * Apply the transformation to the image and returns the image thumbnail
   */
  protected function transform(sfImage $image)
  {
    
    $resource_w = $image->getWidth();
    $resource_h = $image->getHeight();
    
    $scale_w    = $this->getWidth()/$resource_w;
    $scale_h    = $this->getHeight()/$resource_h;

    $ratio_w    = $resource_w/$this->getWidth();
    $ratio_h    = $resource_w/$this->getHeight();
    
    switch ($this->getMethod())
    {
      case 'deflate':
      case 'inflate':
        return $image->resize($this->getWidth(), $this->getHeight());

      case 'west':
        $image->scale(max($scale_w, $scale_h));
        return $image->crop($this->getWidth(), $this->getHeight(), 0, 0);

      case 'east':
        $image->scale(max($scale_w, $scale_h));
        return $image->crop($this->getWidth(), $this->getHeight(), (int)($image->getWidth()-$this->getWidth()), 0);
      
      case 'north':
        $image->scale(max($scale_w, $scale_h));
        return $image->crop($this->getWidth(), $this->getHeight(), 0, 0);
        
      case 'south':
        $image->scale(max($scale_w, $scale_h));
        return $image->crop($this->getWidth(), $this->getHeight(), 0, $image->getHeight()-$this->getHeight());

      case 'center':
        $image->scale(max($scale_w, $scale_h));
        $left = (int)round(($image->getWidth() - $this->getWidth())/2);
        $top  = (int)round(($image->getHeight() - $this->getHeight())/2);

        return $image->crop($this->getWidth(), $this->getHeight(), $left, $top);
        
      case 'scale':
      default:
        return $image->scale(min($scale_w, $scale_h));
      
    }
  }
}
