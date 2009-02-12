<?php
/*
 * This file is part of the sfLucenePlugin package
 * (c) 2007 Carl Vondrick <carlv@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
* sfLucene bridges symfony and Zend_Search_Lucene together to instantly
* add a search engine to your application. Please see the README file for more.
*
* This class represents a Lucene index.  It is responsible for managing all the
* configurations for the index.  This is the primary means of communicating with
* the Zend Search Lucene library.
*
* @author Carl Vondrick <carlv@carlsoft.net>
* @package sfLucenePlugin
*/
class sfLucene
{
  /**
  * If true, Lucene will erase the old database for rebuilding.
  */
  protected $rebuild;

  /**
  * If true, the index is new.
  */
  protected $isNew = false;

  /**
  * The culture of this instance
  */
  protected $culture;

  /**
  * Holds all the cultures enabled.
  */
  protected $cultures = array();

  /**
  * Holds all the stop words
  */
  protected $stopWords = array();

  /**
  * Holds the short word length
  */
  protected $shortWords = 2;

  /**
   * Holds the text analyzer type
   */
  protected $analyzer = 'TextNum';

  /**
   * Holds the case sensitivity
   */
  protected $caseSensitive = false;

  /**
   * Holds whether to use mb_string functions (warning: 100 times slower than normal fxns!)
   */
  protected $mbString = false;

  /**
  * The name of the index
  */
  protected $name;

  /**
  * The encoding of the index
  */
  protected $encoding = 'UTF-8';

  /**
  * Holder for lucene instance
  */
  protected $lucene = null;

  /**
  * Holds the model declarations
  */
  protected $models = array();

  /**
   * Holds the indexer factories
   */
  protected $factories = array();

  /**
   * Holds various misc. parameters
   */
  protected $parameters = array();

  /**
  * Whether the index has been setup yet
  */
  static protected $setup = false;

  /**
  * Holder for the instances
  */
  static protected $instances = array();

  /**
  * Protected constructor
  * @param string $name The name of the index
  * @param string $culture The culture of the index
  * @param bool $rebuild If true, the index is erased before opening it.
  */
  protected function __construct($name, $culture, $rebuild = false)
  {
    $this->name = $name;
    $this->rebuild = $rebuild;
    $this->culture = $culture;

    $this->parameters = new sfParameterHolder('lucene/default');

    if (!$this->loadConfig())
    {
      throw new sfLuceneException(sprintf('The name of this index is invalid.'));
    }

    if (!in_array($culture, $this->getCultures()))
    {
      throw new sfLuceneException(sprintf('Culture "%s" is not enabled.', $culture));
    }

    $this->setAutomaticMode();
    $this->configure();

    if (sfConfig::get('sf_logging_enabled'))
    {
      sfLogger::getInstance()->info(sprintf('{sfLucene} constructed new instance of index "%s" and culture "%s"', $this->name, $culture));
    }
  }

  /**
  * Public constructor.  This returns an instance of sfLucene configured to the specifications
  * of the search.yml files.
  *
  * @param string $name The name of the index
  * @param string $culture The culture of the index
  * @param bool $rebuild If true, the index is erased before opening it.
  */
  static public function getInstance($name, $culture = null, $rebuild = false)
  {
    if (is_null($culture))
    {
      $culture = sfContext::getInstance()->getUser()->getCulture();
    }

    if (!isset(self::$instances[$name][$culture]))
    {
      if (!isset(self::$instances[$name]))
      {
        self::$instances[$name] = array();
      }

      self::$instances[$name][$culture] = new self($name, $culture, $rebuild);
    }
    elseif ($rebuild)
    {
      throw new sfLuceneException('Cannot rebuild index because index is already open.');
    }

    return self::$instances[$name][$culture];
  }

  /**
  * Returns all of the config.
  */
  static public function getConfig()
  {
    // for unit tests *only*
    if (defined('SF_LUCENE_UNIT_TEST'))
    {
      return FakeLucene::getTestConfig();
    }

    require(sfConfigCache::getInstance()->checkConfig(sfConfig::get('sf_config_dir_name').DIRECTORY_SEPARATOR.'search.yml'));

    return $config;
  }

  /**
   * Returns all the instances
   * @param bool $rebuild If true, every instance is rebuilt.
   */
  static public function getAllInstances($rebuild = false)
  {
    static $instances;

    if (!$instances)
    {
      $config = self::getConfig();

      $instances = array();

      foreach ($config as $name => $item)
      {
        foreach ($item['index']['cultures'] as $culture)
        {
          $instances[] = self::getInstance($name, $culture, $rebuild);
        }
      }
    }

    return $instances;
  }

  /**
  * Returns the name of every registered index.
  */
  static public function getAllNames()
  {
    return array_keys(self::getConfig());
  }

