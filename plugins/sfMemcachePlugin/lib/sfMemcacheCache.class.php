<?php

/**
 * Cache class that stores content in memcache.
 *
 * This class is based on the sfFileCache class from the symfony core.
 * All cache files are stored in memcache, and it not available it stores files in the [sf_root_dir].'/cache/'.[sf_app].'/template' directory.
 * To disable all caching, you can set to false [sf_cache] setting.
 *
 * @author     Myke Hines <myke.hines@fox.com>
 */
class sfMemcacheCache extends sfFileCache
{
  protected static $mem = array();
  protected static $instance = null;
  protected $bucket = 'default';
  protected $old_bucket = 'default';  //Used to switch back and forth from buckets
  
  public static function getInstance()
  {
    if (!self::$instance)
      self::$instance = new sfMemcacheCache;
      
    return self::$instance;
  }
 /**
  * Constructor.
  *
  * @param string The cache root directory
  */
  public function __construct($cacheDir = null)
  {
    // Set our file base method
    parent::__construct($cacheDir);
    
    // Initialize our memcache connection
    $this->connectServers();
  }

  /**
   * connectServers.
   *
   */
   private function connectServers()
   {
     // Our config/memcache.yml file includes all of our hosts that we should connect to.
     include (sfConfigCache::getInstance()->checkConfig(sfConfig::get('sf_app_config_dir_name').'/memcache.yml'));
     $conf = sfConfig::get('memcache_servers');
     
     // Clear our connection list
     self::$mem = array();

     // Add servers to our pool
     foreach ($conf as $bucket => $servers)
     {
       if ($bucket!= '')
       {
         if (!isset(self::$mem[$bucket]))
          self::$mem[$bucket] = new Memcache;
         foreach ($servers['servers'] as $server) 
           self::$mem[$bucket]->addServer ($server['host'], $server['port'], $server['persistent'], $server['weight']);
       }
     }
     
     $this->bucket = 'default';
   }

  
 /**
  * Tests if a cache is available and (if yes) returns it.
  *
  * @param  string  The cache id
  * @param  string  The name of the cache namespace
  * @param  boolean If set to true, the cache validity won't be tested
  *
  * @return string  Data of the cache (or null if no cache available)
  *
  * @see sfCache
  */
  public function get($id, $namespace = self::DEFAULT_NAMESPACE, $doNotTestCacheValidity = false)
  {
    list($path, $file) = $this->getFileName($id, $namespace);
    try
    {
      if (!isset(self::$mem[$this->bucket]))
        throw new Exception ('This bucket was not setup in your memcache.yml');
        
      $std = self::$mem[$this->bucket]->get ($path.$file);      
      if ($std instanceof Stdclass)
      {
        return $std->data;
      }
      else throw new Exception ('Could not find cache');
    } catch (Exception $e)
    {
      return parent::get ($id, $namespace, $doNotTestCacheValidity);
    }
  }

  /**
   * Returns true if there is a cache for the given id and namespace.
   *
   * @param  string  The cache id
   * @param  string  The name of the cache namespace
   * @param  boolean If set to true, the cache validity won't be tested
   *
   * @return boolean true if the cache exists, false otherwise
   *
   * @see sfCache
   */
  public function has($id, $namespace = self::DEFAULT_NAMESPACE, $doNotTestCacheValidity = false)
  { 
    list($path, $file) = $this->getFileName($id, $namespace);
    try {
      $std = self::$mem[$this->bucket]->get ($path.$file);      
      if ($std instanceof Stdclass)
      {
        return true;
      }
      else throw new Exception ('Could not find cache');    }
    catch (Exception $e) {
      return parent::has ($id, $namespace, $doNotTestCacheValidity);
    }
  }
  
 /**
  * Saves some data in a cache file.
  *
  * @param string The cache id
  * @param string The name of the cache namespace
  * @param string The data to put in cache
  *
  * @return boolean true if no problem
  *
  * @see sfCache
  */
  public function set($id, $namespace = self::DEFAULT_NAMESPACE, $data)
  {
    list($path, $file) = $this->getFileName($id, $namespace);
    try
    {  
      $std = new Stdclass;
      $std->data = $data;
      $std->lastModified = time();

      $internalUri = sfRouting::getInstance()->getCurrentInternalUri();
      $lifeTime = $this->getLifeTime();
      sfLogger::getInstance()->info("xxx: $internalUri - $lifeTime");
      

      if (!isset(self::$mem[$this->bucket]))
        throw new Exception ('This bucket was not setup correctly');
      if (!self::$mem[$this->bucket]->set ($path.$file, $std, false, $lifeTime))
        throw new Exception ('Could not save in memcache');
        
    } catch (Exception $e)  {      
      return parent::set ($id, $namespace, $data);
    }
  }

 /**
  * Removes a cache file.
  *
  * @param string The cache id
  * @param string The name of the cache namespace
  *
  * @return boolean true if no problem
  */
  public function remove($id, $namespace = self::DEFAULT_NAMESPACE)
  {
    list($path, $file) = $this->getFileName($id, $namespace);    
    try {
      if (!self::$mem[$this->bucket]->delete ($path.$file))
        throw new Exception ('Unable to remove from memcache');
    } catch (Exception $e) {
      parent::remove ($id, $namespace);
    }
  }

 /**
  * Cleans the cache.
  *
  * If no namespace is specified all cache files will be destroyed
  * else only cache files of the specified namespace will be destroyed.
  *
  * @param string The name of the cache namespace
  *
  * @return boolean true if no problem
  */
  public function clean($namespace = null, $mode = 'all')
  {
    // We will just flush the ENTIRE memcache 
    try {
      foreach (self::$mem as $bucket)
      {
        if (! @$bucket->flush() )
         throw new Exception ('Error flushing');
      }
    } catch (Exception $e) {
      parent::clean ($namespace, $mode);
    }
  }

  /**
   * Returns the cache last modification time.
   *
   * @return int The last modification time
   */
  public function lastModified($id, $namespace = self::DEFAULT_NAMESPACE)
  {
    list($path, $file) = $this->getFileName($id, $namespace);
    try
    {
      $std = self::$mem[$this->bucket]->get ($path.$file);
      if ($std instanceof Stdclass)
        return $std->lastModified;
      else throw new Exception("Returned an invalid object type");
    } catch (Exception $e) {
      parent::lastModified ($id, $namespace);
    }
  }
  
  public function getBucket()
  {
    return $this->bucket;
  }
  
  public function setBucket($bucket)
  {
    $this->old_bucket = $this->bucket;
    $this->bucket = $bucket;
  }
  
  // Swtiches back to the origional bucket.
  public function revertBucket()
  {
    $this->bucket = $this->old_bucket;
  }
  
  public function getConnections()
  {
    return self::$mem;
  }

}