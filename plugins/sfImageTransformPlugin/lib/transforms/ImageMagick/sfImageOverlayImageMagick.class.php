<?php
/*
 * This file is part of the sfImageTransform package.
 * (c) 2007 Stuart <stuart.lowes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * sfImageOverlaysGD class.
 *
 * Overlays GD image on top of another GD image.
 *
 * Overlays an image at a set point on the image.
 *
 * @package sfImageTransform
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @version SVN: $Id$
 */
class sfImageOverlayImageMagick extends sfImageTransformAbstract
{
  /**
   * The composite operator
   */
  protected $compose = IMagick::COMPOSITE_DEFAULT;
  
  /**
   * The overlay sfImage.
   */
  protected $overlay;

  /**
   * The opacity applied to the overlay.
   */
  protected $opacity = null;

  /**
   * The left coordinate for the overlay position.
   */
  protected $left = 0;
  
  /**
   * The top coordinate for the overlay position.
   */
  protected $top = 0;

  /**
   * The named position of for the overlay
   */
  protected $position = null;

  /**
   * Construct an sfImageOverlay object.
   *
   * @param sfImage $overlay  - the image for the overlay
   * @param mixed   $position - the named position as string, or the array of exact coordinates
   * @param float   $opacity  - the opacity for the overlay image
   * @param integer $compose  - the composite operator
   * 
   * @return void
   */
  public function __construct(sfImage $overlay, $position=array(0, 0), $opacity=null, $compose=IMagick::COMPOSITE_DEFAULT)
  {
    $this->setOverlay($overlay);
    $this->setOpacity($opacity);
    $this->setCompose($compose);
    
    if (is_array($position) && count($position)==2)
    {
      $this->setLeft($position[0]);
      $this->setTop($position[1]);
    }
    else
    {
      $this->setPosition($position);
    }
  }

  /**
   * sets the over image.
   *
   * @param sfImage
   */
  function setOverlay(sfImage $overlay)
  {
    $this->overlay = $overlay;

  }
  /**
   * returns the overlay sfImage object.
   *
   * @return sfImage
   */
  function getOverlay()
  {
    return $this->overlay;
  }

  /**
   * Sets the left coordinate
   *
   * @param integer
   */
  public function setLeft($left)
  {
    $this->left = $left;
  }

  /**
   * returns the left coordinate.
   *
   * @return integer
   */
  public function getLeft()
  {
    return $this->left;
  }

  /**
   * set the top coordinate.
   *
   * @param integer
   */
  public function setTop($top)
  {
    $this->top = $top;
  }

  /**
   * returns the top coordinate.
   *
   * @return integer
   */
  public function getTop()
  {
    return $this->top;
  }
  
  /**
   * Set named position
   * 
   * @param string $position named position. Possible named positions:
   *                - middle - overlay in the middle
   *                - north  - overlay in the north side
   *                - south  - overlay in the south side
   *                - west   - overlay in the west side
   *                - east   - overlay in the east side
   *                - north west combination of north and west
   *                - north east combination of north and east
   *                - south west combination of south and west
   *                - south east combination of south and east
   * 
   * @return void                       
   */
  public function setPosition($position)
  {
    $this->position = $position;    
  }
  
  /**
   * returns the position name
   * 
   * @return string
   */
  public function getPosition()
  {
    return $this->position;
  }
  
  /**
   * Computes the offset of the overlayed image 
   * and sets the top and left coordinates based on the named position
   * 
   * @param sfImage $image canvas image
   * 
   * @return void
   */
  protected function computeCoordinates(sfImage $image)
  {
    $position = $this->getPosition();

    // no named position nothing to compute
    if (is_null($position)) return;
    
    $resource   = $image->getAdapter()->getHolder();
    $resource_x = $resource->getImageWidth();
    $resource_y = $resource->getImageHeight();
    
    $overlay    = $this->getOverlay()->getAdapter()->getHolder(); 
    $overlay_x  = $overlay->getImageWidth();
    $overlay_y  = $overlay->getImageHeight();
    
    switch ($position)
    {
      case 'north':
        $this->setLeft(round(($resource_x - $overlay_x)/2));
        $this->setTop(0);
        break;
      case 'south':
        $this->setLeft(round(($resource_x - $overlay_x)/2));
        $this->setTop($resource_y-$overlay_y);
        break;
      case 'east':
        $this->setLeft(round($resource_x - $overlay_x));
        $this->setTop(round(($resource_y - $overlay_y)/2));
        break;
      case 'west':
        $this->setLeft(0);
        $this->setTop(round(($resource_y - $overlay_y)/2));
        break;
      case 'north east':
        $this->setLeft($resource_x - $overlay_x);
        $this->setTop(0);
        break;
      case 'north west':
        $this->setLeft(0);
        $this->setTop(0);
        break;
      case 'south east':
        $this->setLeft($resource_x - $overlay_x);
        $this->setTop($resource_y - $overlay_y);
        break;
      case 'south west':
        $this->setLeft(0);
        $this->setTop($resource_y - $overlay_y);
        break;
      case 'center':
      default:
        $this->setLeft(round(($resource_x - $overlay_x)/2));
        $this->setTop(round(($resource_y - $overlay_y)/2));  
        break;
    }
  }
  
  /**
   * sets the opacity used for the overlay.
   *
   * @param integer
   */
  function setOpacity($opacity)
  {
    if(is_numeric($opacity) && $opacity > 1)
    {
      $this->opacity = $opacity/100;
    }
    elseif(is_float($opacity))
    {
      $this->opacity = abs($opacity);
    }
    else
    {
      $this->opacity = $opacity;
    }
  }

  /**
   * returns the opacity used for the overlay.
   *
   * @return mixed
   */
  function getOpacity()
  {
    return $this->opacity;
  }
  
  /**
   * Sets the composite operator
   * 
   * @param integer valid IMagick composite opeator
   * 
   * @return void
   * @see http://php.net/manual/en/imagick.constants.php#imagick.constants.compositeop
   */
  public function setCompose($compose=IMagick::COMPOSITE_DEFAULT)
  {
      $this->compose = $compose;
  }
  
  /**
   * return the composite opeator
   * 
   * @return integer composite operator
   */
  public function getCompose()
  {
      return $this->compose;
  }


  /**
   * Apply the transform to the sfImage object.
   *
   * @param sfImage
   * 
   * @return sfImage
   */
  protected function transform(sfImage $image)
  {
    // compute the named coordinates
    $this->computeCoordinates($image);
    
    $resource = $image->getAdapter()->getHolder();
    $overlay = $this->getOverlay();
    
    if (!is_null($this->getOpacity()))
    {
      $overlay->getAdapter()->getHolder()->setImageOpacity($this->getOpacity());
    }

    $resource->compositeImage($overlay->getAdapter()->getHolder(), $this->getCompose(), $this->getLeft(), $this->getTop());
    
    $image->getAdapter()->setHolder($resource);
    
    return $image;

  }
}