  /**
  * Loads the config for the search engine.
  * @return bool If true, the config was loaded.  If false, there was a problem.
  */
  protected function loadConfig()
  {
    $config = self::getConfig();

    if (!isset($config[$this->name]))
    {
      return false;
    }

    $config = $config[$this->name];

    $this->encoding = $config['index']['encoding'];
    $this->cultures = $config['index']['cultures'];
    $this->stopWords = $config['index']['stop_words'];
    $this->shortWords = $config['index']['short_words'];
    $this->analyzer = $config['index']['analyzer'];
    $this->caseSensitive = $config['index']['case_sensitive'];
    $this->mbString = $config['index']['mb_string'];
    $this->models = $config['models'];
    $this->factories = $config['factories'];

    $holder = $this->getParameterHolder();

    foreach ($config['index']['param'] as $key => $value)
    {
      $holder->set($key, $value);
    }

    return true;
  }

  /**
  * Get all the cultures that are enabled.
  */
  public function getCultures()
  {
    return $this->cultures;
  }

  /**
   * Returns the name of this index
   */
  public function getName()
  {
    return $this->name;
  }

  /**
  * Retrieves the encoding of this index.
  */
  public function getEncoding()
  {
    return $this->encoding;
  }

  /**
  * Returns every registered factory.
  */
  public function getFactories()
  {
    return $this->factories;
  }

  /**
  * Returns whether this is a new index.
  */
  public function isNew()
  {
    return $this->isNew;
  }

  /**
  * Returns the culture of this index.
  */
  public function getCulture()
  {
    return $this->culture;
  }

  /**
  * Returns the categories for this index.
  */
  public function getCategories()
  {
    return sfLuceneCategory::getAllCategories($this);
  }

  /**
   * Zend Search Lucene makes it awfully hard to have multiple Lucene indexes
   * open at the same time. This method combats that by configuring all the
   * static variables for this instance.
   */
  public function configure()
  {
    self::setupLucene();

    sfMixer::callMixins('configure:pre');

    Zend_Search_Lucene_Search_QueryParser::setDefaultEncoding($this->encoding);

    switch (strtolower($this->analyzer))
    {
      default:
        throw new sfLuceneException('Unknown analyzer: ' . $this->analyzer);
      case 'text':
        $analyzer = new Zend_Search_Lucene_Analysis_Analyzer_Common_Text();
        break;
      case 'textnum':
        $analyzer = new Zend_Search_Lucene_Analysis_Analyzer_Common_TextNum();
        break;
      case 'utf8':
      case 'utf-8':
        $analyzer = new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8();
        break;
      case 'utf8num':
      case 'utf-8num':
        $analyzer = new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8Num();
        break;
    }

    if (!$this->caseSensitive)
    {
      $analyzer->addFilter(new sfLuceneLowerCaseFilter($this->mbString, $this->encoding));
    }

    if (count($this->stopWords))
    {
      $analyzer->addFilter(new Zend_Search_Lucene_Analysis_TokenFilter_StopWords($this->stopWords));
    }

    if ($this->shortWords > 0)
    {
      $analyzer->addFilter(new Zend_Search_Lucene_Analysis_TokenFilter_ShortWords($this->shortWords));
    }

    Zend_Search_Lucene_Analysis_Analyzer::setDefault($analyzer);

    sfMixer::callMixins('configure:post');
  }

  /**
  * Configures and loads the Zend libraries. This method *must* be called before
  * you use a Zend library, otherwise the autoloader will not be able to find it!
  */
  static public function setupLucene()
  {
    if (!self::$setup)
    {
      require_once dirname(__FILE__)  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';

      self::$setup = true;
    }
  }

  /**
  * Returns all the models
  */
  public function dumpModels($model = null)
  {
    if ($model)
    {
      sfContext::getInstance()->getLogger()->info(sprintf('{sfLucene} calling ->dumpModels() with a model argument is deprecated; please use ->dumpModel() instead'));

      return $this->dumpModel($model);
    }
    else
    {
      return $this->models;
    }
  }

  /**
    * Returns just one model
    * @param string $model The model to look up
    * @return mixed Null if not found, array of config options if found.
    */
  public function dumpModel($model)
  {
    if (isset($this->models[$model]))
    {
      return $this->models[$model];
    }
    else
    {
      return null;
    }
  }

  /**
  * Returns the lucene object
  * @return Zend_Search_Lucene
  */
  public function getLucene()
  {
    if ($this->lucene == null)
    {
      self::setupLucene();

      if (file_exists($this->getIndexLoc()) && !$this->rebuild)
      {
        
        $lucene = Zend_Search_Lucene::open( new sfLuceneDirectoryStorage($this->getIndexLoc()) );
        $this->isNew = false;
      }
      else
      {
        if (sfConfig::get('sf_logging_enabled'))
        {
          if ($this->rebuild && file_exists($this->getIndexLoc()))
          {
            sfContext::getInstance()->getLogger()->info(sprintf('{sfLucene} erased index "%s"', $this->getIndexLoc()));
          }

          sfContext::getInstance()->getLogger()->info(sprintf('{sfLucene} created index "%s"', $this->getIndexLoc()));
        }

        $this->rebuild = false;
        $this->isNew = true;
        $lucene = Zend_Search_Lucene::create( new sfLuceneDirectoryStorage($this->getIndexLoc()) );
      }

      $this->lucene = $lucene;
   }

    return $this->lucene;
  }

