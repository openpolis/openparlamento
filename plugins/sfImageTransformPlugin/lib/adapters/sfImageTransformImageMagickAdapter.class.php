<?php
/*
 * This file is part of the sfImageTransform package.
 * (c) 2007 Stuart Lowes <stuart.lowes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * sfImageTransformImagickAdapter class.
 *
 * ImageMagick support for sfImageTransform.
 *
 *
 * @package sfImageTransform
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @version SVN: $Id$
 */
class sfImageTransformImageMagickAdapter extends sfImageTransformAdapterAbstract
{

  /**
   * The image resource.
   * @access protected
   * @var resource
   *
   * @throws sfImageTransformException
  */
  protected $holder;
  
  /*
   * Supported MIME types for the sfImageImageMagickAdapter
   * and their associated file extensions
   * @var array
   */
  protected $types = array(
    'image/jpeg' => array('jpeg','jpg'),
    'image/gif' => array('gif'),    
    'image/png' => array('png')
  );
  
  public function __construct()
  {
    // Check that the GD extension is installed and configured
    if (!extension_loaded('imagick'))
    {
      throw new sfImageTransformException('The image processing library ImageMagick is not enabled. See PHP Manual for installation instructions.');
    }
    
    $this->setHolder(new Imagick());    
  }
  
  /**
   * Tidy up the object
  */
  public function __destruct()
  {
    if ($this->hasHolder())
    {
      $this->getHolder()->destroy();
    }
  }
 
  /**
   * Create a new empty (1 x 1 px) gd true colour image
   *
   * @param integer Image width
   * @param integer Image Height
   */
  public function create($x=1, $y=1)
  {
    $image = new Imagick();
    $image->newImage($x, $y, new ImagickPixel('black'));
    $image->setImageFormat('png');
    $this->setHolder($image);
  }

  /**
   * Load and sets the resource from a existing file
   *
   * @param string
   * @return boolean
   *
   * @throws sfImageTransformException
   */
  public function load($filename, $mime)
  {

    if (preg_match('/image\/.+/',$mime))
    {
      $this->holder = new Imagick($filename);
      $this->mime_type = $mime;
      $this->setFilename($filename);
      
      return true;
    } 

    throw new sfImageTransformException(sprintf('Cannot load file %s as %s is an unsupported file type.', $filename, $mime));
  }
  
  /**
   * Load and sets the resource from a existing file
   *
   * @param string
   * @return boolean
   *
   * @throws sfImageTransformException
   */
  public function loadString($string)
  {
    
    $image = $this->getHolder()->readImageBlob($string);
    
    if (is_object($image) && class_name($image) == 'Imagick')
    {
      $this->setHolder($image);
      
      return true;
    }
  
    throw new sfImageTransformException('Cannot load image string');
  }

  /**
   * Get the image as string
   *
   * @return string
   */
  public function __toString()
  {
    $this->getHolder()->setImageCompressionQuality($this->getQuality());
    return (string)$this->getHolder();
  }

  /**
   * Save the image to disk
   *
   * @return boolean
   */
  public function save()
  {
    $this->getHolder()->setImageCompressionQuality($this->getQuality());
    return $this->getHolder()->writeImage($this->getFilename());
  }
  
  /**
   * Save the image to the specified file
   *
   * @param string $filename
   * @return boolean
   */
  public function saveAs($filename, $mime='')
  {
    if ('' !== $mime)
    {
      $this->setMimeType($mime);
    }

    $this->getHolder()->setImageCompressionQuality($this->getQuality());

    return $this->getHolder()->writeImage($filename);
  }

  /**
   * Returns a copy of the adapter object
   *
   * @return sfImage
   */    
  public function copy()
  {
    $class = get_class($this);
    $copyObj = new $class();
        
    $copyObj->setHolder($this->getHolder()->clone());
    
    return $copyObj;
  }
  
  /**
   * Gets the pixel width of the image
   *
   * @return integer
   */
  public function getWidth()
  {
    if ($this->hasHolder())
    {
      return $this->getHolder()->getImageWidth();
    }
    
    return 0;
  }
  
  public function getHeight()
  {
    if ($this->hasHolder())
    {
      return $this->getHolder()->getImageHeight();
    }
    return 0;
  }
  
  /**
   * Sets the image resource holder
   * @param Imagick
   * @return boolean
   *
   */
  public function setHolder($holder)
  {
    if (is_object($holder) && 'Imagick' === get_class($holder))
    {
      $this->holder = $holder;
      return true;
    }
    return false;
  }
  
  /**
   * Returns the image resource
   * @return resource
   *
   */
  public function getHolder()
  {

    if ($this->hasHolder())
    {
      return $this->holder;
    }
    return false;
  }
  
  /**
   * Returns whether there is a valid GD image resource
   * @return boolean
   *
   */
  public function hasHolder()
  {

    if (is_object($this->holder) && 'Imagick' === get_class($this->holder))
    {
      return true; 
    }
    return false;
  }
  
  public function getMimeType()
  {
    return $this->mime_type;
  }
  
  public function setMimeType($mime)
  {
    $this->mime_type = $mime;
    if ($this->hasHolder() && isset($this->types[$mime]))
    {
        $this->getHolder()->setImageFormat($this->types[$mime][0]);
    }
  }
  
  public function getAdapterName()
  {
    return 'ImageMagick';
  }
  
  /**
   * Sets the image filename
   * @param integer Quality of the image
   *
   * @return boolean
   */
  public function setQuality($quality)
  {
    if(parent::setQuality($quality))
    {
      $this->getHolder()->setImageCompressionQuality($quality);
    }
  }
    
}
