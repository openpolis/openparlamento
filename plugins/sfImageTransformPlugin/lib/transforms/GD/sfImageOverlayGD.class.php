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
class sfImageOverlayGD extends sfImageTransformAbstract
{

  /**
   * The overlay sfImage.
  */
  protected $overlay;

  /**
   * The left coordinate for the overlay position.
  */
  protected $left = 0;

  /**
   * The top coordinate for the overlay position.
  */
  protected $top = 0;

  /**
   * The named position for the overlay
   */
  protected $position = null;
  /**
   * Construct an sfImageOverlay object.
   *
   * @param array mixed
   */
  public function __construct(sfImage $overlay, $position=array(0,0)) {

    $this->setOverlay($overlay);
    if (is_array($position) && count($position))
    {
      $this->setLeft($position[0]);
      if (isset($position[1]))
      {
        $this->setTop($position[1]);
      }
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
   * set the named position
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
   * Computes the offset of the overlayed image and sets
   * the top and left coordinates based on the named position
   * 
   * @param sfImage $image canvas image
   * 
   * @return void
   */
  public function computeCoordinates(sfImage $image)
  {
    $position = $this->getPosition();
    
    if (is_null($position)) return;
    
    $resource   = $image->getAdapter()->getHolder();
    $resource_x = ImageSX($resource);
    $resource_y = ImageSY($resource);
    
    $overlay    = $this->getOverlay()->getAdapter()->getHolder();
    $overlay_x  = ImageSX($overlay);
    $overlay_y  = ImageSY($overlay);
    
    switch (strtolower($position))
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
     
      default:
        $this->setLeft(round(($resource_x - $overlay_x)/2));
        $this->setTop(round(($resource_y - $overlay_y)/2));  
        break;
    }
  }

  /**
   * Apply the transform to the sfImage object.
   *
   * @param integer
   * @return sfImage
   */
  protected function transform(sfImage $image)
  {
    // compute the named coordinates
    $this->computeCoordinates($image);
    
    $resource = $image->getAdapter()->getHolder();

    // create true color canvas image:
    $canvas_w = $image->getWidth();
    $canvas_h = $image->getHeight();
    
    $canvas_img = $image->getAdapter()->getTransparentImage($canvas_w, $canvas_h);
    imagecopy($canvas_img, $resource, 0,0,0,0, $canvas_w, $canvas_h);
    
    // Check we have a valid image resource
    if(false === $this->overlay->getAdapter()->getHolder())
    {
      throw new sfImageTransformException(sprintf('Cannot perform transform: %s',get_class($this)));
    }

    // create true color overlay image:
    $overlay_w   = $this->overlay->getWidth();
    $overlay_h   = $this->overlay->getHeight();
    $overlay_img = $this->overlay->getAdapter()->getHolder(); 
    

    // copy and merge the overlay image and the canvas image:
    imagecopy($canvas_img, $overlay_img, $this->left,$this->top,0,0, $overlay_w, $overlay_h);

    // tidy up
    imagedestroy($resource);

    $image->getAdapter()->setHolder($canvas_img);
    return $image;

  }
}