  /**
  * Rebuilds the entire index.  This will be quite slow, so only run from the command line.
  */
  public function rebuildIndex()
  {
    $this->setBatchMode();

    sfLuceneCategory::clearAll($this);

    sfMixer::callMixins('rebuild:pre');

    foreach ($this->getIndexer()->getHandlers() as $handler)
    {
      $handler->rebuild();
    }

    sfMixer::callMixins('rebuild:post');

    return $this;
  }

  /**
  * Determines the best mode to use
  */
  public function setAutomaticMode()
  {
    static $mode;

    if (!$mode)
    {
      $mode = function_exists('pake_echo_action') ? 'batch' : 'interactive';
    }

    if ($mode == 'batch')
    {
      $this->setBatchMode();
    }
    elseif ($mode = 'interactive')
    {
      $this->setInteractiveMode();
    }

    return $this;
  }

  /**
  * Puts the engine into batch mode, which makes it index much faster, but searching is
  * not as good.  Use this for large updates.
  */
  public function setBatchMode()
  {
    $this->getLucene()->setMaxBufferedDocs(500);
    $this->getLucene()->setMaxMergeDocs(PHP_INT_MAX);
    $this->getLucene()->setMergeFactor(50);

    return $this;
  }

  /**
  * Puts the engine into interactive mode, which makes it search faster.  Use this for
  * normal circumstances.
  */
  public function setInteractiveMode()
  {
    $this->getLucene()->setMaxBufferedDocs(10);
    $this->getLucene()->setMaxMergeDocs(PHP_INT_MAX);
    $this->getLucene()->setMergeFactor(10);

    return $this;
  }

  /**
  * Shortcut to retrieve the index location
  */
  protected function getIndexLoc()
  {
    return sfConfig::get('sf_data_dir') . DIRECTORY_SEPARATOR.'index'.DIRECTORY_SEPARATOR . $this->name . DIRECTORY_SEPARATOR . $this->getCulture();
  }

  /**
  * Gets the specified indexer from the factory.
  * @return mixed An instance of the indexer factory.
  */
  public function getIndexer()
  {
    return new sfLuceneIndexerFactory($this);
  }

  public function getParameterHolder()
  {
    return $this->parameters;
  }

  /**
  * Wrapper to optimize the index.
  */
  public function optimize()
  {
    $timer = sfTimerManager::getTimer('Zend Search Lucene Optimize');

    sfMixer::callMixins('optimize:pre');
    $this->getLucene()->optimize();
    sfMixer::callMixins('optimize:post');

    $timer->addTime();
  }

  /**
  * Wrapper for Lucene's count()
  */
  public function count()
  {
    return $this->getLucene()->count();
  }

  /**
  * Wrapper for Lucene's numDocs()
  */
  public function numDocs()
  {
    return $this->getLucene()->numDocs();
  }

  /**
  * Wrapper for Lucene's commit()
  */
  public function commit()
  {
    $this->configure();

    $timer = sfTimerManager::getTimer('Zend Search Lucene Commit');

    sfMixer::callMixins('commit:pre');
    $this->getLucene()->commit();
    sfMixer::callMixins('commit:post');

    $timer->addTime();
  }

  /**
  * Returns the size of the index, in bytes.
  */
  public function byteSize()
  {
    $size = 0;

    foreach ( new DirectoryIterator($this->getIndexLoc()) as $node)
    {
      $size += $node->getSize();
    }

    return $size;
  }

  /**
  * Returns the number of segments that the index is in.
  */
  public function segmentCount()
  {
    return count(glob($this->getIndexLoc() . DIRECTORY_SEPARATOR.'_*.cfs'));
  }

  /**
  * Wrapper for Lucene's find()
  * @param mixed $query The query
  * @return array The array of results
  */
  public function find($query)
  {
    $this->configure();

    $timer = sfTimerManager::getTimer('Zend Search Lucene Find');

    $sort = array();

    if ($query instanceof sfLuceneCriteria)
    {
      foreach ($query->getSorts() as $sortable)
      {
        $sort[] = $sortable['field'];
        $sort[] = $sortable['type'];
        $sort[] = $sortable['order'];
      }

      $query = $query->getQuery();
    }
    elseif (is_string($query))
    {
      $query = sfLuceneCriteria::newInstance()->add($query)->getQuery();
    }

    try
    {
      // as we rarely sort, we can avoid the overhead of call_user_func() with this conditional
      if (count($sort))
      {
        $args = array_merge(array($query), $sort);

        $results = call_user_func_array(array($this->getLucene(), 'find'), $args);
      }
      else
      {
        $results = $this->getLucene()->find($query);
      }
    }
    catch (Exception $e)
    {
      $timer->addTime();
      throw $e;
    }

    $timer->addTime();

    return $results;
  }

  /**
  * Searches the index for the query and returns them with a symfony friendly interface.
  * @param mixed $query The query
  * @return sfLuceneResults The symfony friendly results.
  */
  public function friendlyFind($query)
  {
    return new sfLuceneResults( $this->find($query) , $this);
  }

  /**
   * Hook for sfMixer
   */
  public function __call($a, $b)
  {
    return sfMixer::callMixins();
  }
}
