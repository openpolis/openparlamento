<?php
 class sfMemcacheConfigHandler extends sfYamlConfigHandler
{
  /**
   * Executes this configuration handler.
   *
   * @param array An array of absolute filesystem path to a configuration file
   *
   * @return string Data to be written to a cache file
   *
   * @throws <b>sfParseException</b> If a requested configuration file is improperly formatted
   */
  public function execute($configFiles)
  {
    // parse the yaml
    $myConfig = $this->parseYamls($configFiles);
 
    $myConfig = sfToolkit::arrayDeepMerge(
      isset($myConfig['default']) && is_array($myConfig['default']) ? $myConfig['default'] : array(),
      isset($myConfig['all']) && is_array($myConfig['all']) ? $myConfig['all'] : array(),
      isset($myConfig[sfConfig::get('sf_environment')]) && is_array($myConfig[sfConfig::get('sf_environment')]) ? $myConfig[sfConfig::get('sf_environment')] : array()
    );
 
    // Set Up Servers
    $defaultServerConfig = array('host' => 'localhost',
                            'port' => 11211,
                            'persistent' => true,
                            'weight' => 1,
                            'timeout' => 1,
                            'retry_interval' => 15,
                            'status' => true,                                        
                            );                           
 
    if(!isset($myConfig['servers']) || !is_array($myConfig['servers']))
    {
        $myConfig['servers'] = array( 'default' => $defaultServerConfig );    
    }
 
    $myConfig['servers']['default'] = array_merge( $defaultServerConfig, isset($myConfig['servers']['default']) ? $myConfig['servers']['default'] : array() );  
 
    foreach($myConfig['servers'] as $serverName => &$server)
    {
        $server = array_merge($myConfig['servers']['default'], $server);
    }
 
    // Set Up Buckets
    if(!isset($myConfig['buckets']) || !is_array($myConfig['buckets']))
        throw new sfParseException(sprintf('Configuration file "%s" does not specify any cache buckets.', $configFiles[0]));        
 
    $inits = array();
    $tmp = array();
    foreach($myConfig['buckets'] as $bucketName => &$bucket)
    {
        if(!isset($bucket['servers']))
        {
            $bucket['servers'] = 'default';
        }
 
        if(!is_array($bucket['servers']))
        {
            $bucket['servers'] = array( $bucket['servers'] );            
        }
 
 
        foreach($bucket['servers'] as $serverName => &$server)
        {
            if(!isset($myConfig['servers'][$server]))
                throw new sfParseException(sprintf('Configuration file "%s" requires server configuration \'%s\' for bucket \'%s\', but server configuration does not exist.', $configFiles[0], $server, $bucketName ));
 
            $server = $myConfig['servers'][$server];        
        }
        $tmp[$bucketName] = $bucket;
    }
    $inits[] = sprintf("sfConfig::set('%s', %s);", 'memcache_servers', var_export($tmp, true) );
 
    // Compile Return Value    
    return sprintf("<?php\n  %s", implode("\n", $inits));
  }
}