<?php
/**
 *  Copyright 2009 Sid Bachtiar
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */


/**
 * sfSimpleGoogleSitemap
 *
 * A PHP class for generating XML data for the Google Sitemaps service using GsgXml class.
 *
 * @author  Sid Bachtiar
 * @version 0.0.1
 */
class sfSimpleGoogleSitemap {

  const ORM_AUTO = 'auto';
  const ORM_PROPEL = 'Propel';
  const ORM_DOCTRINE = 'Doctrine';
  const ORM_DB_FINDER = 'DbFinder';

  /**
   * GsgXml object
   *
   * @var GsgXml
   */
  private $gsgxml;

  /**
   * Constructor
   *
   */
  public function __construct()
  {
    $this->gsgxml = new GsgXml();
  }

  /**
   * Returns the type of ORM, e.g.: Propel or DbFinder
   * @return string
   */
  public function detectOrm()
  {
    $orm = sfConfig::get('app_sfSimpleGoogleSitemap_orm', self::ORM_AUTO);

    if ($orm == self::ORM_AUTO) // auto detection
    {
      $orm = self::ORM_PROPEL; // by default it is propel

      // detects if DbFinderPlugin exists
      $path = sfConfig::get('sf_plugins_dir').'/DbFinderPlugin';
      if (file_exists($path)) // check if we have DbFinder installed
      {
        $orm = self::ORM_DB_FINDER;
      }
    }

    return $orm;
  }

  /**
   * Process parameters in app.yml.
   *
   * @return void
   */
  public function processConfig()
  {
    $gsg = $this->gsgxml;

    // process the static urls
    $urls = sfConfig::get('app_sfSimpleGoogleSitemap_urls');
    if ($urls and is_array($urls))
    {
      foreach ($urls as $a)
      {
        $gsg->addUrl($a['url'], false, date('c'), false, $a['freq'], $a['priority']);
      }
    }

    $orm = $this->detectOrm();

    // process the models (e.g.: sfSimpleBlogPlugin model)
    $models = sfConfig::get('app_sfSimpleGoogleSitemap_models');
    if ($models and is_array($models))
    {
      foreach ($models as $just_a_name => $a)
      {
        $model = $a['model'];
        $module = $a['module'];
        $action = $a['action'];
        $routing = (isset($a['routing'])?$a['routing']:null);
        $params_array = $a['params'];
        $date_field = (isset($a['date'])?$a['date']:null);
        $criteria_array = (isset($a['criteria'])?$a['criteria']:null);
        $order_by = (isset($a['order_by'])?$a['order_by']:null);
        $group_by = (isset($a['group_by'])?$a['group_by']:null);
        $limit = (isset($a['limit'])?$a['limit']:null);
        $freq = $a['freq'];
        $priority = $a['priority'];

        switch ($orm)
        {
          case self::ORM_DOCTRINE:
            $objects = $this->queryUsingDoctrine($model, $criteria_array, $order_by, $group_by, $limit);
            break;
          case self::ORM_DB_FINDER:
            $objects = $this->queryUsingDbFinder($model, $criteria_array, $order_by, $group_by, $limit);
            break;

          default: // default use Propel
            $objects = $this->queryUsingPropel($model, $criteria_array, $order_by, $group_by, $limit);
        }

        // if there's any result
        if ($objects and (is_array($objects) or ( $orm == self::ORM_DOCTRINE and $objects instanceof Doctrine_Collection )))
        {
          foreach ($objects as $obj)
          {
            $p = array();
            foreach ($params_array as $name => $method)
            {
              $p[] = $name.'='.$obj->$method();
            }

            if (!$routing)
            {
              $url = $module.'/'.$action.'?'.implode('&', $p);
            }
            else
            {
              $url = $routing.'?'.implode('&', $p);
            }

            if ($date_field)
            {
              $url_date = $obj->$date_field('c');
            }
            else
            {
              $url_date = date('c');
            }

            $gsg->addUrl(
              sfContext::getInstance()->getController()->genUrl($url, true),
              false,
              $url_date,
              true,
              $freq,
              $priority
            );
          }
        }
      }
    }

    $gsg->generateXml();

  }

  /**
   * Do query using propel
   *
   * @param string $model_name
   * @param array $criteria_array
   * @param array $order_by
   * @param array $group_by
   * @param int $limit
   * @return Object[]
   */
  public function queryUsingPropel($model_name, $criteria_array, $order_by, $group_by, $limit)
  {
    $peer = $model_name.'Peer';
    $table_name = constant($peer.'::TABLE_NAME');

    // build criteria
    $c = new Criteria();
    /* @var $c Criteria */

    if ($criteria_array and is_array($criteria_array))
    {
      foreach ($criteria_array as $crit)
      {
        $column = $table_name.'.'.$crit['column'];
        $operator = $crit['operator'];
        $value = $crit['value'];
        $c->add($column, $value, $operator);
      }
    }

    if ($order_by)
    {
      $column = $table_name.'.'.$order_by['column'];

      if ($order_by['sort'] == 'desc')
      {
        $c->addDescendingOrderByColumn($column);
      }
      else
      {
        $c->addAscendingOrderByColumn($column);
      }
    }

    if ($group_by)
    {
      $column = $table_name.'.'.$group_by['column'];

      $c->addGroupByColumn($column);
    }

    if ($limit)
    {
      $c->setLimit($limit);
    }

    // query records
    return call_user_func($peer.'::doSelect', $c);
  }

  /**
   * Do query using db finder
   *
   * @param string $model_name
   * @param array $criteria_array
   * @param array $order_by
   * @param array $group_by
   * @param int $limit
   * @return Object[]
   */
  public function queryUsingDbFinder($model_name, $criteria_array, $order_by, $group_by, $limit)
  {
    $finder = DbFinder::from($model_name);
    /* @var $finder DbFinder */

    if ($criteria_array and is_array($criteria_array))
    {
      foreach ($criteria_array as $crit)
      {
        $method = $crit['method'];
        $operator = $crit['operator'];
        $value = $crit['value'];

        $finder->where($method, $operator, $value);
      }
    }

    if ($order_by)
    {
      $finder->orderBy($order_by['method'], $order_by['sort']);
    }

    if ($group_by)
    {
      $finder->groupBy($group_by['method']);
    }

    if ($limit)
    {
      $finder->limit($limit);
    }

    return $finder->find();
  }

  /**
   * Do query using doctrine
   *
   * @param string $model_name
   * @param array $criteria_array
   * @param array $order_by
   * @param array $group_by
   * @param int $limit
   * @return Object[]
   */
  public function queryUsingDoctrine($model_name, $criteria_array, $order_by, $group_by, $limit)
  {
    $query = Doctrine::getTable($model_name)->createQuery();

    if ($criteria_array and is_array($criteria_array))
    {
      foreach ($criteria_array as $criteria)
      {
        $query->andWhere($criteria['column'] . ' ' . $criteria['operator']. ' ?', $criteria['value']);
      }
    }

    if ($order_by)
    {
      $query->orderBy($order_by['column'] . ' ' . $order_by['sort']);
    }

    if ($group_by)
    {
      $query->groupBy($group_by['column']);
    }

    if ($limit)
    {
      $query->limit($limit);
    }

    return $query->execute();
  }

  /**
   * Returns the xml string
   *
   * @return string
   */
  public function getXml()
  {
    return $this->gsgxml->output();
  }
}
