<?php

/**
 * Subclass for representing a row from the 'sf_monitoring' table.
 *
 * 
 *
 * @package plugins.deppPropelMonitoringBehaviorsPlugin.lib.model
 */ 
class Monitoring extends BaseMonitoring
{
}

# nel progetto Openparlamento, questa classe è anche
# generatore di notizie di community
sfPropelBehavior::add(
  'Monitoring',
  array('deppPropelActAsCommunityNewsGeneratorBehavior' =>
        array('rel_model_getter' => 'getMonitorableModel',
              'rel_id_getter'    => 'getMonitorableId',
        )));
