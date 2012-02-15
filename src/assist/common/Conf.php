<?php

//+---------------------------------------------------------------------------------------------------------------------------------+
//																    /
// Copyright (c) 2012 Yahoo! Inc. All rights reserved. 										    /
// Licensed under the Apache License, Version 2.0 (the "License"); you may not use this 				            /
// file except in compliance with the License. You may obtain a copy of the License at 						    /
//																    /
//		http://www.apache.org/licenses/LICENSE-2.0 									    /
//																    /
// Unless required by applicable law or agreed to in writing, software distributed under 					    /
// the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF    					    /
// ANY KIND, either express or implied. See the License for the specific language governing 					    /
// permissions and limitations under the License. See accompanying LICENSE file.						    /
// 																    /
// $Author:shawcs@yahoo-inc.com  $Date: 30-Jan-2012										    /
//																    /
//+---------------------------------------------------------------------------------------------------------------------------------+


require_once 'Helpers.php';

/**
 * Configuration registry
 *
 * INI files registry
 *
 * Usage example:
 * <code>
 * <?php
 * // init your config files somewhere in your code
 * Conf::init('/home/y/conf/app/config.ini', 'file1', 3600);
 * // ...
 * // use settings from your files anywhere in your code
 * $master_host = Conf::$FILE['file1']['hosts']['master'];
 *
 * // OR, default config, when you only need to use one config file
 * // in your application
 * Conf::init('/home/y/conf/app/config.ini');
 * $master_host = Conf::$CONFIG['hosts']['master'];
 *
 * // or
 * Conf::get('host');
 * Conf::get('host', 'database', 'development');
 * ?>
 * </code>
 */
class Conf {
  /**
   * hash of parsed INI files
   * @var array
   */
  static $FILE;

  /**
   * default configuration file (when no config name specified)
   * @var array
   */
  static $CONFIG;

  /**
   * Initializes INI file
   * @param string full path to configuration (INI) file
   * @param string name reference, once config file is initialized
   * @param int number of seconds to cache initialized config file, default is 5min
   */
  static function init($filename, $name=null, $ttl=300) {
    if(!$name)
      $name = 'default';
      
    $parsed_file = parse_ini_file($filename, true);
    self::$FILE[$name] = $parsed_file;

    if($name == 'default')
      self::$CONFIG = $parsed_file;
    
  }

  /**
   * configuration setting helper
   *
   * shorter alternative to Conf::$FILE[name][environment][setting], Conf::get('setting') or
   * Conf::get('setting', 'conf_name'). When no configuration name specified  self::$CONFIG (default
   * config file is used). When no environment name specified - current environment is used
   * when setting value begins with "keydb://", e.g. "keydb://ops.opsdb_master" ysecure_get_key will
   * be called
   *
   * @param string setting name
   * @param string config file name
   * @param string environment name
   *
   * @return string setting value
   */
  public static function get($setting, $conf=null, $env=null)
  {
    if (!$env) {
        $env = env();
    }


    /*
     * Error handling issues, this section of code threw lots of notices
     * it now does some checking before attempting to blindly access variables
     */
    //$v = !$conf ? self::$CONFIG[$env][$setting] : Conf::$FILE[$conf][$env][$setting];
    $v = '';
    if (!$conf) {
        $v = self::$CONFIG[$env][$setting];
    } else {

        //receiving errors about undefined index
        if (array_key_exists($env, Conf::$FILE[$conf])) {
            $v = Conf::$FILE[$conf][$env][$setting];
        }
    }

    return $v;
  }
}


