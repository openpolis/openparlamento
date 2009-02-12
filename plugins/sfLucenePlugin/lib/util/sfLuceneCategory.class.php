<?php
/*
 * This file is part of the sfLucenePlugin package
 * (c) 2007 Carl Vondrick <carlv@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * This manages and represents a category in the index.
 * @package    sfLucenePlugin
 * @subpackage Category
 * @author     Carl Vondrick <carlv@carlsoft.net>
 */

class sfLuceneCategory
{
  /**
   * The name of the category.
   */
  protected $category;

  /**
   * The name of the index
   */
  protected $name;

  /**
   * The culture of this category
   */
  protected $culture;

  /**
   * The loaded list
   */
  static protected $list = array();

  /**
   * Whether the list has been modified.
   */
  static protected $modified = false;

  /**
   * Singleton constructor
   */
  protected function __construct($name, $search)
  {
    $this->category = $name;
    $this->culture = $search->getCulture();
    $this->name = $search->getName();

    self::readList();
  }

  public function addReference($c = 1)
  {
    $this->prepareItem();

    self::$list[$this->name][$this->culture][$this->category] += $c;

    self::$modified = true;

    return $this;
  }

  public function removeReference($c = 1)
  {
    $this->prepareItem();

    self::$list[$this->name][$this->culture][$this->category] -= $c;

    if (self::$list[$this->name][$this->culture][$this->category] < 0)
    {
      self::$list[$this->name][$this->culture][$this->category] = 0;
    }

    self::$modified = true;

    return $this;
  }

  public function countReferences()
  {
    if (isset(self::$list[$this->name][$this->culture][$this->category]))
    {
      return self::$list[$this->name][$this->culture][$this->category];
    }

    return 0;
  }

  public function save()
  {
    self::writeList();

    return $this;
  }

  protected function prepareItem()
  {
    if (!isset(self::$list[$this->name][$this->culture][$this->category]))
    {
      self::$list[$this->name][$this->culture][$this->category] = 0;
    }
  }

  public function __toString()
  {
    return $this->category;
  }

  /**
   * Public constructor.
   */
  static public function newInstance($category, $search)
  {
    $culture = $search->getCulture();
    $name = $search->getName();

    static $instances;

    if (!isset($instances[$name]))
    {
      $instances[$name] = array();
    }

    if (!isset($instances[$name][$culture]))
    {
      $instances[$name][$culture] = array();
    }

    if (!isset($instances[$name][$culture][$category]))
    {
      $instances[$name][$culture][$category] = new self($category, $search);
    }

    return $instances[$name][$culture][$category];
  }

  static public function getAllCategories($search)
  {
    if (!count(self::$list))
    {
      self::readList();
    }

    if (!isset(self::$list[$search->getName()][$search->getCulture()]))
    {
      return array();
    }

    return array_keys(self::$list[$search->getName()][$search->getCulture()]);
  }

  /**
   * Writes the list to disk
   */
  static protected function writeList()
  {
    if (self::$modified)
    {
      $list = array();

      foreach (self::$list as $culture => $sublist)
      {
        $list[$culture] = array_filter($sublist);
      }

      $data = '<?php $categories = ' . var_export($list, true) . ';';

      $mask = umask(0000);

      $filename = self::getLocation();

      file_put_contents($filename, $data);

      if (file_exists($filename) && substr(sprintf('%o', fileperms($filename)), -4) != '0777')
      {
        if (!@chmod($filename, 0777))
        {
          throw new sfException(sprintf('Unable to chmod file "%s".  Permissions are already %o', $filename, fileperms($filename)));
        }
      }

      umask($mask);

      self::$modified = false;
    }
  }

  /**
   * Reads the list
   */
  static protected function readList()
  {
    if (count(self::$list) == 0)
    {
      if (is_readable(self::getLocation()))
      {
        include(self::getLocation());

        if (isset($categories))
        {
          self::$list = $categories;
        }
        else
        {
          throw new sfLuceneException('No categories were defined the file.');
        }
      }
    }

    return self::$list;
  }

  /**
   * Clears the entire list
   */
  static public function clearAll($search = null)
  {
    if ($search)
    {
      if (isset(self::$list[$search->getName()][$search->getCulture()]))
      {
        self::$list[$search->getName()][$search->getCulture()] = array();
      }
    }
    else
    {
      self::$list = array();
    }

    self::$modified = true;

    self::writeList();
  }

  /**
   * Gets the list location
   */
  static protected function getLocation()
  {
    return dirname(sfConfig::get('sf_base_cache_dir')) . '/sfLucene_search_categories.php';
  }
}